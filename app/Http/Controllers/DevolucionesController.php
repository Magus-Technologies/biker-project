<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Devolucion;
use App\Models\DevolucionItem;
use App\Models\SalesItem;
use App\Models\Stock;
use App\Models\Product;
use App\Models\DocumentType;
use App\Exports\DevolucionesExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DevolucionesController extends Controller
{
    public function index() {
        // Obtener tipos de documento para el filtro
        $documentTypes = DocumentType::whereIn('name', ['FACTURA', 'BOLETA DE VENTA', 'NOTA DE VENTA'])->get();
        
        // Obtener devoluciones del último mes por defecto
        $devoluciones = Devolucion::with(['sale', 'userRegister', 'items.saleItem.item'])
            ->whereDate('created_at', '>=', now()->subMonth())
            ->whereDate('created_at', '<=', now())
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Obtener ventas del último mes por defecto para crear devoluciones
        $ventas = Sale::with(['userRegister', 'mechanic', 'saleItems.item'])
            ->whereDate('fecha_registro', '>=', now()->subMonth())
            ->whereDate('fecha_registro', '<=', now())
            ->orderBy('fecha_registro', 'desc')
            ->get();
        
        return view('devoluciones.index', compact('documentTypes', 'ventas', 'devoluciones'));
    }
    
    // Método para obtener ventas con filtros (reutilizando la lógica de sales)
    public function filtroPorfecha(Request $request) {
        if (!$request->filled('fecha_desde') || !$request->filled('fecha_hasta')) {
            return response()->json(['error' => 'Faltan parámetros'], 400);
        }
        
        $ventas = Sale::with(['userRegister', 'mechanic', 'saleItems.item'])
            ->whereDate('fecha_registro', '>=', $request->fecha_desde)
            ->whereDate('fecha_registro', '<=', $request->fecha_hasta);

        if ($request->filled('document_type_id')) {
            $ventas->where('document_type_id', $request->document_type_id);
        }
        
        return response()->json($ventas->get());
    }
    
    // Método para obtener devoluciones con filtros
    public function filtroDevoluciones(Request $request) {
        if (!$request->filled('fecha_desde') || !$request->filled('fecha_hasta')) {
            return response()->json(['error' => 'Faltan parámetros'], 400);
        }
        
        $devoluciones = Devolucion::with(['sale', 'userRegister', 'items.saleItem.item'])
            ->whereDate('created_at', '>=', $request->fecha_desde)
            ->whereDate('created_at', '<=', $request->fecha_hasta);

        if ($request->filled('document_type_id')) {
            $devoluciones->whereHas('sale', function($query) use ($request) {
                $query->where('document_type_id', $request->document_type_id);
            });
        }
        
        return response()->json($devoluciones->get());
    }
    
    public function getSaleDetails($saleId) {
        $sale = Sale::with(['saleItems.item', 'userRegister'])
            ->findOrFail($saleId);
            
        return response()->json($sale);
    }
    
    public function store(Request $request) {
        try {
            $sale = Sale::findOrFail($request->sale_id);
            
            // Generar código de devolución
            $lastCode = Devolucion::max('code') ?? '0000000';
            $newCode = str_pad(intval($lastCode) + 1, 7, '0', STR_PAD_LEFT);
            
            // Crear la devolución
            $devolucion = Devolucion::create([
                'code' => $newCode,
                'sale_id' => $request->sale_id,
                'total_amount' => $request->total_amount,
                'reason' => $request->reason,
                'user_register' => auth()->id()
            ]);
            
            // Procesar cada item devuelto
            foreach ($request->items as $item) {
                DevolucionItem::create([
                    'devolucion_id' => $devolucion->id,
                    'sale_item_id' => $item['sale_item_id'],
                    'quantity_returned' => $item['quantity_returned'],
                    'unit_price' => $item['unit_price']
                ]);
                
                // Actualizar stock (devolver al inventario)
                $saleItem = SalesItem::find($item['sale_item_id']);
                if ($saleItem && $saleItem->item_type === Product::class) {
                    $stock = Stock::where('product_id', $saleItem->item_id)->first();
                    if ($stock) {
                        $stock->quantity += $item['quantity_returned'];
                        $stock->save();
                    }
                }
            }
            
            return response()->json(['success' => 'Devolución procesada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    // Método para exportar devoluciones a Excel
    public function export(Request $request) {
        try {
            $fechaDesde = $request->get('fecha_desde');
            $fechaHasta = $request->get('fecha_hasta');
            
            $devoluciones = Devolucion::with(['sale', 'userRegister', 'items.saleItem.item']);
            
            if ($fechaDesde && $fechaHasta) {
                $devoluciones->whereDate('created_at', '>=', $fechaDesde)
                             ->whereDate('created_at', '<=', $fechaHasta);
            }
            
            $devoluciones = $devoluciones->orderBy('created_at', 'desc')->get();
            
            $filename = 'devoluciones_' . date('Y-m-d_H-i-s') . '.xlsx';
            
            return Excel::download(
                new DevolucionesExport($devoluciones, $fechaDesde, $fechaHasta), 
                $filename
            );
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al exportar: ' . $e->getMessage());
        }
    }
    
    // Método para obtener detalles de una devolución
    public function show($id) {
        $devolucion = Devolucion::with(['sale', 'userRegister', 'items.saleItem.item'])
            ->findOrFail($id);
            
        return response()->json($devolucion);
    }
    
    // Método para eliminar una devolución (solo admin)
    public function destroy($id) {
        try {
            $devolucion = Devolucion::with('items')->findOrFail($id);
            
            // Revertir el stock (quitar del inventario lo que se había devuelto)
            foreach ($devolucion->items as $item) {
                $saleItem = SalesItem::find($item->sale_item_id);
                if ($saleItem && $saleItem->item_type === Product::class) {
                    $stock = Stock::where('product_id', $saleItem->item_id)->first();
                    if ($stock) {
                        $stock->quantity -= $item->quantity_returned;
                        $stock->save();
                    }
                }
            }
            
            // Eliminar items y devolución
            $devolucion->items()->delete();
            $devolucion->delete();
            
            return response()->json(['success' => 'Devolución eliminada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
