@props(['tabId', 'regions', 'paymentsMethod', 'documentTypes', 'companies', 'paymentsType', 'tiendas'])

<div class="container mx-auto p-2 text-sm" id="sale-form-{{ $tabId }}">
    <div class="grid grid-cols-3 gap-6">
        <!-- Formulario de Cliente -->
        <div class="col-span-2 bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-bold mb-4">Cliente</h2>
            <input type="text" id="dni_personal_{{ $tabId }}" placeholder="Ingrese Documento"
                class="w-full p-2 border rounded mb-2">
            <input type="text" placeholder="Nombre del cliente" id="nombres_apellidos_{{ $tabId }}"
                class="w-full p-2 border rounded mb-2">
            <input type="text" placeholder="Direccion del cliente" id="direccion_{{ $tabId }}"
                class="w-full p-2 border rounded mb-2">
            <select name="region" id="regions_id_{{ $tabId }}" class="w-3/12 p-2 border rounded">
                <option value="todos">Seleccione un Departamento</option>
                @foreach ($regions as $region)
                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                @endforeach
            </select>
            <select name="" id="provinces_id_{{ $tabId }}" class="w-3/12 p-2 border rounded" disabled>
                <option value="todos">Seleccione una opción</option>
            </select>
            <select name="" id="districts_id_{{ $tabId }}" class="w-3/12 p-2 border rounded" disabled>
                <option value="todos">Seleccione una opción</option>
            </select>
            <!-- Botón que abre el modal -->
            <button class="bg-yellow-400 p-2 rounded w-3/12" id="buscarProductos_{{ $tabId }}">Consultar Productos</button>
            <div class="relative">
                <label for="service_{{ $tabId }}" class="block font-medium text-gray-700">Servicio</label>
                <input type="text" id="service_{{ $tabId }}" name="service" value="{{ old('service', 'TALLER') }}"
                    class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm" autocomplete="off">

                <!-- Dropdown de Sugerencias -->
                <div id="serviceDropdown_{{ $tabId }}"
                    class="absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-lg hidden">
                    <ul id="serviceSuggestions_{{ $tabId }}" class="max-h-40 overflow-y-auto"></ul>
                </div>
            </div>

            <div class="mt-3">
                <label for="service_price_{{ $tabId }}" class="block font-medium text-gray-700">Precio del Servicio</label>
                <input type="number" id="service_price_{{ $tabId }}" name="service_price" value="{{ old('service_price', 60) }}"
                    class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm">
            </div>

            <button type="button" id="addService_{{ $tabId }}" class="bg-blue-500 text-white px-4 py-2 mt-3 rounded-md">Agregar
                Servicio</button>
            <div id="modalMecanicos_{{ $tabId }}"
                class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center z-50">
                <div class="bg-white p-6 rounded-lg shadow-md w-1/3">
                    <h3 class="text-xl font-semibold mb-4">Mecánicos Disponibles</h3>
                    <div id="listaMecanicosModal_{{ $tabId }}"></div>
                    <button onclick="closeModalTab('modalMecanicos_{{ $tabId }}')"
                        class="mt-4 px-4 py-2 bg-red-500 text-white rounded-lg">Cerrar</button>
                </div>
            </div>
            <div>
                <div class="flex mt-2">
                    <input name="datos_mecanico" id="datos_mecanico_{{ $tabId }}" type="text"
                        class="block w-6/12  border border-gray-300 rounded-md shadow-sm" readonly>
                    <input name="mechanics_id" id="mechanics_id_{{ $tabId }}" type="hidden"
                        class="block w-full  border border-gray-300 rounded-md shadow-sm">
                    <button onclick="eliminarMecanicoTab('{{ $tabId }}')" type="button"
                        class="px-4 py-2 bg-red-500 text-white rounded-lg mr-11">X</button>
                    <button onclick="mostrarModalMecanicos('{{ $tabId }}')" type="button"
                        class="px-4 py-2 bg-green-500 text-white rounded-lg  whitespace-nowrap">Seleccionar
                        Mecánico</button>

                </div>
            </div>
            <!-- Modal de Productos -->
            <div id="buscarProductosModal_{{ $tabId }}"
                class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 p-4 hidden z-50">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-4xl w-full">
                    <h3 class="text-lg font-bold mb-4">Productos</h3>

                    <!-- Campo de búsqueda dentro del modal -->
                    <div class="mb-4 flex items-center ">
                        <div class="w-8/12">
                            <input type="text" placeholder="Buscar por nombre del producto..."
                                class="w-full p-2 border rounded" id="searchProduct_{{ $tabId }}">
                        </div>
                        <div>
                            <button class="bg-blue-500 text-white px-4 py-2  rounded-md rounded-l-none mr-5"
                                id="btnBuscarProduct_{{ $tabId }}">Buscar</button>
                        </div>
                        <div class="w-3/12">
                            <label for="tienda_id_{{ $tabId }}" class="block font-medium text-gray-700">Tienda</label>
                            <select id="tienda_id_{{ $tabId }}" name="tienda_id"
                                class="block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                                <option value="todos">Todas</option>
                                @foreach ($tiendas as $tienda)
                                    <option value="{{ $tienda->id }}">{{ $tienda->nombre }}</option>
                                @endforeach
                            </select>

                        </div>

                    </div>

                    <!-- Tabla con los productos -->
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
                            <tbody id="productTable_{{ $tabId }}">
                                <!-- Productos generados dinámicamente -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Botón de cerrar modal -->
                    <button class="mt-4 bg-red-500 text-white px-4 py-2 rounded"
                        onclick="closeModalTab('buscarProductosModal_{{ $tabId }}')">Cerrar</button>
                </div>
            </div>
        </div>
        <!-- Detalle del Pedido -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-bold mb-4">Documento</h2>
            <div>
                <label class="font-bold">Empresa </label>
                <!-- Se agrega id para capturar el valor -->
                <select id="companies_id_{{ $tabId }}" class="w-full p-2 border rounded">
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
                <select id="paymentType_{{ $tabId }}" class="w-full p-2 border rounded">
                    <option value="">Seleccione</option>
                    @foreach ($paymentsType as $payment)
                        <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                    @endforeach
                </select>
            </div>
            <!-- Campos adicionales ocultos -->
            <div id="creditFields_{{ $tabId }}" class="mt-3 hidden">
                <label for="nro_dias_{{ $tabId }}">Número de días:</label>
                <input type="number" id="nro_dias_{{ $tabId }}" class="w-full p-2 border rounded" min="1">

                <label for="fecha_vencimiento_{{ $tabId }}" class="mt-2">Fecha de vencimiento:</label>
                <input type="date" id="fecha_vencimiento_{{ $tabId }}" class="w-full p-2 border rounded">
            </div>
            <div class="mt-3" id="paymentMethodContainer1_{{ $tabId }}">
                <label class="font-bold">Metodo pago</label>
                <!-- Se agrega id para capturar el valor -->
                <select id="paymentMethod1_{{ $tabId }}" class="w-full p-2 border rounded">
                    <option value="">Seleccione</option>
                    @foreach ($paymentsMethod as $payment)
                        <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-2" id="paymentMethodContainer2_{{ $tabId }}">
                <input type="checkbox" id="togglePaymentFields_{{ $tabId }}" class="mr-2">
                <label for="togglePaymentFields_{{ $tabId }}">Agregar método de pago y monto</label>
            </div>
            <div id="paymentFieldsContainer_{{ $tabId }}" class="mt-2 hidden">
                <div>
                    <label class="font-bold">Método de pago</label>
                    <select id="paymentMethod2_{{ $tabId }}" class="w-full p-2 border rounded">
                        <option value="">Seleccione</option>
                        @foreach ($paymentsMethod as $payment)
                            <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-2">
                    <label class="font-bold">Monto a pagar</label>
                    <input type="number" id="paymentAmount2_{{ $tabId }}" class="w-full p-2 border rounded"
                        placeholder="Ingrese el monto">
                </div>
            </div>
            <div>
                <label class="font-bold">Tipo de documento</label>
                <!-- Se agrega id para capturar el valor -->
                <select id="documentType_{{ $tabId }}" class="w-full p-2 border rounded">
                    <option value="">Seleccione</option>
                    @foreach ($documentTypes as $documentType)
                        <option value="{{ $documentType->id }}">{{ $documentType->name }}</option>
                    @endforeach
                </select>
            </div>
            <label>Fecha</label>
            <!-- Se agrega id para la fecha -->
            <input type="date" id="orderDate_{{ $tabId }}" value="{{ date('Y-m-d') }}"
                class="w-full p-2 border rounded mb-4">
            <label>Moneda</label>
            <!-- Si la moneda es fija, también se puede capturar -->
            <input type="text" id="orderCurrency_{{ $tabId }}" value="SOLES" class="w-full p-2 border rounded mb-4">
            <!-- Subtotal -->
            <div class="bg-gray-200 text-gray-800 p-1 rounded text-center text-sm font-bold mb-2">
                Subtotal: <span id="subtotalAmount_{{ $tabId }}">S/ 0.00</span>
            </div>
            <!-- IGV (18%) -->
            <div class="bg-gray-200 text-gray-800 p-1 rounded text-center text-sm font-bold mb-2">
                IGV (18%): <span id="igvAmount_{{ $tabId }}">S/ 0.00</span>
            </div>

            <div class="bg-indigo-500 text-white p-1 rounded text-center text-sm font-bold" id="totalAmount_{{ $tabId }}">
                S/ 0.00
            </div>
        </div>
    </div>

    <!-- Tabla de Productos (Detalle del Pedido) -->
    <div class="mt-6 bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-bold mb-4">Producto</h2>
        <div class="mb-4 flex items-center justify-end ">
            <div class="w-5/12">
                <input type="text" placeholder="Buscar por nombre del producto..."
                    class="w-full p-2 border rounded" id="searchProductList_{{ $tabId }}">
            </div>
        </div>

        <table class="w-full border-collapse border border-gray-300" id="orderTable_{{ $tabId }}">
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
            <tbody id="orderTableBody_{{ $tabId }}">
                <tr id="emptyRow_{{ $tabId }}">
                    <td class="border p-2 text-center" colspan="7">No hay productos agregados</td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- Tabla para listar servicios -->
    <div class="mt-5">
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2">Servicio</th>
                    <th class="border border-gray-300 px-4 py-2">Precio</th>
                    <th class="border border-gray-300 px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody id="serviceList_{{ $tabId }}">
                <!-- Aquí se agregarán los servicios -->
            </tbody>
        </table>
    </div>
</div>
