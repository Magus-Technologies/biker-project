<?php

namespace App\Http\Controllers;

use App\Exports\ImportTemplateExport;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Stock;
use App\Models\Unit;
// use App\Models\Warehouse; // Obsoleto
use App\Imports\ProductsImport;
use App\Models\ScannedCode;
use App\Models\Tienda;
use App\Models\UnitType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException as ValidationValidationException;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Reemplaza la función index() existente
    public function index()
    {
        $tiendas = Tienda::where('status', 1)->get();
        $products = Product::where('status', 1)->with('brand', 'unit', 'prices', 'stocks.tienda')->get();
        return view('product.index', compact('products', 'tiendas'));
    }

    public function export(Request $request)
    {
        // Obtén el parámetro 'filter' enviado desde la vista
        $filter = $request->get('filter', 'productos');

        if ($filter === 'productos') {
            // Opción "Exportar por Productos": Exporta todos los productos (con relaciones)
            $query = Product::query()->with('brand', 'unit', 'tienda');

            return Excel::download(new class($query) implements FromQuery, WithHeadings, WithMapping {
                protected $query;

                public function __construct($query)
                {
                    $this->query = $query;
                }

                public function query()
                {
                    // Selecciona los campos de la tabla products
                    return $this->query->select(
                        'id',
                        'code',
                        'description',
                        'model',
                        'location',
                        'tienda_id',
                        'brand_id',
                        'unit_id',
                        'status'
                    );
                }

                public function headings(): array
                {
                    return [
                        'ID',
                        'Código',
                        'Descripción',
                        'Modelo',
                        'Localización',
                        'Tienda',
                        'Marca',
                        'Unidad',
                        'Estado',
                    ];
                }

                public function map($product): array
                {
                    return [
                        $product->id,
                        $product->code,
                        $product->description,
                        $product->model,
                        $product->location,
                        $product->tienda->nombre ?? '',
                        $product->brand->name ?? '',
                        $product->unit->name ?? '',
                        $product->status,
                    ];
                }
            }, 'productos.xlsx');
        } elseif ($filter === 'stock_minimo') {
            // Opción "Exportar por Stock Mínimo": Exporta solo aquellos stocks donde la cantidad es igual al stock mínimo
            // Se asume que existe un modelo Stock con la relación 'product'
            $query = Stock::query()->with('product')->whereColumn('quantity', 'minimum_stock');

            return Excel::download(new class($query) implements FromQuery, WithHeadings, WithMapping {
                protected $query;

                public function __construct($query)
                {
                    $this->query = $query;
                }

                public function query()
                {
                    return $this->query->select(
                        'product_id',
                        'quantity',
                        'minimum_stock'
                    );
                }

                public function headings(): array
                {
                    return [
                        'Producto',
                        'Cantidad',
                        'Stock Mínimo',
                    ];
                }

                public function map($stock): array
                {
                    return [
                        $stock->product->description ?? '',  // o product code, según lo que necesites
                        $stock->quantity,
                        $stock->minimum_stock,
                    ];
                }
            }, 'stock_minimo.xlsx');
        } elseif (
            $filter === 'precio'
        ) {
            $query = ProductPrice::with('product')
                ->whereHas('product', function ($q) {
                    $q->where('status', 1);
                });

            return Excel::download(new class($query) implements FromQuery, WithHeadings, WithMapping {
                protected $query;

                public function __construct($query)
                {
                    $this->query = $query;
                }

                public function query()
                {
                    // Seleccionamos los campos de la tabla product_prices
                    return $this->query->select('id', 'product_id', 'price');
                }

                public function headings(): array
                {
                    return [
                        'Producto',
                        'Precio',
                    ];
                }

                public function map($row): array
                {
                    return [
                        // Utiliza la relación definida en ProductPrice para obtener la descripción del producto
                        $row->product->description ?? '',
                        $row->price,
                    ];
                }
            }, 'precio.xlsx');
        }
    }

    public function search(Request $request)
    {
        $buscar = $request->buscar;
        $query = Product::where('status', 1)
            ->with('brand', 'unit', 'images', 'prices', 'stocks.tienda');  // ← Quité 'warehouse' y agregué 'stocks.tienda'

        if (!empty($buscar)) {
            $query->where(function ($q) use ($buscar) {
                $q
                    ->where('description', 'like', "%{$buscar}%")
                    ->orWhere('code', 'like', "%{$buscar}%");
            });
        }

        // Filtro de ejemplo por si se quiere buscar por tienda en el futuro
        // if ($request->has('tienda_id') && $request->tienda_id !== 'todos') {
        //     $query->where('tienda_id', $request->tienda_id);
        // }

        $products = $query->get();

        // Convertir la ruta de cada imagen para que incluya la URL completa
        $products->each(function ($product) {
            $product->images->transform(function ($img) {
                $img->image_path = asset($img->image_path);
                return $img;
            });
        });

        return response()->json($products);
    }

    public function descargarPlantilla()
    {
        return Excel::download(new ImportTemplateExport, 'Plantilla_Importacion.xlsx');
    }

    /**
     * Vista previa del Excel antes de importar
     */
    public function preview(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            $file = $request->file('file');
            $data = Excel::toArray([], $file);

            if (empty($data) || empty($data[0])) {
                return response()->json([
                    'success' => false,
                    'message' => 'El archivo está vacío o no contiene datos válidos'
                ], 422);
            }

            $rows = $data[0];
            $products = [];

            // Saltar la primera fila (encabezados) y procesar el resto
            for ($i = 1; $i < count($rows); $i++) {
                $row = $rows[$i];

                // Validar que la fila tenga datos mínimos (al menos descripción)
                if (empty($row[2])) {
                    continue; // Saltar filas sin descripción
                }

                $products[] = [
                    'code_sku' => $row[0] ?? '',
                    'code_bar' => $row[1] ?? '',
                    'description' => $row[2] ?? '',
                    'model' => $row[3] ?? '',
                    'location' => $row[4] ?? '',
                    'brand' => $row[5] ?? '',
                    'unit' => $row[6] ?? '',
                    'purchase_price' => $row[7] ?? 0,
                    'wholesale_price' => $row[8] ?? 0,
                    'sucursalA_price' => $row[9] ?? 0,
                    'sucursalB_price' => $row[10] ?? 0,
                    'stock' => $row[11] ?? 0,
                    'minimum_stock' => $row[12] ?? 5,
                ];
            }

            if (empty($products)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontraron productos válidos en el archivo'
                ], 422);
            }

            return response()->json([
                'success' => true,
                'data' => $products,
                'message' => 'Archivo procesado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el archivo: ' . $e->getMessage()
            ], 500);
        }
    }

    public function import(Request $request)
    {
        // Ahora recibe datos JSON en lugar de archivo
        try {
            $products = $request->input('products');
            $tiendaId = $request->input('tienda_id');

            if (empty($products)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay productos para importar'
                ], 422);
            }

            if (!$tiendaId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Debe seleccionar una tienda'
                ], 422);
            }

            DB::beginTransaction();

            $imported = 0;
            $errors = [];

            foreach ($products as $index => $productData) {
                try {
                    // Crear el producto
                    $product = new Product();
                    $product->code_sku = $productData['code_sku'] ?? null;
                    $product->code_bar = $productData['code_bar'] ?? null;
                    $product->description = $productData['description'];
                    $product->model = $productData['model'] ?? null;
                    $product->tienda_id = $tiendaId;
                    $product->location = $productData['location'] ?? 'Almacén';
                    // purchase_price no existe en la tabla products - se ignorará por ahora

                    // Buscar o crear marca
                    if (!empty($productData['brand'])) {
                        $brand = Brand::firstOrCreate(['name' => $productData['brand']]);
                        $product->brand_id = $brand->id;
                    }

                    // Buscar o crear unidad
                    if (!empty($productData['unit'])) {
                        $unit = Unit::firstOrCreate(['name' => $productData['unit']]);
                        $product->unit_id = $unit->id;
                    } else {
                        $unit = Unit::first();
                        $product->unit_id = $unit ? $unit->id : null;
                    }

                    $product->save();

                    // Crear stock si hay cantidad
                    $stockQuantity = $productData['stock'] ?? 0;
                    $minimumStock = $productData['minimum_stock'] ?? 5;

                    if ($stockQuantity > 0) {
                        Stock::create([
                            'product_id' => $product->id,
                            'tienda_id' => $tiendaId,
                            'quantity' => $stockQuantity,
                            'minimum_stock' => $minimumStock
                        ]);
                    }

                    // Crear precios
                    $prices = [
                        'mayorista' => $productData['wholesale_price'] ?? 0,
                        'sucursalA' => $productData['sucursalA_price'] ?? 0,
                        'sucursalB' => $productData['sucursalB_price'] ?? 0,
                    ];

                    foreach ($prices as $type => $price) {
                        if ($price > 0) {
                            ProductPrice::create([
                                'product_id' => $product->id,
                                'type' => $type,
                                'price' => $price
                            ]);
                        }
                    }

                    $imported++;
                } catch (\Illuminate\Database\QueryException $e) {
                    // Error de duplicado (código único)
                    if ($e->errorInfo[1] == 1062) {
                        $errors[] = "Fila " . ($index + 2) . ": El producto '{$productData['description']}' con código '{$productData['code_sku']}' ya existe en el sistema. No se puede importar productos duplicados.";
                    } else {
                        $errors[] = "Fila " . ($index + 2) . ": Error en la base de datos - " . $e->getMessage();
                    }
                } catch (\Exception $e) {
                    $errors[] = "Fila " . ($index + 2) . ": " . $e->getMessage();
                }
            }

            if (!empty($errors)) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => $errors
                ], 422);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Se importaron {$imported} productos correctamente."
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error en la importación: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    // Reemplaza la función create() existente
    public function create()
    {
        $brands = Brand::all();
        $units = Unit::all();
        $tiendas = Tienda::where('status', 1)->get();
        return view('product.create', compact('brands', 'units', 'tiendas'));
    }

    public function generateCode()
    {
        $lastCodigo = Product::max('code') ?? '0000000';
        $nextCodigo = intval($lastCodigo) + 1;
        return str_pad($nextCodigo, 7, '0', STR_PAD_LEFT);
    }

    public function store(Request $request)
    {
        $messages = [
            'description.string' => 'La descripción debe ser un texto.',
            'model.required' => 'El modelo es obligatorio.',
            'tienda_id.exists' => 'La tienda seleccionada no es válida.',
            'brand.required' => 'La marca es obligatoria.',
            'unit_name.required' => 'La unidad es obligatoria.',
            'code_sku.required' => 'El código es obligatorio.',
            'code_sku.unique' => 'El código SKU ya está registrado.',
            'code_bar.unique' => 'El código de barras ya está registrado.',
            'prices.array' => 'Los precios deben ser una lista.',
            'prices.*.numeric' => 'Cada precio debe ser un número válido.',
            'prices.*.min' => 'Cada precio debe ser mayor o igual a 0.',
        ];

        $validationRules = [
            'description' => 'nullable|string',
            'amount' => 'nullable|integer',
            'model' => 'required|string',
            'location' => 'nullable|string',
            'brand' => 'required|string|max:255',
            'unit_name' => 'required|string|max:255',
            'prices' => 'nullable|array',
            'prices.*' => 'nullable|numeric|min:0',
            'code_sku' => 'required|string|unique:products,code_sku',
            'code_bar' => 'required|string|unique:products,code_bar',
            'quantity' => 'nullable|integer|min:0',
            'control_type' => 'required|in:cantidad,codigo_unico',
            'tienda_id' => 'nullable|exists:tiendas,id', // Validación de tienda (opcional)
        ];

        try {
            $validated = $request->validate($validationRules, $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        // Solo después de que TODA la validación pase, generar código y comenzar transacción
        $validated['code'] = $this->generateCode();

        // Asegurar que el control_type se guarde correctamente
        $validated['control_type'] = $request->control_type;
        
        // Guardar tienda_id (puede ser NULL para almacén central)
        $validated['tienda_id'] = $request->tienda_id ?: null;

        DB::beginTransaction();

        try {
            // Normaliza la unidad y la crea si no existe
            $unitName = ucfirst(strtolower(trim($request->unit_name)));
            $unitTypeId = $this->determineUnitType($unitName);
            $unit = Unit::firstOrCreate([
                'name' => $unitName,
            ], [
                'unit_type_id' => $unitTypeId
            ]);
            $validated['unit_id'] = $unit->id;

            // Normaliza la marca y la crea si no existe
            $brandName = ucfirst(strtolower($request->brand));
            $brand = Brand::firstOrCreate(['name' => $brandName]);
            $validated['brand_id'] = $brand->id;

            $product = Product::create($validated);

            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('images/products'), $imageName);

                    $product->images()->create([
                        'image_path' => 'images/products/' . $imageName,
                    ]);
                }
            }

            $prices = $validated['prices'] ?? [];
            $priceData = [];
            foreach ($prices as $type => $price) {
                if (!is_null($price)) {
                    $priceData[] = [
                        'product_id' => $product->id,
                        'type' => $type,
                        'price' => $price,
                    ];
                }
            }

            // Definir quantity para uso posterior
            $quantity = $request->quantity ?? 0;

            // Crear stock en la tienda seleccionada o almacén central si hay cantidad
            if ($quantity > 0) {
                // Usar la tienda seleccionada o NULL para almacén central
                $tiendaId = $request->tienda_id ?: null;
                
                $stock = Stock::create([
                    'product_id' => $product->id,
                    'tienda_id' => $tiendaId,  // NULL indica almacén central, o el ID de la tienda
                    'quantity' => $request->quantity,
                    'minimum_stock' => $request->minimum_stock,
                ]);

                // Si es control por código único, guardar códigos escaneados
                if ($request->control_type === 'codigo_unico' && $request->scanned_codes) {
                    foreach ($request->scanned_codes as $code) {
                        ScannedCode::create([
                            'stock_id' => $stock->id,
                            'code' => $code
                        ]);
                    }
                }
            }

            if (!empty($priceData)) {
                ProductPrice::insert($priceData);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => '¡El producto ha sido registrado con éxito!' . ($request->tienda_id ? ' en la tienda seleccionada' : ' en el almacén central'),
                'product' => $product
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el producto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = Product::with('brand', 'unit', 'prices', 'images', 'stocks.tienda')->findOrFail($id);
            return view('product.show', compact('product'));
        } catch (\Throwable $th) {
            return redirect()->route('products.index')->with('error', 'Producto no encontrado');
        }
    }

    public function determineUnitType($unitName)
    {
        $unitTypeMappings = [
            'Peso' => ['kilogramos', 'gramos', 'toneladas'],
            'Volumen' => ['litros', 'mililitros', 'galones'],
            'Cantidad' => ['unidades', 'piezas', 'cajas'],
        ];

        foreach ($unitTypeMappings as $type => $keywords) {
            if (in_array(strtolower($unitName), $keywords)) {
                // Busca el ID del tipo, si no existe, lo crea
                return UnitType::firstOrCreate(['name' => $type])->id;
            }
        }

        // Si no se encuentra un tipo, se crea "Otro" y devuelve su ID
        return UnitType::firstOrCreate(['name' => 'Otro'])->id;
    }

    /**
     * Show the form for editing the specified resource.
     */
    // Reemplaza la función edit() existente
    public function edit(string $id)
    {
        try {
            $product = Product::with('brand', 'unit', 'prices')->findOrFail($id);
            $units = Unit::all();
            $tiendas = Tienda::where('status', 1)->get();
            
            // Obtener stock del producto (puede ser por tienda o sin tienda para almacén central)
            $productStock = Stock::where('product_id', $product->id)
                ->with('tienda', 'scannedCodes')
                ->get();

            return view('product.edit', compact('product', 'units', 'productStock', 'tiendas'));
        } catch (\Throwable $th) {
            return redirect()->route('products.index')->with('error', 'Error al cargar el producto: ' . $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // return response()->json($request);
        $messages = [
            'description.string' => 'La descripción debe ser un texto.',
            'model.required' => 'El modelo es obligatorio.',
            'tienda_id.required' => 'La tienda es obligatoria.',
            'tienda_id.exists' => 'La tienda seleccionada no es válida.',
            'brand.required' => 'La marca es obligatoria.',
            'unit_name.required' => 'La unidad es obligatoria.',
            'code_sku.required' => 'El código  es obligatorio.',
            'code_sku.unique' => 'El código  ya está registrado.',
            'prices.array' => 'Los precios deben ser una lista.',
            'prices.*.numeric' => 'Cada precio debe ser un número válido.',
            'prices.*.min' => 'Cada precio debe ser mayor o igual a 0.',
        ];
        try {
            // Validar los datos recibidos
            $validated = $request->validate([
                'description' => 'nullable|string',
                'amount' => 'nullable|integer',
                'model' => 'required|string',
                'location' => 'nullable|string',
                'brand' => 'required|string|max:255',
                'unit_name' => 'required|string|max:255',
                'tienda_id' => 'nullable|exists:tiendas,id',
                'quantity' => 'nullable|integer|min:0',
                'minimum_stock' => 'nullable|integer|min:0',
                'prices' => 'nullable|array',
                'prices.*' => 'nullable|numeric|min:0',
                'code_sku' => 'required|string|unique:products,code_sku,' . $id,
                'code_bar' => 'required|string|unique:products,code_bar,' . $id,
            ], $messages);
        } catch (ValidationValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
        try {
            // Buscar el producto existente
            $product = Product::findOrFail($id);

            if ($request->hasFile('new_images')) {
                $newImages = $request->file('new_images');
                
                // Usar un array para evitar duplicados basados en el nombre del archivo
                $processedFiles = [];

                foreach ($newImages as $image) {
                    $originalName = $image->getClientOriginalName();
                    
                    // Evitar procesar el mismo archivo dos veces
                    if (in_array($originalName, $processedFiles)) {
                        continue;
                    }
                    
                    $processedFiles[] = $originalName;
                    $imageName = time() . '_' . $originalName;
                    $image->move(public_path('images/products'), $imageName);

                    $product->images()->create([
                        'image_path' => 'images/products/' . $imageName,
                    ]);
                }
            }

            // Asegurar que deleted_images es un array válido
            $deletedImages = $request->input('deleted_images', []);
            $deletedImages = is_array($deletedImages) ? $deletedImages : json_decode($deletedImages, true);

            if (!empty($deletedImages)) {
                foreach ($deletedImages as $imageId) {
                    $image = $product->images()->find($imageId);
                    if ($image) {
                        $imagePath = public_path($image->image_path);
                        if (file_exists($imagePath)) {
                            unlink($imagePath);  // Eliminar archivo físico
                        }
                        $image->delete();  // Eliminar registro en la base de datos
                    }
                }
            }
            $unitName = ucfirst(strtolower(trim($request->unit_name)));
            $unitTypeId = $this->determineUnitType($unitName);
            $unit = Unit::firstOrCreate([
                'name' => $unitName,
            ], [
                'unit_type_id' => $unitTypeId
            ]);
            $validated['unit_id'] = $unit->id;
            $brandName = ucfirst(strtolower($request->brand));
            $brand = Brand::firstOrCreate(['name' => $brandName]);
            $validated['brand_id'] = $brand->id;
            
            // Actualizar tienda_id y minimum_stock
            $validated['tienda_id'] = $request->tienda_id ?: null;
            $validated['minimum_stock'] = $request->minimum_stock ?? 0;
            
            $product->update($validated);

            // Actualizar stock si se proporcionó cantidad
            if ($request->has('quantity')) {
                $stock = Stock::where('product_id', $product->id)
                    ->where('tienda_id', $request->tienda_id ?: null)
                    ->first();
                
                if ($stock) {
                    $stock->quantity = $request->quantity;
                    $stock->minimum_stock = $request->minimum_stock ?? 0;
                    $stock->save();
                } else {
                    // Crear nuevo stock si no existe
                    Stock::create([
                        'product_id' => $product->id,
                        'tienda_id' => $request->tienda_id ?: null,
                        'quantity' => $request->quantity,
                        'minimum_stock' => $request->minimum_stock ?? 0
                    ]);
                }
            }

            // Manejar los precios
            $prices = $validated['prices'] ?? [];
            $product->prices()->delete();  // Elimina precios anteriores

            $priceData = [];
            foreach ($prices as $type => $price) {
                if (!is_null($price)) {
                    $priceData[] = [
                        'product_id' => $product->id,
                        'type' => $type,
                        'price' => $price,
                    ];
                }
            }

            // Insertar los nuevos precios si hay datos
            if (!empty($priceData)) {
                ProductPrice::insert($priceData);
            }

            return response()->json([
                'success' => true,
                'message' => '¡El producto ha sido actualizado con éxito!',
                'product' => $product
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el producto',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function manageStock(Request $request, $productId)
    {
        try {
            DB::beginTransaction();

            $action = $request->action;  // 'increase' o 'decrease'
            $quantity = $request->quantity;
            // Eliminado: ya no usamos tienda_id, solo almacén central

            $stock = Stock::where('product_id', $productId)
                ->whereNull('tienda_id')  // Almacén central (tienda_id NULL)
                ->first();

            if (!$stock) {
                $stock = Stock::create([
                    'product_id' => $productId,
                    'tienda_id' => null,  // Almacén central
                    'quantity' => 0,
                    'minimum_stock' => 0
                ]);
            }

            $product = Product::find($productId);

            if ($action === 'increase') {
                $stock->quantity += $quantity;

                // Si es control por código único, guardar códigos
                if ($product->control_type === 'codigo_unico' && $request->scanned_codes) {
                    foreach ($request->scanned_codes as $code) {
                        ScannedCode::create([
                            'stock_id' => $stock->id,
                            'code' => $code
                        ]);
                    }
                }
            } else {  // decrease
                if ($product->control_type === 'codigo_unico') {
                    // Para código único: eliminar códigos específicos seleccionados
                    if ($request->codes_to_remove) {
                        $removedCount = 0;
                        foreach ($request->codes_to_remove as $codeId) {
                            $scannedCode = ScannedCode::where('stock_id', $stock->id)
                                ->where('id', $codeId)
                                ->first();
                            if ($scannedCode) {
                                $scannedCode->delete();
                                $removedCount++;
                            }
                        }
                        $stock->quantity -= $removedCount;
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'Debe seleccionar los códigos específicos a eliminar'
                        ], 400);
                    }
                } else {
                    // Para control por cantidad: disminuir normalmente
                    $stock->quantity -= $quantity;
                }

                if ($stock->quantity < 0)
                    $stock->quantity = 0;
            }

            $stock->save();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Stock actualizado correctamente'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar stock: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getStockCodes(Request $request, $productId)
    {
        try {
            // Eliminado: ya no necesitamos tienda_id

            $stock = Stock::where('product_id', $productId)
                ->whereNull('tienda_id')  // Almacén central (tienda_id NULL)
                ->with('scannedCodes')
                ->first();

            if (!$stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró stock para este producto en el almacén central'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'codes' => $stock->scannedCodes->map(function ($code) {
                    return [
                        'id' => $code->id,
                        'code' => $code->code,
                        'created_at' => $code->created_at->format('d/m/Y H:i')
                    ];
                })
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener códigos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->status = 0;
            $product->save();
            return redirect()->route('products.index')->with('success', 'Producto eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 'Error al eliminar el producto.');
        }
    }
}
