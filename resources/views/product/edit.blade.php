<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registro de Productos
        </h2>
    </x-slot>

    <div class="w-3/4 mx-auto py-8 my-6 shadow-lg p-5 rounded-lg border border-gray-300">
        <form id="formProducts" enctype="multipart/form-data">
            @csrf
            <h5 class="text-lg font-semibold mb-4">Datos del Producto</h5>

            <!-- Información de Stock por Tienda -->
            <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <h6 class="text-md font-semibold mb-3 text-blue-800">
                    <i class="fas fa-store mr-2"></i>Stock por Tienda
                </h6>
                @if($productStock->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($productStock as $stock)
                    <div class="bg-white p-3 rounded border">
                        <div class="font-medium text-gray-800">{{ $stock->tienda->nombre ?? 'Sin Tienda' }}</div>
                        <div class="text-lg font-bold text-blue-600">{{ $stock->quantity }} unidades</div>
                        @if($stock->scannedCodes->count() > 0)
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
                    <p>Este producto no tiene stock en ninguna tienda</p>
                </div>
                @endif
                <button type="button" id="gestionar-stock" class="mt-3 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center">
                    <i class="fas fa-cogs mr-2"></i>Gestionar Stock
                </button>
            </div>

            <!-- Control Type Display -->
            <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                <label class="block font-medium text-gray-700 mb-2">Tipo de Control Actual</label>
                <div class="flex items-center">
                    @if($product->control_type === 'codigo_unico')
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                            <i class="fas fa-qrcode mr-1"></i>Control por Código Único
                        </span>
                    @else
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                            <i class="fas fa-calculator mr-1"></i>Control por Cantidad
                        </span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label for="code_sku" class="block text-sm font-medium text-gray-700">Codigo</label>
                    <input type="text" name="code_sku" id="code_sku" value="{{ $product->code_sku }}"
                        class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="grid grid-cols-4 gap-2">
                    <h1 for="images" class="col-span-full text-sm font-medium text-gray-700">Imágenes del
                        Producto</h1>
                    @foreach ($product->images as $image)
                        <div style="width: 90px;">
                            <img src="{{ asset($image->image_path) }}" alt="Imagen del producto"
                                class="w-90 h-10 object-cover border rounded-lg" style="height: 90px;">
                            <button type="button"
                                class="absolute top-0 right-0 bg-red-500 text-white rounded-full px-2 py-1 text-xs btn-delete-image"
                                data-image-id="{{ $image->id }}">
                                X
                            </button>
                        </div>
                    @endforeach
                </div>
                <!-- Contenedor para previsualizar nuevas imágenes -->
                <div>
                    <label for="images" class="block text-sm font-medium text-gray-700">Imágenes del Producto</label>
                    <input type="file" name="new_images[]" id="new_images" accept="image/*" multiple
                        class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm">
                    <div id="preview-container" class="grid grid-cols-4 gap-2 mt-4"></div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                    <input type="text" name="description" id="description" value="{{ $product->description }}"
                        class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="bar_code" class="block text-sm font-medium text-gray-700">Codigo de Barras</label>
                    <input type="text" name="code_bar" id="code_bar" value="{{ $product->code_bar }}"
                        class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm">
                </div>

                <input type="hidden" name="remove_image" id="remove_image" value="0">

                <div>
                    <label for="model" class="block text-sm font-medium text-gray-700">Modelo</label>
                    <input type="text" name="model" id="model" value="{{ $product->model }}"
                        class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="relative">
                    <label for="unit_name" class="block text-sm font-medium text-gray-700">Unidad de Medida</label>
                    <input type="text" id="unit_name" name="unit_name"
                        value="{{ old('unit_name', $product->unit->name) }}"
                        class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm" autocomplete="off">
                    <div id="unitDropdown"
                        class="absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-lg hidden">
                        <ul id="unitSuggestions" class="max-h-40 overflow-y-auto"></ul>
                    </div>
                </div>

                <div class="relative">
                    <label for="brand" class="block font-medium text-gray-700">Marca</label>
                    <input type="text" id="brand" name="brand"
                        class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm" autocomplete="off"
                        value="{{ old('brand', $product->brand->name) }}">

                    <!-- Dropdown de Sugerencias -->
                    <div id="brandDropdown"
                        class="absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-lg hidden">
                        <ul id="brandSuggestions" class="max-h-40 overflow-y-auto"></ul>
                    </div>
                </div>
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Ubicación</label>
                    <input type="text" name="location" id="location" value="{{ $product->location }}"
                        class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm">
                </div>
            </div>

            <h5 class="text-lg font-semibold mb-4">Precios</h5>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-4">
                @foreach ($product->prices as $price)
                    <div>
                        <label for="prices[{{ $price->type }}]" class="block text-sm font-medium text-gray-700">
                            @php
                                switch ($price->type) {
                                    case 'buy':
                                        $label = 'Precio Compra';
                                        break;
                                    case 'sucursalA':
                                        $label = 'Precio Sucursal A';
                                        break;
                                    case 'sucursalB':
                                        $label = 'Precio Sucursal B';
                                        break;
                                    case 'wholesale':
                                        $label = 'Precio Mayorista';
                                        break;
                                    default:
                                        $label = 'Precio ' . ucfirst($price->type);
                                        break;
                                }
                            @endphp
                            {{ $label }}
                        </label>
                        <input type="decimal" name="prices[{{ $price->type }}]" id="prices_{{ $price->type }}"
                            value="{{ $price->price }}"
                            class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm">
                    </div>
                @endforeach
            </div>
            <div class="flex justify-center space-x-4 mt-6">
                <button id="registrar"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition"
                    type="button">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

<script>
    // Variables globales
    let deletedImages = [];

    // Evento DOMContentLoaded
    document.addEventListener('DOMContentLoaded', function() {
        //ELIMINAR IMAGENES
        document.addEventListener("click", function(event) {
            if (event.target.classList.contains("btn-delete-image")) {
                let imageId = event.target.dataset.imageId;

                if (!deletedImages.includes(imageId)) {
                    deletedImages.push(imageId);
                }

                let imageContainer = event.target.closest(".relative");
                if (imageContainer) {
                    imageContainer.remove();
                }
            }
        });
        // FIN
        document.getElementById('remove-image')?.addEventListener('click', function() {
            let previewImage = document.getElementById('preview-image');
            let currentImage = document.getElementById('current-image');
            let imageInput = document.getElementById('image');
            let removeImageInput = document.getElementById('remove_image');
            if (currentImage) {
                currentImage.style.display = 'none';
            }
            previewImage.style.display = 'none';
            imageInput.value = '';
            removeImageInput.value = '1';
        });
        document.getElementById('new_images').addEventListener('change', function(event) {
            let previewContainer = document.getElementById('preview-container');
            previewContainer.innerHTML = '';

            for (let file of event.target.files) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    let img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-24 h-24 object-cover border rounded-lg';
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });

        document.querySelectorAll('.remove-image').forEach(button => {
            button.addEventListener('click', function() {
                let imageId = this.getAttribute('data-image-id');
                this.parentElement.style.display = 'none';

                let inputHidden = document.createElement('input');
                inputHidden.type = 'hidden';
                inputHidden.name = 'remove_images[]';
                inputHidden.value = imageId;
                document.getElementById('formProducts').appendChild(inputHidden);
            });
        });
        document.getElementById('registrar').addEventListener('click', async function(e) {
            e.preventDefault();

            // Obtener el formulario correctamente
            const form = document.getElementById('formProducts');
            let formData = new FormData(form); // Usar el form, no 'this'
            formData.append('_method', 'PUT');
            formData.append('deleted_images', JSON.stringify(deletedImages));

            const csrfToken = document.querySelector('input[name="_token"]').value;

            try {
                const response = await fetch(`{{ route('products.update', $product->id) }}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                if (response.ok) {
                    const data = await response.json();
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message || 'Producto actualizado correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        // Opcional: Redirigir a otra página o recargar
                        window.location.href = "{{ route('products.index') }}";
                    });
                } else {
                    const errorData = await response.json();
                    let errorMessages = 'Ocurrió un error.';
                    if (errorData && errorData.errors) {
                        errorMessages = Object.values(errorData.errors).flat().join('\n');
                    } else if (errorData && errorData.message) {
                        errorMessages = errorData.message;
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de Validación',
                        text: errorMessages
                    });
                }
            } catch (error) {
                console.error('Error en la petición fetch:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de Conexión',
                    text: 'No se pudo conectar con el servidor. Por favor, inténtalo de nuevo.'
                });
            }
        });
        document.getElementById("unit_name").addEventListener("input", function() {
            console.log("Evento input detectado:", this.value); // Agrega esto

            const inputValue = this.value.trim();
            const suggestionsList = document.getElementById("unitSuggestions");
            const dropdown = document.getElementById("unitDropdown");
            if (inputValue === "") {
                suggestionsList.innerHTML = "";
                dropdown.classList.add("hidden");
                return;
            }
            fetch(`{{ route('units.search') }}?query=${this.value}`)
                .then(response => response.json())
                .then(data => {
                    suggestionsList.innerHTML = "";

                    if (data.length > 0) {
                        data.forEach(unit => {
                            const item = document.createElement("li");
                            item.textContent = unit.name;
                            item.classList.add("cursor-pointer", "p-2", "hover:bg-gray-100");

                            item.addEventListener("click", function() {
                                document.getElementById("unit_name").value = unit.name;
                                dropdown.classList.add("hidden");
                            });

                            suggestionsList.appendChild(item);
                        });

                        dropdown.classList.remove("hidden");
                    } else {
                        dropdown.classList.add("hidden");
                    }
                });
        });
        // BUSQUEDA DE MARCA
        document.getElementById("brand").addEventListener("input", function() {
            const inputValue = this.value.trim();
            const suggestionsList = document.getElementById("brandSuggestions");
            const dropdown = document.getElementById("brandDropdown");
            if (inputValue === "") {
                suggestionsList.innerHTML = "";
                dropdown.classList.add("hidden");
                return;
            }
            fetch(`{{ route('api.brands.search') }}?query=${this.value}`)
                .then(response => response.json())
                .then(data => {
                    suggestionsList.innerHTML = "";

                    if (data.length > 0) {
                        data.forEach(brand => {
                            const item = document.createElement("li");
                            item.textContent = brand.name;
                            item.classList.add("cursor-pointer", "p-2", "hover:bg-gray-100");

                            item.addEventListener("click", function() {
                                document.getElementById("brand").value = brand.name;
                                dropdown.classList.add("hidden");
                            });

                            suggestionsList.appendChild(item);
                        });

                        dropdown.classList.remove("hidden");
                    } else {
                        dropdown.classList.add("hidden");
                    }
                });
        });
        // Ocultar el dropdown cuando se hace clic fuera
        document.addEventListener("click", function(event) {
            const dropdown = document.getElementById("brandDropdown");
            if (!document.getElementById("brand").contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add("hidden");
            }
        });

        // Gestión de Stock
        document.getElementById('gestionar-stock')?.addEventListener('click', function() {
            const productId = {{ $product->id }};
            const controlType = '{{ $product->control_type }}';
            
            // Obtener stocks existentes
            const stocks = @json($productStock);

            let stocksHtml = '';
            stocks.forEach(stock => {
                stocksHtml += `
                    <div class="border rounded p-3 mb-3">
                        <div class="flex justify-between items-center mb-2">
                            <div>
                                <div class="font-medium">${stock.tienda ? stock.tienda.nombre : 'Sin Tienda'}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold text-blue-600">${stock.quantity} unidades</div>
                                ${stock.scanned_codes.length > 0 ? `<div class="text-xs text-green-600"><i class="fas fa-qrcode mr-1"></i>${stock.scanned_codes.length} códigos</div>` : ''}
                            </div>
                        </div>
                        <div class="flex gap-2 mt-2">
                            <button type="button" class="increase-stock px-3 py-1 bg-green-500 text-white rounded text-sm hover:bg-green-600" data-tienda="${stock.tienda_id}">
                                <i class="fas fa-plus mr-1"></i>Aumentar
                            </button>
                            <button type="button" class="decrease-stock px-3 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600" data-tienda="${stock.tienda_id}">
                                <i class="fas fa-minus mr-1"></i>Disminuir
                            </button>
                        </div>
                    </div>
                `;
            });
            
            const modalHtml = `
                <div id="stockModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg p-6 w-full max-w-2xl max-h-90vh overflow-y-auto">
                        <div class="flex justify-between items-center mb-4 pb-2 border-b">
                            <h3 class="text-lg font-semibold">
                                <i class="fas fa-cogs mr-2 text-green-500"></i>
                                Gestionar Stock
                            </h3>
                            <button id="closeStockModal" class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <div class="mb-4">
                            <h4 class="font-medium mb-3">Stock Actual por Almacén:</h4>
                            ${stocksHtml}
                        </div>
                        
                        <div class="border-t pt-4">
                            <button id="addNewStock" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center">
                                <i class="fas fa-plus mr-2"></i>
                                Agregar Stock a Nuevo Almacén
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            
            // Event handlers del modal
            const modal = document.getElementById('stockModal');
            
            // Cerrar modal
            document.getElementById('closeStockModal').addEventListener('click', () => modal.remove());
            
            // Aumentar stock
            modal.addEventListener('click', function(e) {
                if (e.target.classList.contains('increase-stock') || e.target.closest('.increase-stock')) {
                    const btn = e.target.classList.contains('increase-stock') ? e.target : e.target.closest('.increase-stock');
                    const tiendaId = btn.dataset.tienda;
                    showQuantityModal('increase', tiendaId, controlType, productId);
                }
            });

            // Disminuir stock
            modal.addEventListener('click', function(e) {
                if (e.target.classList.contains('decrease-stock') || e.target.closest('.decrease-stock')) {
                    const btn = e.target.classList.contains('decrease-stock') ? e.target : e.target.closest('.decrease-stock');
                    const tiendaId = btn.dataset.tienda;
                    showQuantityModal('decrease', tiendaId, controlType, productId);
                }
            });
            
            // Agregar nuevo stock
            document.getElementById('addNewStock').addEventListener('click', function() {
                showNewStockModal(controlType, productId);
            });
        });

        function showQuantityModal(action, tiendaId, controlType, productId) {
            const actionText = action === 'increase' ? 'Aumentar' : 'Disminuir';
            const actionColor = action === 'increase' ? 'green' : 'red';
            const actionIcon = action === 'increase' ? 'plus' : 'minus';
            
            // Encontrar el modal principal y actualizar su contenido
            const stockModal = document.getElementById('stockModal');
            const modalContent = stockModal.querySelector('.bg-white');
            
            let scannedCodes = [];
            
            const quantityFormHtml = `
                <div class="flex justify-between items-center mb-4 pb-2 border-b">
                    <h3 class="text-lg font-semibold">
                        <i class="fas fa-${actionIcon} mr-2 text-${actionColor}-500"></i>
                        ${actionText} Stock
                    </h3>
                    <button id="backToStockMain" class="text-blue-500 hover:text-blue-700">
                        <i class="fas fa-arrow-left mr-1"></i>Volver
                    </button>
                </div>
                
                <div class="max-h-96 overflow-y-auto">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cantidad a ${actionText.toLowerCase()}:</label>
                        <input type="number" id="quantityInput" class="w-full p-2 border rounded" min="1" value="1">
                    </div>
                    
                    ${action === 'increase' && controlType === 'codigo_unico' ? `
                        <div class="mb-4">
                            <button type="button" id="scanCodesBtn" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center justify-center">
                                <i class="fas fa-qrcode mr-2"></i>
                                Escanear Códigos
                            </button>
                            <div id="scanStatus" class="mt-2 text-sm text-gray-600"></div>
                            
                            <!-- Área de escaneo (inicialmente oculta) -->
                            <div id="scanArea" class="hidden mt-4 p-4 bg-gray-50 rounded-lg border">
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Producto:</label>
                                        <input type="text" value="{{ $product->description }}" class="w-full mt-1 p-2 border rounded text-sm" readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Cantidad esperada:</label>
                                        <input type="text" id="expectedQuantityDisplay" class="w-full mt-1 p-2 border rounded text-center font-bold text-sm" readonly>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Código escaneado:</label>
                                    <div class="flex gap-2">
                                        <input type="text" id="inputCodigoEscaneado" class="flex-1 p-2 border rounded text-sm" placeholder="Escanee o ingrese código...">
                                        <button type="button" id="agregarCodigo" class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                                            <i class="fas fa-plus mr-1"></i>Agregar
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Códigos escaneados:</label>
                                    <div id="listaCodigosEscaneados" class="border rounded p-3 h-24 overflow-y-auto bg-black text-green-400 font-mono text-xs">
                                        <div class="text-center text-gray-500">No hay códigos escaneados</div>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm font-medium text-gray-700">Progreso:</span>
                                        <span id="progresoTexto" class="text-sm font-medium">0/0 códigos escaneados</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div id="barraProgreso" class="bg-green-500 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                                    </div>
                                    <div id="estadoEscaneo" class="text-sm text-orange-600 mt-2">
                                        <i class="fas fa-clock mr-1"></i>Esperando códigos...
                                    </div>
                                </div>
                                
                                <button type="button" id="closeScanArea" class="w-full px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 mb-2">
                                    <i class="fas fa-times mr-1"></i>Cerrar Escáner
                                </button>
                            </div>
                        </div>
                    ` : action === 'decrease' && controlType === 'codigo_unico' ? `
                        <div class="mb-4">
                            <button type="button" id="loadExistingCodesBtn" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition flex items-center justify-center">
                                <i class="fas fa-search mr-2"></i>
                                Seleccionar Códigos a Eliminar
                            </button>
                            <div id="codeSelectionStatus" class="mt-2 text-sm text-gray-600"></div>
                            
                            <!-- Área de selección de códigos (inicialmente oculta) -->
                            <div id="codeSelectionArea" class="hidden mt-4 p-4 bg-red-50 rounded-lg border">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Códigos disponibles para eliminar:</label>
                                    <div class="mb-2">
                                        <input type="text" id="searchExistingCodes" class="w-full p-2 border rounded text-sm" placeholder="Buscar código...">
                                    </div>
                                    <div id="existingCodesList" class="border rounded p-3 h-32 overflow-y-auto bg-white">
                                        <div class="text-center text-gray-500">Cargando códigos...</div>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Códigos seleccionados para eliminar:</label>
                                    <div id="selectedCodesForRemoval" class="border rounded p-3 h-24 overflow-y-auto bg-red-900 text-red-300 font-mono text-xs">
                                        <div class="text-center text-gray-500">No hay códigos seleccionados</div>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm font-medium text-gray-700">Códigos a eliminar:</span>
                                        <span id="removalCount" class="text-sm font-medium">0 códigos seleccionados</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div id="removalProgress" class="bg-red-500 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                                    </div>
                                </div>
                                
                                <button type="button" id="closeCodeSelection" class="w-full px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 mb-2">
                                    <i class="fas fa-times mr-1"></i>Cerrar Selección
                                </button>
                            </div>
                        </div>
                    ` : ''}
                </div>
                
                <div class="flex justify-between mt-4 pt-4 border-t bg-white">
                    <button id="cancelQuantity" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        Cancelar
                    </button>
                    <button id="confirmQuantity" class="px-4 py-2 bg-${actionColor}-500 text-white rounded hover:bg-${actionColor}-600">
                        ${actionText}
                    </button>
                </div>
            `;
            
            modalContent.innerHTML = quantityFormHtml;
            
            // Event handlers
            document.getElementById('backToStockMain').addEventListener('click', () => {
                location.reload(); // Recarga para volver al estado inicial
            });
            
            document.getElementById('cancelQuantity').addEventListener('click', () => {
                stockModal.remove();
            });
            
            // Lógica de escaneo
            if (action === 'increase' && controlType === 'codigo_unico') {
                document.getElementById('scanCodesBtn').addEventListener('click', function() {
                    const quantity = parseInt(document.getElementById('quantityInput').value) || 1;
                    const scanArea = document.getElementById('scanArea');
                    const expectedQuantityDisplay = document.getElementById('expectedQuantityDisplay'); // <- Ahora sí existe
                    
                    expectedQuantityDisplay.value = quantity; // <- Ahora funcionará
                    scanArea.classList.remove('hidden');
                    
                    // Inicializar variables de escaneo
                    scannedCodes = [];
                    updateScanProgress(0, quantity);
                    
                    // Focus en input de código
                    setTimeout(() => {
                        document.getElementById('inputCodigoEscaneado').focus();
                    }, 100);
                });
                
                // Event handlers para el área de escaneo
                document.addEventListener('click', function(e) {
                    if (e.target && e.target.id === 'agregarCodigo') {
                        agregarCodigoHandler();
                    }
                    if (e.target && e.target.id === 'closeScanArea') {
                        document.getElementById('scanArea').classList.add('hidden');
                        // Re-habilitar controles si estaban deshabilitados
                        const inputCodigo = document.getElementById('inputCodigoEscaneado');
                        const btnAgregar = document.getElementById('agregarCodigo');
                        if (inputCodigo) {
                            inputCodigo.disabled = false;
                            inputCodigo.placeholder = "Escanee o ingrese código...";
                        }
                        if (btnAgregar) {
                            btnAgregar.disabled = false;
                        }
                        
                        // Solo mostrar mensaje si había códigos escaneados
                        if (scannedCodes.length > 0) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Códigos Guardados',
                                text: `Se han guardado ${scannedCodes.length} códigos escaneados`,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                        
                        document.getElementById('scanStatus').innerHTML = scannedCodes.length > 0 ? 
                            `<i class="fas fa-check text-green-500 mr-1"></i>${scannedCodes.length} códigos guardados` : '';
                    }
                });
                
                document.addEventListener('keypress', function(e) {
                    if (e.target && e.target.id === 'inputCodigoEscaneado' && e.key === 'Enter') {
                        e.preventDefault();
                        agregarCodigoHandler();
                    }
                });
                
                function agregarCodigoHandler() {
                    const inputCodigo = document.getElementById('inputCodigoEscaneado');
                    const codigo = inputCodigo.value.trim();
                    const quantity = parseInt(document.getElementById('quantityInput').value) || 1;
                    
                    if (!codigo) return;
                    
                    if (scannedCodes.includes(codigo)) {
                        Swal.fire('Advertencia', 'Este código ya fue escaneado', 'warning');
                        return;
                    }
                    
                    // LIMITADOR: No permitir más códigos de los necesarios
                    if (scannedCodes.length >= quantity) {
                        Swal.fire('Advertencia', `Ya se han escaneado todos los códigos necesarios (${quantity})`, 'warning');
                        return;
                    }
                    
                    scannedCodes.push(codigo);
                    reproducirSonidoEscaner();
                    
                    // Actualizar lista
                    const listaCodigos = document.getElementById('listaCodigosEscaneados');
                    if (scannedCodes.length === 1) {
                        listaCodigos.innerHTML = '';
                    }
                    const div = document.createElement('div');
                    div.className = 'py-1 border-b border-green-600 last:border-b-0';
                    div.textContent = `${scannedCodes.length}. ${codigo}`;
                    listaCodigos.appendChild(div);
                    
                    updateScanProgress(scannedCodes.length, quantity);
                    
                    inputCodigo.value = '';
                    
                    // Si ya se completó el escaneo, mostrar mensaje y deshabilitar input
                    if (scannedCodes.length === quantity) {
                        inputCodigo.disabled = true;
                        inputCodigo.placeholder = "Escaneo completado";
                        document.getElementById('agregarCodigo').disabled = true;
                        Swal.fire({
                            icon: 'success',
                            title: '¡Escaneo Completo!',
                            text: `Se han escaneado todos los ${quantity} códigos necesarios`,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        inputCodigo.focus();
                    }
                    
                    // Actualizar status
                    document.getElementById('scanStatus').innerHTML = `<i class="fas fa-check text-green-500 mr-1"></i>${scannedCodes.length} de ${quantity} códigos escaneados`;
                }
                
                function updateScanProgress(current, total) {
                    const barraProgreso = document.getElementById('barraProgreso');
                    const progresoTexto = document.getElementById('progresoTexto');
                    const estadoEscaneo = document.getElementById('estadoEscaneo');
                    
                    const progreso = (current / total) * 100;
                    barraProgreso.style.width = progreso + '%';
                    progresoTexto.textContent = `${current}/${total} códigos escaneados`;
                    
                    if (current === total) {
                        estadoEscaneo.innerHTML = '<i class="fas fa-check mr-1 text-green-500"></i>¡Escaneo completo!';
                        estadoEscaneo.className = 'text-sm text-green-600 mt-2';
                    } else {
                        const faltantes = total - current;
                        estadoEscaneo.innerHTML = `<i class="fas fa-clock mr-1"></i>Esperando códigos... (faltan ${faltantes})`;
                        estadoEscaneo.className = 'text-sm text-orange-600 mt-2';
                    }
                }
                
                function reproducirSonidoEscaner() {
                    const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                    const oscillator = audioContext.createOscillator();
                    const gainNode = audioContext.createGain();

                    oscillator.connect(gainNode);
                    gainNode.connect(audioContext.destination);

                    oscillator.frequency.value = 800;
                    oscillator.type = "square";

                    gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
                    gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.1);

                    oscillator.start(audioContext.currentTime);
                    oscillator.stop(audioContext.currentTime + 0.1);
                }
            }
            
            // Confirm action
            document.getElementById('confirmQuantity').addEventListener('click', function() {
                const quantity = parseInt(document.getElementById('quantityInput').value) || 1;
    
                if (action === 'increase' && controlType === 'codigo_unico' && scannedCodes.length !== quantity) {
                    Swal.fire('Error', 'Debe escanear todos los códigos antes de continuar', 'error');
                    return;
                }
                
                if (action === 'decrease' && controlType === 'codigo_unico') {
                    // Verificar si hay códigos seleccionados usando el DOM
                    const selectedCodesDiv = document.getElementById('selectedCodesForRemoval');
                    const hasSelectedCodes = selectedCodesDiv && selectedCodesDiv.children.length > 0 && 
                                            !selectedCodesDiv.querySelector('.text-center.text-gray-500');
                    
                    if (!hasSelectedCodes) {
                        Swal.fire('Error', 'Debe seleccionar al menos un código para eliminar', 'error');
                        return;
                    }
                }
                
                // Send request
                const formData = new FormData();
                formData.append('action', action);
                formData.append('quantity', quantity);
                formData.append('tienda_id', tiendaId);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                
                if (action === 'increase' && scannedCodes.length > 0) {
                    scannedCodes.forEach((code, index) => {
                        formData.append(`scanned_codes[${index}]`, code);
                    });
                }
                
                if (action === 'decrease' && controlType === 'codigo_unico') {
                    // Acceder a selectedCodesForRemoval desde el scope correcto
                    const codeSelectionLogic = document.getElementById('codeSelectionArea');
                    if (codeSelectionLogic && typeof selectedCodesForRemoval !== 'undefined' && selectedCodesForRemoval.length > 0) {
                        selectedCodesForRemoval.forEach((codeData, index) => {
                            formData.append(`codes_to_remove[${index}]`, codeData.id);
                        });
                    }
                }
                
                fetch(`{{ route('products.manage-stock', ['product' => $product->id]) }}`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Éxito', data.message, 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Ocurrió un error al actualizar el stock', 'error');
                });
                
                stockModal.remove();
            });

            // Lógica para disminuir stock con códigos específicos
            if (action === 'decrease' && controlType === 'codigo_unico') {
                selectedCodesForRemoval = [];
                let allAvailableCodes = [];
                
                document.getElementById('loadExistingCodesBtn').addEventListener('click', function() {
                    const codeSelectionArea = document.getElementById('codeSelectionArea');
                    codeSelectionArea.classList.remove('hidden');
                    
                    // Cargar códigos existentes
                    fetch(`{{ route('products.getStockCodes', ['productId' => $product->id]) }}?tienda_id=${tiendaId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                allAvailableCodes = data.codes;
                                displayAvailableCodes(allAvailableCodes);
                            } else {
                                document.getElementById('existingCodesList').innerHTML = 
                                    '<div class="text-center text-red-500">Error al cargar códigos</div>';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            document.getElementById('existingCodesList').innerHTML = 
                                '<div class="text-center text-red-500">Error de conexión</div>';
                        });
                });
                
                function displayAvailableCodes(codes) {
                    const codesList = document.getElementById('existingCodesList');
                    
                    if (codes.length === 0) {
                        codesList.innerHTML = '<div class="text-center text-gray-500">No hay códigos disponibles</div>';
                        return;
                    }
                    
                    codesList.innerHTML = '';
                    codes.forEach(codeData => {
                        const isSelected = selectedCodesForRemoval.some(selected => selected.id === codeData.id);
                        const div = document.createElement('div');
                        div.className = `p-2 border-b cursor-pointer hover:bg-gray-100 ${isSelected ? 'bg-red-100 border-red-300' : ''}`;
                        div.innerHTML = `
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="font-mono text-sm">${codeData.code}</span>
                                    <span class="text-xs text-gray-500 ml-2">${codeData.created_at}</span>
                                </div>
                                <div class="text-sm ${isSelected ? 'text-red-600' : 'text-blue-600'}">
                                    ${isSelected ? '✓ Seleccionado' : 'Click para seleccionar'}
                                </div>
                            </div>
                        `;
                        
                        div.addEventListener('click', () => toggleCodeSelection(codeData, div));
                        codesList.appendChild(div);
                    });
                }
                
                function toggleCodeSelection(codeData, element) {
                    const index = selectedCodesForRemoval.findIndex(selected => selected.id === codeData.id);
                    
                    if (index === -1) {
                        // Seleccionar código
                        selectedCodesForRemoval.push(codeData);
                        element.classList.add('bg-red-100', 'border-red-300');
                        element.querySelector('.text-blue-600').textContent = '✓ Seleccionado';
                        element.querySelector('.text-blue-600').className = 'text-sm text-red-600';
                    } else {
                        // Deseleccionar código
                        selectedCodesForRemoval.splice(index, 1);
                        element.classList.remove('bg-red-100', 'border-red-300');
                        element.querySelector('.text-red-600').textContent = 'Click para seleccionar';
                        element.querySelector('.text-red-600').className = 'text-sm text-blue-600';
                    }
                    
                    updateRemovalDisplay();
                }
                
                function updateRemovalDisplay() {
                    const selectedCodesDiv = document.getElementById('selectedCodesForRemoval');
                    const removalCount = document.getElementById('removalCount');
                    const removalProgress = document.getElementById('removalProgress');
                    const quantityInput = document.getElementById('quantityInput');
                    
                    removalCount.textContent = `${selectedCodesForRemoval.length} códigos seleccionados`;
                    
                    if (selectedCodesForRemoval.length === 0) {
                        selectedCodesDiv.innerHTML = '<div class="text-center text-gray-500">No hay códigos seleccionados</div>';
                        removalProgress.style.width = '0%';
                    } else {
                        selectedCodesDiv.innerHTML = '';
                        selectedCodesForRemoval.forEach((codeData, index) => {
                            const div = document.createElement('div');
                            div.className = 'py-1 border-b border-red-600 last:border-b-0';
                            div.textContent = `${index + 1}. ${codeData.code}`;
                            selectedCodesDiv.appendChild(div);
                        });
                        
                        const progress = Math.min((selectedCodesForRemoval.length / allAvailableCodes.length) * 100, 100);
                        removalProgress.style.width = progress + '%';
                    }
                    
                    // Actualizar cantidad automáticamente
                    quantityInput.value = selectedCodesForRemoval.length;
                    quantityInput.readOnly = true;
                    
                    // Actualizar status
                    document.getElementById('codeSelectionStatus').innerHTML = selectedCodesForRemoval.length > 0 ?
                        `<i class="fas fa-check text-red-500 mr-1"></i>${selectedCodesForRemoval.length} códigos seleccionados para eliminar` : '';
                }
                
                // Búsqueda de códigos
                document.getElementById('searchExistingCodes').addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const filteredCodes = allAvailableCodes.filter(codeData => 
                        codeData.code.toLowerCase().includes(searchTerm)
                    );
                    displayAvailableCodes(filteredCodes);
                });
                
                // Cerrar selección
                document.getElementById('closeCodeSelection').addEventListener('click', function() {
                    document.getElementById('codeSelectionArea').classList.add('hidden');
                });
            }
        }

        function showNewStockModal(controlType, productId) {
            // Encontrar el modal principal y actualizar su contenido
            const stockModal = document.getElementById('stockModal');
            const modalContent = stockModal.querySelector('.bg-white');
            
            let scannedCodes = [];
            let selectedCodesForRemoval = []; // Agregar esta línea
            
            const newStockFormHtml = `
            <div class="max-h-96 overflow-y-auto">
                <div class="flex justify-between items-center mb-4 pb-2 border-b">
                    <h3 class="text-lg font-semibold">
                        <i class="fas fa-plus mr-2 text-blue-500"></i>
                        Agregar Stock a Almacén
                    </h3>
                    <button id="backToStockMain" class="text-blue-500 hover:text-blue-700">
                        <i class="fas fa-arrow-left mr-1"></i>Volver
                    </button>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tienda:</label>
                    <select id="newTiendaSelect" class="w-full p-2 border rounded">
                        <option value="">Seleccione una tienda</option>
                        @foreach($tiendas as $tienda)
                            <option value="{{ $tienda->id }}">{{ $tienda->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cantidad:</label>
                    <input type="number" id="newQuantityInput" class="w-full p-2 border rounded" min="1" value="1">
                </div>
                
                ${controlType === 'codigo_unico' ? `
                    <div class="mb-4">
                        <button type="button" id="newScanCodesBtn" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center justify-center" disabled>
                            <i class="fas fa-qrcode mr-2"></i>
                            Escanear Códigos
                        </button>
                        <div id="newScanStatus" class="mt-2 text-sm text-gray-600"></div>
                        
                        <!-- Área de escaneo para nuevo stock -->
                        <div id="newScanArea" class="hidden mt-4 p-4 bg-gray-50 rounded-lg border">
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Producto:</label>
                                    <input type="text" value="{{ $product->description }}" class="w-full mt-1 p-2 border rounded text-sm" readonly>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Cantidad esperada:</label>
                                    <input type="text" id="newExpectedQuantityDisplay" class="w-full mt-1 p-2 border rounded text-center font-bold text-sm" readonly>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Código escaneado:</label>
                                <div class="flex gap-2">
                                    <input type="text" id="newInputCodigoEscaneado" class="flex-1 p-2 border rounded text-sm" placeholder="Escanee o ingrese código...">
                                    <button type="button" id="newAgregarCodigo" class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                                        <i class="fas fa-plus mr-1"></i>Agregar
                                    </button>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Códigos escaneados:</label>
                                <div id="newListaCodigosEscaneados" class="border rounded p-3 h-24 overflow-y-auto bg-black text-green-400 font-mono text-xs">
                                    <div class="text-center text-gray-500">No hay códigos escaneados</div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-medium text-gray-700">Progreso:</span>
                                    <span id="newProgresoTexto" class="text-sm font-medium">0/0 códigos escaneados</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div id="newBarraProgreso" class="bg-green-500 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                                </div>
                                <div id="newEstadoEscaneo" class="text-sm text-orange-600 mt-2">
                                    <i class="fas fa-clock mr-1"></i>Esperando códigos...
                                </div>
                            </div>
                            
                            <button type="button" id="newCloseScanArea" class="w-full px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 mb-2">
                                <i class="fas fa-times mr-1"></i>Cerrar Escáner
                            </button>
                        </div>
                    </div>
                ` : ''}

                </div>

                <div class="flex justify-between mt-4 pt-4 border-t bg-white">
                    <button id="cancelNewStock" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        Cancelar
                    </button>
                    <button id="confirmNewStock" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Agregar
                    </button>
                </div>
            `;
            
            modalContent.innerHTML = newStockFormHtml;
            
            // Event handlers
            document.getElementById('backToStockMain').addEventListener('click', () => {
                location.reload(); // Recarga para volver al estado inicial
            });
            
            document.getElementById('cancelNewStock').addEventListener('click', () => {
                stockModal.remove();
            });
            
            // Tienda change
            document.getElementById('newTiendaSelect').addEventListener('change', function() {
                const scanBtn = document.getElementById('newScanCodesBtn');
                
                if (this.value) {
                    if (scanBtn) scanBtn.disabled = false;
                } else {
                    if (scanBtn) scanBtn.disabled = true;
                }
            });
            
            // Lógica de escaneo para nuevo stock
            if (controlType === 'codigo_unico') {
                document.getElementById('newScanCodesBtn').addEventListener('click', function() {
                    const quantity = parseInt(document.getElementById('newQuantityInput').value) || 1;
                    const scanArea = document.getElementById('newScanArea');
                    const expectedQuantityDisplay = document.getElementById('newExpectedQuantityDisplay');
                    
                    expectedQuantityDisplay.value = quantity;
                    scanArea.classList.remove('hidden');
                    
                    // Inicializar variables de escaneo
                    scannedCodes = [];
                    updateNewScanProgress(0, quantity);
                    
                    // Focus en input de código
                    setTimeout(() => {
                        document.getElementById('newInputCodigoEscaneado').focus();
                    }, 100);
                });
                
                // Event handlers para el área de escaneo
                document.addEventListener('click', function(e) {
                    if (e.target && e.target.id === 'newAgregarCodigo') {
                        newAgregarCodigoHandler();
                    }
                    if (e.target && e.target.id === 'newCloseScanArea') {
                        document.getElementById('newScanArea').classList.add('hidden');
                        const inputCodigo = document.getElementById('newInputCodigoEscaneado');
                        const btnAgregar = document.getElementById('newAgregarCodigo');
                        if (inputCodigo) {
                            inputCodigo.disabled = false;
                            inputCodigo.placeholder = "Escanee o ingrese código...";
                        }
                        if (btnAgregar) {
                            btnAgregar.disabled = false;
                        }
                        
                        // Solo mostrar mensaje si había códigos escaneados
                        if (scannedCodes.length > 0) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Códigos Guardados',
                                text: `Se han guardado ${scannedCodes.length} códigos escaneados`,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                        
                        document.getElementById('newScanStatus').innerHTML = scannedCodes.length > 0 ? 
                            `<i class="fas fa-check text-green-500 mr-1"></i>${scannedCodes.length} códigos guardados` : '';
                    }
                });
                
                document.addEventListener('keypress', function(e) {
                    if (e.target && e.target.id === 'newInputCodigoEscaneado' && e.key === 'Enter') {
                        e.preventDefault();
                        newAgregarCodigoHandler();
                    }
                });
                
                function newAgregarCodigoHandler() {
                    const inputCodigo = document.getElementById('newInputCodigoEscaneado');
                    const codigo = inputCodigo.value.trim();
                    const quantity = parseInt(document.getElementById('newQuantityInput').value) || 1;
                    
                    if (!codigo) return;
                    
                    if (scannedCodes.includes(codigo)) {
                        Swal.fire('Advertencia', 'Este código ya fue escaneado', 'warning');
                        return;
                    }

                    // LIMITADOR: No permitir más códigos de los necesarios
                    if (scannedCodes.length >= quantity) {
                        Swal.fire('Advertencia', `Ya se han escaneado todos los códigos necesarios (${quantity})`, 'warning');
                        return;
                    }

                    
                    scannedCodes.push(codigo);
                    reproducirSonidoEscaner();
                    
                    // Actualizar lista
                    const listaCodigos = document.getElementById('newListaCodigosEscaneados');
                    if (scannedCodes.length === 1) {
                        listaCodigos.innerHTML = '';
                    }
                    const div = document.createElement('div');
                    div.className = 'py-1 border-b border-green-600 last:border-b-0';
                    div.textContent = `${scannedCodes.length}. ${codigo}`;
                    listaCodigos.appendChild(div);
                    
                    updateNewScanProgress(scannedCodes.length, quantity);
                    
                    inputCodigo.value = '';
                    // Si ya se completó el escaneo, mostrar mensaje y deshabilitar input
                    if (scannedCodes.length === quantity) {
                        inputCodigo.disabled = true;
                        inputCodigo.placeholder = "Escaneo completado";
                        document.getElementById('newAgregarCodigo').disabled = true;
                        Swal.fire({
                            icon: 'success',
                            title: '¡Escaneo Completo!',
                            text: `Se han escaneado todos los ${quantity} códigos necesarios`,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        inputCodigo.focus();
                    }
                    
                    // Actualizar status
                    document.getElementById('newScanStatus').innerHTML = `<i class="fas fa-check text-green-500 mr-1"></i>${scannedCodes.length} códigos escaneados`;
                }
                
                function updateNewScanProgress(current, total) {
                    const barraProgreso = document.getElementById('newBarraProgreso');
                    const progresoTexto = document.getElementById('newProgresoTexto');
                    const estadoEscaneo = document.getElementById('newEstadoEscaneo');
                    
                    const progreso = (current / total) * 100;
                    barraProgreso.style.width = progreso + '%';
                    progresoTexto.textContent = `${current}/${total} códigos escaneados`;
                    
                    if (current === total) {
                        estadoEscaneo.innerHTML = '<i class="fas fa-check mr-1 text-green-500"></i>¡Escaneo completo!';
                        estadoEscaneo.className = 'text-sm text-green-600 mt-2';
                    } else {
                        const faltantes = total - current;
                        estadoEscaneo.innerHTML = `<i class="fas fa-clock mr-1"></i>Esperando códigos... (faltan ${faltantes})`;
                        estadoEscaneo.className = 'text-sm text-orange-600 mt-2';
                    }
                }
                
                function reproducirSonidoEscaner() {
                    const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                    const oscillator = audioContext.createOscillator();
                    const gainNode = audioContext.createGain();

                    oscillator.connect(gainNode);
                    gainNode.connect(audioContext.destination);

                    oscillator.frequency.value = 800;
                    oscillator.type = "square";

                    gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
                    gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.1);

                    oscillator.start(audioContext.currentTime);
                    oscillator.stop(audioContext.currentTime + 0.1);
                }
            }
            
            // Confirm new stock
            document.getElementById('confirmNewStock').addEventListener('click', function() {
                const tiendaId = document.getElementById('newTiendaSelect').value;
                const quantity = parseInt(document.getElementById('newQuantityInput').value) || 1; // <- Esta línea faltaba

                if (!tiendaId) {
                    Swal.fire('Error', 'Debe seleccionar una tienda', 'error');
                    return;
                }
                
                if (controlType === 'codigo_unico' && scannedCodes.length !== quantity) {
                    Swal.fire('Error', 'Debe escanear todos los códigos antes de continuar', 'error');
                    return;
                }
                
                // Send request
                const formData = new FormData();
                formData.append('action', 'increase');
                formData.append('quantity', quantity);
                formData.append('tienda_id', tiendaId);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                
                if (scannedCodes.length > 0) {
                    scannedCodes.forEach((code, index) => {
                        formData.append(`scanned_codes[${index}]`, code);
                    });
                }
                
                fetch(`{{ route('products.manage-stock', ['product' => $product->id]) }}`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Éxito', data.message, 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Ocurrió un error al agregar el stock', 'error');
                });
                
                stockModal.remove();
            });
        }

    });
</script>