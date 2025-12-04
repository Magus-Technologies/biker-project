<x-app-layout>
    <!-- Breadcrumb -->
    <x-breadcrumb
        title="Registrar Ventas Mayoristas"
        parent="Ventas"
        parentUrl="{{ route('sales.index') }}"
        subtitle="Ventas Mayoristas"
    />

    <div class="px-3 py-4">
        <!-- Header con botones de acción -->
        <div class="bg-white rounded-lg px-4 py-3 mb-3 flex flex-wrap justify-between items-center gap-3">
            <h2 class="text-lg font-semibold text-gray-700">
                <i class="bi bi-cart-plus mr-2 text-blue-600"></i>
                Ventas Mayoristas - Registro Múltiple
            </h2>
            <div class="flex gap-2">
                <button onclick="addNewSaleTab()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors text-sm">
                    <i class="bi bi-plus-lg mr-1"></i>
                    Nueva Venta
                </button>
                <button onclick="saveAllSales()" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition-colors text-sm">
                    <i class="bi bi-save mr-1"></i>
                    Guardar Todas (<span id="salesCount">0</span>)
                </button>
                <a href="{{ route('sales.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition-colors text-sm">
                    <i class="bi bi-x-lg mr-1"></i>
                    Cancelar
                </a>
            </div>
        </div>

        <!-- Info -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-3 rounded mb-3 text-sm">
            <p class="text-blue-800">
                <i class="bi bi-info-circle mr-1"></i>
                <strong>Instrucciones:</strong> Haz clic en "Nueva Venta" para agregar más ventas. Cada pestaña es una venta independiente. Puedes guardar cada venta individualmente con el botón "Guardar Esta Venta" o guardar todas a la vez con "Guardar Todas".
            </p>
        </div>

        <!-- Tabs de ventas -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <!-- Tab Headers -->
            <div class="flex items-center gap-1 px-2 py-2 bg-gray-50 border-b border-gray-200 overflow-x-auto" id="tabHeaders" style="min-height: 50px;">
                <!-- Los tabs se agregarán dinámicamente aquí -->
            </div>

            <!-- Tab Contents -->
            <div id="tabContents">
                <!-- Los contenidos de los tabs se agregarán dinámicamente aquí -->
            </div>
        </div>
    </div>

    <style>
    .tab-header {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
        font-size: 0.875rem;
        font-weight: 500;
        min-width: fit-content;
    }
    .tab-header:not(.active) {
        background-color: white;
        color: #6b7280;
        border: 1px solid #e5e7eb;
    }
    .tab-header:not(.active):hover {
        background-color: #f3f4f6;
        border-color: #3b82f6;
    }
    .tab-header.active {
        background-color: #3b82f6;
        color: white;
        border: 1px solid #3b82f6;
        box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
    }
    .tab-content {
        display: none;
        padding: 1rem;
    }
    .tab-content.active {
        display: block;
    }
    .close-tab {
        margin-left: 0.5rem;
        padding: 0.125rem 0.375rem;
        border-radius: 0.25rem;
        transition: background-color 0.2s;
        font-size: 0.75rem;
    }
    .close-tab:hover {
        background-color: rgba(0, 0, 0, 0.2);
    }
    </style>

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
        
        <div class="p-6 space-y-4" id="panelDocumentoContent">
            <!-- El contenido se cargará dinámicamente -->
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

    <!-- ✅ Template HTML para formulario de documento (mejor práctica) -->
    <template id="documento-form-template">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-bold mb-4">Documento</h2>
            
            <div>
                <label class="font-bold">Tipo pago <span class="text-red-500">*</span></label>
                <select data-id="paymentType" class="w-full p-2 border rounded">
                    <option value="">Seleccione</option>
                    @foreach ($paymentsType as $payment)
                        <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div data-id="creditFields" class="mt-3 hidden">
                <label>Número de días:</label>
                <input type="number" data-id="nro_dias" class="w-full p-2 border rounded" min="1">
                <label class="mt-2">Fecha de vencimiento:</label>
                <input type="date" data-id="fecha_vencimiento" class="w-full p-2 border rounded">
            </div>
            
            <div class="mt-3" data-id="paymentMethodContainer1">
                <label class="font-bold">Método pago <span class="text-red-500">*</span></label>
                <select data-id="paymentMethod1" class="w-full p-2 border rounded">
                    <option value="">Seleccione</option>
                    @foreach ($paymentsMethod as $payment)
                        <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mt-2" data-id="paymentMethodContainer2">
                <input type="checkbox" data-id="togglePaymentFields" class="mr-2">
                <label>Agregar método de pago y monto</label>
            </div>
            
            <div data-id="paymentFieldsContainer" class="mt-2 hidden">
                <div>
                    <label class="font-bold">Método de pago</label>
                    <select data-id="paymentMethod2" class="w-full p-2 border rounded">
                        <option value="">Seleccione</option>
                        @foreach ($paymentsMethod as $payment)
                            <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-2">
                    <label class="font-bold">Monto a pagar</label>
                    <input type="number" data-id="paymentAmount2" class="w-full p-2 border rounded" placeholder="Ingrese el monto">
                </div>
            </div>
            
            <div class="mt-3">
                <label class="font-bold">Tipo de documento <span class="text-red-500">*</span></label>
                <select data-id="documentType" class="w-full p-2 border rounded">
                    <option value="">Seleccione</option>
                    @foreach ($documentTypes as $documentType)
                        <option value="{{ $documentType->id }}">{{ $documentType->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Fecha comentada - ahora aparece arriba al lado de N. Vendedor -->
            <!--
            <div class="mt-3">
                <label class="font-bold">Fecha</label>
                <input type="date" data-id="orderDate" value="{{ date('Y-m-d') }}" class="w-full p-2 border rounded">
            </div>
            -->
            
            <div class="mt-3 mb-4">
                <label class="font-bold">Moneda</label>
                <input type="text" data-id="orderCurrency" value="SOLES" class="w-full p-2 border rounded" readonly>
            </div>
            
            <!-- Totales comentados - ya aparecen debajo de la tabla de productos -->
            <!--
            <div class="space-y-2">
                <div class="bg-gray-200 text-gray-800 p-2 rounded text-center text-sm font-bold">
                    Subtotal: <span data-id="subtotalAmount">S/ 0.00</span>
                </div>
                <div class="bg-gray-200 text-gray-800 p-2 rounded text-center text-sm font-bold">
                    IGV (18%): <span data-id="igvAmount">S/ 0.00</span>
                </div>
                <div class="bg-indigo-500 text-white p-2 rounded text-center text-sm font-bold" data-id="totalAmount">
                    S/ 0.00
                </div>
            </div>
            -->
        </div>
    </template>

    <script>
    // Variables globales
    let saleCounter = 0;
    let salesData = new Map(); // Almacena datos de cada venta por tabId
    const token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InN5c3RlbWNyYWZ0LnBlQGdtYWlsLmNvbSJ9.yuNS5hRaC0hCwymX_PjXRoSZJWLNNBeOdlLRSUGlHGA';
    
    // Datos del servidor
    const tiendasData = @json($tiendas);
    const regionsData = @json($regions);
    const userRole = '{{ auth()->user()->getRoleNames()->first() }}';
    const userTienda = '{{ auth()->user()->tienda->nombre ?? "Sin tienda asignada" }}';

    // Variables para el panel de documento
    let currentTabIdDocumento = null;

    // Abrir panel lateral de documento
    function abrirPanelDocumento(tabId) {
        currentTabIdDocumento = tabId;
        const data = salesData.get(tabId);
        
        // Cargar el contenido del formulario en el panel
        const template = document.getElementById('documento-form-template');
        const clone = template.content.cloneNode(true);
        
        // Reemplazar todos los data-id con IDs únicos
        clone.querySelectorAll('[data-id]').forEach(element => {
            const fieldName = element.getAttribute('data-id');
            element.id = `${fieldName}_${tabId}`;
            element.removeAttribute('data-id');
        });
        
        // Insertar en el panel
        const panelContent = document.getElementById('panelDocumentoContent');
        panelContent.innerHTML = '';
        panelContent.appendChild(clone);
        
        // Cargar valores guardados si existen
        if (data && data.documento) {
            setTimeout(() => {
                try {
                    if (data.documento.paymentType) {
                        const paymentTypeEl = document.getElementById(`paymentType_${tabId}`);
                        if (paymentTypeEl) paymentTypeEl.value = data.documento.paymentType;
                    }
                    if (data.documento.paymentMethod1) {
                        const paymentMethod1El = document.getElementById(`paymentMethod1_${tabId}`);
                        if (paymentMethod1El) paymentMethod1El.value = data.documento.paymentMethod1;
                    }
                    if (data.documento.documentType) {
                        const documentTypeEl = document.getElementById(`documentType_${tabId}`);
                        if (documentTypeEl) documentTypeEl.value = data.documento.documentType;
                    }
                } catch (error) {
                    console.error('Error cargando valores del documento:', error);
                }
            }, 100);
        }
        
        // Mostrar panel y overlay
        document.getElementById('panelDocumento').classList.remove('translate-x-full');
        document.getElementById('overlayDocumento').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    // Cerrar panel lateral
    function cerrarPanelDocumento() {
        document.getElementById('panelDocumento').classList.add('translate-x-full');
        document.getElementById('overlayDocumento').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Aplicar configuración de documento
    function aplicarDocumento() {
        if (!currentTabIdDocumento) return;
        
        const tabId = currentTabIdDocumento;
        const data = salesData.get(tabId);
        
        // Obtener valores seleccionados
        const tipoDocSelect = document.getElementById(`documentType_${tabId}`);
        const tipoPagoSelect = document.getElementById(`paymentType_${tabId}`);
        const metodoPagoSelect = document.getElementById(`paymentMethod1_${tabId}`);
        
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
        
        // Guardar valores en salesData para mantenerlos
        if (!data.documento) {
            data.documento = {};
        }
        data.documento.paymentType = tipoPagoSelect?.value;
        data.documento.paymentMethod1 = metodoPagoSelect?.value;
        data.documento.documentType = tipoDocSelect?.value;
        data.documento.tipoDocText = tipoDoc;
        data.documento.tipoPagoText = tipoPago;
        data.documento.metodoPagoText = metodoPago;
        
        // Actualizar resumen
        document.getElementById(`resumenTipoDoc_${tabId}`).textContent = tipoDoc;
        document.getElementById(`resumenTipoPago_${tabId}`).textContent = tipoPago;
        document.getElementById(`resumenMetodoPago_${tabId}`).textContent = metodoPago;
        document.getElementById(`documentoResumen_${tabId}`).classList.remove('hidden');
        
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

    // Inicializar con una venta
    document.addEventListener('DOMContentLoaded', function() {
        addNewSaleTab();
    });

    // Función para agregar nueva pestaña de venta
    function addNewSaleTab() {
        saleCounter++;
        const tabId = `sale-${saleCounter}`;

        // Crear tab header
        const tabHeader = document.createElement('div');
        tabHeader.className = 'tab-header';
        tabHeader.id = `tab-${tabId}`;
        tabHeader.innerHTML = `
            <i class="bi bi-cart"></i>
            <span>Venta #${saleCounter}</span>
            ${saleCounter > 1 ? `<button onclick="closeTab('${tabId}', event)" class="close-tab" title="Cerrar"><i class="bi bi-x-lg"></i></button>` : ''}
        `;
        tabHeader.onclick = (e) => {
            if (!e.target.closest('.close-tab')) {
                switchTab(tabId);
            }
        };

        document.getElementById('tabHeaders').appendChild(tabHeader);

        // Crear tab content con el componente
        const tabContent = document.createElement('div');
        tabContent.className = 'tab-content';
        tabContent.id = `content-${tabId}`;

        document.getElementById('tabContents').appendChild(tabContent);

        // Cargar el contenido del formulario via AJAX
        fetch(`{{ route('sales.create') }}`)
            .then(response => response.text())
            .then(html => {
                // Crear el HTML del formulario directamente
                tabContent.innerHTML = createSaleFormHTML(tabId);

                // Inicializar datos y eventos para este tab
                initializeSaleTab(tabId);
            });

        // Inicializar datos de la venta
        salesData.set(tabId, {
            saleNumber: saleCounter,
            services: [],
            quotationItems: [],
            products: [],
            payments: [],
            orderCount: 0
        });

        // Activar el nuevo tab
        switchTab(tabId);
        updateSalesCount();
    }

    // Crear HTML del formulario
    function createSaleFormHTML(tabId) {
        return `
        <div class="container mx-auto p-2 text-sm" id="sale-form-${tabId}">
            <!-- Información de Tienda, Vendedor y Cliente en un solo card -->
            <div class="bg-white p-4 rounded-lg shadow mb-4">
                <!-- Fecha y Hora (arriba a la derecha) -->
                <div class="flex justify-end mb-3">
                    <input type="text" id="fechaHora_${tabId}" value="" 
                        class="p-2 border border-gray-300 rounded-md shadow-sm text-sm bg-gray-50 text-right" 
                        readonly style="width: 200px;">
                </div>
                
                <!-- Primera fila: NOMBRE DE TIENDA y N. VENDEDOR -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <!-- NOMBRE DE TIENDA -->
                    <div>
                        <label class="text-xs text-gray-500 uppercase font-semibold block mb-1">Nombre de Tienda</label>
                        <select id="tienda_select_${tabId}" class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="todos">Todas las tiendas</option>
                            ${tiendasData.map(tienda => `<option value="${tienda.id}">${tienda.nombre}</option>`).join('')}
                        </select>
                    </div>
                    
                    <!-- N. VENDEDOR -->
                    <div>
                        <label class="text-xs text-gray-500 uppercase font-semibold block mb-1">N. Vendedor</label>
                        <input type="text" id="vendedor_${tabId}" value="" 
                            placeholder="Ingrese nombre del vendedor"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm">
                    </div>
                </div>
                
                <!-- Segunda fila: NÚMERO DE TELÉFONO, DEPARTAMENTO, PROVINCIA, DISTRITO -->
                <div class="grid grid-cols-4 gap-4 mb-4">
                    <!-- NÚMERO DE TELÉFONO -->
                    <div>
                        <label class="text-xs text-gray-500 uppercase font-semibold block mb-1">Número de Teléfono</label>
                        <input type="tel" id="phone_${tabId}" placeholder="Ej: 999 999 999"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm" maxlength="9">
                    </div>
                    
                    <!-- DEPARTAMENTO -->
                    <div>
                        <label class="text-xs text-gray-500 uppercase font-semibold block mb-1">Departamento</label>
                        <select id="departamento_${tabId}" class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">Seleccione</option>
                            ${regionsData.map(region => `<option value="${region.id}">${region.name}</option>`).join('')}
                        </select>
                    </div>
                    
                    <!-- PROVINCIA -->
                    <div>
                        <label class="text-xs text-gray-500 uppercase font-semibold block mb-1">Provincia</label>
                        <select id="provincia_${tabId}" class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm" disabled>
                            <option value="">Seleccione</option>
                        </select>
                    </div>
                    
                    <!-- DISTRITO -->
                    <div>
                        <label class="text-xs text-gray-500 uppercase font-semibold block mb-1">Distrito</label>
                        <select id="distrito_${tabId}" class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm" disabled>
                            <option value="">Seleccione</option>
                        </select>
                    </div>
                </div>

                <!-- Tercera fila: DOCUMENTO y CLIENTE -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="text-xs text-gray-500 uppercase font-semibold block mb-1">Documento</label>
                        <input type="text" id="dni_personal_${tabId}" placeholder="Ingrese Documento"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 uppercase font-semibold block mb-1">Cliente</label>
                        <input type="text" placeholder="Nombre del cliente" id="nombres_apellidos_${tabId}"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm">
                    </div>
                </div>
                
                <!-- Cuarta fila: BUSCADOR DE PRODUCTOS -->
                <div class="relative">
                    <label class="text-xs text-gray-500 uppercase font-semibold block mb-1">Buscar Producto</label>
                    <div class="flex gap-2">
                        <div class="flex-1 relative">
                            <input type="text" id="searchProductInput_${tabId}" 
                                placeholder="Escriba para buscar productos..."
                                autocomplete="off"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500">
                            <!-- Dropdown de resultados -->
                            <div id="searchProductResults_${tabId}" 
                                class="hidden absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-96 overflow-y-auto">
                                <!-- Los resultados se cargarán aquí -->
                            </div>
                        </div>
                        <button type="button" onclick="addSelectedProduct('${tabId}')" 
                            class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition text-sm whitespace-nowrap">
                            <i class="bi bi-plus-circle mr-1"></i>Agregar
                        </button>
                    </div>
                    <!-- Campo oculto para guardar el producto seleccionado -->
                    <input type="hidden" id="selectedProduct_${tabId}" value="">
                </div>
            </div>

            {{-- Campos ocultos para mantener compatibilidad --}}
            <input type="hidden" id="direccion_${tabId}" value="">
            <input type="hidden" id="regions_id_${tabId}" value="todos">
            <input type="hidden" id="provinces_id_${tabId}" value="todos">
            <input type="hidden" id="districts_id_${tabId}" value="todos">

            <div class="grid grid-cols-1 gap-6">

                    <!-- Grid de 2 columnas para servicio y precio (comentado) -->
                   <!-- <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="relative">
                            <label for="service_${tabId}" class="block text-sm font-medium text-gray-700 mb-1">Servicio</label>
                            <input type="text" id="service_${tabId}" name="service" value="TALLER"
                                class="block w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm" autocomplete="off">
                            <div id="serviceDropdown_${tabId}"
                                class="absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-lg hidden">
                                <ul id="serviceSuggestions_${tabId}" class="max-h-40 overflow-y-auto"></ul>
                            </div>
                        </div>
                        <div>
                            <label for="service_price_${tabId}" class="block text-sm font-medium text-gray-700 mb-1">Precio del Servicio</label>
                            <input type="number" id="service_price_${tabId}" name="service_price" value="60"
                                class="block w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm">
                        </div>
                    </div> -->
                    
                    <!-- Grid de 2 columnas para botones -->
                    <!-- <div class="grid grid-cols-2 gap-4 mb-4">
                        <button class="bg-yellow-400 hover:bg-yellow-500 p-2 rounded transition font-medium text-sm" id="buscarProductos_${tabId}">
                            <i class="bi bi-search mr-1"></i>Consultar Productos
                        </button>
                        <button type="button" id="addService_${tabId}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition text-sm">
                            <i class="bi bi-plus-circle mr-1"></i>Agregar Servicio
                        </button>
                    </div> -->

                    <!-- Selector de Mecánico -->
                  <!--  <div class="mt-4">
                        <label for="mecanico_select_${tabId}" class="block text-sm font-medium text-gray-700 mb-1">Mecánico</label>
                        <div class="flex gap-2">
                            <select id="mecanico_select_${tabId}" class="flex-1 p-2 border border-gray-300 rounded-md shadow-sm text-sm">
                                <option value="">Seleccionar mecánico</option>
                            </select>
                            <button onclick="mostrarModalMecanicos('${tabId}')" type="button" 
                                class="px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md transition text-sm"
                                title="Buscar mecánico">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        <input name="mechanics_id" id="mechanics_id_${tabId}" type="hidden">
                    </div> -->

                    <!-- Modal Mecánicos -->
                    <div id="modalMecanicos_${tabId}" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center z-50">
                        <div class="bg-white p-6 rounded-lg shadow-md w-1/3">
                            <h3 class="text-xl font-semibold mb-4">Mecánicos Disponibles</h3>
                            <div id="listaMecanicosModal_${tabId}"></div>
                            <button onclick="closeModalTab('modalMecanicos_${tabId}')" class="mt-4 px-4 py-2 bg-red-500 text-white rounded-lg">Cerrar</button>
                        </div>
                    </div>

                    <!-- Modal Productos -->
                    <div id="buscarProductosModal_${tabId}" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 p-4 hidden z-50">
                        <div class="bg-white p-6 rounded-lg shadow-lg max-w-4xl w-full">
                            <h3 class="text-lg font-bold mb-4">Productos</h3>
                            <div class="mb-4 flex items-center">
                                <div class="w-8/12">
                                    <input type="text" placeholder="Buscar por nombre del producto..."
                                        class="w-full p-2 border rounded" id="searchProduct_${tabId}">
                                </div>
                                <div>
                                    <button class="bg-blue-500 text-white px-4 py-2 rounded-md rounded-l-none mr-5"
                                        id="btnBuscarProduct_${tabId}">Buscar</button>
                                </div>
                                <div class="w-3/12">
                                    <label for="tienda_id_${tabId}" class="block font-medium text-gray-700">Tienda</label>
                                    <select id="tienda_id_${tabId}" name="tienda_id"
                                        class="block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                                        <option value="todos">Todas</option>
                                        ${tiendasData.map(tienda => `<option value="${tienda.id}">${tienda.nombre}</option>`).join('')}
                                    </select>
                                </div>
                            </div>
                            <div class="overflow-x-auto overflow-y-auto h-80">
                                <table class="min-w-full table-auto text-xs">
                                    <thead class="bg-gray-200 sticky top-0">
                                        <tr>
                                            <th class="px-2 py-1 border">Código</th>
                                            <th class="px-2 py-1 border">Descripción</th>
                                            <th class="px-2 py-1 border">Ubicación</th>
                                            <th class="px-2 py-1 border">Stock Actual</th>
                                            <th class="px-2 py-1 border">Stock Mínimo</th>
                                            <th class="px-2 py-1 border">Cantidad</th>
                                            <th class="px-2 py-1 border">Seleccionar Precio</th>
                                            <th class="px-2 py-1 border">Subtotal</th>
                                            <th class="px-2 py-1 border">Agregar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productTable_${tabId}"></tbody>
                                </table>
                            </div>
                            <button class="mt-4 bg-red-500 text-white px-4 py-2 rounded"
                                onclick="closeModalTab('buscarProductosModal_${tabId}')">Cerrar</button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Tabla de Productos -->
            <div class="mt-6 bg-white p-6 rounded-lg shadow">
                <table class="w-full border-collapse border border-gray-300 no-search-button" id="orderTable_${tabId}">
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
                    <tbody id="orderTableBody_${tabId}">
                    </tbody>
                </table>
            </div>

            <!-- Botón Configurar Documento y Totales -->
            <div class="mt-4 bg-white p-4 rounded-lg shadow">
                <div class="flex flex-col items-end">
                    <!-- Botón pequeño alineado a la derecha -->
                    <button onclick="abrirPanelDocumento('${tabId}')" type="button" 
                        class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition text-sm mb-3 w-auto">
                        <i class="bi bi-file-earmark-text mr-1"></i>Configurar Documento de Venta
                    </button>
                    
                    <!-- Resumen de documento seleccionado -->
                    <div id="documentoResumen_${tabId}" class="mb-3 p-3 bg-gray-50 rounded-lg hidden w-auto">
                        <h3 class="font-semibold text-gray-700 mb-2 flex items-center gap-2 text-sm">
                            <i class="bi bi-check-circle-fill text-green-500"></i>
                            Documento Configurado
                        </h3>
                        <div class="text-xs text-gray-600 space-y-1">
                            <p><strong>Tipo:</strong> <span id="resumenTipoDoc_${tabId}">-</span></p>
                            <p><strong>Pago:</strong> <span id="resumenTipoPago_${tabId}">-</span></p>
                            <p><strong>Método:</strong> <span id="resumenMetodoPago_${tabId}">-</span></p>
                        </div>
                    </div>
                    
                    <!-- Totales con el mismo ancho que el botón -->
                    <div class="space-y-2 w-auto">
                        <div class="bg-gray-200 text-gray-800 p-2 rounded text-center text-sm font-bold whitespace-nowrap">
                            Subtotal: <span id="subtotalAmount_${tabId}">S/ 0.00</span>
                        </div>
                        <div class="bg-gray-200 text-gray-800 p-2 rounded text-center text-sm font-bold whitespace-nowrap">
                            IGV (18%): <span id="igvAmount_${tabId}">S/ 0.00</span>
                        </div>
                        <div class="bg-indigo-500 text-white p-2 rounded text-center text-sm font-bold whitespace-nowrap" id="totalAmount_${tabId}">
                            S/ 0.00
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Servicios (comentada) -->
            <!--
            <div class="mt-5">
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-300 px-4 py-2">Servicio</th>
                            <th class="border border-gray-300 px-4 py-2">Precio</th>
                            <th class="border border-gray-300 px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="serviceList_${tabId}"></tbody>
                </table>
            </div>
            -->

            <!-- Botones para guardar venta y registrar despacho -->
            <div class="mt-6 flex justify-center gap-3 pt-4 border-t">
                <button onclick="registrarDespacho('${tabId}')" type="button" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg transition-colors shadow-md">
                    <i class="bi bi-truck mr-2"></i>Registrar Despacho
                </button>
                <button onclick="saveSingleSale('${tabId}')" type="button" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors shadow-md">
                    <i class="bi bi-save mr-2"></i>Guardar Esta Venta
                </button>
            </div>
        </div>
        `;
    }

    // Inicializar eventos para un tab
    function initializeSaleTab(tabId) {
        const data = salesData.get(tabId);

        // Inicializar DataTable para la tabla de productos
        if ($.fn.DataTable) {
            data.dataTable = $(`#orderTable_${tabId}`).DataTable({
                responsive: true,
                paging: false, // ✅ Desactivar paginación
                info: false, // ✅ Desactivar contador
                language: {
                    zeroRecords: "No se encontraron productos",
                    emptyTable: "No hay productos agregados"
                },
                dom: 'rt', // ✅ Solo tabla (r=processing, t=table)
                columnDefs: [
                    { targets: [6], orderable: false },
                    { targets: [0], className: 'text-center' },
                    { targets: [4, 5], className: 'text-right' }
                ],
                order: [[0, 'asc']],
                autoWidth: false
            });
        }

        // Evento para buscar DNI
        const dniInput = document.getElementById(`dni_personal_${tabId}`);
        if (dniInput) {
            dniInput.addEventListener('input', () => buscarDNI(tabId));
        }

        // Evento para tipo de pago
        const paymentType = document.getElementById(`paymentType_${tabId}`);
        if (paymentType) {
            paymentType.addEventListener('change', () => handlePaymentTypeChange(tabId));
        }

        // Evento para toggle de segundo método de pago
        const togglePayment = document.getElementById(`togglePaymentFields_${tabId}`);
        if (togglePayment) {
            togglePayment.addEventListener('change', function() {
                const container = document.getElementById(`paymentFieldsContainer_${tabId}`);
                container.style.display = this.checked ? 'block' : 'none';
            });
        }

        // Evento para agregar servicio
        const addServiceBtn = document.getElementById(`addService_${tabId}`);
        if (addServiceBtn) {
            addServiceBtn.addEventListener('click', () => addService(tabId));
        }

        // Evento para buscar productos
        const buscarProductosBtn = document.getElementById(`buscarProductos_${tabId}`);
        if (buscarProductosBtn) {
            buscarProductosBtn.addEventListener('click', () => {
                openModalTab(`buscarProductosModal_${tabId}`);
                fetchProducts(tabId);
            });
        }

        // Evento para botón buscar en modal
        const btnBuscar = document.getElementById(`btnBuscarProduct_${tabId}`);
        if (btnBuscar) {
            btnBuscar.addEventListener('click', () => fetchProducts(tabId));
        }

        // Eventos para selects de ubicación (Departamento, Provincia, Distrito)
        const departamentoSelect = document.getElementById(`departamento_${tabId}`);
        if (departamentoSelect) {
            departamentoSelect.addEventListener('change', function() {
                const regionId = this.value;
                if (regionId !== '') {
                    fetchProvincesForTab(tabId, regionId);
                } else {
                    clearSelectForTab(`provincia_${tabId}`);
                    clearSelectForTab(`distrito_${tabId}`);
                }
            });
        }

        const provinciaSelect = document.getElementById(`provincia_${tabId}`);
        if (provinciaSelect) {
            provinciaSelect.addEventListener('change', function() {
                const provinceId = this.value;
                if (provinceId !== '') {
                    fetchDistrictsForTab(tabId, provinceId);
                } else {
                    clearSelectForTab(`distrito_${tabId}`);
                }
            });
        }

        // Evento para búsqueda de servicios
        const serviceInput = document.getElementById(`service_${tabId}`);
        if (serviceInput) {
            serviceInput.addEventListener('input', () => searchServices(tabId));
        }

        // Evento para buscador de productos con autocompletado
        const searchProductInput = document.getElementById(`searchProductInput_${tabId}`);
        if (searchProductInput) {
            searchProductInput.addEventListener('input', function() {
                const searchTerm = this.value.trim();
                if (searchTerm.length >= 1) {
                    searchProductsAutocomplete(tabId, searchTerm);
                } else {
                    hideProductResults(tabId);
                }
            });

            // Cerrar dropdown al hacer clic fuera
            document.addEventListener('click', function(e) {
                const resultsDiv = document.getElementById(`searchProductResults_${tabId}`);
                const inputDiv = document.getElementById(`searchProductInput_${tabId}`);
                if (resultsDiv && !resultsDiv.contains(e.target) && e.target !== inputDiv) {
                    hideProductResults(tabId);
                }
            });
        }

        // Cargar mecánicos en el select
        cargarMecanicosTab(tabId);
        
        // Establecer fecha y hora actual
        setCurrentDateTime(tabId);
    }
    
    // Función para establecer fecha y hora actual
    function setCurrentDateTime(tabId) {
        const fechaHoraInput = document.getElementById(`fechaHora_${tabId}`);
        if (fechaHoraInput) {
            const now = new Date();
            const fecha = now.toLocaleDateString('es-PE', { 
                day: '2-digit', 
                month: '2-digit', 
                year: 'numeric' 
            });
            const hora = now.toLocaleTimeString('es-PE', { 
                hour: '2-digit', 
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            });
            fechaHoraInput.value = `${fecha} ${hora}`;
        }
    }

    // Función para buscar productos con autocompletado
    function searchProductsAutocomplete(tabId, searchTerm) {
        // Verificar que el tab aún existe
        const searchInput = document.getElementById(`searchProductInput_${tabId}`);
        if (!searchInput) {
            console.warn('Tab cerrado, cancelando búsqueda');
            return;
        }
        
        const tiendaSelect = document.getElementById(`tienda_select_${tabId}`);
        let tiendaId = 'todos';
        
        if (tiendaSelect) {
            tiendaId = tiendaSelect.value || 'todos';
        }

        console.log('Buscando con tienda_id:', tiendaId, 'search:', searchTerm);
        const url = `${baseUrl}/api/product?tienda_id=${tiendaId}&search=${searchTerm}`;
        console.log('URL completa:', url);

        fetch(url)
            .then(response => response.json())
            .then(data => {
                console.log('Respuesta de la API:', data);
                // Verificar nuevamente que el tab existe antes de mostrar resultados
                if (document.getElementById(`searchProductResults_${tabId}`)) {
                    // La API devuelve un array directamente, no un objeto con products
                    displayProductResults(tabId, Array.isArray(data) ? data : []);
                }
            })
            .catch(error => {
                console.error('Error buscando productos:', error);
                hideProductResults(tabId);
            });
    }

    // Función para mostrar resultados de búsqueda
    function displayProductResults(tabId, products) {
        const resultsDiv = document.getElementById(`searchProductResults_${tabId}`);
        
        if (!resultsDiv) {
            console.error('No se encontró el div de resultados');
            return;
        }
        
        if (products.length === 0) {
            resultsDiv.innerHTML = '<div class="p-3 text-sm text-gray-500 text-center">No se encontraron productos</div>';
            resultsDiv.classList.remove('hidden');
            return;
        }

        let html = '<div class="divide-y divide-gray-200">';
        
        products.forEach(product => {
            console.log('Producto completo:', product);
            console.log('Stock del producto:', product.stock);
            
            const stock = product.stock || { quantity: 0, minimum_stock: 0 };
            const stockQuantity = stock.quantity || 0;
            const stockMin = stock.minimum_stock || 0;
            
            console.log('Stock quantity:', stockQuantity);
            
            const stockColor = stockQuantity <= 0 ? 'text-red-600' : 
                              stockQuantity <= stockMin ? 'text-yellow-600' : 
                              'text-green-600';
            
            // Obtener el precio de venta (sucursalA o el primero disponible)
            let price = 0;
            if (product.prices && product.prices.length > 0) {
                const sucursalAPrice = product.prices.find(p => p.type === 'sucursalA');
                const wholesalePrice = product.prices.find(p => p.type === 'wholesale');
                price = sucursalAPrice ? parseFloat(sucursalAPrice.price) : 
                       wholesalePrice ? parseFloat(wholesalePrice.price) : 
                       parseFloat(product.prices[0].price);
            }
            
            const storeName = product.tienda ? product.tienda.nombre : 'Todas';
            
            // Guardar el producto en base64 para evitar problemas con comillas
            const productBase64 = btoa(encodeURIComponent(JSON.stringify(product)));
            
            html += `
                <div class="p-3 hover:bg-gray-50 cursor-pointer transition" onclick="selectProductFromList('${tabId}', '${productBase64}')">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-800">${product.description}</p>
                            <p class="text-xs text-gray-500">Código: ${product.code_sku || product.code_bar || 'N/A'}</p>
                            <p class="text-xs ${stockColor} font-medium">Stock: ${stockQuantity}</p>
                        </div>
                        <div class="text-right ml-3">
                            <p class="text-sm font-bold text-blue-600">S/ ${price.toFixed(2)}</p>
                            <p class="text-xs text-gray-500">${storeName}</p>
                        </div>
                    </div>
                </div>
            `;
        });
        
        html += '</div>';
        resultsDiv.innerHTML = html;
        resultsDiv.classList.remove('hidden');
    }

    // Función para ocultar resultados
    function hideProductResults(tabId) {
        const resultsDiv = document.getElementById(`searchProductResults_${tabId}`);
        if (resultsDiv) {
            resultsDiv.classList.add('hidden');
        }
    }

    // Función para seleccionar un producto de la lista (solo lo coloca en el input)
    function selectProductFromList(tabId, productBase64) {
        try {
            const product = JSON.parse(decodeURIComponent(atob(productBase64)));
            
            // Colocar el nombre del producto en el input
            const searchInput = document.getElementById(`searchProductInput_${tabId}`);
            if (searchInput) {
                searchInput.value = product.description;
            }
            
            // Guardar el producto seleccionado en el campo oculto
            const hiddenInput = document.getElementById(`selectedProduct_${tabId}`);
            if (hiddenInput) {
                hiddenInput.value = productBase64;
            }
            
            // Ocultar resultados
            hideProductResults(tabId);
        } catch (error) {
            console.error('Error al seleccionar producto:', error);
        }
    }

    // Función para agregar el producto seleccionado (botón Agregar)
    function addSelectedProduct(tabId) {
        const hiddenInput = document.getElementById(`selectedProduct_${tabId}`);
        const searchInput = document.getElementById(`searchProductInput_${tabId}`);
        
        if (!hiddenInput || !hiddenInput.value) {
            Swal.fire({
                icon: 'warning',
                title: 'Seleccione un producto',
                text: 'Debe seleccionar un producto de la lista',
                confirmButtonColor: '#3b82f6'
            });
            return;
        }
        
        try {
            const product = JSON.parse(decodeURIComponent(atob(hiddenInput.value)));
            const stock = product.stock || { quantity: 0, minimum_stock: 0 };
            const stockQuantity = stock.quantity || 0;
            
            // Verificar stock
            if (stockQuantity <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sin stock',
                    text: 'Este producto no tiene stock disponible',
                    confirmButtonColor: '#3b82f6'
                });
                return;
            }

            // Agregar producto a la tabla
            addProductToOrder(tabId, product);
            
            // Limpiar búsqueda
            if (searchInput) searchInput.value = '';
            hiddenInput.value = '';
            hideProductResults(tabId);
            
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
                text: 'No se pudo agregar el producto',
                confirmButtonColor: '#ef4444'
            });
        }
    }

    // Función para agregar producto a la orden
    function addProductToOrder(tabId, product) {
        const data = salesData.get(tabId);
        
        const stock = product.stock || { quantity: 0, minimum_stock: 0 };
        const stockQuantity = stock.quantity || 0;
        
        // Obtener precios correctamente según el tipo
        let price_buy = 0, price_wholesale = 0, price_sucursalA = 0, price_sucursalB = 0;
        
        if (product.prices && product.prices.length > 0) {
            product.prices.forEach(p => {
                const priceValue = parseFloat(p.price) || 0;
                switch(p.type) {
                    case 'buy':
                        price_buy = priceValue;
                        break;
                    case 'wholesale':
                        price_wholesale = priceValue;
                        break;
                    case 'sucursalA':
                        price_sucursalA = priceValue;
                        break;
                    case 'sucursalB':
                        price_sucursalB = priceValue;
                        break;
                }
            });
        }
        
        // Usar precio de sucursalA por defecto, o el primero disponible
        const defaultPrice = price_sucursalA || price_wholesale || price_buy || 0;
        
        console.log('Producto:', product);
        console.log('Precios:', { price_buy, price_wholesale, price_sucursalA, price_sucursalB, defaultPrice });
        
        // Verificar si el producto ya existe
        const existingProduct = data.products.find(p => p.id === product.id);
        if (existingProduct) {
            if (existingProduct.quantity + 1 > stockQuantity) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Stock insuficiente',
                    text: `Solo hay ${stockQuantity} unidades disponibles`,
                    confirmButtonColor: '#3b82f6'
                });
                return;
            }
            existingProduct.quantity++;
            existingProduct.subtotal = existingProduct.quantity * existingProduct.price;
        } else {
            data.orderCount++;
            data.products.push({
                id: product.id,
                item: data.orderCount,
                code: product.code_sku || product.code_bar || 'N/A',
                description: product.description,
                quantity: 1,
                price: defaultPrice,
                price_buy: price_buy,
                price_wholesale: price_wholesale,
                price_sucursalA: price_sucursalA,
                price_sucursalB: price_sucursalB,
                type_price: 'sucursalA',
                subtotal: defaultPrice,
                stock: stockQuantity,
                prices: product.prices || []
            });
        }

        updateOrderTable(tabId);
        updateCalculations(tabId);
    }

    // Función para actualizar la tabla de productos
    function updateOrderTable(tabId) {
        const data = salesData.get(tabId);
        
        if (data.dataTable) {
            data.dataTable.clear();
            
            data.products.forEach(product => {
                data.dataTable.row.add([
                    product.item,
                    product.description,
                    `<input type="number" value="${product.quantity}" min="1" max="${product.stock}" 
                        onchange="updateProductQuantity('${tabId}', ${product.id}, this.value)" 
                        class="w-20 p-1 border rounded text-center text-sm">`,
                    `S/ ${product.price.toFixed(2)}`,
                    `<select onchange="updateProductPrice('${tabId}', ${product.id}, this.value)" 
                        class="w-full p-1 border rounded text-sm">
                        <option value="price_1" ${product.type_price === 'price_1' ? 'selected' : ''}>Precio 1</option>
                        <option value="price_2" ${product.type_price === 'price_2' ? 'selected' : ''}>Precio 2</option>
                        <option value="price_3" ${product.type_price === 'price_3' ? 'selected' : ''}>Precio 3</option>
                    </select>`,
                    `S/ ${product.subtotal.toFixed(2)}`,
                    `<button onclick="removeProduct('${tabId}', ${product.id})" 
                        class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
                        <i class="bi bi-trash"></i>
                    </button>`
                ]);
            });
            
            data.dataTable.draw();
        }
    }

    // Función para actualizar cantidad de producto
    function updateProductQuantity(tabId, productId, newQuantity) {
        const data = salesData.get(tabId);
        const product = data.products.find(p => p.id === productId);
        
        if (product) {
            const qty = parseInt(newQuantity);
            if (qty > product.stock) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Stock insuficiente',
                    text: `Solo hay ${product.stock} unidades disponibles`,
                    confirmButtonColor: '#3b82f6'
                });
                return;
            }
            
            product.quantity = qty;
            product.subtotal = product.quantity * product.price;
            updateOrderTable(tabId);
            updateCalculations(tabId);
        }
    }

    // Función para actualizar precio de producto
    function updateProductPrice(tabId, productId, priceType) {
        const data = salesData.get(tabId);
        const product = data.products.find(p => p.id === productId);
        
        if (product) {
            // Aquí deberías obtener el precio correcto del producto según el tipo
            // Por ahora mantenemos el precio actual
            product.type_price = priceType;
            updateOrderTable(tabId);
        }
    }

    // Función para eliminar producto
    function removeProduct(tabId, productId) {
        const data = salesData.get(tabId);
        data.products = data.products.filter(p => p.id !== productId);
        updateOrderTable(tabId);
        updateCalculations(tabId);
    }

    // Funciones para manejar ubicación por tab
    function fetchProvincesForTab(tabId, regionId) {
        fetch(`${baseUrl}/api/provinces/${regionId}`)
            .then(response => response.json())
            .then(data => {
                const provinceSelect = document.getElementById(`provincia_${tabId}`);
                provinceSelect.removeAttribute('disabled');
                clearSelectForTab(`distrito_${tabId}`);
                updateSelectOptionsForTab(`provincia_${tabId}`, data.provinces);
            })
            .catch(error => console.error('Error:', error));
    }

    function fetchDistrictsForTab(tabId, provinceId) {
        fetch(`${baseUrl}/api/districts/${provinceId}`)
            .then(response => response.json())
            .then(data => {
                const districtSelect = document.getElementById(`distrito_${tabId}`);
                districtSelect.removeAttribute('disabled');
                updateSelectOptionsForTab(`distrito_${tabId}`, data.districts);
            })
            .catch(error => console.error('Error:', error));
    }

    function updateSelectOptionsForTab(selectId, options) {
        const select = document.getElementById(selectId);
        if (!select) {
            console.warn(`Select ${selectId} no encontrado`);
            return;
        }
        select.innerHTML = '<option value="">Seleccione</option>';
        options.forEach(option => {
            const opt = document.createElement('option');
            opt.value = option.id;
            opt.textContent = option.name;
            select.appendChild(opt);
        });
    }

    function clearSelectForTab(selectId) {
        const select = document.getElementById(selectId);
        if (select) {
            select.innerHTML = '<option value="">Seleccione</option>';
            select.setAttribute('disabled', 'disabled');
        }
    }

    // Funciones de Tab Management
    function switchTab(tabId) {
        document.querySelectorAll('.tab-header').forEach(tab => tab.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

        document.getElementById(`tab-${tabId}`)?.classList.add('active');
        document.getElementById(`content-${tabId}`)?.classList.add('active');
    }

    // Función para cerrar tab sin confirmación (usado después de guardar)
    function forceCloseTab(tabId) {
        const data = salesData.get(tabId);
        if (data && data.dataTable) {
            data.dataTable.destroy();
        }

        document.getElementById(`tab-${tabId}`)?.remove();
        document.getElementById(`content-${tabId}`)?.remove();
        salesData.delete(tabId);

        const firstTab = document.querySelector('.tab-header');
        if (firstTab) {
            const firstTabId = firstTab.id.replace('tab-', '');
            switchTab(firstTabId);
        }

        updateSalesCount();
    }

    // Función para limpiar campos del tab (para nueva venta)
    function resetTabFields(tabId) {
        const data = salesData.get(tabId);
        
        // Limpiar productos
        data.products = [];
        data.services = [];
        data.documento = null;
        
        // Limpiar tabla
        if (data.dataTable) {
            data.dataTable.clear().draw();
        }
        
        // Limpiar campos del formulario
        const dniInput = document.getElementById(`dni_personal_${tabId}`);
        const nombresInput = document.getElementById(`nombres_apellidos_${tabId}`);
        const phoneInput = document.getElementById(`phone_${tabId}`);
        const vendedorInput = document.getElementById(`vendedor_${tabId}`);
        
        if (dniInput) dniInput.value = '';
        if (nombresInput) nombresInput.value = '';
        if (phoneInput) phoneInput.value = '';
        if (vendedorInput) vendedorInput.value = '';
        
        // Ocultar resumen de documento
        const resumen = document.getElementById(`documentoResumen_${tabId}`);
        if (resumen) resumen.classList.add('hidden');
        
        // Actualizar totales
        updateCalculations(tabId);
        
        Swal.fire({
            icon: 'info',
            title: 'Listo para nueva venta',
            text: 'Los campos han sido limpiados',
            timer: 1500,
            showConfirmButton: false
        });
    }

    function closeTab(tabId, event) {
        event?.stopPropagation();

        if (salesData.size <= 1) {
            Swal.fire({
                icon: 'warning',
                title: 'No se puede cerrar',
                text: 'Debe haber al menos una venta abierta',
                confirmButtonColor: '#3b82f6'
            });
            return;
        }

        Swal.fire({
            title: '¿Cerrar esta venta?',
            text: 'Se perderán los datos no guardados',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sí, cerrar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Destruir DataTable antes de eliminar el contenido
                const data = salesData.get(tabId);
                if (data && data.dataTable) {
                    data.dataTable.destroy();
                }

                document.getElementById(`tab-${tabId}`)?.remove();
                document.getElementById(`content-${tabId}`)?.remove();
                salesData.delete(tabId);

                const firstTab = document.querySelector('.tab-header');
                if (firstTab) {
                    const firstTabId = firstTab.id.replace('tab-', '');
                    switchTab(firstTabId);
                }

                updateSalesCount();
            }
        });
    }

    function updateSalesCount() {
        document.getElementById('salesCount').textContent = salesData.size;
    }

    // Funciones de Modal
    function openModalTab(modalId) {
        document.getElementById(modalId)?.classList.remove('hidden');
    }

    function closeModalTab(modalId) {
        document.getElementById(modalId)?.classList.add('hidden');
    }

    // Función para buscar DNI
    function buscarDNI(tabId) {
        const dni = document.getElementById(`dni_personal_${tabId}`).value;
        if (dni.length === 8) {
            fetch(`https://dniruc.apisperu.com/api/v1/dni/${dni}?token=${token}`)
                .then(response => response.json())
                .then(data => {
                    if (data.nombres) {
                        document.getElementById(`nombres_apellidos_${tabId}`).value =
                            data.apellidoPaterno + ' ' + data.apellidoMaterno + ' ' + data.nombres;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    }

    // Función para manejar cambio de tipo de pago
    function handlePaymentTypeChange(tabId) {
        const selectedValue = document.getElementById(`paymentType_${tabId}`).value;
        const creditFields = document.getElementById(`creditFields_${tabId}`);
        const paymentMethodContainer1 = document.getElementById(`paymentMethodContainer1_${tabId}`);
        const paymentMethodContainer2 = document.getElementById(`paymentMethodContainer2_${tabId}`);
        const paymentFieldsContainer = document.getElementById(`paymentFieldsContainer_${tabId}`);

        if (selectedValue === "2") {
            creditFields.classList.remove("hidden");
            paymentMethodContainer1.classList.add("hidden");
            paymentMethodContainer2.classList.add("hidden");
            paymentFieldsContainer.classList.add("hidden");

            // Calcular fecha de vencimiento
            const daysInput = document.getElementById(`nro_dias_${tabId}`);
            const dueDateInput = document.getElementById(`fecha_vencimiento_${tabId}`);

            daysInput.addEventListener("input", function() {
                let days = parseInt(this.value, 10);
                if (!isNaN(days) && days > 0) {
                    let today = new Date();
                    today.setDate(today.getDate() + days);
                    dueDateInput.value = today.toISOString().split("T")[0];
                } else {
                    dueDateInput.value = "";
                }
            });
        } else if (selectedValue === "1") {
            creditFields.classList.add("hidden");
            paymentMethodContainer1.classList.remove("hidden");
            paymentMethodContainer2.classList.remove("hidden");
        } else {
            creditFields.classList.add("hidden");
        }
    }

    // Funciones de Mecánicos
    function cargarMecanicosTab(tabId) {
        fetch("{{ route('mecanicosDisponibles') }}")
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById(`mecanico_select_${tabId}`);
                if (!select) {
                    console.warn(`Select mecanico_select_${tabId} no encontrado`);
                    return;
                }
                
                select.innerHTML = '<option value="">Seleccionar mecánico</option>';
                
                data.forEach(mecanico => {
                    const option = document.createElement('option');
                    option.value = mecanico.id;
                    option.textContent = `${mecanico.name} ${mecanico.apellidos}`;
                    select.appendChild(option);
                });

                // Evento cuando cambia el select
                select.addEventListener('change', function() {
                    const mechanicsInput = document.getElementById(`mechanics_id_${tabId}`);
                    if (mechanicsInput) {
                        mechanicsInput.value = this.value;
                    }
                });
            })
            .catch(error => {
                console.error('Error cargando mecánicos:', error);
            });
    }

    function mostrarModalMecanicos(tabId) {
        openModalTab(`modalMecanicos_${tabId}`);
        fetch("{{ route('mecanicosDisponibles') }}")
            .then(response => response.json())
            .then(data => {
                let contenedor = document.getElementById(`listaMecanicosModal_${tabId}`);
                contenedor.innerHTML = '';

                data.forEach(mecanico => {
                    let row = `
                    <div class="flex justify-between items-center p-2 border-b">
                        <span>${mecanico.name} ${mecanico.apellidos}</span>
                        <button onclick="seleccionarMecanico('${tabId}', ${mecanico.id}, '${mecanico.name} ${mecanico.apellidos}')"
                            class="px-3 py-1 bg-blue-500 text-white rounded-lg" type="button">
                            Asignar
                        </button>
                    </div>
                `;
                    contenedor.innerHTML += row;
                });
            });
    }

    function seleccionarMecanico(tabId, id, datos) {
        document.getElementById(`mechanics_id_${tabId}`).value = id;
        const select = document.getElementById(`mecanico_select_${tabId}`);
        select.value = id;
        closeModalTab(`modalMecanicos_${tabId}`);
    }

    // Funciones de Ubicación
    function fetchProvinces(tabId) {
        const regionId = document.getElementById(`regions_id_${tabId}`).value;
        if (regionId !== 'todos') {
            fetch(`${baseUrl}/api/provinces/${regionId}`)
                .then(response => response.json())
                .then(data => {
                    const provinceSelect = document.getElementById(`provinces_id_${tabId}`);
                    provinceSelect.removeAttribute('disabled');
                    updateSelectOptions(`provinces_id_${tabId}`, data.provinces);
                    clearSelect(`districts_id_${tabId}`);
                })
                .catch(error => console.error('Error fetching provinces:', error));
        } else {
            clearSelect(`provinces_id_${tabId}`);
            clearSelect(`districts_id_${tabId}`);
        }
    }

    function fetchDistricts(tabId) {
        const provinceId = document.getElementById(`provinces_id_${tabId}`).value;
        if (provinceId !== 'todos') {
            fetch(`${baseUrl}/api/districts/${provinceId}`)
                .then(response => response.json())
                .then(data => {
                    const districtSelect = document.getElementById(`districts_id_${tabId}`);
                    districtSelect.removeAttribute('disabled');
                    updateSelectOptions(`districts_id_${tabId}`, data.districts);
                })
                .catch(error => console.error('Error fetching districts:', error));
        } else {
            clearSelect(`districts_id_${tabId}`);
        }
    }

    function updateSelectOptions(selectId, options) {
        const select = document.getElementById(selectId);
        select.innerHTML = '<option value="todos">Seleccione una opción</option>';
        options.forEach(option => {
            const opt = document.createElement('option');
            opt.value = option.id;
            opt.textContent = option.name;
            select.appendChild(opt);
        });
    }

    function clearSelect(selectId) {
        const select = document.getElementById(selectId);
        if (select) {
            select.innerHTML = '<option value="todos">Seleccione una opción</option>';
        }
    }

    // Funciones de Servicios
    function addService(tabId) {
        const data = salesData.get(tabId);
        const serviceName = document.getElementById(`service_${tabId}`).value.trim();
        const servicePrice = document.getElementById(`service_price_${tabId}`).value.trim();

        if (serviceName === "" || servicePrice === "") {
            Swal.fire({
                icon: 'warning',
                title: 'Campos incompletos',
                text: 'Por favor, complete todos los campos.',
                confirmButtonColor: '#3b82f6'
            });
            return;
        }

        const newService = {
            id: Date.now(),
            name: serviceName,
            price: servicePrice
        };

        data.services.push(newService);
        updateServiceTable(tabId);
        updateCalculations(tabId);

        document.getElementById(`service_${tabId}`).value = "";
        document.getElementById(`service_price_${tabId}`).value = "";
    }

    function updateServiceTable(tabId) {
        const data = salesData.get(tabId);
        const tableBody = document.getElementById(`serviceList_${tabId}`);
        tableBody.innerHTML = "";

        data.services.forEach(service => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td class="border border-gray-300 px-4 py-2">${service.name}</td>
                <td class="border border-gray-300 px-4 py-2">${service.price}</td>
                <td class="border border-gray-300 px-4 py-2">
                    <button class="bg-red-500 text-white px-2 py-1 rounded-md" onclick="deleteService('${tabId}', ${service.id})">Eliminar</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    function deleteService(tabId, serviceId) {
        const data = salesData.get(tabId);
        data.services = data.services.filter(service => service.id !== serviceId);
        updateServiceTable(tabId);
        updateCalculations(tabId);
    }

    function searchServices(tabId) {
        const inputValue = document.getElementById(`service_${tabId}`).value.trim();
        const suggestionsList = document.getElementById(`serviceSuggestions_${tabId}`);
        const dropdown = document.getElementById(`serviceDropdown_${tabId}`);

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
                            document.getElementById(`service_${tabId}`).value = service.name;
                            document.getElementById(`service_price_${tabId}`).value = service.default_price;
                            dropdown.classList.add("hidden");
                        });

                        suggestionsList.appendChild(item);
                    });

                    dropdown.classList.remove("hidden");
                } else {
                    dropdown.classList.add("hidden");
                }
            });
    }

    // Funciones de Productos
    function fetchProducts(tabId) {
        const data = salesData.get(tabId);
        const tiendaId = document.getElementById(`tienda_id_${tabId}`).value;
        const search = document.getElementById(`searchProduct_${tabId}`).value;

        fetch(`${baseUrl}/api/product?tienda_id=${tiendaId}&search=${search}`)
            .then(res => res.json())
            .then(products => {
                let allProducts = products
                    .filter(product => !data.quotationItems.some(item => item.item_id === product.id))
                    .map(product => ({
                        ...product,
                        selectedQuantity: 1,
                        selectedPrice: ""
                    }));
                data.products = [...allProducts];
                renderProducts(tabId, data.products);
            })
            .catch(error => console.error('Error:', error));
    }

    function renderProducts(tabId, productList) {
        const productTable = document.getElementById(`productTable_${tabId}`);
        productTable.innerHTML = "";

        productList.forEach(product => {
            const stockActual = product.stock?.quantity ?? 0;
            const stockMinimo = product.stock?.minimum_stock ?? 0;
            const sinStock = stockActual === 0;
            const stockBajo = stockActual > 0 && stockActual <= stockMinimo;
            
            const row = document.createElement("tr");
            row.innerHTML = `
                <td class="px-2 py-1 border">${product.code_sku}</td>
                <td class="px-2 py-1 border">${product.description}</td>
                <td class="px-2 py-1 border">${product.location || '-'}</td>
                <td class="px-2 py-1 border ${sinStock ? 'bg-red-100 text-red-700 font-bold' : stockBajo ? 'bg-yellow-100 text-yellow-700' : ''}">${stockActual}</td>
                <td class="px-2 py-1 border">${stockMinimo}</td>
                <td class="px-2 py-1 border">
                    <input type="number" class="p-2 border rounded" value="1" min="1" max="${stockActual}"
                        id="qty_${tabId}_${product.id}" onchange="updateModalSubtotal('${tabId}', ${product.id})" ${sinStock ? 'disabled' : ''}>
                </td>
                <td class="px-2 py-1 border">
                    <select class="p-2 border rounded" id="price_${tabId}_${product.id}" onchange="updateModalSubtotal('${tabId}', ${product.id})" ${sinStock ? 'disabled' : ''}>
                        <option value="">Seleccionar precio</option>
                        ${product.prices.map(price => `<option value="${price.price}" data-price-id="${price.id}">${price.type} - ${price.price}</option>`).join('')}
                    </select>
                </td>
                <td class="px-2 py-1 border" id="subtotal_${tabId}_${product.id}">0</td>
                <td class="px-2 py-1 border">
                    <button class="bg-blue-500 text-white px-3 py-1 rounded ${sinStock ? 'opacity-50 cursor-not-allowed' : ''}" onclick="agregarProducto('${tabId}', ${product.id})" ${sinStock ? 'disabled' : ''}>Agregar</button>
                </td>
            `;
            productTable.appendChild(row);
        });
    }

    function updateModalSubtotal(tabId, productId) {
        const quantity = parseInt(document.getElementById(`qty_${tabId}_${productId}`).value) || 0;
        const priceSelect = document.getElementById(`price_${tabId}_${productId}`);
        const price = parseFloat(priceSelect.value) || 0;
        const subtotal = quantity * price;
        document.getElementById(`subtotal_${tabId}_${productId}`).textContent = subtotal.toFixed(2);
    }

    function agregarProducto(tabId, productId) {
        const data = salesData.get(tabId);
        const quantity = document.getElementById(`qty_${tabId}_${productId}`).value;
        const priceSelect = document.getElementById(`price_${tabId}_${productId}`);
        const selectedOption = priceSelect.options[priceSelect.selectedIndex];
        const selectedPriceId = selectedOption.getAttribute("data-price-id");

        const response = data.products.find(product => product.id == productId);
        if (response) {
            const product = {
                item_id: productId,
                description: response.description,
                priceId: selectedPriceId,
                unit_price: priceSelect.value,
                prices: response.prices,
                quantity: quantity,
                maximum_stock: response.stock?.quantity || 0,
            };

            const productCopy = { ...product };
            delete productCopy.prices;
            data.quotationItems.push(productCopy);

            addProductToTable(tabId, product);
            updateCalculations(tabId);
        }

        data.products = data.products.filter(product => product.id != productId);
        const row = priceSelect.closest("tr");
        row.style.display = "none";
    }

    function addProductToTable(tabId, product) {
        const data = salesData.get(tabId);
        data.orderCount++;

        // Crear la fila con DataTables API
        if (data.dataTable) {
            const rowNode = data.dataTable.row.add([
                data.orderCount,
                product.description,
                `<input type="number" class="p-2 border rounded"
                       value="${product.quantity}"
                       max="${product.maximum_stock}"
                       min="1"
                       style="width: 60px;"
                       onchange="updatePriceAndTotal('${tabId}', ${product.item_id})">`,
                `<select class="p-2 border rounded" style="width: 120px;"
                        onchange="updatePriceAndTotal('${tabId}', ${product.item_id})"
                        id="priceSelect_${tabId}_${product.item_id}">
                    <option value="">Seleccionar precio</option>
                    ${product.prices.map(precio => `
                        <option value="${precio.price}"
                                data-price-id="${precio.id}"
                                ${precio.id == product.priceId ? 'selected' : ''}>
                            ${precio.type} - ${precio.price}
                        </option>`).join('')}
                </select>`,
                `<span id="priceValue_${tabId}_${product.item_id}">${product.unit_price}</span>`,
                `<span id="totalValue_${tabId}_${product.item_id}">${product.unit_price * product.quantity}</span>`,
                `<button class="bg-red-500 text-white px-2 py-1 rounded" onclick="deleteProduct('${tabId}', ${product.item_id})">Eliminar</button>`
            ]).draw(false).node();

            // Agregar atributo data-product-id a la fila
            $(rowNode).attr('data-product-id', product.item_id);
        }
    }

    function updatePriceAndTotal(tabId, productId) {
        const data = salesData.get(tabId);
        const row = document.querySelector(`#orderTableBody_${tabId} tr[data-product-id="${productId}"]`);
        const quantityInput = row.querySelector('input[type="number"]');
        const priceSelect = document.getElementById(`priceSelect_${tabId}_${productId}`);

        const quantity = parseFloat(quantityInput.value) || 0;
        const selectedOption = priceSelect.options[priceSelect.selectedIndex];
        const price = parseFloat(selectedOption.value) || 0;

        document.getElementById(`priceValue_${tabId}_${productId}`).textContent = price.toFixed(2);
        document.getElementById(`totalValue_${tabId}_${productId}`).textContent = (price * quantity).toFixed(2);

        data.quotationItems.forEach(item => {
            if (item.item_id == productId) {
                item.quantity = quantity;
                item.unit_price = price;
                item.priceId = parseFloat(selectedOption.dataset.priceId);
            }
        });

        updateCalculations(tabId);
    }

    function deleteProduct(tabId, productId) {
        const data = salesData.get(tabId);
        data.quotationItems = data.quotationItems.filter(product => product.item_id != productId);

        // Eliminar fila usando DataTables API
        if (data.dataTable) {
            const row = data.dataTable.row(`tr[data-product-id="${productId}"]`);
            if (row.length) {
                row.remove().draw(false);
            }
        }

        updateCalculations(tabId);
    }

    // Función para actualizar cálculos
    function updateCalculations(tabId) {
        const data = salesData.get(tabId);
        let totalAmount = 0;

        // Sumar productos
        if (data.products && data.products.length > 0) {
            data.products.forEach(item => {
                totalAmount += parseFloat(item.subtotal) || 0;
            });
        }

        // Sumar quotationItems (si existen)
        if (data.quotationItems && data.quotationItems.length > 0) {
            data.quotationItems.forEach(item => {
                totalAmount += item.quantity * item.unit_price;
            });
        }

        // Sumar servicios (si existen)
        if (data.services && data.services.length > 0) {
            data.services.forEach(item => {
                totalAmount += parseFloat(item.price);
            });
        }

        const igvAmount = totalAmount * 0.18;
        const subtotalAmount = totalAmount - igvAmount;

        const subtotalEl = document.getElementById(`subtotalAmount_${tabId}`);
        const igvEl = document.getElementById(`igvAmount_${tabId}`);
        const totalEl = document.getElementById(`totalAmount_${tabId}`);
        
        if (subtotalEl) subtotalEl.textContent = "S/ " + subtotalAmount.toFixed(2);
        if (igvEl) igvEl.textContent = "S/ " + igvAmount.toFixed(2);
        if (totalEl) totalEl.textContent = "S/ " + totalAmount.toFixed(2);
    }

    // Función para obtener métodos de pago
    function getSalePaymentMethods(tabId) {
        const data = salesData.get(tabId);
        data.payments = [];

        const paymentMethod1 = document.getElementById(`paymentMethod1_${tabId}`).value;
        const totalAmountDiv = document.getElementById(`totalAmount_${tabId}`);
        let text = totalAmountDiv.textContent.trim();
        let paymentAmount1 = parseFloat(text.replace('S/', '').trim()) || 0;
        let paymentAmount2 = 0;

        if (document.getElementById(`togglePaymentFields_${tabId}`).checked) {
            const paymentMethod2 = document.getElementById(`paymentMethod2_${tabId}`).value;
            paymentAmount2 = parseFloat(document.getElementById(`paymentAmount2_${tabId}`).value) || 0;

            if (paymentMethod2 && paymentAmount2 > 0) {
                data.payments.push({
                    payment_method_id: paymentMethod2,
                    amount: paymentAmount2,
                    order: 2
                });
            }
        }

        if (paymentMethod1) {
            data.payments.push({
                payment_method_id: paymentMethod1,
                amount: paymentAmount1 - paymentAmount2,
                order: 1
            });
        }

        return data.payments;
    }

    // Función para construir datos de una venta
    function buildOrderData(tabId) {
        const data = salesData.get(tabId);

        // Función auxiliar para obtener valor de forma segura
        const getValue = (id, defaultValue = '') => {
            const element = document.getElementById(id);
            return element ? element.value.trim() : defaultValue;
        };

        const getTextContent = (id, defaultValue = '0.00') => {
            const element = document.getElementById(id);
            return element ? element.textContent.replace("S/ ", "").trim() : defaultValue;
        };

        // Preparar productos en el formato esperado por el backend
        const products = (data.products || []).map(product => ({
            item_id: product.id,
            quantity: product.quantity,
            unit_price: product.price
        }));

        // Preparar pagos en el formato esperado por el backend
        const payments = data.documento ? [{
            payment_method_id: data.documento.paymentMethod1,
            amount: parseFloat(getTextContent(`totalAmount_${tabId}`)) || 0,
            order: 1
        }] : [];

        return {
            customer_dni: getValue(`dni_personal_${tabId}`),
            customer_names_surnames: getValue(`nombres_apellidos_${tabId}`),
            customer_address: getValue(`direccion_${tabId}`),
            phone: getValue(`phone_${tabId}`),
            seller_name: getValue(`vendedor_${tabId}`),
            tienda_id: getValue(`tienda_select_${tabId}`) === 'todos' ? null : getValue(`tienda_select_${tabId}`),
            districts_id: getValue(`distrito_${tabId}`) || null,
            payments_id: data.documento?.paymentType || null,
            order_date: getValue(`fechaHora_${tabId}`) || new Date().toISOString().split('T')[0],
            currency: 'SOLES',
            document_type_id: data.documento?.documentType || null,
            nro_dias: getValue(`nro_dias_${tabId}`) || null,
            fecha_vencimiento: getValue(`fecha_vencimiento_${tabId}`) || null,
            igv: parseFloat(getTextContent(`igvAmount_${tabId}`)) || 0,
            total: parseFloat(getTextContent(`totalAmount_${tabId}`)) || 0,
            products: products,
            services: data.services || [],
            payments: payments
        };
    }

    // Función para registrar despacho (sin funcionalidad aún)
    function registrarDespacho(tabId) {
        Swal.fire({
            icon: 'info',
            title: 'Registrar Despacho',
            text: 'Esta funcionalidad estará disponible próximamente',
            confirmButtonColor: '#3b82f6'
        });
    }

    // Función para guardar una venta individual
    async function saveSingleSale(tabId) {
        const saleData = salesData.get(tabId);
        if (!saleData) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se encontró la venta',
                confirmButtonColor: '#ef4444'
            });
            return;
        }

        const result = await Swal.fire({
            title: '¿Guardar esta venta?',
            html: `<p>Venta #${saleData.saleNumber}</p>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        });

        if (!result.isConfirmed) return;

        Swal.fire({
            title: 'Guardando venta...',
            html: 'Por favor espere',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        try {
            const orderData = buildOrderData(tabId);

            // Validación básica
            const documentTypeId = orderData.document_type_id;
            const isNotaDeVenta = documentTypeId == 6;
            
            if (!isNotaDeVenta && (!orderData.customer_dni || !orderData.customer_names_surnames)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Datos incompletos',
                    text: 'Falta DNI o nombre del cliente',
                    confirmButtonColor: '#f59e0b'
                });
                return;
            }

            if (orderData.products.length === 0 && orderData.services.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sin productos',
                    text: 'Agregue al menos un producto o servicio',
                    confirmButtonColor: '#f59e0b'
                });
                return;
            }

            const response = await fetch('{{ route('sales.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(orderData)
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Error al guardar la venta');
            }

            Swal.fire({
                icon: 'success',
                title: '¡Venta guardada!',
                text: `Venta #${saleData.saleNumber} guardada exitosamente`,
                confirmButtonColor: '#10b981',
                showCancelButton: true,
                confirmButtonText: 'Ir al índice',
                cancelButtonText: 'Nueva venta'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirigir al índice de ventas
                    window.location.href = '{{ route("sales.index") }}';
                } else {
                    // Si hay más de un tab, cerrar el actual
                    if (salesData.size > 1) {
                        forceCloseTab(tabId);
                    } else {
                        // Si es el único tab, limpiar los campos para nueva venta
                        resetTabFields(tabId);
                    }
                }
            });

        } catch (error) {
            console.error('Error guardando venta:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Error al guardar la venta',
                confirmButtonColor: '#ef4444'
            });
        }
    }

    // Función para guardar todas las ventas
    async function saveAllSales() {
        if (salesData.size === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No hay ventas',
                text: 'Agregue al menos una venta para guardar',
                confirmButtonColor: '#3b82f6'
            });
            return;
        }

        const result = await Swal.fire({
            title: '¿Guardar todas las ventas?',
            html: `<p>Total de ventas: <strong>${salesData.size}</strong></p>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6b7280',
            confirmButtonText: `Sí, guardar ${salesData.size} venta(s)`,
            cancelButtonText: 'Cancelar'
        });

        if (!result.isConfirmed) return;

        Swal.fire({
            title: 'Guardando ventas...',
            html: 'Por favor espere',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        let savedCount = 0;
        let errorCount = 0;
        let errors = [];

        for (const [tabId, saleData] of salesData) {
            try {
                const orderData = buildOrderData(tabId);

                // Validación básica - Permitir NOTA DE VENTA sin cliente (se generará código automático)
                const documentTypeId = orderData.document_type_id;
                const isNotaDeVenta = documentTypeId == 6; // ID de NOTA DE VENTA
                
                if (!isNotaDeVenta && (!orderData.customer_dni || !orderData.customer_names_surnames)) {
                    errors.push(`Venta #${saleData.saleNumber}: Falta DNI o nombre del cliente`);
                    errorCount++;
                    continue;
                }

                if (orderData.products.length === 0 && orderData.services.length === 0) {
                    errors.push(`Venta #${saleData.saleNumber}: No hay productos ni servicios`);
                    errorCount++;
                    continue;
                }

                const response = await fetch('{{ route('sales.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(orderData)
                });

                if (!response.ok) {
                    throw new Error(`Error en venta #${saleData.saleNumber}`);
                }

                savedCount++;
            } catch (error) {
                console.error('Error guardando venta:', error);
                errors.push(`Venta #${saleData.saleNumber}: ${error.message}`);
                errorCount++;
            }
        }

        let resultHtml = `<p class="text-green-600 font-semibold">Ventas guardadas: ${savedCount}</p>`;
        if (errorCount > 0) {
            resultHtml += `<p class="text-red-600 font-semibold mt-2">Errores: ${errorCount}</p>`;
            resultHtml += `<ul class="text-left text-sm mt-2">`;
            errors.forEach(err => {
                resultHtml += `<li class="text-red-500">- ${err}</li>`;
            });
            resultHtml += `</ul>`;
        }

        Swal.fire({
            icon: savedCount > 0 ? 'success' : 'error',
            title: savedCount > 0 ? '¡Proceso completado!' : 'Error',
            html: resultHtml,
            confirmButtonColor: '#10b981'
        }).then(() => {
            if (savedCount > 0) {
                window.location.href = '{{ route("sales.index") }}';
            }
        });
    }
    </script>
</x-app-layout>
