<x-app-layout>
    <x-breadcrumb 
        title="Editar Producto" 
        parent="Productos" 
        parentUrl="{{ route('products.index') }}" 
        subtitle="{{ $product->description }}" 
    />

    <div class="px-3 py-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <h2 class="text-xl font-bold text-white">Editar Producto</h2>
                    <a href="{{ route('products.index') }}" class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors text-sm font-medium">
                        <i class="fas fa-arrow-left mr-2"></i>Volver
                    </a>
                </div>
            </div>

            <!-- Form -->
            <form id="formProducts" enctype="multipart/form-data" class="p-6">
                @csrf

                <!-- Stock Information -->
                <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <h6 class="text-md font-semibold mb-3 text-blue-800">
                        <i class="fas fa-warehouse mr-2"></i>Stock Actual
                    </h6>
                    @if($productStock->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach($productStock as $stock)
                                <div class="bg-white p-3 rounded border">
                                    <div class="font-medium text-gray-800">{{ $stock->tienda->nombre ?? 'Almacén Central' }}</div>
                                    <div class="text-lg font-bold text-blue-600">{{ $stock->quantity }} unidades</div>
                                    @if($stock->scannedCodes && $stock->scannedCodes->count() > 0)
                                        <div class="text-xs text-green-600">
                                            <i class="fas fa-qrcode mr-1"></i>{{ $stock->scannedCodes->count() }} códigos
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-gray-500 py-4">
                            <i class="fas fa-inbox text-4xl mb-2"></i>
                            <p>Este producto no tiene stock registrado</p>
                        </div>
                    @endif
                    <button type="button" id="gestionar-stock" class="mt-3 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center text-sm">
                        <i class="fas fa-cogs mr-2"></i>Gestionar Stock
                    </button>
                </div>

                <!-- Control Type -->
                <div class="mb-6 p-3 bg-gray-50 rounded-lg">
                    <label class="block font-medium text-gray-700 mb-2 text-sm">Tipo de Control</label>
                    <div class="flex items-center">
                        @if($product->control_type === 'codigo_unico')
                            <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-medium">
                                <i class="fas fa-qrcode mr-1"></i>Código Único
                            </span>
                        @else
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                                <i class="fas fa-calculator mr-1"></i>Cantidad
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Product Information -->
                <h5 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">Información del Producto</h5>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label for="code_sku" class="block text-sm font-medium text-gray-700 mb-1">Código SKU *</label>
                        <input type="text" name="code_sku" id="code_sku" value="{{ $product->code_sku }}" required
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>

                    <div>
                        <label for="code_bar" class="block text-sm font-medium text-gray-700 mb-1">Código de Barras *</label>
                        <input type="text" name="code_bar" id="code_bar" value="{{ $product->code_bar }}" required
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <input type="text" name="description" id="description" value="{{ $product->description }}"
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>

                    <div>
                        <label for="model" class="block text-sm font-medium text-gray-700 mb-1">Modelo *</label>
                        <input type="text" name="model" id="model" value="{{ $product->model }}" required
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Ubicación</label>
                        <input type="text" name="location" id="location" value="{{ $product->location }}"
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>

                    <div class="relative">
                        <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Marca *</label>
                        <input type="text" id="brand" name="brand" value="{{ $product->brand->name }}" required autocomplete="off"
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <div id="brandDropdown" class="absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-lg hidden mt-1">
                            <ul id="brandSuggestions" class="max-h-40 overflow-y-auto"></ul>
                        </div>
                    </div>

                    <div class="relative">
                        <label for="unit_name" class="block text-sm font-medium text-gray-700 mb-1">Unidad *</label>
                        <input type="text" id="unit_name" name="unit_name" value="{{ $product->unit->name }}" required autocomplete="off"
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <div id="unitDropdown" class="absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-lg hidden mt-1">
                            <ul id="unitSuggestions" class="max-h-40 overflow-y-auto"></ul>
                        </div>
                    </div>
                </div>

                <!-- Images -->
                <h5 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">Imágenes</h5>
                
                <!-- Current Images -->
                @if($product->images && $product->images->count() > 0)
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Imágenes Actuales</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                            @foreach ($product->images as $image)
                                <div class="relative group">
                                    <img src="{{ asset($image->image_path) }}" alt="Imagen del producto"
                                        class="w-full h-24 object-cover border rounded-lg">
                                    <button type="button"
                                        class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs btn-delete-image hover:bg-red-600 transition opacity-0 group-hover:opacity-100"
                                        data-image-id="{{ $image->id }}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- New Images -->
                <div class="mb-6">
                    <label for="new_images" class="block text-sm font-medium text-gray-700 mb-2">Agregar Nuevas Imágenes</label>
                    <input type="file" name="new_images[]" id="new_images" accept="image/*" multiple
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <div id="preview-container" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 mt-3"></div>
                </div>

                <input type="hidden" name="deleted_images" id="deleted_images" value="">

                <!-- Prices -->
                <h5 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">Precios</h5>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    @foreach ($product->prices as $price)
                        <div>
                            <label for="prices[{{ $price->type }}]" class="block text-sm font-medium text-gray-700 mb-1">
                                @php
                                    $labels = [
                                        'buy' => 'Precio Compra',
                                        'sucursalA' => 'Precio Sucursal A',
                                        'sucursalB' => 'Precio Sucursal B',
                                        'wholesale' => 'Precio Mayorista',
                                    ];
                                    $label = $labels[$price->type] ?? 'Precio ' . ucfirst($price->type);
                                @endphp
                                {{ $label }}
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-500 text-sm">S/</span>
                                <input type="number" step="0.01" name="prices[{{ $price->type }}]" id="prices_{{ $price->type }}"
                                    value="{{ $price->price }}"
                                    class="block w-full pl-10 p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row justify-center gap-3 mt-6 pt-6 border-t">
                    <button id="registrar" type="button"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition font-medium text-sm">
                        <i class="fas fa-save mr-2"></i>Actualizar Producto
                    </button>
                    <a href="{{ route('products.index') }}"
                        class="px-6 py-2 bg-gray-500 text-white rounded-lg shadow-md hover:bg-gray-600 transition font-medium text-sm text-center">
                        <i class="fas fa-times mr-2"></i>Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
    let deletedImages = [];

    document.addEventListener('DOMContentLoaded', function() {
        // Delete image handler
        document.addEventListener("click", function(event) {
            if (event.target.closest('.btn-delete-image')) {
                const button = event.target.closest('.btn-delete-image');
                let imageId = button.dataset.imageId;

                if (!deletedImages.includes(imageId)) {
                    deletedImages.push(imageId);
                }

                document.getElementById('deleted_images').value = JSON.stringify(deletedImages);

                let imageContainer = button.closest(".relative");
                if (imageContainer) {
                    imageContainer.remove();
                }
            }
        });

        // Preview new images
        document.getElementById('new_images').addEventListener('change', function(e) {
            const previewContainer = document.getElementById('preview-container');
            previewContainer.innerHTML = '';

            Array.from(e.target.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const div = document.createElement('div');
                    div.className = 'relative group';
                    div.innerHTML = `
                        <img src="${event.target.result}" class="w-full h-24 object-cover border rounded-lg">
                        <button type="button" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition opacity-0 group-hover:opacity-100 remove-preview" data-index="${index}">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    previewContainer.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        });

        // Remove preview
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-preview')) {
                e.target.closest('.relative').remove();
            }
        });

        // Brand autocomplete
        const brandInput = document.getElementById('brand');
        const brandDropdown = document.getElementById('brandDropdown');
        const brandSuggestions = document.getElementById('brandSuggestions');

        brandInput.addEventListener('input', function() {
            const query = this.value;
            if (query.length > 0) {
                fetch(`${baseUrl}/api/brands/search?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        brandSuggestions.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(brand => {
                                const li = document.createElement('li');
                                li.textContent = brand.name;
                                li.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm';
                                li.addEventListener('click', function() {
                                    brandInput.value = brand.name;
                                    brandDropdown.classList.add('hidden');
                                });
                                brandSuggestions.appendChild(li);
                            });
                            brandDropdown.classList.remove('hidden');
                        } else {
                            brandDropdown.classList.add('hidden');
                        }
                    });
            } else {
                brandDropdown.classList.add('hidden');
            }
        });

        // Unit autocomplete
        const unitInput = document.getElementById('unit_name');
        const unitDropdown = document.getElementById('unitDropdown');
        const unitSuggestions = document.getElementById('unitSuggestions');

        unitInput.addEventListener('input', function() {
            const query = this.value;
            if (query.length > 0) {
                fetch(`${baseUrl}/api/units/search?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        unitSuggestions.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(unit => {
                                const li = document.createElement('li');
                                li.textContent = unit.name;
                                li.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm';
                                li.addEventListener('click', function() {
                                    unitInput.value = unit.name;
                                    unitDropdown.classList.add('hidden');
                                });
                                unitSuggestions.appendChild(li);
                            });
                            unitDropdown.classList.remove('hidden');
                        } else {
                            unitDropdown.classList.add('hidden');
                        }
                    });
            } else {
                unitDropdown.classList.add('hidden');
            }
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!brandInput.contains(e.target) && !brandDropdown.contains(e.target)) {
                brandDropdown.classList.add('hidden');
            }
            if (!unitInput.contains(e.target) && !unitDropdown.contains(e.target)) {
                unitDropdown.classList.add('hidden');
            }
        });

        // Submit form
        document.getElementById('registrar').addEventListener('click', function() {
            const formData = new FormData(document.getElementById('formProducts'));
            formData.append('_method', 'PUT');

            fetch(`${baseUrl}/products/{{ $product->id }}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message,
                        confirmButtonColor: '#3b82f6'
                    }).then(() => {
                        window.location.href = '{{ route("products.index") }}';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Error al actualizar el producto',
                        confirmButtonColor: '#ef4444'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al actualizar el producto',
                    confirmButtonColor: '#ef4444'
                });
            });
        });
    });
</script>
