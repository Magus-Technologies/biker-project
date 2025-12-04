<x-app-layout>
    <x-breadcrumb title="Registrar venta" parent="ventas" parentUrl="{{route('sales.index')}}" subtitle="crear"/>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Registro de Socios --}}
        </h2>
    </x-slot>
    <div class="container mx-auto p-2 text-sm">
        <div class="grid grid-cols-1 gap-6">
            <!-- Formulario de Cliente -->
            <div class="bg-white p-6 rounded-lg shadow">
                <!-- Primera fila: Modelo de Moto y Fecha/Hora -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="motorcycle_model" class="text-xs text-gray-500 uppercase font-semibold block mb-1">Modelo de Moto</label>
                        <input type="text" id="motorcycle_model" placeholder="Ingrese modelo de moto"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm">
                    </div>
                    <div class="flex justify-end items-end">
                        <input type="text" id="fechaHora" value="" 
                            class="p-2 border border-gray-300 rounded-md shadow-sm text-sm bg-gray-50 text-right" 
                            readonly style="width: 200px;">
                    </div>
                </div>
                
                <!-- Segunda fila: Número de Celular y Mecánico -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="phone" class="text-xs text-gray-500 uppercase font-semibold block mb-1">Número de Celular</label>
                        <input type="tel" id="phone" placeholder="Ej: 999 999 999"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm" maxlength="9">
                    </div>
                    <div>
                        <label for="mecanico_select" class="text-xs text-gray-500 uppercase font-semibold block mb-1">Mecánico</label>
                        <div class="flex gap-2">
                            <select id="mecanico_select" class="flex-1 p-2 border border-gray-300 rounded-md shadow-sm text-sm">
                                <option value="">Seleccionar mecánico</option>
                            </select>
                            <button onclick="mostrarModal()" type="button" 
                                class="px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md transition text-sm"
                                title="Buscar mecánico">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        <input name="mechanics_id" id="mechanics_id" type="hidden">
                    </div>
                </div>
                
                <h2 class="text-lg font-bold mb-4">Cliente</h2>
                
                <!-- Grid de 2 columnas para campos de cliente -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="dni_personal" class="text-xs text-gray-500 uppercase font-semibold block mb-1">Documento</label>
                        <input type="text" id="dni_personal" placeholder="Ingrese Documento"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm">
                    </div>
                    <div>
                        <label for="nombres_apellidos" class="text-xs text-gray-500 uppercase font-semibold block mb-1">Nombre del Cliente</label>
                        <input type="text" placeholder="Nombre del cliente" id="nombres_apellidos"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm">
                    </div>
                </div>

                <!-- Campos ocultos para compatibilidad -->
                <input type="hidden" id="direccion" value="">
                <input type="hidden" id="districts_id" value="todos">

                <!-- Buscador de Productos con Autocompletado -->
                <div class="mb-4">
                    <div class="relative">
                        <label class="text-xs text-gray-500 uppercase font-semibold block mb-1">Buscar Producto</label>
                        <div class="flex gap-2">
                            <div class="flex-1 relative">
                                <input type="text" id="searchProductInput" 
                                    placeholder="Escriba para buscar productos..."
                                    autocomplete="off"
                                    class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500">
                                <!-- Dropdown de resultados -->
                                <div id="searchProductResults" 
                                    class="hidden absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-96 overflow-y-auto">
                                    <!-- Los resultados se cargarán aquí -->
                                </div>
                            </div>
                            <button type="button" onclick="addSelectedProduct()" 
                                class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition text-sm whitespace-nowrap">
                                <i class="bi bi-plus-circle mr-1"></i>Agregar
                            </button>
                        </div>
                        <!-- Campo oculto para guardar el producto seleccionado -->
                        <input type="hidden" id="selectedProduct" value="">
                    </div>
                </div>

                <!-- Modal Mecánicos -->
                <div id="modalMecanicos"
                    class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center z-50">
                    <div class="bg-white p-6 rounded-lg shadow-md w-1/3">
                        <h3 class="text-xl font-semibold mb-4">Mecánicos Disponibles</h3>
                        <div id="listaMecanicosModal"></div>
                        <button onclick="closeModal('modalMecanicos')"
                            class="mt-4 px-4 py-2 bg-red-500 text-white rounded-lg">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Productos (Detalle del Pedido) -->
        <div class="mt-6 bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-bold mb-4">Productos</h2>

            <table class="w-full border-collapse border border-gray-300" id="orderTable">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2">Item</th>
                        <th class="border p-2">Producto</th>
                        <th class="border p-2">Cantidad</th>
                        <th class="border p-2">P. Unit.</th>
                        <th class="border p-2">T. Precio</th>
                        <th class="border p-2">Parcial</th>
                        <th class="border p-2">Acciones</th>
                    </tr>
                </thead>
                <tbody id="orderTableBody">
                    <tr id="emptyRow">
                        <td class="border p-2 text-center" colspan="7">No hay productos agregados</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Tabla para listar servicios -->
        <div class="mt-5 bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-bold mb-4">Servicios</h2>
            
            <!-- Agregar Servicio (arriba de tabla de servicios) -->
            <div class="mb-4 grid grid-cols-12 gap-2 items-end">
                <div class="col-span-5 relative">
                    <label for="service" class="block text-sm font-medium text-gray-700 mb-1">Servicio</label>
                    <input type="text" id="service" name="service" value="{{ old('service', 'TALLER') }}"
                        class="block w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm" autocomplete="off">
                    <div id="serviceDropdown"
                        class="absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-lg hidden">
                        <ul id="serviceSuggestions" class="max-h-40 overflow-y-auto"></ul>
                    </div>
                </div>
                <div class="col-span-4">
                    <label for="service_price" class="block text-sm font-medium text-gray-700 mb-1">Precio del Servicio</label>
                    <input type="number" id="service_price" name="service_price" value="{{ old('service_price', 60) }}"
                        class="block w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm">
                </div>
                <div class="col-span-3">
                    <button type="button" id="addService" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition text-sm">
                        <i class="bi bi-plus-circle mr-1"></i>Agregar Servicio
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">Servicio</th>
                        <th class="border border-gray-300 px-4 py-2">Precio</th>
                        <th class="border border-gray-300 px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody id="serviceList">
                    <!-- Aquí se agregarán los servicios -->
                </tbody>
            </table>
        </div>
        
        <!-- Configurar Documento, Totales y Botón Guardar (todo en un mismo card) -->
        <div class="mt-5 bg-white p-4 rounded-lg shadow">
            <div class="flex flex-col items-end">
                <!-- Botón Configurar Documento -->
                <button type="button" onclick="abrirPanelDocumento()" 
                    class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition text-sm mb-3 w-auto">
                    <i class="bi bi-file-earmark-text mr-1"></i>Configurar Documento de Venta
                </button>
                
                <!-- Resumen del documento configurado -->
                <div id="documentoResumen" class="hidden p-3 bg-gray-50 rounded-lg w-auto mb-3">
                    <h3 class="font-semibold text-gray-700 mb-2 flex items-center gap-2 text-sm">
                        <i class="bi bi-check-circle-fill text-green-500"></i>
                        Documento Configurado
                    </h3>
                    <div class="text-xs text-gray-600 space-y-1">
                        <p><strong>Tipo:</strong> <span id="resumenTipoDoc">-</span></p>
                        <p><strong>Pago:</strong> <span id="resumenTipoPago">-</span></p>
                        <p><strong>Método:</strong> <span id="resumenMetodoPago">-</span></p>
                    </div>
                </div>
                
                <!-- Totales alineados a la derecha -->
                <div class="space-y-2 w-auto mb-4">
                    <div class="bg-gray-200 text-gray-800 p-2 rounded text-center text-sm font-bold whitespace-nowrap">
                        Subtotal: <span id="subtotalAmount">S/ 0.00</span>
                    </div>
                    <div class="bg-gray-200 text-gray-800 p-2 rounded text-center text-sm font-bold whitespace-nowrap">
                        IGV (18%): <span id="igvAmount">S/ 0.00</span>
                    </div>
                    <div class="bg-indigo-500 text-white p-2 rounded text-center text-sm font-bold whitespace-nowrap" id="totalAmount">
                        S/ 0.00
                    </div>
                </div>
                
                <!-- Botón Guardar -->
                <button class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg transition text-lg" onclick="saveSales()">
                    <i class="bi bi-save mr-2"></i>Guardar Venta
                </button>
            </div>
        </div>

    </div>
    
    <!-- Panel lateral para configurar documento -->
    <div id="panelDocumento" class="fixed inset-y-0 right-0 w-96 bg-white shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out z-50 overflow-y-auto">
        <div class="sticky top-0 bg-blue-600 text-white p-6 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <i class="bi bi-file-earmark-text text-2xl"></i>
                <h2 class="text-xl font-bold">Documento de Venta</h2>
            </div>
            <button onclick="cerrarPanelDocumento()" class="text-white hover:bg-white/20 rounded-full p-2 transition">
                <i class="bi bi-x-lg text-2xl"></i>
            </button>
        </div>
        
        <div class="p-6 space-y-4">
            <div>
                <label class="font-bold">Tipo pago <span class="text-red-500">*</span></label>
                <select id="paymentType" class="w-full p-2 border rounded">
                    <option value="">Seleccione</option>
                    @foreach ($paymentsType as $payment)
                        <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div id="creditFields" class="hidden">
                <label>Número de días:</label>
                <input type="number" id="nro_dias" class="w-full p-2 border rounded" min="1">
                <label class="mt-2">Fecha de vencimiento:</label>
                <input type="date" id="fecha_vencimiento" class="w-full p-2 border rounded">
            </div>
            
            <div id="paymentMethodContainer1">
                <label class="font-bold">Método pago <span class="text-red-500">*</span></label>
                <select id="paymentMethod1" class="w-full p-2 border rounded">
                    <option value="">Seleccione</option>
                    @foreach ($paymentsMethod as $payment)
                        <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div id="paymentMethodContainer2">
                <input type="checkbox" id="togglePaymentFields" class="mr-2">
                <label>Agregar método de pago y monto</label>
            </div>
            
            <div id="paymentFieldsContainer" class="hidden">
                <div>
                    <label class="font-bold">Método de pago</label>
                    <select id="paymentMethod2" class="w-full p-2 border rounded">
                        <option value="">Seleccione</option>
                        @foreach ($paymentsMethod as $payment)
                            <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-2">
                    <label class="font-bold">Monto a pagar</label>
                    <input type="number" id="paymentAmount2" class="w-full p-2 border rounded" placeholder="Ingrese el monto">
                </div>
            </div>
            
            <div>
                <label class="font-bold">Tipo de documento <span class="text-red-500">*</span></label>
                <select id="documentType" class="w-full p-2 border rounded">
                    <option value="">Seleccione</option>
                    @foreach ($documentTypes as $documentType)
                        <option value="{{ $documentType->id }}">{{ $documentType->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="font-bold">Fecha</label>
                <input type="date" id="orderDate" value="{{ date('Y-m-d') }}" class="w-full p-2 border rounded">
            </div>
            
            <div>
                <label class="font-bold">Moneda</label>
                <input type="text" id="orderCurrency" value="SOLES" class="w-full p-2 border rounded" readonly>
            </div>
        </div>
        
        <div class="sticky bottom-0 bg-white border-t p-4 flex gap-3">
            <button onclick="cerrarPanelDocumento()" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-4 rounded-lg transition">
                Cancelar
            </button>
            <button onclick="aplicarDocumento()" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-4 rounded-lg transition">
                <i class="bi bi-check-lg mr-2"></i>Aplicar
            </button>
        </div>
    </div>

    <!-- Overlay oscuro -->
    <div id="overlayDocumento" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40" onclick="cerrarPanelDocumento()"></div>
</x-app-layout>

<script>
    let services = [];
    let quotationItems = [];
    const searchInput = document.getElementById("searchProduct");
    let orderCount = 0; // para numerar los ítems
    const totalAmountEl = document.getElementById("totalAmount");
    const orderTableBody = document.getElementById("orderTableBody");
    let payments = [];
    let pedidoId = null; // Para guardar el ID del pedido si viene de conversión
    let documentoData = {}; // Para guardar la configuración del documento
    
    // Funciones para el panel de documento
    function abrirPanelDocumento() {
        document.getElementById('panelDocumento').classList.remove('translate-x-full');
        document.getElementById('overlayDocumento').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function cerrarPanelDocumento() {
        document.getElementById('panelDocumento').classList.add('translate-x-full');
        document.getElementById('overlayDocumento').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    function aplicarDocumento() {
        const tipoDocSelect = document.getElementById('documentType');
        const tipoPagoSelect = document.getElementById('paymentType');
        const metodoPagoSelect = document.getElementById('paymentMethod1');
        
        const tipoDoc = tipoDocSelect?.options[tipoDocSelect.selectedIndex]?.text || '-';
        const tipoPago = tipoPagoSelect?.options[tipoPagoSelect.selectedIndex]?.text || '-';
        const metodoPago = metodoPagoSelect?.options[metodoPagoSelect.selectedIndex]?.text || '-';
        
        // Validar campos obligatorios
        if (!tipoDocSelect?.value || !tipoPagoSelect?.value) {
            Swal.fire({
                icon: 'warning',
                title: 'Campos obligatorios',
                text: 'Debes seleccionar el tipo de documento y tipo de pago',
                confirmButtonColor: '#3b82f6'
            });
            return;
        }
        
        if (tipoPagoSelect.value === '1' && !metodoPagoSelect?.value) {
            Swal.fire({
                icon: 'warning',
                title: 'Campo obligatorio',
                text: 'Debes seleccionar un método de pago',
                confirmButtonColor: '#3b82f6'
            });
            return;
        }
        
        // Guardar valores
        documentoData = {
            paymentType: tipoPagoSelect?.value,
            paymentMethod1: metodoPagoSelect?.value,
            documentType: tipoDocSelect?.value,
            tipoDocText: tipoDoc,
            tipoPagoText: tipoPago,
            metodoPagoText: metodoPago
        };
        
        // Actualizar resumen
        document.getElementById('resumenTipoDoc').textContent = tipoDoc;
        document.getElementById('resumenTipoPago').textContent = tipoPago;
        document.getElementById('resumenMetodoPago').textContent = metodoPago;
        document.getElementById('documentoResumen').classList.remove('hidden');
        
        // Cerrar panel
        cerrarPanelDocumento();
        
        Swal.fire({
            icon: 'success',
            title: 'Documento configurado',
            text: 'La configuración se ha guardado correctamente',
            timer: 1500,
            showConfirmButton: false
        });
    }

    // Actualizar fecha y hora
    function actualizarFechaHora() {
        const ahora = new Date();
        const opciones = { 
            year: 'numeric', 
            month: '2-digit', 
            day: '2-digit',
            hour: '2-digit', 
            minute: '2-digit',
            second: '2-digit',
            hour12: false 
        };
        const fechaHoraFormateada = ahora.toLocaleString('es-PE', opciones).replace(',', '');
        document.getElementById('fechaHora').value = fechaHoraFormateada;
    }
    
    // Verificar si viene de un pedido
    document.addEventListener('DOMContentLoaded', function() {
        // Actualizar fecha y hora cada segundo
        actualizarFechaHora();
        setInterval(actualizarFechaHora, 1000);
        
        const urlParams = new URLSearchParams(window.location.search);
        pedidoId = urlParams.get('pedido_id');

        if (pedidoId) {
            cargarDatosPedido(pedidoId);
        }
        
        // Inicializar buscador de productos
        initProductSearch();
    });
    
    // Función para inicializar el buscador de productos
    function initProductSearch() {
        const searchProductInput = document.getElementById('searchProductInput');
        if (searchProductInput) {
            searchProductInput.addEventListener('input', function() {
                const searchTerm = this.value.trim();
                if (searchTerm.length >= 1) {
                    searchProductsAutocomplete(searchTerm);
                } else {
                    hideProductResults();
                }
            });

            // Cerrar dropdown al hacer clic fuera
            document.addEventListener('click', function(e) {
                const resultsDiv = document.getElementById('searchProductResults');
                const inputDiv = document.getElementById('searchProductInput');
                if (resultsDiv && !resultsDiv.contains(e.target) && e.target !== inputDiv) {
                    hideProductResults();
                }
            });
        }
    }
    
    // Función para buscar productos con autocompletado
    function searchProductsAutocomplete(searchTerm) {
        const url = `${baseUrl}/api/product?tienda_id=todos&search=${searchTerm}`;
        
        fetch(url)
            .then(response => response.json())
            .then(data => {
                displayProductResults(Array.isArray(data) ? data : []);
            })
            .catch(error => {
                console.error('Error buscando productos:', error);
                hideProductResults();
            });
    }
    
    // Función para mostrar resultados de búsqueda
    function displayProductResults(products) {
        const resultsDiv = document.getElementById('searchProductResults');
        
        if (!resultsDiv) {
            console.error('No se encontró el div de resultados');
            return;
        }
        
        if (products.length === 0) {
            resultsDiv.innerHTML = '<div class="p-3 text-sm text-gray-500 text-center">No se encontraron productos</div>';
            resultsDiv.classList.remove('hidden');
            return;
        }
        
        let html = '';
        products.forEach(product => {
            const stockQuantity = product.stock?.quantity || 0;
            const stockColor = stockQuantity === 0 ? 'text-red-600' : (stockQuantity <= (product.stock?.minimum_stock || 0) ? 'text-yellow-600' : 'text-green-600');
            
            // Obtener el primer precio disponible
            const firstPrice = product.prices && product.prices.length > 0 ? product.prices[0] : null;
            const priceText = firstPrice ? `S/ ${firstPrice.price}` : 'Sin precio';
            
            html += `
                <div class="product-result p-3 hover:bg-gray-100 cursor-pointer border-b border-gray-200 transition" 
                     data-product-id="${product.id}"
                     data-product-description="${product.description.replace(/"/g, '&quot;')}"
                     data-product-prices='${JSON.stringify(product.prices || [])}'
                     data-product-stock="${stockQuantity}">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="font-medium text-sm text-gray-900">${product.description}</div>
                            <div class="text-xs text-gray-500 mt-1">Código: ${product.code_sku}</div>
                            <div class="text-xs ${stockColor} font-semibold mt-1">Stock: ${stockQuantity}</div>
                        </div>
                        <div class="text-right ml-3">
                            <div class="text-sm font-semibold text-blue-600">${priceText}</div>
                        </div>
                    </div>
                </div>
            `;
        });
        
        resultsDiv.innerHTML = html;
        resultsDiv.classList.remove('hidden');
        
        // Agregar event listeners a los resultados
        resultsDiv.querySelectorAll('.product-result').forEach(item => {
            item.addEventListener('click', function() {
                const productId = parseInt(this.dataset.productId);
                const description = this.dataset.productDescription;
                const prices = JSON.parse(this.dataset.productPrices);
                const stock = parseInt(this.dataset.productStock);
                selectProduct(productId, description, prices, stock);
            });
        });
    }
    
    // Función para ocultar resultados
    function hideProductResults() {
        const resultsDiv = document.getElementById('searchProductResults');
        if (resultsDiv) {
            resultsDiv.classList.add('hidden');
        }
    }
    
    // Función para seleccionar un producto
    function selectProduct(productId, description, prices, stock) {
        const hiddenInput = document.getElementById('selectedProduct');
        if (hiddenInput) {
            hiddenInput.value = JSON.stringify({
                item_id: productId,
                description: description,
                prices: prices,
                stock: stock
            });
        }
        
        // Actualizar el input con el nombre del producto
        const searchInput = document.getElementById('searchProductInput');
        if (searchInput) {
            searchInput.value = description;
        }
        
        hideProductResults();
    }
    
    // Función para agregar el producto seleccionado
    function addSelectedProduct() {
        const hiddenInput = document.getElementById('selectedProduct');
        
        if (!hiddenInput || !hiddenInput.value) {
            Swal.fire({
                icon: 'warning',
                title: 'Seleccione un producto',
                text: 'Debe buscar y seleccionar un producto de la lista',
                confirmButtonColor: '#3b82f6'
            });
            return;
        }
        
        try {
            const productData = JSON.parse(hiddenInput.value);
            const stockQuantity = productData.stock || 0;
            
            // Verificar stock
            if (stockQuantity <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sin stock',
                    text: 'Este producto no tiene stock disponible',
                    confirmButtonColor: '#ef4444'
                });
                return;
            }
            
            // Verificar si ya existe en la lista
            const existingProduct = quotationItems.find(item => item.item_id === productData.item_id);
            if (existingProduct) {
                if (existingProduct.quantity + 1 > stockQuantity) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Stock insuficiente',
                        text: `Solo hay ${stockQuantity} unidades disponibles`,
                        confirmButtonColor: '#ef4444'
                    });
                    return;
                }
                existingProduct.quantity += 1;
            } else {
                // Agregar nuevo producto
                const firstPrice = productData.prices && productData.prices.length > 0 ? productData.prices[0] : null;
                
                if (!firstPrice) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Sin precio',
                        text: 'Este producto no tiene precios configurados',
                        confirmButtonColor: '#ef4444'
                    });
                    return;
                }
                
                const product = {
                    item_id: productData.item_id,
                    description: productData.description,
                    priceId: firstPrice.id,
                    unit_price: parseFloat(firstPrice.price),
                    prices: productData.prices,
                    quantity: 1,
                    maximum_stock: stockQuantity
                };
                
                const productCopy = { ...product };
                delete productCopy.prices;
                quotationItems.push(productCopy);
                
                addProductTo(product);
            }
            
            // Limpiar búsqueda
            document.getElementById('searchProductInput').value = '';
            document.getElementById('selectedProduct').value = '';
            hideProductResults();
            
            updateInformationCalculos();
            
            Swal.fire({
                icon: 'success',
                title: 'Producto agregado',
                timer: 1000,
                showConfirmButton: false
            });
            
        } catch (error) {
            console.error('Error al agregar producto:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al agregar el producto',
                confirmButtonColor: '#ef4444'
            });
        }
    }

    // Función para cargar datos del pedido
    async function cargarDatosPedido(id) {
        try {
            Swal.fire({
                title: 'Cargando pedido...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            const response = await fetch(`${baseUrl}/pedido/convertir/${id}`);
            const result = await response.json();

            if (result.success) {
                const datos = result.datos;

                // Cargar datos del cliente
                document.getElementById('dni_personal').value = datos.customer_dni || '';
                document.getElementById('nombres_apellidos').value = datos.customer_names_surnames || '';
                document.getElementById('direccion').value = datos.customer_address || '';

                // Cargar distrito si existe
                if (datos.districts_id && datos.districts_id !== 'todos') {
                    // Aquí necesitarías cargar la ubicación completa
                    document.getElementById('districts_id').value = datos.districts_id;
                }

                // Cargar mecánico si existe
                if (datos.mechanics_id) {
                    document.getElementById('mechanics_id').value = datos.mechanics_id;
                    // Obtener nombre del mecánico
                    fetch(`${baseUrl}/quotation/mecanicos-disponibles`)
                        .then(res => res.json())
                        .then(mecanicos => {
                            const mecanico = mecanicos.find(m => m.id == datos.mechanics_id);
                            if (mecanico) {
                                document.getElementById('datos_mecanico').value = `${mecanico.name} ${mecanico.apellidos}`;
                            }
                        });
                }

                // Cargar productos
                if (datos.products && datos.products.length > 0) {
                    for (const producto of datos.products) {
                        // Buscar el producto completo con sus precios
                        const productResponse = await fetch(`${baseUrl}/api/product?search=${encodeURIComponent(producto.description)}`);
                        const productData = await productResponse.json();
                        const productoCompleto = productData.find(p => p.id == producto.item_id);

                        if (productoCompleto) {
                            const productToAdd = {
                                item_id: producto.item_id,
                                description: producto.description,
                                priceId: producto.priceId,
                                unit_price: producto.unit_price,
                                prices: productoCompleto.prices || [],
                                quantity: producto.quantity,
                                maximum_stock: productoCompleto.stock?.quantity || 999
                            };

                            // Agregar a quotationItems sin prices
                            const productCopy = { ...productToAdd };
                            delete productCopy.prices;
                            quotationItems.push(productCopy);

                            // Agregar a la tabla
                            addProductTo(productToAdd);
                        }
                    }
                }

                // Cargar servicios
                if (datos.services && datos.services.length > 0) {
                    datos.services.forEach(servicio => {
                        const newService = {
                            id: Date.now() + Math.random(),
                            name: servicio.name,
                            price: servicio.price
                        };
                        services.push(newService);
                    });
                    updateTable();
                }

                // Actualizar cálculos
                updateInformationCalculos();

                Swal.fire({
                    icon: 'success',
                    title: 'Pedido cargado',
                    text: 'Los datos del pedido han sido cargados. Complete los datos de facturación.',
                    confirmButtonColor: '#10b981',
                    timer: 3000
                });

            } else {
                Swal.fire('Error', result.message || 'No se pudo cargar el pedido', 'error');
            }
        } catch (error) {
            console.error('Error al cargar pedido:', error);
            Swal.fire('Error', 'Ocurrió un error al cargar el pedido', 'error');
        }
    }

    // credito y contado
    document.getElementById("paymentType").addEventListener("change", function() {
        let selectedValue = this.value;
        let creditFields = document.getElementById("creditFields");
        let daysInput = document.getElementById("nro_dias");
        let dueDateInput = document.getElementById("fecha_vencimiento");
        let paymentFieldsContainer = document.getElementById("paymentFieldsContainer");
        let paymentMethodContainer1 = document.getElementById("paymentMethodContainer1");
        let paymentMethodContainer2 = document.getElementById("paymentMethodContainer2");
        if (selectedValue === "2") {
            // Si es crédito, mostrar campos de número de días y fecha de vencimiento
            creditFields.classList.remove("hidden");
            paymentFieldsContainer.classList.add("hidden"); // Ocultar método de pago
            paymentMethodContainer1.classList.add("hidden");
            paymentMethodContainer2.classList.add("hidden");
            // Calcular fecha de vencimiento al cambiar el número de días
            daysInput.addEventListener("input", function() {
                let days = parseInt(this.value, 10);
                if (!isNaN(days) && days > 0) {
                    let today = new Date();
                    today.setDate(today.getDate() + days);
                    dueDateInput.value = today.toISOString().split("T")[0]; // Formato YYYY-MM-DD
                } else {
                    dueDateInput.value = ""; // Vaciar si el valor no es válido
                }
            });
            const container = document.getElementById('paymentFieldsContainer');

            payments = [];

            container.style.display = 'none';
            document.getElementById("togglePaymentFields").checked = false;
            document.getElementById("paymentMethod2").value = "";
            document.getElementById("paymentAmount2").value = "";
            document.getElementById("paymentMethod1").value = "";
            document.getElementById("paymentAmount1").value = "";

        } else if (selectedValue === "1") {
            // Si es contado, mostrar el método de pago y ocultar crédito
            creditFields.classList.add("hidden");
            paymentMethodContainer1.classList.remove("hidden");
            paymentMethodContainer2.classList.remove("hidden");
            let togglePaymentFields = document.getElementById("togglePaymentFields").checked;
            if (togglePaymentFields) {
                paymentFieldsContainer.classList.remove("hidden");
                document.getElementById('paymentFieldsContainer').style.display = 'block';

            }
        } else {
            // Si no ha seleccionado nada, ocultar ambos
            creditFields.classList.add("hidden");
        }

        // Reiniciar valores si cambia de opción
        if (selectedValue !== "2") {
            daysInput.value = "";
            dueDateInput.value = "";
        }
    });
    
    //metodo de pago 
    document.getElementById('togglePaymentFields').addEventListener('change', function() {
        const container = document.getElementById('paymentFieldsContainer');
        container.style.display = this.checked ? 'block' : 'none';
    });

    // metodos de pago 
    function salePaymentMethods() {
        payments = [];
        let paymentMethod1 = document.getElementById('paymentMethod1').value;
        const totalAmountDiv = document.getElementById('totalAmount');
        let text = totalAmountDiv.textContent.trim();
        let paymentAmount1 = parseFloat(text.replace('S/', '').trim()) || 0;
        let paymentAmount2 = 0;
        if (document.getElementById('togglePaymentFields').checked) {
            let paymentMethod2 = document.getElementById('paymentMethod2').value;
            paymentAmount2 = parseFloat(document.getElementById('paymentAmount2').value) || 0;

            if (paymentMethod2 && paymentAmount2 > 0) {
                payments.push({
                    payment_method_id: paymentMethod2,
                    amount: paymentAmount2,
                    order: 2
                });
            }
        } else {
            document.getElementById('paymentMethod2').value = '';
            document.getElementById('paymentAmount2').value = '';
        }

        if (paymentMethod1) {
            payments.push({
                payment_method_id: paymentMethod1,
                amount: paymentAmount1 - paymentAmount2,
                order: 1
            });
        }
    }
    // Cargar mecánicos al iniciar
    function cargarMecanicos() {
        fetch("{{ route('mecanicosDisponibles') }}")
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('mecanico_select');
                select.innerHTML = '<option value="">Seleccionar mecánico</option>';
                
                data.forEach(mecanico => {
                    const option = document.createElement('option');
                    option.value = mecanico.id;
                    option.textContent = `${mecanico.name} ${mecanico.apellidos}`;
                    select.appendChild(option);
                });
            });
    }

    // Evento cuando cambia el select
    document.addEventListener('DOMContentLoaded', function() {
        cargarMecanicos();
        
        document.getElementById('mecanico_select').addEventListener('change', function() {
            document.getElementById('mechanics_id').value = this.value;
        });
    });

    // Funciones del modal
    function seleccionarMecanico(id, datos) {
        document.getElementById('mechanics_id').value = id;
        const select = document.getElementById('mecanico_select');
        select.value = id;
        cerrarModal();
    }

    function mostrarModal() {
        document.getElementById('modalMecanicos').classList.remove('hidden');
        fetch("{{ route('mecanicosDisponibles') }}")
            .then(response => response.json())
            .then(data => {
                let contenedor = document.getElementById('listaMecanicosModal');
                contenedor.innerHTML = '';

                data.forEach(mecanico => {
                    let row = `
                    <div class="flex justify-between items-center p-2 border-b">
                        <span>${mecanico.name} ${mecanico.apellidos}</span>
                        <button onclick="seleccionarMecanico(${mecanico.id}, '${mecanico.name} ${mecanico.apellidos}')" 
                            class="px-3 py-1 bg-blue-500 text-white rounded-lg" type="button">
                            Asignar
                        </button>
                    </div>
                `;
                    contenedor.innerHTML += row;
                });
            });
    }

    function cerrarModal() {
        document.getElementById('modalMecanicos').classList.add('hidden');
    }

    /// AGREGANDO SERVICIOS
    document.getElementById("addService").addEventListener("click", function() {
        let serviceName = document.getElementById("service").value.trim();
        let servicePrice = document.getElementById("service_price").value.trim();

        if (serviceName === "" || servicePrice === "") {
            Swal.fire({
                icon: 'warning',
                title: 'Campos incompletos',
                text: 'Por favor, complete todos los campos.',
                confirmButtonColor: '#3b82f6'
            });
            return;
        }

        let newService = {
            id: Date.now(), // Genera un ID único basado en el tiempo
            name: serviceName,
            price: servicePrice
        };

        services.push(newService); // Agregar al array
        updateTable(); // Refrescar la tabla
        updateInformationCalculos();

        // Limpiar inputs
        document.getElementById("service").value = "";
        document.getElementById("service_price").value = "";
    });
    // modal
    function openModal(modalId, callback) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove("hidden");
            if (callback) callback();
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add("hidden");
        }
    }




    function addProductTo(product) {
        const emptyRow = document.getElementById("emptyRow");
        if (emptyRow) {
            emptyRow.remove();
        }
        orderCount++;
        const orderRow = document.createElement("tr");
        orderRow.setAttribute("data-product-id", product.item_id);
        orderRow.innerHTML = `
            <td class="border p-2 text-center">${orderCount}</td>
            <td class="border p-2">${product.description}</td>
            <td class="border p-2">
                <input type="number" class="p-2 border rounded data-quantity-value-${product.item_id}" onchange="updatePriceAndTotal(${product.item_id})"
                       value="${product.quantity}" 
                       max="${product.maximum_stock}"
                       min="1"
                       style="width: 60px;">
            </td>
            <td class="border p-2">
                <select class="p-2 border rounded data-price-select-${product.item_id}" 
                        style="width: 120px;" onchange="updatePriceAndTotal(${product.item_id})">
                    <option value="">Seleccionar precio</option>
                    ${product.prices.map(precio => `
                        <option value="${precio.price}" 
                                data-price-id="${precio.id}" 
                                ${precio.id == product.priceId ? 'selected' : ''}>
                            ${precio.type} - ${precio.price}
                        </option>`).join('')}
                </select>
            </td>
            <td class="border p-2 data-price-value-${product.item_id}" style="text-align: right;">${product.unit_price}</td>
            <td class="border p-2 data-total-value-${product.item_id}" style="text-align: right;">${product.unit_price * product.quantity}</td>
            <td class="border p-2 text-center">
                <button class="bg-red-500 text-white px-2 py-1 rounded eliminar-btn" 
                       onclick="deleteProduct(${product.item_id})">
                    Eliminar
                </button>
            </td>
        `;
        orderTableBody.appendChild(orderRow);
    }
    // calcular subtotal igv y total
    function updateInformationCalculos() {
        let totalAmount = 0;
        let igvAmount = 0;
        let subtotalAmount = 0;
        quotationItems.forEach(item => {
            totalAmount += item.quantity * item.unit_price;
        })
        services.forEach(item => {
            totalAmount += parseFloat(item.price);
        })
        igvAmount = totalAmount * 0.18;
        subtotalAmount = totalAmount - igvAmount;
        document.getElementById("subtotalAmount").textContent = "S/ " + subtotalAmount.toFixed(2);
        document.getElementById("igvAmount").textContent = "S/ " + igvAmount.toFixed(2);
        document.getElementById("totalAmount").textContent = "S/ " + totalAmount.toFixed(2);
    }




    function updatePriceAndTotal(productId) {
        const quantityInput = document.querySelector(`.data-quantity-value-${productId}`);
        const priceSelect = document.querySelector(`.data-price-select-${productId}`);
        const priceValueCell = document.querySelector(`.data-price-value-${productId}`);
        const totalValueCell = document.querySelector(`.data-total-value-${productId}`);
        const quantity = parseFloat(quantityInput.value) || 0;
        const selectedOption = priceSelect.options[priceSelect.selectedIndex];
        const price = parseFloat(selectedOption.value) || 0;
        // precio y total en la tabla
        priceValueCell.textContent = price.toFixed(2);
        totalValueCell.textContent = (price * quantity).toFixed(2);

        quotationItems.forEach(item => {
            if (item.item_id == productId) {
                item.quantity = quantity;
                item.unit_price = price;
                item.priceId = parseFloat(selectedOption.dataset.priceId);
            }
        })
        updateInformationCalculos();

    }
    // eliminar producto
    function deleteProduct(productId) {
        quotationItems = quotationItems.filter(product => product.item_id != productId);
        const row = document.querySelector(`tr[data-product-id="${productId}"]`);
        if (row) {
            row.remove();
        }
        updateInformationCalculos();
    }


    // // 🔹 Función para construir el objeto de orden
    function buildOrderData() {
        return {
            ...getCustomerData(),
            products: quotationItems,
            services: services
        };
    }
    // // Extraer los datos del cliente
    function getCustomerData() {
        return {
            customer_dni: document.getElementById("dni_personal").value.trim(),
            customer_names_surnames: document.getElementById("nombres_apellidos").value.trim(),
            customer_address: document.getElementById("direccion").value.trim(),
            motorcycle_model: document.getElementById("motorcycle_model").value.trim(),
            phone: document.getElementById("phone").value.trim(),
            districts_id: document.getElementById("districts_id")?.value || 'todos',
            mechanics_id: document.getElementById("mechanics_id").value,
            payments_id: document.getElementById("paymentType").value,
            order_date: document.getElementById("orderDate").value,
            currency: document.getElementById("orderCurrency").value,
            document_type_id: document.getElementById("documentType").value,
            nro_dias: document.getElementById("nro_dias").value,
            fecha_vencimiento: document.getElementById("fecha_vencimiento").value,
            igv: parseAmount("igvAmount"),
            total: parseAmount("totalAmount")
        };
    }
    // // Convierte valores monetarios a números
    function parseAmount(elementId) {
        return parseFloat(document.getElementById(elementId).textContent.replace("S/ ", "")) || 0;
    }
    // Función para limpiar el formulario y preparar para nueva venta
    function resetFormFields() {
        // Limpiar modelo de moto y teléfono
        document.getElementById('motorcycle_model').value = '';
        document.getElementById('phone').value = '';
        
        // Limpiar datos del cliente
        document.getElementById('dni_personal').value = '';
        document.getElementById('nombres_apellidos').value = '';
        document.getElementById('direccion').value = '';
        
        // Limpiar mecánico si existe
        const mecanicoSelect = document.getElementById('mecanico_select');
        const mechanicsId = document.getElementById('mechanics_id');
        if (mecanicoSelect) mecanicoSelect.value = '';
        if (mechanicsId) mechanicsId.value = '';
        
        // Limpiar servicio
        const serviceInput = document.getElementById('service');
        const servicePriceInput = document.getElementById('service_price');
        if (serviceInput) serviceInput.value = 'TALLER';
        if (servicePriceInput) servicePriceInput.value = '60';
        
        // Limpiar documento
        document.getElementById('paymentType').value = '';
        document.getElementById('paymentMethod1').value = '';
        document.getElementById('documentType').value = '';
        document.getElementById('orderDate').value = '{{ date('Y-m-d') }}';
        
        // Ocultar campos de crédito
        document.getElementById('creditFields').classList.add('hidden');
        document.getElementById('nro_dias').value = '';
        document.getElementById('fecha_vencimiento').value = '';
        
        // Limpiar método de pago adicional
        document.getElementById('togglePaymentFields').checked = false;
        document.getElementById('paymentFieldsContainer').classList.add('hidden');
        document.getElementById('paymentMethod2').value = '';
        document.getElementById('paymentAmount2').value = '';
        
        // Limpiar productos y servicios
        quotationItems = [];
        services = [];
        payments = [];
        orderCount = 0;
        
        // Limpiar tabla de productos
        const orderTableBody = document.getElementById('orderTableBody');
        orderTableBody.innerHTML = '<tr id="emptyRow"><td class="border p-2 text-center" colspan="7">No hay productos agregados</td></tr>';
        
        // Limpiar tabla de servicios
        document.getElementById('serviceList').innerHTML = '';
        
        // Limpiar buscador de productos
        document.getElementById('searchProductInput').value = '';
        document.getElementById('selectedProduct').value = '';
        const searchResults = document.getElementById('searchProductResults');
        if (searchResults) searchResults.classList.add('hidden');
        
        // Resetear totales
        updateInformationCalculos();
        
        // Mostrar mensaje de confirmación
        Swal.fire({
            icon: 'info',
            title: 'Listo para nueva venta',
            text: 'El formulario ha sido limpiado',
            timer: 1500,
            showConfirmButton: false
        });
    }
    
    // guardar cotizacion
    async function saveSales() {
        try {
            const orderData = buildOrderData();

            // Validaciones antes de enviar
            if (!orderData.document_type_id) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campo requerido',
                    text: 'Seleccione un tipo de documento',
                    confirmButtonColor: '#3b82f6'
                });
                return;
            }



            if (!orderData.payments_id) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campo requerido',
                    text: 'Seleccione un tipo de pago',
                    confirmButtonColor: '#3b82f6'
                });
                return;
            }

            if (quotationItems.length === 0 && services.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sin productos',
                    text: 'Agregue al menos un producto o servicio',
                    confirmButtonColor: '#3b82f6'
                });
                return;
            }

            // UBICACIÓN - OPCIONAL (comentado porque ahora permite NULL)
            // if (!orderData.districts_id || orderData.districts_id === 'todos') {
            //     Swal.fire({
            //         icon: 'warning',
            //         title: 'Campo requerido',
            //         text: 'Seleccione departamento, provincia y distrito',
            //         confirmButtonColor: '#3b82f6'
            //     });
            //     return;
            // }

            // Validar método de pago si es contado
            if (orderData.payments_id === '1') {
                const paymentMethod1 = document.getElementById('paymentMethod1').value;
                if (!paymentMethod1) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Campo requerido',
                        text: 'Seleccione un método de pago',
                        confirmButtonColor: '#3b82f6'
                    });
                    return;
                }
            }

            salePaymentMethods()

            const response = await fetch('{{ route('sales.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    ...orderData,
                    payments,
                    pedido_id: pedidoId // Incluir el ID del pedido si existe
                })
            });

            const data = await response.json();

            if (!response.ok || data.error) {
                throw new Error(data.error || "Error en la petición");
            }

            // Si viene de un pedido, marcarlo como convertido
            if (pedidoId && data.sale_id) {
                try {
                    await fetch(`${baseUrl}/pedido/marcar-convertido`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            pedido_id: pedidoId,
                            sale_id: data.sale_id
                        })
                    });
                } catch (e) {
                    console.error('Error al marcar pedido como convertido:', e);
                }
            }

            Swal.fire({
                icon: 'success',
                title: '¡Venta guardada!',
                text: pedidoId ? 'La venta se ha creado y el pedido ha sido convertido.' : 'Venta guardada exitosamente',
                confirmButtonColor: '#10b981',
                showCancelButton: true,
                confirmButtonText: 'Ir al índice',
                cancelButtonText: 'Nueva venta'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirigir al índice de ventas
                    window.location.href = `${baseUrl}/sales`;
                } else {
                    // Limpiar los campos para nueva venta
                    resetFormFields();
                }
            });
        } catch (error) {
            console.error("Error al guardar la orden:", error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Error al guardar la orden.',
                confirmButtonColor: '#ef4444'
            });
        }
    }




    // Función para actualizar la tabla
    function updateTable() {
        let tableBody = document.getElementById("serviceList");
        tableBody.innerHTML = ""; // Limpiar tabla antes de actualizar

        services.forEach(service => {
            let row = document.createElement("tr");
            row.innerHTML = `
                    <td class="border border-gray-300 px-4 py-2">${service.name}</td>
                    <td class="border border-gray-300 px-4 py-2">${service.price}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <button class="bg-red-500 text-white px-2 py-1 rounded-md" onclick="deleteService(${service.id})">Eliminar</button>
                    </td>
                `;
            tableBody.appendChild(row);
        });
    }

    // Función para eliminar un servicio
    function deleteService(id) {
        services = services.filter(service => service.id !== id); // Elimina del array
        updateTable(); // Refrescar la tabla
        updateInformationCalculos();
    }
    // BUSQUEDA DE SERVICIOS
    document.getElementById("service").addEventListener("input", function() {
        const inputValue = this.value.trim();
        const suggestionsList = document.getElementById("serviceSuggestions");
        const dropdown = document.getElementById("serviceDropdown");

        if (inputValue === "") {
            suggestionsList.innerHTML = "";
            dropdown.classList.add("hidden");
            return;
        }

        fetch(`${baseUrl}/api/services?query=${inputValue}`)
            .then(response => response.json())
            .then(data => {
                suggestionsList.innerHTML = "";

                if (data.length > 0) {
                    data.forEach(service => {
                        const item = document.createElement("li");
                        item.textContent = `${service.name} - S/. ${service.default_price}`;
                        item.classList.add("cursor-pointer", "p-2", "hover:bg-gray-100");

                        item.addEventListener("click", function() {
                            document.getElementById("service").value = service.name;
                            document.getElementById("service_price").value = service
                                .default_price;
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
    // api dni
    const inputDni = document.getElementById('dni_personal');
    const token =
        'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InN5c3RlbWNyYWZ0LnBlQGdtYWlsLmNvbSJ9.yuNS5hRaC0hCwymX_PjXRoSZJWLNNBeOdlLRSUGlHGA';
    // Función para buscar DNI
    function buscarDNI(dni) {
        if (dni.length === 8) {
            fetch(`https://dniruc.apisperu.com/api/v1/dni/${dni}?token=${token}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la solicitud');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data);
                    document.getElementById('nombres_apellidos').value = data.apellidoPaterno + ' ' +
                        data.apellidoMaterno + ' ' + data.nombres;
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'DNI no encontrado',
                        text: 'No se pudo encontrar el DNI en la base de datos.',
                        confirmButtonColor: '#ef4444'
                    });
                });
        }
    }

    // Evento cuando el usuario escribe en el campo DNI
    inputDni.addEventListener('input', () => {
        buscarDNI(inputDni.value);
    });
</script>
