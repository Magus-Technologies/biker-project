<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\PedidoService;
use App\Models\Product;
use App\Models\Region;
use App\Models\Tienda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    /**
     * Listar todos los pedidos
     */
    public function index()
    {
        $pedidos = Pedido::with(['userRegister', 'district', 'mechanic'])
            ->orderBy('id', 'desc')
            ->get();

        return view('pedidos.index', compact('pedidos'));
    }

    /**
     * Mostrar formulario para crear pedido
     */
    public function create()
    {
        $regions = Region::all();
        $tiendas = Tienda::where('status', 1)->get();

        return view('pedidos.create', compact('regions', 'tiendas'));
    }

    /**
     * Guardar nuevo pedido
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Crear el pedido
            $pedido = Pedido::create([
                'customer_dni' => $request->customer_dni,
                'customer_names_surnames' => $request->customer_names_surnames,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'districts_id' => $request->districts_id != 'todos' ? $request->districts_id : null,
                'mechanics_id' => $request->mechanics_id,
                'status' => 'pendiente',
                'priority' => $request->priority ?? 'normal',
                'observation' => $request->observation,
                'expires_at' => $request->expires_at,
                'subtotal' => 0,
                'igv' => 0,
                'total' => 0,
            ]);

            // Agregar productos
            if ($request->has('products') && is_array($request->products)) {
                foreach ($request->products as $product) {
                    PedidoItem::create([
                        'pedido_id' => $pedido->id,
                        'product_id' => $product['item_id'],
                        'product_price_id' => $product['priceId'] ?? null,
                        'quantity' => $product['quantity'],
                        'unit_price' => $product['unit_price'],
                        'total' => $product['quantity'] * $product['unit_price'],
                    ]);
                }
            }

            // Agregar servicios
            if ($request->has('services') && is_array($request->services)) {
                foreach ($request->services as $service) {
                    PedidoService::create([
                        'pedido_id' => $pedido->id,
                        'service_name' => $service['name'],
                        'price' => $service['price'],
                    ]);
                }
            }

            // Recalcular totales
            $pedido->refresh();
            $pedido->calculateTotals();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pedido creado exitosamente',
                'pedido' => $pedido
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el pedido: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar detalles del pedido
     */
    public function show($id)
    {
        $pedido = Pedido::with(['items.product', 'services', 'userRegister', 'district', 'mechanic'])
            ->findOrFail($id);

        return view('pedidos.show', compact('pedido'));
    }

    /**
     * Mostrar formulario para editar pedido
     */
    public function edit($id)
    {
        $pedido = Pedido::with([
            'items.product.prices',
            'items.product.stock',
            'services',
            'district.province.region',
            'mechanic'
        ])->findOrFail($id);

        if (!$pedido->canBeEdited()) {
            return redirect()->route('pedidos.index')
                ->with('error', 'Este pedido no puede ser editado');
        }

        $regions = Region::all();
        $tiendas = Tienda::where('status', 1)->get();

        return view('pedidos.edit', compact('pedido', 'regions', 'tiendas'));
    }

    /**
     * Actualizar pedido
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $pedido = Pedido::findOrFail($id);

            if (!$pedido->canBeEdited()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este pedido no puede ser editado'
                ], 400);
            }

            // Actualizar datos del pedido
            $pedido->update([
                'customer_dni' => $request->customer_dni,
                'customer_names_surnames' => $request->customer_names_surnames,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'districts_id' => $request->districts_id != 'todos' ? $request->districts_id : null,
                'mechanics_id' => $request->mechanics_id,
                'priority' => $request->priority ?? 'normal',
                'observation' => $request->observation,
                'expires_at' => $request->expires_at,
            ]);

            // Eliminar items y servicios anteriores
            $pedido->items()->delete();
            $pedido->services()->delete();

            // Agregar nuevos productos
            if ($request->has('products') && is_array($request->products)) {
                foreach ($request->products as $product) {
                    PedidoItem::create([
                        'pedido_id' => $pedido->id,
                        'product_id' => $product['item_id'],
                        'product_price_id' => $product['priceId'] ?? null,
                        'quantity' => $product['quantity'],
                        'unit_price' => $product['unit_price'],
                        'total' => $product['quantity'] * $product['unit_price'],
                    ]);
                }
            }

            // Agregar nuevos servicios
            if ($request->has('services') && is_array($request->services)) {
                foreach ($request->services as $service) {
                    PedidoService::create([
                        'pedido_id' => $pedido->id,
                        'service_name' => $service['name'],
                        'price' => $service['price'],
                    ]);
                }
            }

            // Recalcular totales
            $pedido->refresh();
            $pedido->calculateTotals();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pedido actualizado exitosamente',
                'pedido' => $pedido
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el pedido: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar pedido
     */
    public function destroy($id)
    {
        try {
            $pedido = Pedido::findOrFail($id);

            if ($pedido->isConvertido()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar un pedido que ya fue convertido a venta'
                ], 400);
            }

            $pedido->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pedido eliminado exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el pedido: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cambiar estado del pedido
     */
    public function cambiarEstado(Request $request)
    {
        try {
            $pedido = Pedido::findOrFail($request->pedido_id);
            $nuevoEstado = $request->status;

            // Validar transiciones de estado permitidas
            $transicionesPermitidas = [
                'pendiente' => ['confirmado', 'cancelado'],
                'confirmado' => ['pendiente', 'cancelado'],
                'cancelado' => ['pendiente'],
            ];

            if (!isset($transicionesPermitidas[$pedido->status]) ||
                !in_array($nuevoEstado, $transicionesPermitidas[$pedido->status])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transición de estado no permitida'
                ], 400);
            }

            $pedido->update(['status' => $nuevoEstado]);

            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado exitosamente',
                'nuevo_estado' => $nuevoEstado
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener detalles del pedido (para modal)
     */
    public function detallesPedido($id)
    {
        $pedido = Pedido::with([
            'items.product',
            'services',
            'userRegister',
            'district.province.region',
            'mechanic'
        ])->findOrFail($id);

        return response()->json($pedido);
    }

    /**
     * Convertir pedido a venta
     */
    public function convertirAVenta($id)
    {
        try {
            $pedido = Pedido::with(['items', 'services'])->findOrFail($id);

            if (!$pedido->canBeConverted()) {
                return response()->json([
                    'success' => false,
                    'message' => 'El pedido debe estar confirmado para convertirse a venta'
                ], 400);
            }

            // Preparar datos para la vista de ventas
            $datosVenta = [
                'pedido_id' => $pedido->id,
                'customer_dni' => $pedido->customer_dni,
                'customer_names_surnames' => $pedido->customer_names_surnames,
                'customer_address' => $pedido->customer_address,
                'districts_id' => $pedido->districts_id,
                'mechanics_id' => $pedido->mechanics_id,
                'products' => $pedido->items->map(function ($item) {
                    return [
                        'item_id' => $item->product_id,
                        'description' => $item->product->description ?? '',
                        'quantity' => $item->quantity,
                        'unit_price' => $item->unit_price,
                        'priceId' => $item->product_price_id,
                    ];
                }),
                'services' => $pedido->services->map(function ($service) {
                    return [
                        'name' => $service->service_name,
                        'price' => $service->price,
                    ];
                }),
            ];

            return response()->json([
                'success' => true,
                'datos' => $datosVenta
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al preparar conversión: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Marcar pedido como convertido (llamado después de crear la venta)
     */
    public function marcarComoConvertido(Request $request)
    {
        try {
            $pedido = Pedido::findOrFail($request->pedido_id);

            $pedido->update([
                'status' => 'convertido',
                'sale_id' => $request->sale_id,
                'converted_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pedido marcado como convertido'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Filtrar pedidos por fecha
     */
    public function filtroPorFecha(Request $request)
    {
        $query = Pedido::with(['userRegister', 'district', 'mechanic']);

        if ($request->fecha_desde) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->fecha_hasta) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $pedidos = $query->orderBy('id', 'desc')->get();

        return response()->json($pedidos);
    }
}
