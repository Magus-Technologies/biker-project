<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class DespachoController extends Controller
{
    /**
     * Mostrar lista de ventas para despacho
     */
    public function index()
    {
        $ventasPendientes = Sale::with(['userRegister', 'district.province.region'])
            ->where('delivery_status', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        $ventasEntregadas = Sale::with(['userRegister', 'district.province.region'])
            ->where('delivery_status', 1)
            ->orderBy('delivered_at', 'desc')
            ->limit(50)
            ->get();

        $tiendas = \App\Models\Tienda::where('status', 1)->get();

        return view('despachos.index', compact('ventasPendientes', 'ventasEntregadas', 'tiendas'));
    }

    /**
     * Marcar venta como entregada y generar factura
     */
    public function marcarEntregado(Request $request)
    {
        try {
            $sale = Sale::findOrFail($request->sale_id);

            // Si la venta tiene serie TEMP, generar serie y número real
            if ($sale->serie === 'TEMP' || $sale->number == 0) {
                $saleController = new SaleController();
                $sale->serie = $saleController->generateSerie($sale->document_type_id);
                $sale->number = $saleController->generateNumero($sale->document_type_id);
            }

            $sale->update([
                'delivery_status' => 1,
                'delivered_at' => now(),
                'serie' => $sale->serie,
                'number' => $sale->number
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Venta marcada como entregada y facturada'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Marcar venta como pendiente
     */
    public function marcarPendiente(Request $request)
    {
        try {
            $sale = Sale::findOrFail($request->sale_id);

            $sale->update([
                'delivery_status' => 0,
                'delivered_at' => null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Venta marcada como pendiente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Filtrar ventas por fecha y estado
     */
    public function filtrar(Request $request)
    {
        $query = Sale::with(['userRegister', 'district.province.region']);

        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        if ($request->filled('status')) {
            $query->where('delivery_status', $request->status);
        }

        $ventas = $query->orderBy('created_at', 'desc')->get();

        return response()->json($ventas);
    }

    /**
     * Obtener detalles de una venta para despacho
     */
    public function detalles($id)
    {
        try {
            $venta = Sale::with(['saleItems.product', 'district.province.region'])
                ->findOrFail($id);

            $productos = $venta->saleItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'item_id' => $item->item_id,
                    'description' => $item->product->description ?? $item->description ?? 'Sin descripción',
                    'code_sku' => $item->product->code_sku ?? '',
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'precio_nivel' => $item->unit_price,
                    'location' => $item->product->location ?? '-',
                    'ubicacion' => $item->product->location ?? '-'
                ];
            });

            $distrito = '';
            if ($venta->district) {
                $distrito = $venta->district->name;
                if ($venta->district->province) {
                    $distrito .= ', ' . $venta->district->province->name;
                }
            }

            return response()->json([
                'success' => true,
                'venta' => [
                    'id' => $venta->id,
                    'serie' => $venta->serie,
                    'number' => $venta->number,
                    'customer_names_surnames' => $venta->customer_names_surnames,
                    'customer_address' => $venta->customer_address,
                    'distrito' => $distrito,
                    'total_price' => $venta->total_price
                ],
                'productos' => $productos
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Guardar cambios del despacho
     */
    public function guardar(Request $request)
    {
        try {
            $sale = Sale::findOrFail($request->sale_id);

            // Eliminar items actuales
            $sale->saleItems()->delete();

            // Agregar nuevos items
            $totalPrice = 0;
            foreach ($request->productos as $producto) {
                $sale->saleItems()->create([
                    'item_id' => $producto['item_id'],
                    'quantity' => $producto['quantity'],
                    'unit_price' => $producto['unit_price'],
                ]);

                $totalPrice += $producto['quantity'] * $producto['unit_price'];
            }

            // Actualizar total
            $igv = $totalPrice * 0.18;
            $sale->update([
                'total_price' => $totalPrice,
                'igv' => $igv
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Despacho actualizado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
