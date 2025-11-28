<x-app-layout>
    <x-breadcrumb title="Detalle del Producto" parent="Productos" parentUrl="{{ route('products.index') }}" subtitle="{{ $product->description }}" />

    <div class="px-3 py-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-white">{{ $product->description }}</h2>
                    <a href="{{ route('products.index') }}" class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors text-sm font-medium">
                        <i class="fas fa-arrow-left mr-2"></i>Volver
                    </a>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Información Principal -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Información General</h3>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Código SKU</label>
                                <p class="text-gray-900 font-medium">{{ $product->code_sku ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Código de Barras</label>
                                <p class="text-gray-900 font-medium">{{ $product->code_bar ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Modelo</label>
                                <p class="text-gray-900">{{ $product->model ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Ubicación</label>
                                <p class="text-gray-900">{{ $product->location ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Marca</label>
                                <p class="text-gray-900">{{ $product->brand->name ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Unidad</label>
                                <p class="text-gray-900">{{ $product->unit->name ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Tienda</label>
                                <p class="text-gray-900">{{ $product->tienda->nombre ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Tipo de Control</label>
                                <p class="text-gray-900">
                                    @if($product->control_type === 'codigo_unico')
                                        <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded text-xs">Código Único</span>
                                    @else
                                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">Cantidad</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Imágenes -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Imágenes</h3>
                        
                        @if($product->images && $product->images->count() > 0)
                            <div class="grid grid-cols-2 gap-4">
                                @foreach($product->images as $image)
                                    <div class="aspect-square rounded-lg overflow-hidden border border-gray-200">
                                        <img src="{{ asset($image->image_path) }}" alt="{{ $product->description }}" class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-gray-100 rounded-lg p-8 text-center">
                                <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
                                <p class="text-gray-500">Sin imágenes</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Precios -->
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Precios</h3>
                    
                    @if($product->prices && $product->prices->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($product->prices as $price)
                                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                                    <p class="text-sm text-green-700 font-medium mb-1">{{ ucfirst($price->type) }}</p>
                                    <p class="text-2xl font-bold text-green-900">S/ {{ number_format($price->price, 2) }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">No hay precios registrados</p>
                    @endif
                </div>

                <!-- Stock -->
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Stock por Tienda</h3>
                    
                    @if($product->stocks && $product->stocks->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Tienda</th>
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600">Cantidad</th>
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600">Stock Mínimo</th>
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($product->stocks as $stock)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 text-sm text-gray-900">{{ $stock->tienda->nombre ?? 'Almacén Central' }}</td>
                                            <td class="px-4 py-3 text-sm text-center font-medium">{{ $stock->quantity }}</td>
                                            <td class="px-4 py-3 text-sm text-center">{{ $stock->minimum_stock ?? 0 }}</td>
                                            <td class="px-4 py-3 text-center">
                                                @if($stock->quantity > $stock->minimum_stock)
                                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-medium">
                                                        <i class="fas fa-check-circle mr-1"></i>Disponible
                                                    </span>
                                                @elseif($stock->quantity > 0)
                                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-medium">
                                                        <i class="fas fa-exclamation-triangle mr-1"></i>Bajo
                                                    </span>
                                                @else
                                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-medium">
                                                        <i class="fas fa-times-circle mr-1"></i>Agotado
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">No hay stock registrado</p>
                    @endif
                </div>

                <!-- Acciones -->
                <div class="mt-6 flex gap-3">
                    <a href="{{ route('products.edit', $product->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors text-sm font-medium">
                        <i class="fas fa-edit mr-2"></i>Editar Producto
                    </a>
                    <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition-colors text-sm font-medium">
                        <i class="fas fa-arrow-left mr-2"></i>Volver al Listado
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
