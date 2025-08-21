<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Warehouse; // Obsoleto
use App\Models\Product;
use App\Models\Stock;
use App\Models\Buy;
use App\Models\DocumentType;
use App\Models\BuyItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\ProductPrice;
use App\Models\Supplier;  // ← Agregar esta línea
use App\Models\Tienda; 
use App\Models\PaymentMethod;  // ← Agregar esta línea
use Illuminate\Support\Facades\Http;  // ← AGREGAR esta línea
use App\Models\ScannedCode;           // ← AGREGAR esta línea
use App\Models\BuyPaymentMethod;      // ← AGREGAR esta línea (si no existe ya)
use App\Models\Warehouse; 
use App\Models\ProductPriceHistory;  
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\BuyCreditInstallment;
use App\Exports\BuysExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BuyTemplateExport;

class BuyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::where('status', 1)->with('brand', 'unit', 'prices', 'stocks')->get();
        $suppliers = Supplier::where('status', 1)->get();  // ← Agregar esta línea
        return view('buy.index', compact('products', 'suppliers'));  // ← Agregar 'suppliers' al compact
    }
    public function search(Request $request)
    {
        if (!$request->filled('fecha_desde') || !$request->filled('fecha_hasta')) {
            return response()->json(['error' => 'Faltan parámetros'], 400);
        }
        $user = auth()->user();
        $compras = Buy::with('userRegister')
            ->whereDate('fecha_registro', '>=', $request->fecha_desde)
            ->whereDate('fecha_registro', '<=', $request->fecha_hasta);
        return response()->json($compras->get());
    }
    public function addStock(Request $request)
    {
        //dd($request);
       // Validar los datos del request
    $request->validate([
        'total' => 'required|numeric',
        'customer_names_surnames' => 'required|string',
        'customer_address' => 'required|string',
        'customer_dni' => 'required|string',
        'igv' => 'required|numeric',
        'document_type_id' => 'required|integer',
    ]);

    DB::beginTransaction();

    try {
        // Obtener almacén central
        $centralWarehouse = Warehouse::getCentral();
        if (!$centralWarehouse) {
            throw new \Exception("No se encontró almacén central configurado");
        }

        // Crear la compra
        $buy = Buy::create([
            'total_price' => $request->total,
            'customer_names_surnames' => $request->customer_names_surnames,
            'customer_address' => $request->customer_address??NULL,
            'customer_dni' => $request->customer_dni,
            'igv' => $request->igv,
            'document_type_id' => $request->document_type_id,
            'warehouse_id' => $centralWarehouse->id, // Agregar warehouse_id
            'serie' => $this->generateSerie($request->document_type_id),
            'number' => $this->generateNumero($request->document_type_id),
        ]);

        // Procesar cada producto
        foreach ($request->products as $productData) {
            // Verificar existencia del producto
            $producto = Product::find($productData['product_id']);
            if (!$producto) {
                // Si el producto no existe, lanzar una excepción
                throw new \Exception("El producto con ID {$productData['producto_id']} no existe.");
            }
            
            // Actualizar o crear el stock
            $productoStock = Stock::firstOrCreate(
                ['product_id' => $producto->id],
                ['quantity' => $productData['quantity']]
            );
            // Actualizar precio solo donde type = 'buy' osea precio compra
            $productPriceBuy = ProductPrice::where('product_id', $productData['product_id'])
                ->where('type', 'buy')
                ->first();

            if ($productPriceBuy) {
                $productPriceBuy->price = $productData['price'];
                $productPriceBuy->save();
            }
            $productoStock->quantity += $productData['quantity'];
            $productoStock->save();

            // Registrar el detalle de la compra
            BuyItem::create([
                'buy_id' => $buy->id,
                'product_id' => $producto->id,
                'warehouse_id' => $centralWarehouse->id, // Agregar warehouse_id
                'quantity' => $productData['quantity'],
                'price' => $productData['price'],
            ]);
        }

        DB::commit();

        return response()->json(['message' => 'Stock y compra registrados correctamente'], 200);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['message' => 'Error al registrar la compra', 'error' => $e->getMessage()], 500);
    }
    }
    public function detallesBuy($id){
        $buy = Buy::with('buyItems.product','userRegister')->find($id);
        if (!$buy) {
            return abort(404, 'Venta no encontrada');
        }
        return response()->json([
            'buy' => $buy,
        ]);
    }
    public function generatePDF($id)
    {
        $buy = Buy::with('buyItems.product', 'userRegister', 'documentType', 'supplier')->find($id);
        if (!$buy) {
            return abort(404, 'compra no encontrada');
        }
        
        $buy->buy_items = $buy->buyItems ?? [];
        
        // Agregar información del proveedor incluyendo documento
        if ($buy->supplier) {
            $buy->supplier_document = $buy->supplier->nro_documento;
            $buy->supplier_doc_type = $buy->supplier->tipo_doc;
            $buy->supplier_full_name = $buy->supplier->nombre_negocio ?: $buy->supplier->getFullNameAttribute();
        } else {
            $buy->supplier_document = null;
            $buy->supplier_doc_type = null;
            $buy->supplier_full_name = null;
        }
        
        $pdf = Pdf::loadView('buy.pdf', compact('buy'));
        return $pdf->stream('buy.pdf');
    }
    /**
     * Show the form for creating a new resource.
     */
    // Busca el método create() (alrededor de la línea 125) y reemplázalo por:
    public function create()
    {
        $documentTypes = DocumentType::whereIn('name', ['NOTA DE VENTA'])->get();

        $paymentMethods = PaymentMethod::where('status', 1)->get();

        // Verificar que existe almacén central
        $centralWarehouse = Warehouse::getCentral();
        if (!$centralWarehouse) {
            return redirect()->back()->with('error', 'No se encontró almacén central configurado');
        }

        // Eliminado: 'tiendas' del compact() porque no se debe usar
        return view('buy.create', compact('documentTypes', 'paymentMethods'));
    }

    private function generateSerie($documentTypeId)
    {
        $documentTypeId = (int) $documentTypeId; // Convertir a entero

        $tipoDocumento = DocumentType::find($documentTypeId);

        if (!$tipoDocumento) {
            throw new \Exception('Tipo de documento no encontrado');
        }

        $prefijos = [
            'NOTA DE VENTA' => 'NC',
        ];

        if (!isset($prefijos[$tipoDocumento->name])) {
            throw new \Exception('Tipo de documento no válido');
        }

        // FACTURA y BOLETA DE VENTA usan tres dígitos (F001, B001), NOTA DE VENTA usa dos (NV01)
        $numeroSerie = ($tipoDocumento->name === 'NOTA DE VENTA') ? '01' : '001';

        return $prefijos[$tipoDocumento->name] . $numeroSerie;
    }

    private function generateNumero($documentTypeId)
    {
        $documentTypeId = (int) $documentTypeId;
        if ($documentTypeId <= 0) {
            throw new \Exception('ID de documento no válido');
        }
        $ultimaVenta = Buy::where('document_type_id', $documentTypeId)
            ->orderByDesc('number')
            ->first();
        $ultimoNumero = $ultimaVenta ? intval($ultimaVenta->number) : 0;
        $nuevoNumero = $ultimoNumero + 1;

        return (string) $nuevoNumero;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getPriceHistory($productId)
    {
        $history = ProductPriceHistory::with(['buy', 'user'])
            ->where('product_id', $productId)
            ->where('type', 'buy')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($history);
    }

    /**
     * Obtener compras filtradas para reportes
     */
    private function getFilteredBuys($filters)
    {
        $query = Buy::with([
            'userRegister', 
            'documentType',
            'buyItems.product',
            'paymentMethods.paymentMethod'
        ]);

        if (!empty($filters['fecha_desde'])) {
            $query->whereDate('fecha_registro', '>=', $filters['fecha_desde']);
        }
        
        if (!empty($filters['fecha_hasta'])) {
            $query->whereDate('fecha_registro', '<=', $filters['fecha_hasta']);
        }
        
        if (!empty($filters['delivery_status'])) {
            $query->where('delivery_status', $filters['delivery_status']);
        }

        // Eliminados: filtros por supplier_id y tienda_id ya que no se usarán

        return $query->orderBy('fecha_registro', 'desc')->get();
    }

    
    /**
     * Validar códigos únicos escaneados
     */
    private function validateScannedCodes($product, $scannedCodes, $quantity)
    {
        if ($product->control_type !== 'codigo_unico') {
            return true;
        }

        if (count($scannedCodes) !== $quantity) {
            throw new \Exception("El producto {$product->description} requiere escanear {$quantity} códigos únicos");
        }

        // Verificar que los códigos no estén duplicados
        $uniqueCodes = array_unique($scannedCodes);
        if (count($uniqueCodes) !== count($scannedCodes)) {
            throw new \Exception("Hay códigos duplicados para el producto {$product->description}");
        }

        // Verificar que los códigos no existan ya en el sistema
        foreach ($scannedCodes as $code) {
            $existingCode = ScannedCode::where('code', $code)->first();
            if ($existingCode) {
                throw new \Exception("El código {$code} ya existe en el sistema");
            }
        }

        return true;
    }

    
    /**
     * Reporte de productos más comprados
     */
    public function topProductsReport(Request $request)
    {
        $dateFrom = $request->fecha_desde;
        $dateTo = $request->fecha_hasta;
        $limit = $request->limit ?? 20;

        $productos = DB::table('buy_items')
            ->join('products', 'buy_items.product_id', '=', 'products.id')
            ->join('buys', 'buy_items.buy_id', '=', 'buys.id')
            ->whereDate('buys.fecha_registro', '>=', $dateFrom)
            ->whereDate('buys.fecha_registro', '<=', $dateTo)
            ->select(
                'products.description',
                'products.code_sku',
                DB::raw('SUM(buy_items.quantity) as total_quantity'),
                DB::raw('SUM(buy_items.quantity * buy_items.price) as total_amount'),
                DB::raw('AVG(buy_items.price) as avg_price'),
                DB::raw('COUNT(DISTINCT buy_items.buy_id) as total_purchases')
            )
            ->groupBy('products.id', 'products.description', 'products.code_sku')
            ->orderBy('total_quantity', 'desc')
            ->limit($limit)
            ->get();

        $pdf = Pdf::loadView('buy.top_products_report', compact(
            'productos',
            'dateFrom', 
            'dateTo',
            'limit'
        ));

        return $pdf->download('reporte_productos_mas_comprados.pdf');
    }

    /**
     * Actualizar precios masivamente
     */
    public function updatePricesMassive(Request $request)
    {
        $request->validate([
            'updates' => 'required|array',
            'updates.*.product_id' => 'required|exists:products,id',
            'updates.*.new_price' => 'required|numeric|min:0',
            'updates.*.price_type' => 'required|in:buy,sale,wholesale'
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->updates as $update) {
                $productPrice = ProductPrice::where('product_id', $update['product_id'])
                    ->where('type', $update['price_type'])
                    ->first();

                if ($productPrice) {
                    // Guardar historial antes de actualizar
                    ProductPriceHistory::create([
                        'product_id' => $update['product_id'],
                        'price' => $productPrice->price,
                        'type' => $update['price_type']
                    ]);

                    // Actualizar precio
                    $productPrice->update(['price' => $update['new_price']]);
                }
            }

            DB::commit();
            return response()->json(['message' => 'Precios actualizados correctamente'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al actualizar precios', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Obtener estadísticas de compras
     */
    public function getStatistics(Request $request)
    {
        $dateFrom = $request->fecha_desde ?? now()->startOfMonth();
        $dateTo = $request->fecha_hasta ?? now()->endOfMonth();

        $stats = [
            'total_compras' => Buy::whereDate('fecha_registro', '>=', $dateFrom)
                ->whereDate('fecha_registro', '<=', $dateTo)
                ->count(),
            
            'total_monto' => Buy::whereDate('fecha_registro', '>=', $dateFrom)
                ->whereDate('fecha_registro', '<=', $dateTo)
                ->sum('total_price'),
            
            'compras_pendientes' => Buy::where('delivery_status', 'pending')
                ->whereDate('fecha_registro', '>=', $dateFrom)
                ->whereDate('fecha_registro', '<=', $dateTo)
                ->count(),
            
            'compras_recibidas' => Buy::where('delivery_status', 'received')
                ->whereDate('fecha_registro', '>=', $dateFrom)
                ->whereDate('fecha_registro', '<=', $dateTo)
                ->count(),
            
            'proveedores_activos' => Buy::whereDate('fecha_registro', '>=', $dateFrom)
                ->whereDate('fecha_registro', '<=', $dateTo)
                ->distinct('supplier_id')
                ->count(),
            
            'productos_comprados' => DB::table('buy_items')
                ->join('buys', 'buy_items.buy_id', '=', 'buys.id')
                ->whereDate('buys.fecha_registro', '>=', $dateFrom)
                ->whereDate('buys.fecha_registro', '<=', $dateTo)
                ->sum('buy_items.quantity')
        ];

        return response()->json($stats);
    }

    /**
     * Obtener lista filtrada de compras
     */
    // Reemplaza el método filteredList() completo:
    public function filteredList(Request $request)
    {
        $query = Buy::with(['documentType', 'userRegister']);

        if ($request->fecha_desde) {
            $query->whereDate('fecha_registro', '>=', $request->fecha_desde);
        }
        
        if ($request->fecha_hasta) {
            $query->whereDate('fecha_registro', '<=', $request->fecha_hasta);
        }
        
        if ($request->products_status) {
            $query->where('delivery_status', $request->products_status === 'recibidos' ? 'received' : 'pending');
        }

        // Eliminado: filtro por supplier_id ya que no se usa

        // Agregar paginación
        $perPage = $request->per_page ?? 15;
        $buys = $query->orderBy('fecha_registro', 'desc')->paginate($perPage);  
        // Agregar status de productos para la vista
        $buys->getCollection()->each(function($buy) {
            $buy->products_status = $buy->delivery_status === 'received' ? 'recibidos' : 'pendientes';
        });

        return response()->json($buys);
    }

    /**
     * Exportar reportes
     */
    public function exportReports(Request $request)
    {
        $filters = [
            'fecha_desde' => $request->fecha_desde,
            'fecha_hasta' => $request->fecha_hasta,
            'products_status' => $request->products_status,
            'supplier_id' => $request->supplier_id
        ];

        $compras = $this->getFilteredBuys($filters);

        if ($request->format === 'excel') {
            return $this->exportExcel($compras);
        } else {
            return $this->generateDetailedPDF($compras);
        }
    }

    /**
     * Descargar plantilla de importación
     */
    public function downloadImportTemplate()
    {
        return Excel::download(new BuyTemplateExport(), 'plantilla_importacion_compras.xlsx');
    }

    /**
     * Importar compras desde archivo (método legacy - redirige al nuevo proceso)
     */
    public function importBuys(Request $request)
    {
        // Redirigir al nuevo método de procesamiento
        return $this->processImportFile($request);
    }

// ARCHIVO: app/Http/Controllers/BuyController.php
// AGREGAR estas funciones al final del archivo, antes del último }

    /**
     * Buscar productos por código, SKU, código de barras o nombre
     */
    public function searchProducts(Request $request)
    {
        $search = $request->search;
        
        if (empty($search)) {
            return response()->json([]);
        }
        
        $products = Product::with(['prices', 'brand', 'unit', 'stocks'])
            ->where('status', 1)
            ->where(function($query) use ($search) {
                $query->where('code', 'LIKE', "%{$search}%")
                    ->orWhere('code_bar', 'LIKE', "%{$search}%")
                    ->orWhere('code_sku', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            })
            ->limit(10)
            ->get();
        
        // Agregar información de precios y stock
        $products->each(function($product) {
            $product->precio_compra = $product->prices->where('type', 'buy')->first()->price ?? 0;
            $product->precio_venta = $product->prices->where('type', 'sale')->first()->price ?? 0;
            $product->stock_total = $product->stocks->sum('quantity');
        });
        
        return response()->json($products);
    }

    /**
     * Buscar información de documento (DNI/RUC)
     */
    public function buscarDocumento($doc)
    {
        $token = env('RENIEC_API_TOKEN');
        
        if (strlen($doc) == 8) {
            $url = 'https://dniruc.apisperu.com/api/v1/dni/' . $doc . '?token=' . $token;
        } else {
            $url = 'https://dniruc.apisperu.com/api/v1/ruc/' . $doc . '?token=' . $token;
        }
        
        // SOLUCIÓN: Desactiva verificación SSL solo en desarrollo
        $response = Http::withoutVerifying()->get($url);
        
        if ($response->successful()) {
            $data = $response->json();
            
            if (strlen($doc) == 8) {
                $data["nombre"] = $data["nombres"] . " " . $data["apellidoPaterno"] . " " . $data["apellidoMaterno"];
            } else {
                $data["nombre"] = $data["razonSocial"];
            }
            
            return response()->json($data);
        } else {
            return response()->json([
                'message' => 'No se pudo obtener la información del documento',
                'status' => $response->status()
            ], $response->status());
        }
    }

    /**
     * Registrar nueva compra con validaciones completas
     */
    public function storePurchase(Request $request)
    {
        $request->validate([
            'document_type_id' => 'required|exists:document_types,id',
            'payment_type' => 'required|in:cash,credit',
            'total_price' => 'required|numeric|min:0',
            'igv' => 'required|numeric|min:0',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'payment_methods' => 'required|array|min:1'
        ]);
        
        DB::beginTransaction();
        
        try {

            $centralWarehouse = Warehouse::getCentral();

            // Crear la compra
            $buy = Buy::create([
                'supplier_id' => null,
                'warehouse_id' => $centralWarehouse->id,
                'document_type_id' => $request->document_type_id,
                'payment_type' => $request->payment_type,
                'delivery_status' => 'pending',
                'total_price' => $request->total_price,
                'igv' => $request->igv,
                'observation' => $request->observation,
                'serie' => $this->generateSerie($request->document_type_id),
                'number' => $this->generateNumero($request->document_type_id),
                'received_date' => null,
                'customer_dni' => '', // Campo requerido por el modelo
                'customer_names_surnames' => '', // Campo requerido por el modelo
                'customer_address' => '' // Campo requerido por el modelo
            ]);
            
            // Procesar productos
            foreach ($request->products as $productData) {
                $product = Product::findOrFail($productData['product_id']);
                
                
                // Validar códigos escaneados SOLO si es código único Y productos están recibidos
                $scannedCodes = [];
                if ($product->control_type === 'codigo_unico' && $request->delivery_status === 'received') {
                    // Buscar códigos escaneados en el array de productos
                    $productos = $request->input('products', []);
                    foreach ($productos as $prod) {
                        if (isset($prod['product_id']) && $prod['product_id'] == $product->id) {
                            if (isset($prod['scanned_codes']) && !empty($prod['scanned_codes'])) {
                                if (is_string($prod['scanned_codes'])) {
                                    $decoded = json_decode($prod['scanned_codes'], true);
                                    $scannedCodes = is_array($decoded) ? $decoded : [];
                                } elseif (is_array($prod['scanned_codes'])) {
                                    $scannedCodes = $prod['scanned_codes'];
                                }
                                break;
                            }
                        }
                    }
                    
                    if (count($scannedCodes) !== (int)$productData['quantity']) {
                        throw new \Exception("El producto {$product->description} requiere escanear {$productData['quantity']} códigos únicos. Se recibieron " . count($scannedCodes) . " códigos.");
                    }
                }

                
                // Crear item de compra
                $buyItem = BuyItem::create([
                    'buy_id' => $buy->id,
                    'product_id' => $product->id,
                    'warehouse_id' => $centralWarehouse->id,
                    'quantity' => $productData['quantity'],
                    'price' => $productData['price'],
                    'custom_price' => isset($productData['use_custom_price']) && $productData['use_custom_price'] ? $productData['price'] : null,
                    'scanned_codes' => $product->control_type === 'codigo_unico' ? $scannedCodes : [] // Solo guardar códigos si es código único
                ]);

                
                // Actualizar stock solo si los productos están recibidos
                if ($request->delivery_status === 'received') {
                    $stock = Stock::firstOrCreate(
                        ['product_id' => $product->id, 'tienda_id' => $request->tienda_id],
                        ['quantity' => 0, 'minimum_stock' => 0]
                    );
                    
                    $stock->quantity += $productData['quantity'];
                    $stock->save();
                    
                    // Guardar códigos escaneados si aplica
                    if ($product->control_type === 'codigo_unico' && !empty($scannedCodes)) {
                        foreach ($scannedCodes as $code) {
                            ScannedCode::create([
                                'stock_id' => $stock->id,
                                'code' => $code
                            ]);
                        }
                    }
                }
                
                // Guardar historial de precios si es precio personalizado
                if (isset($productData['use_custom_price']) && $productData['use_custom_price']) {
                    ProductPriceHistory::create([
                        'product_id' => $product->id,
                        'buy_id' => $buy->id,
                        'price' => $productData['price'],
                        'type' => 'buy'
                    ]);
                } else {
                    // Actualizar precio de compra del producto
                    $productPrice = ProductPrice::where('product_id', $product->id)
                        ->where('type', 'buy')
                        ->first();
                    
                    if ($productPrice) {
                        $productPrice->update(['price' => $productData['price']]);
                    }
                }
            }
            
            // Guardar métodos de pago
            foreach ($request->payment_methods as $index => $paymentMethod) {
                $buyPaymentMethod = BuyPaymentMethod::create([
                    'buy_id' => $buy->id,
                    'payment_method_id' => $paymentMethod['payment_method_id'],
                    'amount' => $paymentMethod['amount'],
                    'installments' => $paymentMethod['installments'] ?? 1,
                    'due_date' => $paymentMethod['due_date'] ?? null
                ]);
                
                // Generar cuotas si el pago es a crédito y tiene más de 1 cuota
                if ($request->payment_type === 'credit' && $buyPaymentMethod->installments > 1) {
                    $installmentsConfig = null;
                    if ($request->has("installments_config.{$index}")) {
                        $installmentsConfig = json_decode($request->input("installments_config.{$index}"), true);
                    }
                    
                    $this->generateCreditInstallments($buyPaymentMethod, $installmentsConfig);
                }
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Compra registrada exitosamente',
                'buy_id' => $buy->id
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar compra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generar cuotas automáticamente para pagos a crédito
     */
    private function generateCreditInstallments($buyPaymentMethod, $installmentsConfig = null)
    {
        if ($buyPaymentMethod->installments <= 1) {
            return; // No generar cuotas si es pago único
        }

        $installmentAmount = $buyPaymentMethod->amount / $buyPaymentMethod->installments;
        $baseDate = $buyPaymentMethod->due_date ? Carbon::parse($buyPaymentMethod->due_date) : Carbon::now();

        for ($i = 1; $i <= $buyPaymentMethod->installments; $i++) {
            // Calcular fecha de vencimiento para cada cuota
            $dueDate = $baseDate->copy()->addMonths($i - 1);
            
            // Si hay configuración personalizada de cuotas, usar esos datos
            $customAmount = $installmentAmount;
            $customDate = $dueDate;
            
            if (is_array($installmentsConfig)) {
                foreach ($installmentsConfig as $config) {
                    if ($config['installment_number'] == $i) {
                        $customAmount = $config['amount'];
                        $customDate = Carbon::parse($config['due_date']);
                        break;
                    }
                }
            }

            BuyCreditInstallment::create([
                'buy_payment_method_id' => $buyPaymentMethod->id,
                'installment_number' => $i,
                'amount' => $customAmount,
                'due_date' => $customDate,
                'status' => 'pendiente'
            ]);
        }
    }

    /**
     * Generar PDF detallado de compras
     */
    private function generateDetailedPDF($compras)
    {
        // Cargar datos adicionales para el reporte
        $totalCompras = $compras->count();
        $montoTotal = $compras->sum('total_price');
        $igvTotal = $compras->sum('igv');
        $comprasRecibidas = $compras->where('delivery_status', 'received')->count();
        $comprasPendientes = $compras->where('delivery_status', 'pending')->count();
        
        $estadisticasPorMes = $compras->groupBy(function($compra) {
            return \Carbon\Carbon::parse($compra->fecha_registro)->format('Y-m');
        })->map(function($comprasMes, $mes) {
            return [
                'mes' => $mes,
                'total_compras' => $comprasMes->count(),
                'monto_total' => $comprasMes->sum('total_price'),
                'productos_recibidos' => $comprasMes->where('delivery_status', 'received')->count(),
                'productos_pendientes' => $comprasMes->where('delivery_status', 'pending')->count()
            ];
        })->sortByDesc('monto_total');

        // Productos más comprados
        $productosComprados = [];
        foreach($compras as $compra) {
            foreach($compra->buyItems as $item) {
                $key = $item->product_id;
                if(isset($productosComprados[$key])) {
                    $productosComprados[$key]['cantidad_total'] += $item->quantity;
                    $productosComprados[$key]['monto_total'] += ($item->quantity * $item->price);
                    $productosComprados[$key]['compras_count'] += 1;
                } else {
                    $productosComprados[$key] = [
                        'producto' => $item->product->description ?? 'Producto eliminado',
                        'sku' => $item->product->code_sku ?? 'N/A',
                        'cantidad_total' => $item->quantity,
                        'monto_total' => ($item->quantity * $item->price),
                        'compras_count' => 1,
                        'precio_promedio' => $item->price
                    ];
                }
            }
        }
        
        // Convertir a collection solo para ordenar y luego volver a array
        $productosComprados = collect($productosComprados)->sortByDesc('cantidad_total')->take(15)->values()->toArray();

        $estadisticasPorMes = $estadisticasPorMes->values()->toArray();
        // $productosComprados ya es array, no necesita conversión adicional

        $datos = compact(
            'compras', 
            'totalCompras', 
            'montoTotal', 
            'igvTotal',
            'comprasRecibidas', 
            'comprasPendientes',
            'estadisticasPorMes',
            'productosComprados'
        );

        $pdf = Pdf::loadView('buy.detailed_report', $datos);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('reporte_detallado_compras_' . date('Y-m-d_H-i') . '.pdf');
    }

    /**
     * Exportar compras a Excel
     */
    private function exportExcel($compras)
    {
        return Excel::download(new BuysExport($compras), 'reporte_compras_detallado_' . date('Y-m-d_H-i') . '.xlsx');
    }

    /**
     * Procesar archivo de importación y mostrar preview
     */
    // Busca el método processImportFile() y reemplázalo completamente:
    /**
     * Procesar archivo de importación y mostrar preview
     */
    public function processImportFile(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            $import = new \App\Imports\BuysImport();
            $rawData = Excel::toArray($import, $request->file('file'));
            
            // Procesar los datos usando el método de la clase import
            $result = $import->processImportData($rawData[0]);
            
            return response()->json([
                'success' => true,
                'data' => $result['data'] ?? [],
                'errors' => $result['errors'] ?? []
            ]);

        } catch (\Exception $e) {
            \Log::error('Error procesando archivo de importación: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el archivo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Importar compras seleccionadas
     */
    public function importSelectedBuys(Request $request)
    {

        $request->validate([
            'selected_buys' => 'required|array|min:1',
            //             // 'selected_buys.*.supplier' => 'required', // Deshabilitado porque el proveedor ya no es requerido para la importación. // Deshabilitado segun requerimiento
            'selected_buys.*.product' => 'required',
            'selected_buys.*.cantidad' => 'required|numeric|min:1',
            'selected_buys.*.precio' => 'required|numeric|min:0'
        ]);

        DB::beginTransaction();

        try {
            $importedCount = 0;
            $errors = [];

            // Agrupar por compra (fecha y tipo documento, sin proveedor ni tienda)
            $groupedBuys = collect($request->selected_buys)->groupBy(function($item) {
                return $item['fecha'] . '_' . $item['document_type']['id'];
            });

            // Busca el foreach ($groupedBuys as $group) dentro del método importSelectedBuys() (alrededor de línea 800) 
            // y reemplaza la sección de creación de Buy::create():

            foreach ($groupedBuys as $group) {
                try {
                    $firstItem = $group->first();
                    
                    // Obtener almacén central
                    $centralWarehouse = Warehouse::getCentral();
                    if (!$centralWarehouse) {
                        throw new \Exception("No se encontró almacén central configurado");
                    }
                    
                    // Obtener almacén central primero
                    $centralWarehouse = Warehouse::getCentral();
                    if (!$centralWarehouse) {
                        throw new \Exception("No se encontró almacén central configurado");
                    }
                    
                    // Crear la compra principal
                    $totalPrice = $group->sum(function($item) {
                        return $item['cantidad'] * $item['precio'];
                    });
                    
                    $igv = $totalPrice * 0.18;

                    $buy = Buy::create([
                        'supplier_id' => null, // Eliminado: ya no se asigna proveedor
                        'warehouse_id' => $centralWarehouse->id, // Siempre almacén central
                        'document_type_id' => $firstItem['document_type']['id'],
                        'payment_type' => $firstItem['payment_method']['type'],
                        'delivery_status' => $firstItem['delivery_status'],
                        'total_price' => $totalPrice,
                        'igv' => $igv,
                        'observation' => $firstItem['observacion'],
                        'serie' => $this->generateSerie($firstItem['document_type']['id']),
                        'number' => $this->generateNumero($firstItem['document_type']['id']),
                        'received_date' => $firstItem['delivery_status'] === 'received' ? now() : null,
                        'fecha_registro' => $firstItem['fecha'],
                        'customer_dni' => '',
                        'customer_names_surnames' => '',
                        'customer_address' => ''
                    ]);

                    // Crear items de compra
                    foreach ($group as $item) {
                        BuyItem::create([
                            'buy_id' => $buy->id,
                            'product_id' => $item['product']['id'],
                            'warehouse_id' => $centralWarehouse->id, // Siempre almacén central
                            'quantity' => $item['cantidad'],
                            'price' => $item['precio']
                        ]);

                        // Actualizar stock si está marcado como recibido
                        if ($item['delivery_status'] === 'received') {
                            $stock = Stock::firstOrCreate(
                                ['product_id' => $item['product']['id']],
                                ['quantity' => 0, 'minimum_stock' => 0]
                            );
                            
                            $stock->quantity += $item['cantidad'];
                            $stock->save();
                        }
                    }

                    // Crear método de pago
                    BuyPaymentMethod::create([
                        'buy_id' => $buy->id,
                        'payment_method_id' => $firstItem['payment_method']['id'],
                        'amount' => $totalPrice,
                        'installments' => 1
                    ]);

                    $importedCount++;

                } catch (\Exception $e) {
                    // Eliminado: referencia a supplier en el error
                    $errors[] = "Error al procesar compra de la fila: " . $e->getMessage();
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Se importaron {$importedCount} compras exitosamente",
                'imported_count' => $importedCount,
                'errors' => $errors
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Añadimos un log para capturar el error detallado
            Log::error("Error en importación de compras: " . $e->getMessage() . " Archivo: " . $e->getFile() . " Línea: " . $e->getLine());

            return response()->json([
                'success' => false,
                'message' => 'Error al importar compras: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener detalles completos de la compra para modal
     */
    public function getModalDetails($id)
    {
        $buy = Buy::with([
            'buyItems.product.brand',
            'buyItems.product.unit',
            'supplier',
            'tienda',
            'documentType',
            'userRegister',
            'paymentMethods.paymentMethod',
            'paymentMethods.creditInstallments'
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'buy' => $buy
        ]);
    }

    /**
     * Marcar cuota como pagada
     */
    public function markInstallmentAsPaid(Request $request, $installmentId)
    {
        $request->validate([
            'paid_amount' => 'nullable|numeric|min:0'
        ]);

        DB::beginTransaction();
        
        try {
            $installment = BuyCreditInstallment::findOrFail($installmentId);
            
            $installment->update([
                'status' => 'pagado',
                'paid_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cuota marcada como pagada exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al marcar la cuota como pagada: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Desmarcar cuota como pagada (volver a pendiente)
     */
    public function markInstallmentAsPending($installmentId)
    {
        DB::beginTransaction();
        
        try {
            $installment = BuyCreditInstallment::findOrFail($installmentId);
            
            $installment->update([
                'status' => 'pendiente',
                'paid_at' => null
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cuota marcada como pendiente exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado de la cuota: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener datos para modal de recepción
     */
    public function getReceptionData($id)
    {
        $buy = Buy::with([
            'buyItems.product.brand',
            'buyItems.product.unit',
            'supplier',
            'tienda'
        ])->findOrFail($id);

        // Solo permitir recepción si está pendiente
        if ($buy->delivery_status === 'received') {
            return response()->json([
                'success' => false,
                'message' => 'Esta compra ya ha sido recepcionada'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'buy' => $buy
        ]);
    }

    /**
     * Procesar recepción de productos
     */
    public function processReception(Request $request, $id)
    {
        $request->validate([
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity_received' => 'required|integer|min:0',
            'products.*.scanned_codes' => 'nullable|array'
        ]);

        DB::beginTransaction();

        try {
            $buy = Buy::findOrFail($id);

            if ($buy->delivery_status === 'received') {
                throw new \Exception('Esta compra ya ha sido recepcionada');
            }

            foreach ($request->products as $productData) {
                $buyItem = BuyItem::where('buy_id', $id)
                    ->where('product_id', $productData['product_id'])
                    ->first();

                if (!$buyItem) {
                    throw new \Exception("Producto no encontrado en la compra");
                }

                $product = Product::findOrFail($productData['product_id']);
                $quantityReceived = $productData['quantity_received'];

                // Validar códigos únicos si es necesario
                if ($product->control_type === 'codigo_unico' && $quantityReceived > 0) {
                    $scannedCodes = $productData['scanned_codes'] ?? [];
                    
                    if (count($scannedCodes) !== $quantityReceived) {
                        throw new \Exception("El producto {$product->description} requiere {$quantityReceived} códigos únicos, pero se recibieron " . count($scannedCodes));
                    }

                    // Verificar que los códigos no existan
                    foreach ($scannedCodes as $code) {
                        $existingCode = ScannedCode::where('code', $code)->first();
                        if ($existingCode) {
                            throw new \Exception("El código {$code} ya existe en el sistema");
                        }
                    }

                    // Guardar códigos escaneados en el BuyItem
                    $buyItem->scanned_codes = $scannedCodes;
                }

                // Actualizar stock solo para la cantidad recibida
                if ($quantityReceived > 0) {
                    $stock = Stock::firstOrCreate(
                        ['product_id' => $product->id, 'tienda_id' => $buy->tienda_id],
                        ['quantity' => 0, 'minimum_stock' => 0]
                    );

                    $stock->quantity += $quantityReceived;
                    $stock->save();

                    // Guardar códigos escaneados en la tabla scanned_codes
                    if ($product->control_type === 'codigo_unico' && !empty($scannedCodes)) {
                        foreach ($scannedCodes as $code) {
                            ScannedCode::create([
                                'stock_id' => $stock->id,
                                'code' => $code
                            ]);
                        }
                    }
                }

                $buyItem->save();
            }

            // Marcar como recibida si todos los productos fueron recepcionados
            $allProductsReceived = true;
            foreach ($buy->buyItems as $item) {
                // Si no hay códigos escaneados y el producto requiere códigos únicos, no está completo
                if ($item->product->control_type === 'codigo_unico') {
                    if (empty($item->scanned_codes) || count($item->scanned_codes) < $item->quantity) {
                        $allProductsReceived = false;
                        break;
                    }
                }
            }

            if ($allProductsReceived) {
                $buy->update([
                    'delivery_status' => 'received',
                    'received_date' => now()
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Recepción procesada exitosamente',
                'fully_received' => $allProductsReceived
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la recepción: ' . $e->getMessage()
            ], 500);
        }
    }

}
