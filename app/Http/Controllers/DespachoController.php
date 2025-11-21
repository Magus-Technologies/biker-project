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

        return view('despachos.index', compact('ventasPendientes', 'ventasEntregadas'));
    }

    /**
     * Marcar venta como entregada
     */
    public function marcarEntregado(Request $request)
    {
        try {
            $sale = Sale::findOrFail($request->sale_id);

            $sale->update([
                'delivery_status' => 1,
                'delivered_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Venta marcada como entregada'
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
}
