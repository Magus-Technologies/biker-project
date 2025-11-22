<x-app-layout>
    <x-breadcrumb title="Editar Pedido" parent="Pedidos" parentUrl="{{ route('pedidos.index') }}" subtitle="Editar Pedido #{{ $pedido->code }}" />

    <div class="container mx-auto p-4 text-sm">
        <div class="grid grid-cols-3 gap-6">
            <!-- Formulario de Cliente -->
            <div class="col-span-2 bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-bold mb-4">Datos del Cliente</h2>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">DNI/RUC</label>
                        <input type="text" id="customer_dni" value="{{ $pedido->customer_dni }}" placeholder="Ingrese documento" class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                        <input type="text" id="customer_phone" value="{{ $pedido->customer_phone }}" placeholder="Teléfono del cliente" class="w-full p-2 border rounded">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del Cliente</label>
                    <input type="text" id="customer_names_surnames" value="{{ $pedido->customer_names_surnames }}" placeholder="Nombre completo" class="w-full p-2 border rounded">
                </div>

                {{-- CAMPOS OPCIONALES - Descomentar si se necesitan --}}
                {{--
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                    <input type="text" id="customer_address" value="{{ $pedido->customer_address }}" placeholder="Dirección del cliente" class="w-full p-2 border rounded">
                </div>

                <div class="grid grid-cols-3 gap-2 mb-4">
                    <select id="regions_id" class="p-2 border rounded">
                        <option value="todos">Departamento</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region->id }}" {{ $pedido->district && $pedido->district->province->region_id == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                        @endforeach
                    </select>
                    <select id="provinces_id" class="p-2 border rounded">
                        <option value="todos">Provincia</option>
                    </select>
                    <select id="districts_id" class="p-2 border rounded">
                        <option value="todos">Distrito</option>
                    </select>
                </div>
                --}}

                {{-- Campos ocultos para mantener compatibilidad --}}
                <input type="hidden" id="customer_address" value="">
                <input type="hidden" id="regions_id" value="todos">
                <input type="hidden" id="provinces_id" value="todos">
                <input type="hidden" id="districts_id" value="todos">

                <!-- Botón para buscar productos -->
                <button type="button" id="buscarProductos" class="bg-yellow-400 hover:bg-yellow-500 p-2 rounded w-full mb-4">
                    <i class="bi bi-search mr-1"></i> Consultar Productos
                </button>

                {{-- SERVICIOS - OPCIONAL - Descomentar si se necesita --}}
                {{--
                <div class="border-t pt-4">
                    <h3 class="font-medium mb-2">Agregar Servicio</h3>
                    <div class="relative mb-2">
                        <input type="text" id="service_name" placeholder="Nombre del servicio" class="w-full p-2 border rounded" autocomplete="off">
                        <div id="serviceDropdown" class="absolute z-10 w-full bg-white border rounded shadow-lg hidden">
                            <ul id="serviceSuggestions" class="max-h-40 overflow-y-auto"></ul>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <input type="number" id="service_price" placeholder="Precio" class="flex-1 p-2 border rounded">
                        <button type="button" id="addService" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                            <i class="bi bi-plus-lg"></i> Agregar
                        </button>
                    </div>
                </div>
                --}}

                <!-- Mecánico -->
                <div class="border-t pt-4 mt-4">
                    <h3 class="font-medium mb-2">Mecánico (Opcional)</h3>
                    <div class="flex gap-2">
                        <input type="text" id="datos_mecanico" class="flex-1 p-2 border rounded bg-gray-50" readonly
                            value="{{ $pedido->mechanic ? $pedido->mechanic->name . ' ' . $pedido->mechanic->apellidos : '' }}"
                            placeholder="Sin mecánico asignado">
                        <input type="hidden" id="mechanics_id" value="{{ $pedido->mechanics_id }}">
                        <button type="button" onclick="eliminarMecanico()" class="bg-red-500 text-white px-3 py-2 rounded">
                            <i class="bi bi-x-lg"></i>
                        </button>
                        <button type="button" onclick="mostrarModalMecanicos()" class="bg-green-500 text-white px-3 py-2 rounded">
                            <i class="bi bi-person-plus"></i> Seleccionar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Panel Derecho - Resumen -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-bold mb-4">Detalles del Pedido</h2>

                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Código</label>
                    <input type="text" value="{{ $pedido->code }}" class="w-full p-2 border rounded bg-gray-100" readonly>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Prioridad</label>
                    <select id="priority" class="w-full p-2 border rounded">
                        <option value="normal" {{ $pedido->priority == 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="urgente" {{ $pedido->priority == 'urgente' ? 'selected' : '' }}>Urgente</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Expiración</label>
                    <input type="date" id="expires_at" value="{{ $pedido->expires_at ? \Carbon\Carbon::parse($pedido->expires_at)->format('Y-m-d') : '' }}" class="w-full p-2 border rounded">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                    <textarea id="observation" rows="3" class="w-full p-2 border rounded" placeholder="Notas adicionales...">{{ $pedido->observation }}</textarea>
                </div>

                <!-- Totales -->
                <div class="border-t pt-4">
                    <div class="bg-gray-100 p-2 rounded text-center font-bold mb-2">
                        Subtotal: <span id="subtotalAmount">S/ 0.00</span>
                    </div>
                    <div class="bg-gray-100 p-2 rounded text-center font-bold mb-2">
                        IGV (18%): <span id="igvAmount">S/ 0.00</span>
                    </div>
                    <div class="bg-indigo-500 text-white p-3 rounded text-center text-lg font-bold">
                        Total: <span id="totalAmount">S/ 0.00</span>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="mt-4 space-y-2">
                    <button type="button" onclick="actualizarPedido()" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded font-medium">
                        <i class="bi bi-save mr-1"></i> Actualizar Pedido
                    </button>
                    <a href="{{ route('pedidos.index') }}" class="block w-full bg-gray-500 hover:bg-gray-600 text-white py-3 rounded font-medium text-center">
                        <i class="bi bi-x-lg mr-1"></i> Cancelar
                    </a>
                </div>
            </div>
        </div>

        <!-- Tabla de Productos -->
        <div class="mt-6 bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-bold mb-4">Productos</h2>
            <table class="w-full border-collapse border" id="orderTable">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2">Item</th>
                        <th class="border p-2">Producto</th>
                        <th class="border p-2">Cantidad</th>
                        <th class="border p-2">P. Unit.</th>
                        <th class="border p-2">Total</th>
                        <th class="border p-2">Acciones</th>
                    </tr>
                </thead>
                <tbody id="orderTableBody">
                    <tr id="emptyRow">
                        <td class="border p-2 text-center text-gray-500" colspan="6">No hay productos agregados</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- TABLA DE SERVICIOS - OPCIONAL - Descomentar si se necesita --}}
        {{--
        <div class="mt-4 bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-bold mb-4">Servicios</h2>
            <table class="w-full border-collapse border">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2">Servicio</th>
                        <th class="border p-2">Precio</th>
                        <th class="border p-2">Acciones</th>
                    </tr>
                </thead>
                <tbody id="serviceList">
                    <tr id="emptyServiceRow">
                        <td class="border p-2 text-center text-gray-500" colspan="3">No hay servicios agregados</td>
                    </tr>
                </tbody>
            </table>
        </div>
        --}}
    </div>

    <!-- Modal de Productos -->
    <div id="buscarProductosModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 p-4 hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-4xl w-full">
            <h3 class="text-lg font-bold mb-4">Buscar Productos</h3>
            <div class="mb-4 flex gap-2">
                <input type="text" id="searchProduct" placeholder="Buscar por nombre..." class="flex-1 p-2 border rounded">
                <select id="tienda_id" class="p-2 border rounded">
                    <option value="todos">Todas las tiendas</option>
                    @foreach ($tiendas as $tienda)
                        <option value="{{ $tienda->id }}">{{ $tienda->nombre }}</option>
                    @endforeach
                </select>
                <button id="btnBuscarProduct" class="bg-blue-500 text-white px-4 py-2 rounded">Buscar</button>
            </div>
            <div class="overflow-x-auto overflow-y-auto h-80">
                <table class="min-w-full table-auto text-xs">
                    <thead class="bg-gray-200 sticky top-0">
                        <tr>
                            <th class="px-2 py-1 border">Código</th>
                            <th class="px-2 py-1 border">Descripción</th>
                            <th class="px-2 py-1 border">Ubicación</th>
                            <th class="px-2 py-1 border">Stock</th>
                            <th class="px-2 py-1 border">Cantidad</th>
                            <th class="px-2 py-1 border">Precio</th>
                            <th class="px-2 py-1 border">Subtotal</th>
                            <th class="px-2 py-1 border">Agregar</th>
                        </tr>
                    </thead>
                    <tbody id="productTable"></tbody>
                </table>
            </div>
            <button class="mt-4 bg-red-500 text-white px-4 py-2 rounded" onclick="closeModal('buscarProductosModal')">Cerrar</button>
        </div>
    </div>

    <!-- Modal de Mecánicos -->
    <div id="modalMecanicos" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-md w-1/3">
            <h3 class="text-xl font-semibold mb-4">Mecánicos Disponibles</h3>
            <div id="listaMecanicosModal"></div>
            <button onclick="closeModal('modalMecanicos')" class="mt-4 px-4 py-2 bg-red-500 text-white rounded-lg">Cerrar</button>
        </div>
    </div>

    <script>
    // Variables globales
    const token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InN5c3RlbWNyYWZ0LnBlQGdtYWlsLmNvbSJ9.yuNS5hRaC0hCwymX_PjXRoSZJWLNNBeOdlLRSUGlHGA';
    const pedidoId = {{ $pedido->id }};
    let services = [];
    let quotationItems = [];
    let products = [];
    let orderCount = 0;

    // Datos existentes del pedido
    const existingItems = @json($pedido->items);
    const existingServices = @json($pedido->services);
    const existingDistrict = @json($pedido->district);

    document.addEventListener('DOMContentLoaded', function() {
        // Cargar datos existentes
        loadExistingData();

        // Buscar DNI
        document.getElementById('customer_dni').addEventListener('input', buscarDNI);

        // UBICACIÓN - COMENTADO (campos ocultos)
        // document.getElementById('regions_id').addEventListener('change', fetchProvinces);
        // document.getElementById('provinces_id').addEventListener('change', fetchDistricts);

        // Cargar ubicación existente - COMENTADO
        // if (existingDistrict) {
        //     loadExistingLocation();
        // }

        // Productos
        document.getElementById('buscarProductos').addEventListener('click', () => {
            openModal('buscarProductosModal');
            fetchProducts();
        });
        document.getElementById('btnBuscarProduct').addEventListener('click', fetchProducts);

        // SERVICIOS - COMENTADO (sección oculta)
        // document.getElementById('service_name').addEventListener('input', searchServices);
        // document.getElementById('addService').addEventListener('click', addService);
    });

    // Cargar datos existentes
    function loadExistingData() {
        // Cargar productos existentes
        existingItems.forEach(item => {
            const product = {
                item_id: item.product_id,
                description: item.product?.description || 'Producto',
                priceId: item.product_price_id,
                unit_price: parseFloat(item.unit_price),
                quantity: parseInt(item.quantity),
                prices: item.product?.prices || [],
                maximum_stock: item.product?.stock?.quantity || 999
            };
            quotationItems.push(product);
            addProductToTable(product);
        });

        // Cargar servicios existentes
        existingServices.forEach(srv => {
            const service = {
                id: srv.id,
                name: srv.service_name,
                price: parseFloat(srv.price)
            };
            services.push(service);
        });
        updateServiceTable();

        // Actualizar cálculos
        updateCalculations();
    }

    // Cargar ubicación existente
    function loadExistingLocation() {
        const regionId = existingDistrict.province.region_id;
        const provinceId = existingDistrict.province_id;
        const districtId = existingDistrict.id;

        // Cargar provincias
        fetch(`${baseUrl}/api/provinces/${regionId}`)
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('provinces_id');
                select.innerHTML = '<option value="todos">Provincia</option>';
                data.provinces.forEach(p => {
                    select.innerHTML += `<option value="${p.id}" ${p.id == provinceId ? 'selected' : ''}>${p.name}</option>`;
                });

                // Cargar distritos
                return fetch(`${baseUrl}/api/districts/${provinceId}`);
            })
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('districts_id');
                select.innerHTML = '<option value="todos">Distrito</option>';
                data.districts.forEach(d => {
                    select.innerHTML += `<option value="${d.id}" ${d.id == districtId ? 'selected' : ''}>${d.name}</option>`;
                });
            });
    }

    // Funciones de Modal
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    // Buscar DNI
    function buscarDNI() {
        const dni = document.getElementById('customer_dni').value;
        if (dni.length === 8) {
            fetch(`https://dniruc.apisperu.com/api/v1/dni/${dni}?token=${token}`)
                .then(response => response.json())
                .then(data => {
                    if (data.nombres) {
                        document.getElementById('customer_names_surnames').value =
                            data.apellidoPaterno + ' ' + data.apellidoMaterno + ' ' + data.nombres;
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }

    // Ubicación
    function fetchProvinces() {
        const regionId = document.getElementById('regions_id').value;
        if (regionId !== 'todos') {
            fetch(`${baseUrl}/api/provinces/${regionId}`)
                .then(response => response.json())
                .then(data => {
                    const select = document.getElementById('provinces_id');
                    select.disabled = false;
                    select.innerHTML = '<option value="todos">Provincia</option>';
                    data.provinces.forEach(p => {
                        select.innerHTML += `<option value="${p.id}">${p.name}</option>`;
                    });
                    document.getElementById('districts_id').innerHTML = '<option value="todos">Distrito</option>';
                    document.getElementById('districts_id').disabled = true;
                });
        }
    }

    function fetchDistricts() {
        const provinceId = document.getElementById('provinces_id').value;
        if (provinceId !== 'todos') {
            fetch(`${baseUrl}/api/districts/${provinceId}`)
                .then(response => response.json())
                .then(data => {
                    const select = document.getElementById('districts_id');
                    select.disabled = false;
                    select.innerHTML = '<option value="todos">Distrito</option>';
                    data.districts.forEach(d => {
                        select.innerHTML += `<option value="${d.id}">${d.name}</option>`;
                    });
                });
        }
    }

    // Mecánicos
    function mostrarModalMecanicos() {
        openModal('modalMecanicos');
        fetch(`${baseUrl}/quotation/mecanicos-disponibles`)
            .then(response => response.json())
            .then(data => {
                let html = '';
                data.forEach(m => {
                    html += `
                        <div class="flex justify-between items-center p-2 border-b">
                            <span>${m.name} ${m.apellidos}</span>
                            <button onclick="seleccionarMecanico(${m.id}, '${m.name} ${m.apellidos}')"
                                class="px-3 py-1 bg-blue-500 text-white rounded">Asignar</button>
                        </div>
                    `;
                });
                document.getElementById('listaMecanicosModal').innerHTML = html;
            });
    }

    function seleccionarMecanico(id, nombre) {
        document.getElementById('mechanics_id').value = id;
        document.getElementById('datos_mecanico').value = nombre;
        closeModal('modalMecanicos');
    }

    function eliminarMecanico() {
        document.getElementById('mechanics_id').value = '';
        document.getElementById('datos_mecanico').value = '';
    }

    // Servicios
    function searchServices() {
        const query = document.getElementById('service_name').value.trim();
        const dropdown = document.getElementById('serviceDropdown');
        const list = document.getElementById('serviceSuggestions');

        if (query === '') {
            dropdown.classList.add('hidden');
            return;
        }

        fetch(`${baseUrl}/api/services?query=${query}`)
            .then(response => response.json())
            .then(data => {
                list.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(s => {
                        const li = document.createElement('li');
                        li.textContent = `${s.name} - S/ ${s.default_price}`;
                        li.className = 'cursor-pointer p-2 hover:bg-gray-100';
                        li.onclick = () => {
                            document.getElementById('service_name').value = s.name;
                            document.getElementById('service_price').value = s.default_price;
                            dropdown.classList.add('hidden');
                        };
                        list.appendChild(li);
                    });
                    dropdown.classList.remove('hidden');
                } else {
                    dropdown.classList.add('hidden');
                }
            });
    }

    function addService() {
        const name = document.getElementById('service_name').value.trim();
        const price = document.getElementById('service_price').value.trim();

        if (!name || !price) {
            Swal.fire('Error', 'Complete nombre y precio del servicio', 'warning');
            return;
        }

        const service = { id: Date.now(), name, price: parseFloat(price) };
        services.push(service);
        updateServiceTable();
        updateCalculations();

        document.getElementById('service_name').value = '';
        document.getElementById('service_price').value = '';
    }

    function updateServiceTable() {
        const tbody = document.getElementById('serviceList');
        // Si la tabla no existe (comentada), salir
        if (!tbody) return;

        tbody.innerHTML = '';

        if (services.length === 0) {
            tbody.innerHTML = '<tr><td class="border p-2 text-center text-gray-500" colspan="3">No hay servicios agregados</td></tr>';
            return;
        }

        services.forEach(s => {
            tbody.innerHTML += `
                <tr>
                    <td class="border p-2">${s.name}</td>
                    <td class="border p-2 text-right">S/ ${s.price.toFixed(2)}</td>
                    <td class="border p-2 text-center">
                        <button onclick="deleteService(${s.id})" class="bg-red-500 text-white px-2 py-1 rounded">Eliminar</button>
                    </td>
                </tr>
            `;
        });
    }

    function deleteService(id) {
        services = services.filter(s => s.id !== id);
        updateServiceTable();
        updateCalculations();
    }

    // Productos
    function fetchProducts() {
        const tiendaId = document.getElementById('tienda_id').value;
        const search = document.getElementById('searchProduct').value;

        fetch(`${baseUrl}/api/product?tienda_id=${tiendaId}&search=${search}`)
            .then(res => res.json())
            .then(data => {
                products = data.filter(p => !quotationItems.some(i => i.item_id === p.id));
                renderProducts();
            });
    }

    function renderProducts() {
        const tbody = document.getElementById('productTable');
        tbody.innerHTML = '';

        products.forEach(p => {
            tbody.innerHTML += `
                <tr>
                    <td class="px-2 py-1 border">${p.code_sku}</td>
                    <td class="px-2 py-1 border">${p.description}</td>
                    <td class="px-2 py-1 border">${p.location || '-'}</td>
                    <td class="px-2 py-1 border">${p.stock?.quantity || 0}</td>
                    <td class="px-2 py-1 border">
                        <input type="number" id="qty_${p.id}" value="1" min="1" max="${p.stock?.quantity || 0}" class="w-16 p-1 border rounded" onchange="updateSubtotal(${p.id})">
                    </td>
                    <td class="px-2 py-1 border">
                        <select id="price_${p.id}" class="p-1 border rounded" onchange="updateSubtotal(${p.id})">
                            <option value="">Seleccionar</option>
                            ${p.prices.map(pr => `<option value="${pr.price}" data-id="${pr.id}">${pr.type} - S/${pr.price}</option>`).join('')}
                        </select>
                    </td>
                    <td class="px-2 py-1 border" id="subtotal_${p.id}">0.00</td>
                    <td class="px-2 py-1 border">
                        <button onclick="agregarProducto(${p.id})" class="bg-blue-500 text-white px-2 py-1 rounded">Agregar</button>
                    </td>
                </tr>
            `;
        });
    }

    function updateSubtotal(productId) {
        const qty = parseInt(document.getElementById(`qty_${productId}`).value) || 0;
        const price = parseFloat(document.getElementById(`price_${productId}`).value) || 0;
        document.getElementById(`subtotal_${productId}`).textContent = (qty * price).toFixed(2);
    }

    function agregarProducto(productId) {
        const qty = document.getElementById(`qty_${productId}`).value;
        const priceSelect = document.getElementById(`price_${productId}`);
        const priceId = priceSelect.options[priceSelect.selectedIndex]?.dataset.id;
        const price = priceSelect.value;

        if (!price) {
            Swal.fire('Error', 'Seleccione un precio', 'warning');
            return;
        }

        const product = products.find(p => p.id === productId);
        if (product) {
            quotationItems.push({
                item_id: productId,
                description: product.description,
                priceId: priceId,
                unit_price: parseFloat(price),
                quantity: parseInt(qty),
                prices: product.prices,
                maximum_stock: product.stock?.quantity || 0
            });

            addProductToTable(quotationItems[quotationItems.length - 1]);
            updateCalculations();

            products = products.filter(p => p.id !== productId);
            renderProducts();
        }
    }

    function addProductToTable(product) {
        const emptyRow = document.getElementById('emptyRow');
        if (emptyRow) emptyRow.remove();

        orderCount++;
        const tbody = document.getElementById('orderTableBody');
        tbody.innerHTML += `
            <tr data-id="${product.item_id}">
                <td class="border p-2 text-center">${orderCount}</td>
                <td class="border p-2">${product.description}</td>
                <td class="border p-2">
                    <input type="number" value="${product.quantity}" min="1" max="${product.maximum_stock}"
                        class="w-16 p-1 border rounded" onchange="updateProductQty(${product.item_id}, this.value)">
                </td>
                <td class="border p-2 text-right">S/ ${product.unit_price.toFixed(2)}</td>
                <td class="border p-2 text-right" id="productTotal_${product.item_id}">S/ ${(product.quantity * product.unit_price).toFixed(2)}</td>
                <td class="border p-2 text-center">
                    <button onclick="deleteProduct(${product.item_id})" class="bg-red-500 text-white px-2 py-1 rounded">Eliminar</button>
                </td>
            </tr>
        `;
    }

    function updateProductQty(productId, qty) {
        const item = quotationItems.find(i => i.item_id === productId);
        if (item) {
            item.quantity = parseInt(qty);
            document.getElementById(`productTotal_${productId}`).textContent = `S/ ${(item.quantity * item.unit_price).toFixed(2)}`;
            updateCalculations();
        }
    }

    function deleteProduct(productId) {
        quotationItems = quotationItems.filter(i => i.item_id !== productId);
        const row = document.querySelector(`tr[data-id="${productId}"]`);
        if (row) row.remove();

        if (quotationItems.length === 0) {
            document.getElementById('orderTableBody').innerHTML =
                '<tr id="emptyRow"><td class="border p-2 text-center text-gray-500" colspan="6">No hay productos agregados</td></tr>';
        }
        updateCalculations();
    }

    // Cálculos
    function updateCalculations() {
        let total = 0;
        quotationItems.forEach(i => total += i.quantity * i.unit_price);
        services.forEach(s => total += s.price);

        const igv = total * 0.18;
        const subtotal = total - igv;

        document.getElementById('subtotalAmount').textContent = `S/ ${subtotal.toFixed(2)}`;
        document.getElementById('igvAmount').textContent = `S/ ${igv.toFixed(2)}`;
        document.getElementById('totalAmount').textContent = `S/ ${total.toFixed(2)}`;
    }

    // Actualizar pedido
    function actualizarPedido() {
        const data = {
            customer_dni: document.getElementById('customer_dni').value,
            customer_names_surnames: document.getElementById('customer_names_surnames').value,
            customer_phone: document.getElementById('customer_phone').value,
            customer_address: document.getElementById('customer_address').value,
            districts_id: document.getElementById('districts_id').value,
            mechanics_id: document.getElementById('mechanics_id').value,
            priority: document.getElementById('priority').value,
            expires_at: document.getElementById('expires_at').value,
            observation: document.getElementById('observation').value,
            products: quotationItems.map(i => ({
                item_id: i.item_id,
                priceId: i.priceId,
                quantity: i.quantity,
                unit_price: i.unit_price
            })),
            services: services.map(s => ({
                name: s.name,
                price: s.price
            }))
        };

        // Validaciones
        if (!data.customer_names_surnames) {
            Swal.fire('Error', 'Ingrese el nombre del cliente', 'warning');
            return;
        }

        if (data.products.length === 0) {
            Swal.fire('Error', 'Agregue al menos un producto', 'warning');
            return;
        }

        Swal.fire({
            title: 'Actualizando pedido...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        fetch(`${baseUrl}/pedidos/${pedidoId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Pedido actualizado',
                    text: result.message,
                    confirmButtonColor: '#10b981'
                }).then(() => {
                    window.location.href = `${baseUrl}/pedidos`;
                });
            } else {
                Swal.fire('Error', result.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Ocurrió un error al actualizar', 'error');
        });
    }
    </script>
</x-app-layout>
