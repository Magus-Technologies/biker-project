<x-app-layout>
      <x-breadcrumb 
        title="Registrar Cotizacion" 
        parent="Cotizacion" 
        parentUrl="{{ route('quotations.index') }}" 
        subtitle="Crear" 
    />
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            cotizacion insertar
        </h2>
    </x-slot>
    <div class="container mx-auto p-2 text-sm">
        <div class="grid grid-cols-3 gap-6">
            <!-- Formulario de Cliente -->
            <div class="col-span-2 bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-bold mb-4">Cliente</h2>
                <input type="text" id="dni_personal" placeholder="Ingrese Documento"
                    class="w-full p-2 border rounded mb-2">
                <input type="text" placeholder="Nombre del cliente" id="nombres_apellidos"
                    class="w-full p-2 border rounded mb-2">
                <input type="text" placeholder="Direccion del cliente" id="direccion"
                    class="w-full p-2 border rounded mb-2">
                <select name="region" id="regions_id" class="w-3/12 p-2 border rounded">
                    <option value="todos">Seleccione un Departamento</option>
                    @foreach ($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                    @endforeach
                </select>
                <select name="" id="provinces_id" class="w-3/12 p-2 border rounded" disabled>
                    <option value="todos">Seleccione una opción</option>
                </select>
                <select name="" id="districts_id" class="w-3/12 p-2 border rounded" disabled>
                    <option value="todos">Seleccione una opción</option>
                </select>
                <!-- Botón que abre el modal -->
                <button class="bg-yellow-400 p-2 rounded w-3/12 mt-2" id="buscarProductos">Consultar
                    Productos</button>
                <div class="relative">
                    <label for="service" class="block font-medium text-gray-700">Servicio</label>
                    <input type="text" id="service" name="service" value="{{ old('service', 'TALLER') }}"
                        class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm" autocomplete="off">

                    <!-- Dropdown de Sugerencias -->
                    <div id="serviceDropdown"
                        class="absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-lg hidden">
                        <ul id="serviceSuggestions" class="max-h-40 overflow-y-auto"></ul>
                    </div>
                </div>

                <div class="mt-3">
                    <label for="service_price" class="block font-medium text-gray-700">Precio del Servicio</label>
                    <input type="number" id="service_price" name="service_price" value="{{ old('service_price', 60) }}"
                        class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm">
                </div>

                <button type="button" id="addService" class="bg-blue-500 text-white px-4 py-2 mt-3 rounded-md">Agregar
                    Servicio</button>
                <div id="modalMecanicos"
                    class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center">
                    <div class="bg-white p-6 rounded-lg shadow-md w-1/3">
                        <h3 class="text-xl font-semibold mb-4">Mecánicos Disponibles</h3>
                        <div id="listaMecanicosModal"></div>
                        <button onclick="cerrarModal()"
                            class="mt-4 px-4 py-2 bg-red-500 text-white rounded-lg">Cerrar</button>
                    </div>
                </div>
                <div>
                    <div class="flex mt-2">
                        <input name="datos_mecanico" id="datos_mecanico" type="text"
                            class="block w-6/12  border border-gray-300 rounded-md shadow-sm">
                        <input name="mechanics_id" id="mechanics_id" type="hidden"
                            class="block w-full  border border-gray-300 rounded-md shadow-sm">
                        <button onclick="eliminarMecanico()" type="button"
                            class="px-4 py-2 bg-red-500 text-white rounded-lg mr-11">X</button>
                        <button onclick="mostrarModal()" type="button"
                            class="px-4 py-2 bg-green-500 text-white rounded-lg  whitespace-nowrap">Seleccionar
                            Mecánico</button>

                    </div>
                </div>
                <!-- Modal -->
                <div id="buscarProductosModal"
                    class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 p-4 hidden">
                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-4xl w-full">
                        <h3 class="text-lg font-bold mb-4">Productos</h3>

                        <!-- Campo de búsqueda dentro del modal -->
                        <div class="mb-4 flex items-center ">
                            <div class="w-8/12">
                                <input type="text" placeholder="Buscar por codigo del producto..."
                                    class="w-full p-2 border rounded" id="searchProduct">
                            </div>
                            <div>
                                <button class="bg-blue-500 text-white px-4 py-2  rounded-md rounded-l-none mr-5"
                                    id="btnBuscarProduct">Buscar</button>
                            </div>
                            <div class="w-3/12">
                                <label for="tienda_id" class="block font-medium text-gray-700">Tienda</label>
                                <select id="tienda_id" name="tienda_id"
                                    class="block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                                    <option value="todos">Todas</option>
                                    @foreach ($tiendas as $tienda)
                                        <option value="{{ $tienda->id }}">{{ $tienda->nombre }}</option>
                                    @endforeach
                                </select>

                            </div>

                        </div>

                        <!-- Tabla con los productos -->
                        <div class="overflow-x-auto overflow-y-auto h-80 border border-gray-300 rounded-lg">
                            <table class="min-w-full table-auto text-xs">
                                <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white sticky top-0 shadow-md">
                                    <tr>
                                        <th class="px-3 py-3 border-r border-blue-400 text-left font-semibold">Código</th>
                                        <th class="px-3 py-3 border-r border-blue-400 text-left font-semibold">Descripción</th>
                                        <th class="px-3 py-3 border-r border-blue-400 text-center font-semibold">Ubicación</th>
                                        <th class="px-3 py-3 border-r border-blue-400 text-center font-semibold">Stock Actual</th>
                                        <th class="px-3 py-3 border-r border-blue-400 text-center font-semibold">Stock Mín.</th>
                                        <th class="px-3 py-3 border-r border-blue-400 text-center font-semibold">Cantidad</th>
                                        <th class="px-3 py-3 border-r border-blue-400 text-left font-semibold">Precio</th>
                                        <th class="px-3 py-3 border-r border-blue-400 text-right font-semibold">Subtotal</th>
                                        <th class="px-3 py-3 text-center font-semibold">Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="productTable" class="bg-white divide-y divide-gray-200">
                                    <!-- Productos generados dinámicamente -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Botón de cerrar modal -->
                        <button class="mt-4 bg-red-500 text-white px-4 py-2 rounded"
                            onclick="closeModal('buscarProductosModal')">Cerrar</button>
                    </div>
                </div>
            </div>
            <!-- Detalle del Pedido -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-bold mb-4">Documento</h2>
                <div>
                    <label class="font-bold">Empresa </label>
                    <!-- Se agrega id para capturar el valor -->
                    <select id="companies_id" class="w-full p-2 border rounded">
                        <option value="">Seleccione</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->razon_social }} - {{ $company->ruc }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="font-bold">Tipo pago</label>
                    <!-- Se agrega id para capturar el valor -->
                    <select id="paymentType" class="w-full p-2 border rounded">
                        <option value="">Seleccione</option>
                        @foreach ($paymentsType as $payment)
                            <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Campos adicionales ocultos -->
                <div id="creditFields" class="mt-3 hidden">
                    <label for="nro_dias">Número de días:</label>
                    <input type="number" id="nro_dias" class="w-full p-2 border rounded" min="1">

                    <label for="fecha_vencimiento" class="mt-2">Fecha de vencimiento:</label>
                    <input type="date" id="fecha_vencimiento" class="w-full p-2 border rounded">
                </div>
                <div class="mt-3" id="paymentMethodContainer1">
                    <label class="font-bold">Metodo pago</label>
                    <select id="paymentMethod1" class="w-full p-2 border rounded">
                        <option value="">Seleccione</option>
                        @foreach ($paymentsMethod as $payment)
                            <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-2" id="paymentMethodContainer2">
                    <input type="checkbox" id="togglePaymentFields" class="mr-2">
                    <label for="togglePaymentFields">Agregar método de pago y monto</label>
                </div>
                <div id="paymentFieldsContainer" class="mt-2 hidden">
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
                        <input type="number" id="paymentAmount2" class="w-full p-2 border rounded"
                            placeholder="Ingrese el monto">
                    </div>
                </div>

                <div>
                    <label class="font-bold">Tipo de documento</label>
                    <!-- Se agrega id para capturar el valor -->
                    <select id="documentType" class="w-full p-2 border rounded">
                        <option value="">Seleccione</option>
                        @foreach ($documentTypes as $documentType)
                            <option value="{{ $documentType->id }}">{{ $documentType->name }}</option>
                        @endforeach
                    </select>
                </div>
                <label>Fecha</label>
                <!-- Se agrega id para la fecha -->
                <input type="date" id="orderDate" value="{{ date('Y-m-d') }}"
                    class="w-full p-2 border rounded mb-4">
                <label>Moneda</label>
                <!-- Si la moneda es fija, también se puede capturar -->
                <input type="text" id="orderCurrency" value="SOLES" class="w-full p-2 border rounded mb-4">
                <!-- Subtotal -->
                <div class="bg-gray-200 text-gray-800 p-1 rounded text-center text-sm font-bold mb-2">
                    Subtotal: <span id="subtotalAmount">S/ 0.00</span>
                </div>
                <!-- IGV (18%) -->
                <div class="bg-gray-200 text-gray-800 p-1 rounded text-center text-sm font-bold mb-2">
                    IGV (18%): <span id="igvAmount">S/ 0.00</span>
                </div>

                <div class="bg-indigo-500 text-white p-1 rounded text-center text-sm font-bold" id="totalAmount">
                    S/ 0.00
                </div>
                <div class="mt-4">
                    <!-- Botón para guardar la orden -->
                    <button class="bg-blue-500 text-white p-2 rounded" onclick="saveQuotation()">Guardar</button>
                </div>
            </div>
        </div>

        <!-- Tabla de Productos (Detalle del Pedido) -->
        <div class="mt-6 bg-white p-6 rounded-lg shadow-lg border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Productos
                </h2>
                <div class="w-5/12">
                    <div class="relative">
                        <input type="text" placeholder="Buscar producto..." 
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                            id="searchProductList">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto rounded-lg border border-gray-300">
                <table class="w-full border-collapse" id="orderTable">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-700 to-gray-800 text-white">
                            <th class="border-r border-gray-600 px-4 py-3 text-center text-sm font-semibold">Item</th>
                            <th class="border-r border-gray-600 px-4 py-3 text-left text-sm font-semibold">Producto</th>
                            <th class="border-r border-gray-600 px-4 py-3 text-center text-sm font-semibold">Cantidad</th>
                            <th class="border-r border-gray-600 px-4 py-3 text-center text-sm font-semibold">P. Unit.</th>
                            <th class="border-r border-gray-600 px-4 py-3 text-center text-sm font-semibold">T. Precio</th>
                            <th class="border-r border-gray-600 px-4 py-3 text-right text-sm font-semibold">Parcial</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="orderTableBody" class="bg-white divide-y divide-gray-200">
                        <tr id="emptyRow">
                            <td class="px-4 py-8 text-center text-gray-500" colspan="7">
                                <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-sm font-medium">No hay productos agregados</p>
                                <p class="text-xs text-gray-400 mt-1">Usa el botón "Consultar Productos" para agregar items</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Tabla para listar servicios -->
        <div class="mt-6 bg-white p-6 rounded-lg shadow-lg border border-gray-200">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Servicios
            </h2>
            <div class="overflow-x-auto rounded-lg border border-gray-300">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gradient-to-r from-green-600 to-green-700 text-white">
                            <th class="border-r border-green-500 px-4 py-3 text-left text-sm font-semibold">Servicio</th>
                            <th class="border-r border-green-500 px-4 py-3 text-right text-sm font-semibold">Precio</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="serviceList" class="bg-white divide-y divide-gray-200">
                        <!-- Aquí se agregarán los servicios -->
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <style>
        /* Estilos personalizados para las tablas */
        #orderTable tbody tr:hover,
        #productTable tr:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Animación suave para inputs y selects */
        input[type="number"]:focus,
        select:focus {
            transform: scale(1.02);
            transition: all 0.2s ease;
        }

        /* Estilo para el scrollbar de la tabla del modal */
        .overflow-y-auto::-webkit-scrollbar {
            width: 8px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Efecto de pulso para botones */
        @keyframes pulse-subtle {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.9;
            }
        }

        button:active {
            transform: scale(0.95);
        }

        /* Mejorar la apariencia de las celdas de precio */
        .data-price-value,
        .data-total-value {
            font-family: 'Courier New', monospace;
        }
    </style>
</x-app-layout>

<script>
    let services = [];
    let orderCount = 0; // para numerar los ítems
    const searchInput = document.getElementById("searchProduct");
    let products = []; // Productos disponibles en el modal
    let quotationItems = [];
    let orderTableBody = document.getElementById("orderTableBody");
    const totalAmountEl = document.getElementById("totalAmount");
    let payments = [];

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

    // Mostrar/ocultar campos adicionales de pago
    document.getElementById("togglePaymentFields").addEventListener("change", function() {
        let paymentFieldsContainer = document.getElementById("paymentFieldsContainer");
        paymentFieldsContainer.classList.toggle("hidden", !this.checked);
    });



    // BUSCADOR DEPARTAMENTO PROVINCIA DISTRITO
    document.getElementById('regions_id').addEventListener('change', function() {
        const regionId = this.value;
        if (regionId !== 'Seleccione un Departamento') {
            fetchProvinces(regionId);
        } else {
            clearSelect('provinces_id');
            clearSelect('districts_id');
        }
    });
    document.getElementById('provinces_id').addEventListener('change', function() {
        const provinceId = this.value;
        if (provinceId !== 'todos') {
            fetchDistricts(provinceId);
        } else {
            clearSelect('districts_id');
        }
    });

    function fetchProvinces(regionId) {
        fetch(`${baseUrl}/api/provinces/${regionId}`)
            .then(response => response.json())
            .then(data => {
                const provinceSelect = document.getElementById('provinces_id');
                provinceSelect.removeAttribute(
                    'disabled');
                clearSelect('districts_id');
                updateSelectOptions('provinces_id', data.provinces);
                console.log('data.provinces', data.provinces);
            })
            .catch(error => console.error('Error fetching provinces:', error));
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
        select.innerHTML = '<option value="todos">Seleccione una opción</option>';
    }

    function fetchDistricts(provinceId) {
        fetch(`${baseUrl}/api/districts/${provinceId}`)
            .then(response => response.json())
            .then(data => {
                const districtSelect = document.getElementById('districts_id');
                districtSelect.removeAttribute(
                    'disabled');
                updateSelectOptions('districts_id', data.districts);
            })
            .catch(error => console.error('Error fetching districts:', error));
    }

    //AGREGANDO PARA EL MECANICO
    function seleccionarMecanico(id, datos) {
        document.getElementById('mechanics_id').value = id;
        document.getElementById('datos_mecanico').value = datos;
    }

    function eliminarMecanico() {
        document.getElementById('mechanics_id').value = '';
        document.getElementById('datos_mecanico').value = '';
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
                        <span>${mecanico.name} ${mecanico.apellidos} </span>
                        <button onclick="seleccionarMecanico(${mecanico.id}, '${mecanico.name} ${mecanico.apellidos}'); cerrarModal()" 
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
    //agregando buscador 
    document.getElementById('searchProductList').addEventListener('input', function() {
        let searchProductList = document.getElementById('searchProductList').value;
        let filteredItems = quotationItems.filter(item =>
            item.description.toLowerCase().includes(searchProductList.toLowerCase())
        );
        console.log(searchProductList, "searchProductList")
        console.log(filteredItems, "filteredItems")
        console.log(quotationItems, "quotationItems")
        mostrarProductos(filteredItems);
    })

    function mostrarProductos(items) {
        let productListContainer = document.getElementById('orderTableBody');
        productListContainer.innerHTML = ''; // Limpia la tabla

        if (items.length === 0) {
            productListContainer.innerHTML = `
            <tr id="emptyRow">
                <td colspan="7" class="text-center p-2">No hay productos disponibles</td>
            </tr>
        `;
            return;
        }

        items.forEach(product => {
            addProductTo(product); // Usa la misma función para crear filas
        });
    }
    //metodo d epago 
    document.getElementById('togglePaymentFields').addEventListener('change', function() {
        const container = document.getElementById('paymentFieldsContainer');
        container.style.display = this.checked ? 'block' : 'none';
    });

    //SERVICIOS
    //  AGREGANDO SERVICIOS
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

    // Función para actualizar la tabla de servicios
    function updateTable() {
        let tableBody = document.getElementById("serviceList");
        tableBody.innerHTML = ""; // Limpiar tabla antes de actualizar

        services.forEach((service, index) => {
            let row = document.createElement("tr");
            row.className = index % 2 === 0 ? 'bg-white hover:bg-green-50 transition-colors' : 'bg-gray-50 hover:bg-green-50 transition-colors';
            row.innerHTML = `
                    <td class="px-4 py-3 text-gray-800 font-medium">${service.name}</td>
                    <td class="px-4 py-3 text-right font-bold text-green-700">S/ ${parseFloat(service.price).toFixed(2)}</td>
                    <td class="px-4 py-3 text-center">
                        <button class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-3 py-1 rounded-md shadow-sm transition-all transform hover:scale-105" 
                            onclick="deleteService(${service.id})">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Eliminar
                        </button>
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
    // FIN DE SERVICIOS

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
    document.getElementById("buscarProductos").addEventListener("click", () => {
        openModal("buscarProductosModal", () => {
            fetchProducts();
        });
    });

    document.getElementById("btnBuscarProduct").addEventListener("click", () => {
        fetchProducts();
    })

    function fetchProducts() {
        const tiendaId = document.getElementById("tienda_id").value;
        const search = searchInput.value;
        // Realizar la solicitud a la API
        fetch('/api/product?tienda_id=' + tiendaId + '&search=' + search)
            .then(res => res.json())
            .then(data => {
                let allProducts = data
                    .filter(product => !quotationItems.some(item => item.item_id === product.id))
                    .map(product => ({
                        ...product,
                        selectedQuantity: 1,
                        selectedPrice: ""
                    }));
                products = [...allProducts];
                console.log(products)
                renderProducts(products);
            })
            .catch(error => console.error('Error:', error));
    }

    // // Renderiza la lista de productos en el modal
    function renderProducts(productList) {
        productTable.innerHTML = "";
        productList.forEach((product, index) => {
            const row = document.createElement("tr");
            const stockQuantity = product.stock?.quantity ?? 0;
            const minStock = product.stock?.minimum_stock ?? 0;
            
            // Determinar color del stock
            let stockClass = 'text-green-700 bg-green-50';
            if (stockQuantity === 0) {
                stockClass = 'text-red-700 bg-red-50 font-bold';
            } else if (stockQuantity <= minStock) {
                stockClass = 'text-yellow-700 bg-yellow-50 font-semibold';
            }
            
            row.className = index % 2 === 0 ? 'bg-white hover:bg-blue-50 transition-colors' : 'bg-gray-50 hover:bg-blue-50 transition-colors';
            row.innerHTML = `
                    <td class="px-3 py-2 border-r border-gray-200 text-gray-700 font-mono text-xs">${product.code_sku}</td>
                    <td class="px-3 py-2 border-r border-gray-200 text-gray-800 font-medium">${product.description}</td>
                    <td class="px-3 py-2 border-r border-gray-200 text-center text-gray-600">${product.location || '-'}</td>
                    <td class="px-3 py-2 border-r border-gray-200 text-center">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold ${stockClass}">
                            ${stockQuantity}
                        </span>
                    </td>
                    <td class="px-3 py-2 border-r border-gray-200 text-center text-gray-600">${minStock}</td>
                    <td class="px-3 py-2 border-r border-gray-200 text-center">
                        <input type="number" 
                            class="w-16 px-2 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent text-center data-quantity-id-${product.id}" 
                            value="1" min="1" max="${stockQuantity}" data-product-id="${product.id}">
                    </td>
                    <td class="px-3 py-2 border-r border-gray-200">
                        <select class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent text-xs data-price-id-${product.id}" data-product-id="${product.id}">
                            <option value="">Seleccionar precio</option>
                            ${product.prices.map(price => `<option value="${price.price}" data-price-id="${price.id}">${price.type} - S/ ${price.price}</option>`).join('')}
                        </select>
                    </td>
                    <td class="px-3 py-2 border-r border-gray-200 text-right font-semibold text-gray-800 subtotal-cell" id="subtotal-${product.id}">S/ 0.00</td>
                    <td class="px-3 py-2 text-center">
                        <button class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-3 py-1 rounded-md shadow-sm transition-all transform hover:scale-105" 
                            data-product-id="${product.id}" onclick="agregarProducto(${product.id})">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Agregar
                        </button>
                    </td>
                `;
            productTable.appendChild(row);
            addSubtotalEvents(row, product.id);

        });
    }

    // calcular subtotal de productos en el modal y tabla
    function addSubtotalEvents(row, productId) {
        const quantity = row.querySelector(`.data-quantity-id-${productId}`);
        const priceSelect = row.querySelector(`.data-price-id-${productId}`);

        quantity.addEventListener("input", () => updateModalSubtotal(productId, quantity, priceSelect));
        priceSelect.addEventListener("change", () => updateModalSubtotal(productId, quantity, priceSelect));
    }

    function updateModalSubtotal(productId, quantityInput, priceSelect) {
        const quantity = parseInt(quantityInput.value) || 0;
        const price = parseFloat(priceSelect.value) || 0;
        const subtotal = quantity * price;
        const subtotalElement = document.getElementById(`subtotal-${productId}`);

        if (subtotalElement) {
            subtotalElement.textContent = 'S/ ' + subtotal.toFixed(2);
        }
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
        priceValueCell.textContent = 'S/ ' + price.toFixed(2);
        totalValueCell.textContent = 'S/ ' + (price * quantity).toFixed(2);

        quotationItems.forEach(item => {
            if (item.item_id == productId) {
                item.quantity = quantity;
                item.unit_price = price;
                item.priceId = parseFloat(selectedOption.dataset.priceId);
            }
        })
        updateInformationCalculos();

    }

    // guardar cotizacion 
    async function saveQuotation() {
        try {

            const orderData = buildOrderData();
            quotationPaymentMethods()
            const response = await fetch('{{ route('quotations.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    ...orderData,
                    payments
                })
            });

            if (!response.ok) throw new Error("Error en la petición");
            const data = await response.json();
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: 'La cotización se ha guardado correctamente.',
                confirmButtonColor: '#10b981'
            }).then(() => {
                window.location.href = "{{ route('quotations.index') }}";
            });
        } catch (error) {
            console.error("Error al guardar la orden:", error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al guardar la orden.',
                confirmButtonColor: '#ef4444'
            });
        }
    }

    function quotationPaymentMethods() {
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

    //agregar productos
    function agregarProducto(productId) {
        const quantity = document.querySelector(`.data-quantity-id-${productId}`).value;
        const priceSelect = document.querySelector(`.data-price-id-${productId}`);
        const selectOptionPriceId = priceSelect.options[priceSelect.selectedIndex];
        const selectedPriceId = selectOptionPriceId.getAttribute("data-price-id");
        const response = products.find(product => product.id == productId);
        if (response) {
            const product = {
                item_id: productId,
                description: response.description,
                priceId: selectedPriceId,
                unit_price: priceSelect.value,
                prices: response.prices,
                quantity: quantity,
                maximum_stock: response.stock?.quantity,
            }
            // const productCopy = {
            //     ...product
            // };
            // delete productCopy.prices;
            quotationItems.push(product);
            addProductTo(product);
            updateInformationCalculos();

            Swal.fire({
                icon: 'success',
                title: 'Producto agregado exitosamente',
                showConfirmButton: false,
                timer: 1500
            })

        }
        products = products.filter(product => product.id != productId)
        const row = priceSelect.closest("tr");
        console.log(quotationItems);
        row.style.display = "none";
    }

    function addProductTo(product) {
        const emptyRow = document.getElementById("emptyRow");
        if (emptyRow) {
            emptyRow.remove();
        }
        orderCount++;
        const orderRow = document.createElement("tr");
        orderRow.className = orderCount % 2 === 0 ? 'bg-white hover:bg-gray-50 transition-colors' : 'bg-gray-50 hover:bg-gray-100 transition-colors';
        orderRow.setAttribute("data-product-id", product.item_id);
        orderRow.innerHTML = `
            <td class="px-4 py-3 text-center font-semibold text-gray-700">${orderCount}</td>
            <td class="px-4 py-3 text-gray-800">${product.description}</td>
            <td class="px-4 py-3 text-center">
                <input type="number" 
                    class="w-20 px-2 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent text-center data-quantity-value-${product.item_id}" 
                    onchange="updatePriceAndTotal(${product.item_id})"
                    value="${product.quantity}" 
                    max="${product.maximum_stock}"
                    min="1">
            </td>
            <td class="px-4 py-3 text-center">
                <select class="w-full px-2 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent text-xs data-price-select-${product.item_id}" 
                        onchange="updatePriceAndTotal(${product.item_id})">
                    <option value="">Seleccionar precio</option>
                    ${product.prices.map(precio => `
                        <option value="${precio.price}" 
                                data-price-id="${precio.id}" 
                                ${precio.id == product.priceId ? 'selected' : ''}>
                            ${precio.type} - S/ ${precio.price}
                        </option>`).join('')}
                </select>
            </td>
            <td class="px-4 py-3 text-center font-semibold text-blue-600 data-price-value-${product.item_id}">S/ ${product.unit_price}</td>
            <td class="px-4 py-3 text-right font-bold text-gray-800 data-total-value-${product.item_id}">S/ ${(product.unit_price * product.quantity).toFixed(2)}</td>
            <td class="px-4 py-3 text-center">
                <button class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-3 py-1 rounded-md shadow-sm transition-all transform hover:scale-105 eliminar-btn" 
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
    // eliminar producto
    function deleteProduct(productId) {
        quotationItems = quotationItems.filter(product => product.item_id != productId);
        const row = document.querySelector(`tr[data-product-id="${productId}"]`);
        if (row) {
            row.remove();
        }
        updateInformationCalculos();

    }
    // fin de eliminar


    // // 🔹 Función para construir el objeto de orden
    function buildOrderData() {
        return {
            ...getCustomerData(),
            products: quotationItems,
            services: services,
        };
    }

    // // Extraer los datos del cliente
    function getCustomerData() {
        return {
            customer_dni: document.getElementById("dni_personal").value.trim(),
            customer_names_surnames: document.getElementById("nombres_apellidos").value.trim(),
            customer_address: document.getElementById("direccion").value.trim(),
            districts_id: document.getElementById("districts_id").value,
            mechanics_id: document.getElementById("mechanics_id").value,
            payments_id: document.getElementById("paymentType").value,
            order_date: document.getElementById("orderDate").value,
            currency: document.getElementById("orderCurrency").value,
            document_type_id: document.getElementById("documentType").value,
            companies_id: document.getElementById("companies_id").value,
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
                        title: 'Error',
                        text: 'No se pudo encontrar el DNI',
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
