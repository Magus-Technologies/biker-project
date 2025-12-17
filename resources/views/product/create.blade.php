<!-- resources\views\product\create.blade.php -->
<x-app-layout>
    <x-breadcrumb 
        title="Registrar Producto" 
        parent="Productos" 
        parentUrl="{{ route('products.index') }}" 
        subtitle="Crear" 
    />

    <div class="px-3 py-4">
        <!-- Header con botones -->
        <!-- <div class="bg-white rounded-lg px-4 py-3 mb-3 flex flex-wrap justify-between items-center gap-3">
            <h2 class="text-lg font-semibold text-gray-700">
                <i class="bi bi-box-seam mr-2 text-blue-600"></i>
                Registro de Producto
            </h2>
            <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition-colors text-sm">
                <i class="bi bi-x-lg mr-1"></i>
                Cancelar
            </a>
        </div> -->

        <!-- Formulario -->
        <div class="bg-white rounded-lg shadow-lg p-4 md:p-6 border border-gray-200">
            <form id="formProducts" enctype="multipart/form-data">
                @csrf
                <h5 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">
                    <i class="bi bi-info-circle mr-2 text-blue-600"></i>
                    Datos del Producto
                </h5>

                <!-- Control Type Switch -->
                <div class="mb-6">
                    <label class="block font-medium text-gray-700 mb-3 text-sm">Tipo de Control</label>
                    <div class="flex items-center justify-center">
                        <div class="bg-gray-200 p-1 rounded-full shadow-inner">
                            <div class="flex flex-col sm:flex-row relative gap-1 sm:gap-0">
                                <input type="radio" name="control_type" value="cantidad" class="sr-only" id="radio_cantidad">
                                <input type="radio" name="control_type" value="codigo_unico" class="sr-only" id="radio_codigo" checked>
                                
                                <label for="radio_cantidad" class="flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 rounded-full cursor-pointer transition-all duration-300 control-option" data-value="cantidad">
                                    <i class="fas fa-calculator mr-2 text-blue-500"></i>
                                    <span class="text-xs sm:text-sm font-medium whitespace-nowrap">Control por Cantidad</span>
                                </label>
                                
                                <label for="radio_codigo" class="flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 rounded-full cursor-pointer transition-all duration-300 control-option" data-value="codigo_unico">
                                    <i class="fas fa-qrcode mr-2 text-green-500"></i>
                                    <span class="text-xs sm:text-sm font-medium whitespace-nowrap">Control por Código Único</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mb-6">
            
                    <div>
                        <label for="code_sku" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-upc-scan mr-1 text-gray-500"></i>Código SKU
                        </label>
                        <input type="text" name="code_sku" id="code_sku"
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-card-text mr-1 text-gray-500"></i>Descripción
                        </label>
                        <input type="text" name="description" id="description"
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="code_bar" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-upc mr-1 text-gray-500"></i>Código de Barras
                        </label>
                        <input type="text" name="code_bar" id="code_bar"
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="model" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-tag mr-1 text-gray-500"></i>Modelo
                        </label>
                        <input type="text" name="model" id="model"
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div class="relative">
                        <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-award mr-1 text-gray-500"></i>Marca
                        </label>
                        <input type="text" id="brand" name="brand"
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" autocomplete="off">
                        <div id="brandDropdown"
                            class="absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-lg hidden">
                            <ul id="brandSuggestions" class="max-h-40 overflow-y-auto"></ul>
                        </div>
                    </div>

                    <div class="relative">
                        <label for="unit_name" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-rulers mr-1 text-gray-500"></i>Unidad de Medida
                        </label>
                        <input type="text" id="unit_name" name="unit_name"
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" autocomplete="off">
                        <div id="unitDropdown"
                            class="absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-lg hidden">
                            <ul id="unitSuggestions" class="max-h-40 overflow-y-auto"></ul>
                        </div>
                    </div>

                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-box-seam mr-1 text-gray-500"></i>Cantidad
                        </label>
                        <input type="number" name="quantity" id="quantity"
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="minimum_stock" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-exclamation-triangle mr-1 text-gray-500"></i>Stock Mínimo
                        </label>
                        <input type="number" name="minimum_stock" id="minimum_stock"
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-geo-alt mr-1 text-gray-500"></i>Ubicación
                        </label>
                        <input type="text" name="location" id="location"
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div class="sm:col-span-2 lg:col-span-3">
                        <label for="images" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-images mr-1 text-gray-500"></i>Imágenes del Producto
                        </label>
                        <input type="file" name="images[]" id="images" accept="image/*" multiple
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <div id="previewImages" class="mt-2 flex flex-wrap gap-2"></div>
                    </div>

                    <div id="scanButton" class="hidden sm:col-span-2 lg:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Escanear Códigos</label>
                        <button type="button" id="openScanModal" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 transition flex items-center justify-center text-sm">
                            <i class="fas fa-qrcode mr-2"></i>
                            Escanear
                        </button>
                    </div>
                </div>

                <h5 class="text-lg font-semibold mb-4 mt-6 text-gray-800 border-b pb-2">
                    <i class="bi bi-currency-dollar mr-2 text-green-600"></i>
                    Precios
                </h5>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div>
                        <label for="prices[buy]" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-cart mr-1 text-gray-500"></i>Precio de Compra
                        </label>
                        <input type="number" step="0.01" name="prices[buy]" id="prices_buy"
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="prices[wholesale]" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-people mr-1 text-gray-500"></i>Precio Mayorista
                        </label>
                        <input type="number" step="0.01" name="prices[wholesale]" id="prices_wholesale"
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="prices[sucursalA]" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-shop mr-1 text-gray-500"></i>Precio Sucursal A
                        </label>
                        <input type="number" step="0.01" name="prices[sucursalA]" id="prices_sucursal_a"
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="prices[sucursalB]" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-shop-window mr-1 text-gray-500"></i>Precio Sucursal B
                        </label>
                        <input type="number" step="0.01" name="prices[sucursalB]" id="prices_sucursal_b"
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-center gap-3 mt-6 pt-4 border-t">
                    <a href="{{ route('products.index') }}" class="px-6 py-2 bg-gray-500 text-white rounded-lg shadow-md hover:bg-gray-600 transition text-center text-sm">
                        <i class="bi bi-x-lg mr-1"></i>
                        Cancelar
                    </a>
                    <button id="registrar"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition text-sm"
                        type="submit">
                        <i class="bi bi-save mr-1"></i>
                        Registrar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
    // Previsualizar imágenes múltiples
    document.getElementById('images').addEventListener('change', function(e) {
        const previewContainer = document.getElementById('previewImages');
        previewContainer.innerHTML = ""; // Limpiar previsualizaciones previas
        const files = this.files;

        if (files.length > 0) {
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = "Previsualización de imagen";
                    img.className =
                        "w-20 h-20 object-cover border rounded-lg"; // Ajusta según tus necesidades
                    previewContainer.appendChild(img);
                }
                reader.readAsDataURL(file);
            });
        }
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

    // FIN DE MARCA

    // BUSQUEDA DE UNIDAD MEDIDA
    document.getElementById("unit_name").addEventListener("input", function() {
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
    // FIN DE BUSQUEDA DE UNIDAD MEDIDA
    

    // Control Type Switch Logic
    document.addEventListener('DOMContentLoaded', function() {
        const controlOptions = document.querySelectorAll('.control-option');
        const radioInputs = document.querySelectorAll('input[name="control_type"]');
        const quantityInput = document.getElementById('quantity');
        const tiendaSelect = document.getElementById('tiendaSelect');
        const scanButton = document.getElementById('scanButton');
        let scannedCodes = [];

        // Función para actualizar la apariencia visual
        function updateSwitchAppearance() {
            const checkedValue = document.querySelector('input[name="control_type"]:checked').value;
            
            controlOptions.forEach(option => {
                const value = option.dataset.value;
                const icon = option.querySelector('i');
                const span = option.querySelector('span');
                
                if (value === checkedValue) {
                    // Opción activa
                    if (value === 'cantidad') {
                        option.classList.add('bg-blue-500', 'text-white', 'shadow-lg', 'transform', 'scale-105');
                        option.classList.remove('text-gray-700', 'hover:bg-gray-100');
                        icon.classList.remove('text-blue-500');
                        icon.classList.add('text-white');
                    } else {
                        option.classList.add('bg-green-500', 'text-white', 'shadow-lg', 'transform', 'scale-105');
                        option.classList.remove('text-gray-700', 'hover:bg-gray-100');
                        icon.classList.remove('text-green-500');
                        icon.classList.add('text-white');
                    }
                } else {
                    // Opción inactiva
                    option.classList.remove('bg-blue-500', 'bg-green-500', 'text-white', 'shadow-lg', 'transform', 'scale-105');
                    option.classList.add('text-gray-700', 'hover:bg-gray-100');
                    
                    if (value === 'cantidad') {
                        icon.classList.remove('text-white');
                        icon.classList.add('text-blue-500');
                    } else {
                        icon.classList.remove('text-white');
                        icon.classList.add('text-green-500');
                    }
                }
            });
        }

        // Event listeners para los labels
        controlOptions.forEach(option => {
            option.addEventListener('click', function() {
                const value = this.dataset.value;
                const radioInput = document.getElementById(value === 'cantidad' ? 'radio_cantidad' : 'radio_codigo');
                
                // Marcar el radio button correspondiente
                radioInputs.forEach(radio => {
                    radio.checked = radio.value === value;
                });
                
                // Actualizar apariencia
                updateSwitchAppearance();
                
                // Manejar visibilidad del botón de escaneo
                const quantity = parseInt(quantityInput.value) || 0;
                if (quantity > 0 && value === 'codigo_unico') {
                    scanButton.classList.remove('hidden');
                } else {
                    scanButton.classList.add('hidden');
                }
            });
        });

        // Inicializar apariencia
        updateSwitchAppearance();

        // Quantity input change handler
        quantityInput.addEventListener('input', function() {
            const quantity = parseInt(this.value) || 0;
            const controlType = document.querySelector('input[name="control_type"]:checked').value;
            
            if (quantity > 0 && controlType === 'codigo_unico') {
                scanButton.classList.remove('hidden');
            } else {
                scanButton.classList.add('hidden');
            }
        });

        // Control type change handler
        radioInputs.forEach(radio => {
            radio.addEventListener('change', function() {
                const quantity = parseInt(quantityInput.value) || 0;
                if (quantity > 0 && this.value === 'codigo_unico') {
                    scanButton.classList.remove('hidden');
                } else {
                    scanButton.classList.add('hidden');
                }
            });
        });

        // Reproducir sonido de escáner
        function reproducirSonidoEscaner() {
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            
            setTimeout(() => {
                const inputEdit = $('#inputCodigoEscaneado');
                if (inputEdit) {
                    inputEdit.prop('readonly', false);
                    inputEdit.prop('disabled', false);
                    inputEdit.removeAttr('readonly');
                    inputEdit.removeAttr('disabled');
                    inputEdit.focus();
                }
            }, 100);
            
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

        // Modal de escaneo
        document.getElementById('openScanModal')?.addEventListener('click', function() {
            const quantity = parseInt(quantityInput.value) || 0;
            if (quantity === 0) {
                Swal.fire('Advertencia', 'Debe ingresar una cantidad válida primero', 'warning');
                return;
            }
            
            const modalHtml = `
                <div id="scanModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg p-6 w-[700px] max-w-[95vw]">
                        <div class="flex justify-between items-center mb-4 pb-2 border-b">
                            <h3 class="text-lg font-semibold flex items-center">
                                <i class="fas fa-qrcode mr-2 text-green-500"></i>
                                ESCANEAR CÓDIGOS ÚNICOS DEL PRODUCTO
                            </h3>
                            <button id="closeScanModal" class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Producto:</label>
                                <input type="text" value="${document.getElementById('description').value || 'Nuevo Producto'}" class="w-full mt-1 p-2 border rounded" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Cantidad esperada:</label>
                                <input type="text" value="${quantity}" class="w-full mt-1 p-2 border rounded text-center font-bold" readonly>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Código escaneado:</label>
                            <div class="flex gap-2">
                                <input type="text" id="inputCodigoEscaneado" class="flex-1 p-2 border rounded" placeholder="Escanee o ingrese código...">
                                <button type="button" id="agregarCodigo" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                    <i class="fas fa-plus mr-1"></i>Agregar
                                </button>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Códigos escaneados:</label>
                            <div id="listaCodigosEscaneados" class="border rounded p-3 h-32 overflow-y-auto bg-black text-green-400 font-mono text-sm">
                                <div class="text-center text-gray-500">No hay códigos escaneados</div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">Progreso:</span>
                                <span id="progresoTexto" class="text-sm font-medium">0/${quantity} códigos escaneados</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div id="barraProgreso" class="bg-green-500 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                            <div id="estadoEscaneo" class="text-sm text-orange-600 mt-2">
                                <i class="fas fa-clock mr-1"></i>Esperando códigos... (faltan ${quantity})
                            </div>
                        </div>
                        
                        <div class="flex justify-between">
                            <button id="cancelarEscaneo" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                                <i class="fas fa-times mr-1"></i>Cancelar
                            </button>
                            <button id="guardarCodigos" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600" disabled>
                                <i class="fas fa-check mr-1"></i>Guardar
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            
            // Modal event handlers
            const modal = document.getElementById('scanModal');
            const inputCodigo = document.getElementById('inputCodigoEscaneado');
            const btnAgregar = document.getElementById('agregarCodigo');
            const listaCodigos = document.getElementById('listaCodigosEscaneados');
            const barraProgreso = document.getElementById('barraProgreso');
            const progresoTexto = document.getElementById('progresoTexto');
            const estadoEscaneo = document.getElementById('estadoEscaneo');
            const btnGuardar = document.getElementById('guardarCodigos');
            let codigosEscaneados = [];
            
            // Cerrar modal
            document.getElementById('closeScanModal').addEventListener('click', () => modal.remove());
            document.getElementById('cancelarEscaneo').addEventListener('click', () => modal.remove());
            
            // Agregar código
            function agregarCodigo() {
                const codigo = inputCodigo.value.trim();
                if (!codigo) return;
                
                // NUEVA VALIDACIÓN: Evitar escanear más códigos de los necesarios
                if (codigosEscaneados.length >= quantity) {
                    Swal.fire('Advertencia', `Ya se han escaneado todos los códigos necesarios (${quantity}/${quantity})`, 'warning');
                    inputCodigo.value = '';
                    return;
                }
                
                if (codigosEscaneados.includes(codigo)) {
                    Swal.fire('Advertencia', 'Este código ya fue escaneado', 'warning');
                    return;
                }
                
                codigosEscaneados.push(codigo);
                reproducirSonidoEscaner();
                
                // Actualizar lista
                if (codigosEscaneados.length === 1) {
                    listaCodigos.innerHTML = '';
                }
                const div = document.createElement('div');
                div.className = 'py-1 border-b border-green-600 last:border-b-0';
                div.textContent = `${codigosEscaneados.length}. ${codigo}`;
                listaCodigos.appendChild(div);
                
                // Actualizar progreso
                const progreso = (codigosEscaneados.length / quantity) * 100;
                barraProgreso.style.width = progreso + '%';
                progresoTexto.textContent = `${codigosEscaneados.length}/${quantity} códigos escaneados`;
                
                if (codigosEscaneados.length === quantity) {
                    estadoEscaneo.innerHTML = '<i class="fas fa-check mr-1 text-green-500"></i>¡Escaneo completo!';
                    estadoEscaneo.className = 'text-sm text-green-600 mt-2';
                    btnGuardar.disabled = false;
                    btnGuardar.classList.remove('opacity-50');
                    
                    // NUEVA FUNCIONALIDAD: Deshabilitar input cuando se complete
                    inputCodigo.disabled = true;
                    inputCodigo.placeholder = 'Escaneo completado';
                    btnAgregar.disabled = true;
                    btnAgregar.classList.add('opacity-50');
                } else {
                    const faltantes = quantity - codigosEscaneados.length;
                    estadoEscaneo.innerHTML = `<i class="fas fa-clock mr-1"></i>Esperando códigos... (faltan ${faltantes})`;
                }
                
                inputCodigo.value = '';
                inputCodigo.focus();
            }
            
            btnAgregar.addEventListener('click', agregarCodigo);
            inputCodigo.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    agregarCodigo();
                }
            });
            
            // Guardar códigos
            btnGuardar.addEventListener('click', function() {
                scannedCodes = codigosEscaneados;
                modal.remove();
                Swal.fire('Éxito', `${codigosEscaneados.length} códigos guardados correctamente`, 'success');
            });
            
            inputCodigo.focus();
        });

        // Modificar el submit del formulario para incluir códigos escaneados
        const originalSubmit = document.getElementById('formProducts').onsubmit;
        document.getElementById('formProducts').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const controlType = document.querySelector('input[name="control_type"]:checked').value;
            const quantity = parseInt(quantityInput.value) || 0;
            
            // Validar códigos escaneados si es necesario
            if (quantity > 0 && controlType === 'codigo_unico' && scannedCodes.length !== quantity) {
                Swal.fire('Error', 'Debe escanear todos los códigos antes de guardar el producto', 'error');
                return;
            }
            
            let formData = new FormData(this);
            
            // Agregar códigos escaneados al FormData
            if (scannedCodes.length > 0) {
                scannedCodes.forEach((code, index) => {
                    formData.append(`scanned_codes[${index}]`, code);
                });
            }

            fetch('{{ route('products.store') }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            let errorMessages = '';
                            if (err.errors) {
                                for (let field in err.errors) {
                                    errorMessages += `${field}: ${err.errors[field].join(', ')}\n`;
                                }
                            } else if (err.error) {
                                errorMessages = err.error;
                            } else if (err.errorPago) {
                                errorMessages = err.errorPago;
                            }

                            if (errorMessages) {
                                Swal.fire({
                                    title: 'Errores de Validación',
                                    text: errorMessages,
                                    icon: 'error',
                                    confirmButtonText: 'Aceptar'
                                });
                            }

                            throw new Error('Error en la respuesta del servidor');
                        });
                    }

                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: data.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        
                        // Solo resetear el formulario cuando hay éxito
                        document.getElementById('formProducts').reset();
                        document.getElementById('previewImages').innerHTML = '';
                        scannedCodes = [];
                        
                        // Reset control type to default (código único)
                        document.getElementById('radio_codigo').checked = true;
                        document.getElementById('radio_cantidad').checked = false;
                        updateSwitchAppearance();
                        
                        // Hide scan button
                        scanButton.classList.add('hidden');
                    }
                })
            .catch(error => {
                console.error('Error:', error);
            });
    });
    });

</script>

<style>
    .control-option {
        transition: all 0.3s ease;
        min-width: 180px;
        text-align: center;
        border: 2px solid transparent;
    }
    
    .control-option:hover {
        transform: translateY(-1px);
    }
    
    .control-option.bg-blue-500 {
        border-color: rgba(59, 130, 246, 0.3);
        box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
    }
    
    .control-option.bg-green-500 {
        border-color: rgba(34, 197, 94, 0.3);
        box-shadow: 0 0 20px rgba(34, 197, 94, 0.3);
    }
    
    .control-option i {
        transition: color 0.3s ease;
    }
    
    .control-option span {
        transition: color 0.3s ease;
        font-weight: 500;
    }
</style>    