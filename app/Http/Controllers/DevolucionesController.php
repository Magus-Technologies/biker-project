<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Devolucion;
use App\Models\DevolucionItem;
use App\Models\SalesItem;
use App\Models\Stock;
use App\Models\Product;
use App\Models\DocumentType;
use Illuminate\Http\Request;

class DevolucionesController extends Controller
{
    public function index() {
        // Obtener tipos de documento para el filtro
        $documentTypes = DocumentType::whereIn('name', ['FACTURA', 'BOLETA DE VENTA', 'NOTA DE VENTA'])->get();
        
        // Obtener ventas del último mes por defecto
        $ventas = Sale::with(['userRegister', 'mechanic', 'saleItems.item'])
            ->whereDate('fecha_registro', '>=', now()->subMonth())
            ->whereDate('fecha_registro', '<=', now())
            ->orderBy('fecha_registro', 'desc')
            ->get();
        
        return view('devoluciones.index', compact('documentTypes', 'ventas'));
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
}
