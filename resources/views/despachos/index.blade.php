<x-app-layout>
    <x-breadcrumb title="Despachos" parent="Ventas" parentUrl="{{ route('sales.index') }}" subtitle="Control de Entregas" />

    <div class="px-3 py-4">
        <!-- Estadísticas -->
        <div class="grid grid-cols-2 gap-3 mb-4">
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="text-yellow-600 text-sm font-medium">Pendientes de Entrega</div>
                <div class="text-3xl font-bold text-yellow-700">{{ $ventasPendientes->count() }}</div>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="text-green-600 text-sm font-medium">Entregados (últimos 50)</div>
                <div class="text-3xl font-bold text-green-700">{{ $ventasEntregadas->count() }}</div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white rounded-lg shadow">
            <div class="border-b">
                <nav class="flex">
                    <button onclick="showTab('pendientes')" id="tab-pendientes"
                        class="px-6 py-3 text-sm font-medium border-b-2 border-yellow-500 text-yellow-600">
                        Pendientes ({{ $ventasPendientes->count() }})
                    </button>
                    <button onclick="showTab('entregados')" id="tab-entregados"
                        class="px-6 py-3 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700">
                        Entregados ({{ $ventasEntregadas->count() }})
                    </button>
                </nav>
            </div>

            <!-- Tab Pendientes -->
            <div id="content-pendientes" class="p-4">
                @if($ventasPendientes->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left">Serie-Número</th>
                                <th class="px-4 py-3 text-left">Cliente</th>
                                <th class="px-4 py-3 text-left">Dirección</th>
                                <th class="px-4 py-3 text-left">Distrito</th>
                                <th class="px-4 py-3 text-right">Total</th>
                                <th class="px-4 py-3 text-left">Fecha Venta</th>
                                <th class="px-4 py-3 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ventasPendientes as $venta)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium">{{ $venta->serie }}-{{ $venta->number }}</td>
                                <td class="px-4 py-3">{{ $venta->customer_names_surnames }}</td>
                                <td class="px-4 py-3">{{ $venta->customer_address ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    @if($venta->district)
                                        {{ $venta->district->name }}
                                        @if($venta->district->province)
                                            , {{ $venta->district->province->name }}
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right font-medium">S/ {{ number_format($venta->total_price, 2) }}</td>
                                <td class="px-4 py-3">{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Ver/Editar detalles -->
                                        <button onclick="verDetalles({{ $venta->id }})" 
                                            class="text-blue-600 hover:text-blue-800 p-1" 
                                            title="Ver/Editar detalles">
                                            <i class="bi bi-eye text-lg"></i>
                                        </button>
                                        
                                        <!-- Generar PDF -->
                                        <a href="{{ route('sales.pdf', $venta->id) }}" 
                                            target="_blank"
                                            class="text-red-600 hover:text-red-800 p-1" 
                                            title="Generar PDF">
                                            <i class="bi bi-file-pdf text-lg"></i>
                                        </a>
                                        
                                        <!-- Marcar Entregado -->
                                        <button onclick="marcarEntregado({{ $venta->id }})"
                                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs whitespace-nowrap">
                                            <i class="bi bi-check-lg mr-1"></i> Marcar Entregado
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-8 text-gray-500">
                    <i class="bi bi-check-circle text-4xl text-green-500"></i>
                    <p class="mt-2">No hay ventas pendientes de entrega</p>
                </div>
                @endif
            </div>

            <!-- Tab Entregados -->
            <div id="content-entregados" class="p-4 hidden">
                @if($ventasEntregadas->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left">Serie-Número</th>
                                <th class="px-4 py-3 text-left">Cliente</th>
                                <th class="px-4 py-3 text-left">Dirección</th>
                                <th class="px-4 py-3 text-right">Total</th>
                                <th class="px-4 py-3 text-left">Fecha Entrega</th>
                                <th class="px-4 py-3 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ventasEntregadas as $venta)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium">{{ $venta->serie }}-{{ $venta->number }}</td>
                                <td class="px-4 py-3">{{ $venta->customer_names_surnames }}</td>
                                <td class="px-4 py-3">{{ $venta->customer_address ?? '-' }}</td>
                                <td class="px-4 py-3 text-right font-medium">S/ {{ number_format($venta->total_price, 2) }}</td>
                                <td class="px-4 py-3">
                                    @if($venta->delivered_at)
                                        {{ \Carbon\Carbon::parse($venta->delivered_at)->format('d/m/Y H:i') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <button onclick="marcarPendiente({{ $venta->id }})"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">
                                        <i class="bi bi-arrow-counterclockwise mr-1"></i> Revertir
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-8 text-gray-500">
                    <i class="bi bi-box-seam text-4xl"></i>
                    <p class="mt-2">No hay entregas registradas</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Ver/Editar Detalles del Despacho -->
    <div id="modalDetalles" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center p-4" style="z-index: 9999;">
        <div class="bg-white rounded-lg shadow-xl max-w-6xl w-full max-h-[90vh] overflow-hidden">
            <!-- Header -->
            <div class="bg-blue-600 text-white px-6 py-4 flex justify-between items-center">
                <h3 class="text-xl font-semibold">
                    <i class="bi bi-box-seam mr-2"></i>
                    Detalles del Despacho - <span id="modalSerieNumero"></span>
                </h3>
                <button onclick="cerrarModal()" class="text-white hover:text-gray-200">
                    <i class="bi bi-x-lg text-2xl"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="p-6 overflow-y-auto" style="max-height: calc(90vh - 140px);">
                <!-- Info del Cliente -->
                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                    <h4 class="font-semibold text-gray-700 mb-2">Información del Cliente</h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Cliente:</span>
                            <span class="font-medium ml-2" id="modalCliente"></span>
                        </div>
                        <div>
                            <span class="text-gray-600">Dirección:</span>
                            <span class="font-medium ml-2" id="modalDireccion"></span>
                        </div>
                        <div>
                            <span class="text-gray-600">Distrito:</span>
                            <span class="font-medium ml-2" id="modalDistrito"></span>
                        </div>
                        <div>
                            <span class="text-gray-600">Total:</span>
                            <span class="font-medium ml-2 text-green-600" id="modalTotal"></span>
                        </div>
                    </div>
                </div>

                <!-- Tabla de Productos -->
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="font-semibold text-gray-700">Productos del Despacho</h4>
                        <button onclick="abrirModalProductos()" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                            <i class="bi bi-plus-lg mr-1"></i> Agregar Producto
                        </button>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-3 py-2 text-left">Producto</th>
                                    <th class="px-3 py-2 text-left">Código</th>
                                    <th class="px-3 py-2 text-center">Cantidad Vendida</th>
                                    <th class="px-3 py-2 text-right">Precio Venta</th>
                                    <th class="px-3 py-2 text-right">Precio Nivel</th>
                                    <th class="px-3 py-2 text-right">Total Unidad</th>
                                    <th class="px-3 py-2 text-left">Ubicación</th>
                                    <th class="px-3 py-2 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaProductosDespacho">
                                <!-- Se llenará dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 border-t">
                <button onclick="cerrarModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Cancelar
                </button>
                <button onclick="guardarDespacho()" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                    <i class="bi bi-save mr-1"></i> Guardar Cambios
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Buscar Productos -->
    <div id="modalBuscarProductos" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center p-4" style="z-index: 10000;">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-5xl w-full max-h-[90vh] overflow-hidden">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold">Buscar Productos</h3>
                <button onclick="cerrarModalProductos()" class="text-gray-500 hover:text-gray-700">
                    <i class="bi bi-x-lg text-2xl"></i>
                </button>
            </div>

            <!-- Búsqueda -->
            <div class="mb-4 flex items-center gap-3">
                <div class="flex-1">
                    <input type="text" placeholder="Buscar por nombre, código..." 
                        class="w-full p-2 border rounded" id="searchProductDespacho">
                </div>
                <button class="bg-blue-500 text-white px-4 py-2 rounded" onclick="buscarProductosDespacho()">
                    <i class="bi bi-search mr-1"></i> Buscar
                </button>
                <div class="w-48">
                    <select id="tienda_id_despacho" class="w-full p-2 border rounded">
                        <option value="todos">Todas las tiendas</option>
                        @foreach ($tiendas ?? [] as $tienda)
                            <option value="{{ $tienda->id }}">{{ $tienda->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Tabla de productos -->
            <div class="overflow-x-auto overflow-y-auto" style="max-height: 60vh;">
                <table class="min-w-full table-auto text-xs">
                    <thead class="bg-gray-200 sticky top-0">
                        <tr>
                            <th class="px-2 py-1 border">Código</th>
                            <th class="px-2 py-1 border">Descripción</th>
                            <th class="px-2 py-1 border">Ubicación</th>
                            <th class="px-2 py-1 border">Stock</th>
                            <th class="px-2 py-1 border">Stock Mín</th>
                            <th class="px-2 py-1 border">Cantidad</th>
                            <th class="px-2 py-1 border">Precio</th>
                            <th class="px-2 py-1 border">Subtotal</th>
                            <th class="px-2 py-1 border">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="tablaProductosBusqueda">
                        <tr>
                            <td colspan="9" class="text-center py-4 text-gray-500">
                                Busca productos para agregar al despacho
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex justify-end">
                <button onclick="cerrarModalProductos()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    <script>
    let ventaActual = null;
    let productosDespacho = [];

    function showTab(tab) {
        // Ocultar todos los contenidos
        document.getElementById('content-pendientes').classList.add('hidden');
        document.getElementById('content-entregados').classList.add('hidden');

        // Resetear estilos de tabs
        document.getElementById('tab-pendientes').classList.remove('border-yellow-500', 'text-yellow-600');
        document.getElementById('tab-pendientes').classList.add('border-transparent', 'text-gray-500');
        document.getElementById('tab-entregados').classList.remove('border-green-500', 'text-green-600');
        document.getElementById('tab-entregados').classList.add('border-transparent', 'text-gray-500');

        // Mostrar tab seleccionado
        document.getElementById('content-' + tab).classList.remove('hidden');

        if (tab === 'pendientes') {
            document.getElementById('tab-pendientes').classList.add('border-yellow-500', 'text-yellow-600');
            document.getElementById('tab-pendientes').classList.remove('border-transparent', 'text-gray-500');
        } else {
            document.getElementById('tab-entregados').classList.add('border-green-500', 'text-green-600');
            document.getElementById('tab-entregados').classList.remove('border-transparent', 'text-gray-500');
        }
    }

    function marcarEntregado(saleId) {
        Swal.fire({
            title: '¿Marcar como entregado?',
            text: 'Esta venta se moverá a la lista de entregados',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sí, marcar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`${baseUrl}/despacho/marcar-entregado`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ sale_id: saleId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Entregado',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Ocurrió un error', 'error');
                });
            }
        });
    }

    function marcarPendiente(saleId) {
        Swal.fire({
            title: '¿Revertir a pendiente?',
            text: 'Esta venta volverá a la lista de pendientes',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f59e0b',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sí, revertir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`${baseUrl}/despacho/marcar-pendiente`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ sale_id: saleId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Revertido',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Ocurrió un error', 'error');
                });
            }
        });
    }

    // Ver detalles del despacho
    function verDetalles(saleId) {
        fetch(`${baseUrl}/despacho/detalles/${saleId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    ventaActual = data.venta;
                    productosDespacho = data.productos || [];
                    
                    // Llenar información
                    document.getElementById('modalSerieNumero').textContent = `${data.venta.serie}-${data.venta.number}`;
                    document.getElementById('modalCliente').textContent = data.venta.customer_names_surnames || '-';
                    document.getElementById('modalDireccion').textContent = data.venta.customer_address || '-';
                    document.getElementById('modalDistrito').textContent = data.venta.distrito || '-';
                    document.getElementById('modalTotal').textContent = `S/ ${parseFloat(data.venta.total_price).toFixed(2)}`;
                    
                    // Llenar tabla de productos
                    renderProductosDespacho();
                    
                    // Mostrar modal
                    document.getElementById('modalDetalles').classList.remove('hidden');
                } else {
                    Swal.fire('Error', data.message || 'No se pudieron cargar los detalles', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Ocurrió un error al cargar los detalles', 'error');
            });
    }

    // Renderizar productos en la tabla
    function renderProductosDespacho() {
        const tbody = document.getElementById('tablaProductosDespacho');
        tbody.innerHTML = '';
        
        if (productosDespacho.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="text-center py-4 text-gray-500">No hay productos</td></tr>';
            return;
        }
        
        productosDespacho.forEach((producto, index) => {
            const row = `
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-3 py-2">${producto.description || producto.producto || '-'}</td>
                    <td class="px-3 py-2">${producto.code_sku || producto.codigo || '-'}</td>
                    <td class="px-3 py-2 text-center">
                        <input type="number" value="${producto.quantity || 1}" min="1" 
                            onchange="actualizarCantidad(${index}, this.value)"
                            class="w-20 px-2 py-1 border rounded text-center">
                    </td>
                    <td class="px-3 py-2 text-right">${parseFloat(producto.unit_price || 0).toFixed(2)}</td>
                    <td class="px-3 py-2 text-right">${parseFloat(producto.precio_nivel || 0).toFixed(2)}</td>
                    <td class="px-3 py-2 text-right font-medium">${(parseFloat(producto.unit_price || 0) * parseInt(producto.quantity || 1)).toFixed(2)}</td>
                    <td class="px-3 py-2">${producto.location || producto.ubicacion || '-'}</td>
                    <td class="px-3 py-2 text-center">
                        <button onclick="eliminarProductoDespacho(${index})" 
                            class="text-red-600 hover:text-red-800 p-1" 
                            title="Eliminar">
                            <i class="bi bi-trash text-lg"></i>
                        </button>
                    </td>
                </tr>
            `;
            tbody.innerHTML += row;
        });
    }

    // Actualizar cantidad de producto
    function actualizarCantidad(index, nuevaCantidad) {
        productosDespacho[index].quantity = parseInt(nuevaCantidad);
        renderProductosDespacho();
    }

    // Eliminar producto del despacho
    function eliminarProductoDespacho(index) {
        Swal.fire({
            title: '¿Eliminar producto?',
            text: 'Este producto se quitará del despacho',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                productosDespacho.splice(index, 1);
                renderProductosDespacho();
                Swal.fire({
                    icon: 'success',
                    title: 'Eliminado',
                    text: 'Producto eliminado del despacho',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    }

    // Abrir modal de productos
    function abrirModalProductos() {
        document.getElementById('modalBuscarProductos').classList.remove('hidden');
        buscarProductosDespacho();
    }

    // Cerrar modal de productos
    function cerrarModalProductos() {
        document.getElementById('modalBuscarProductos').classList.add('hidden');
    }

    // Buscar productos
    function buscarProductosDespacho() {
        const query = document.getElementById('searchProductDespacho').value;
        const tiendaId = document.getElementById('tienda_id_despacho').value;
        
        fetch(`${baseUrl}/api/product?tienda_id=${tiendaId}&search=${query}`)
            .then(response => response.json())
            .then(productos => {
                const tbody = document.getElementById('tablaProductosBusqueda');
                tbody.innerHTML = '';
                
                if (productos.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="9" class="text-center py-4 text-gray-500">No se encontraron productos</td></tr>';
                    return;
                }
                
                productos.forEach(producto => {
                    const stockActual = producto.stock?.quantity ?? 0;
                    const stockMinimo = producto.stock?.minimum_stock ?? 0;
                    const sinStock = stockActual === 0;
                    const stockBajo = stockActual > 0 && stockActual <= stockMinimo;
                    
                    const row = `
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-2 py-1">${producto.code_sku}</td>
                            <td class="px-2 py-1">${producto.description}</td>
                            <td class="px-2 py-1">${producto.location || '-'}</td>
                            <td class="px-2 py-1 text-center ${sinStock ? 'bg-red-100 text-red-700 font-bold' : stockBajo ? 'bg-yellow-100 text-yellow-700' : ''}">${stockActual}</td>
                            <td class="px-2 py-1 text-center">${stockMinimo}</td>
                            <td class="px-2 py-1">
                                <input type="number" value="1" min="1" max="${stockActual}" 
                                    class="w-16 px-2 py-1 border rounded text-center" 
                                    id="qty_${producto.id}" ${sinStock ? 'disabled' : ''}>
                            </td>
                            <td class="px-2 py-1">
                                <select class="w-32 px-2 py-1 border rounded text-xs" id="price_${producto.id}" ${sinStock ? 'disabled' : ''}>
                                    <option value="">Seleccionar</option>
                                    ${producto.prices.map(p => `<option value="${p.price}">${p.type} - ${p.price}</option>`).join('')}
                                </select>
                            </td>
                            <td class="px-2 py-1 text-right" id="subtotal_${producto.id}">0.00</td>
                            <td class="px-2 py-1 text-center">
                                <button onclick="agregarProductoAlDespacho(${producto.id}, '${producto.description}', '${producto.code_sku}', '${producto.location || '-'}')" 
                                    class="bg-blue-500 text-white px-2 py-1 rounded text-xs ${sinStock ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-600'}" 
                                    ${sinStock ? 'disabled' : ''}>
                                    Agregar
                                </button>
                            </td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                    
                    // Eventos para calcular subtotal
                    setTimeout(() => {
                        const qtyInput = document.getElementById(`qty_${producto.id}`);
                        const priceSelect = document.getElementById(`price_${producto.id}`);
                        
                        if (qtyInput && priceSelect) {
                            qtyInput.addEventListener('input', () => calcularSubtotalProducto(producto.id));
                            priceSelect.addEventListener('change', () => calcularSubtotalProducto(producto.id));
                        }
                    }, 100);
                });
            });
    }

    // Calcular subtotal de producto
    function calcularSubtotalProducto(productoId) {
        const qty = parseInt(document.getElementById(`qty_${productoId}`).value) || 0;
        const price = parseFloat(document.getElementById(`price_${productoId}`).value) || 0;
        const subtotal = qty * price;
        document.getElementById(`subtotal_${productoId}`).textContent = subtotal.toFixed(2);
    }

    // Agregar producto al despacho
    function agregarProductoAlDespacho(productoId, descripcion, codigo, ubicacion) {
        const qty = parseInt(document.getElementById(`qty_${productoId}`).value) || 1;
        const price = parseFloat(document.getElementById(`price_${productoId}`).value);
        
        if (!price) {
            Swal.fire({
                icon: 'warning',
                title: 'Selecciona un precio',
                text: 'Debes seleccionar un precio antes de agregar',
                timer: 2000
            });
            return;
        }
        
        productosDespacho.push({
            item_id: productoId,
            description: descripcion,
            code_sku: codigo,
            quantity: qty,
            unit_price: price,
            precio_nivel: price,
            location: ubicacion,
            ubicacion: ubicacion
        });
        
        renderProductosDespacho();
        cerrarModalProductos();
        
        Swal.fire({
            icon: 'success',
            title: 'Producto agregado',
            timer: 1500,
            showConfirmButton: false
        });
    }

    // Evento de búsqueda con Enter
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchProductDespacho');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    buscarProductosDespacho();
                }
            });
        }
    });

    // Guardar cambios del despacho
    function guardarDespacho() {
        if (!ventaActual) return;
        
        Swal.fire({
            title: 'Guardando...',
            text: 'Por favor espere',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        fetch(`${baseUrl}/despacho/guardar`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                sale_id: ventaActual.id,
                productos: productosDespacho
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Guardado',
                    text: 'Los cambios se guardaron correctamente. Puedes seguir modificando.',
                    confirmButtonColor: '#10b981'
                }).then(() => {
                    cerrarModal();
                    location.reload();
                });
            } else {
                Swal.fire('Error', data.message || 'No se pudo guardar', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Ocurrió un error al guardar', 'error');
        });
    }

    // Cerrar modal
    function cerrarModal() {
        document.getElementById('modalDetalles').classList.add('hidden');
        ventaActual = null;
        productosDespacho = [];
    }
    </script>
</x-app-layout>
