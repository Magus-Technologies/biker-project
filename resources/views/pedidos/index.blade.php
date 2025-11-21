<x-app-layout>
    <x-breadcrumb title="Pedidos" parent="Ventas" parentUrl="{{ route('sales.index') }}" subtitle="Listado de Pedidos" />

    <div class="px-3 py-4">
        <!-- Filtros -->
        <div class="bg-white rounded-lg px-4 py-3 mb-3">
            <div class="flex flex-wrap items-end gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Desde</label>
                    <input type="date" id="fecha_desde" class="border rounded px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hasta</label>
                    <input type="date" id="fecha_hasta" class="border rounded px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <select id="status_filter" class="border rounded px-3 py-2 text-sm">
                        <option value="">Todos</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="confirmado">Confirmado</option>
                        <option value="convertido">Convertido</option>
                        <option value="cancelado">Cancelado</option>
                    </select>
                </div>
                <button onclick="aplicarFiltros()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                    <i class="bi bi-search mr-1"></i> Filtrar
                </button>
                <button onclick="limpiarFiltros()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm">
                    <i class="bi bi-x-lg mr-1"></i> Limpiar
                </button>
                <div class="ml-auto">
                    <a href="{{ route('pedidos.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm inline-flex items-center">
                        <i class="bi bi-plus-lg mr-1"></i> Nuevo Pedido
                    </a>
                </div>
            </div>
        </div>

        <!-- Estadísticas rápidas -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-3">
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                <div class="text-yellow-600 text-sm font-medium">Pendientes</div>
                <div class="text-2xl font-bold text-yellow-700">{{ $pedidos->where('status', 'pendiente')->count() }}</div>
            </div>
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                <div class="text-blue-600 text-sm font-medium">Confirmados</div>
                <div class="text-2xl font-bold text-blue-700">{{ $pedidos->where('status', 'confirmado')->count() }}</div>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                <div class="text-green-600 text-sm font-medium">Convertidos</div>
                <div class="text-2xl font-bold text-green-700">{{ $pedidos->where('status', 'convertido')->count() }}</div>
            </div>
            <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                <div class="text-red-600 text-sm font-medium">Cancelados</div>
                <div class="text-2xl font-bold text-red-700">{{ $pedidos->where('status', 'cancelado')->count() }}</div>
            </div>
        </div>

        <!-- Tabla -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table id="pedidosTable" class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left">Código</th>
                        <th class="px-4 py-3 text-left">Cliente</th>
                        <th class="px-4 py-3 text-left">DNI</th>
                        <th class="px-4 py-3 text-left">Teléfono</th>
                        <th class="px-4 py-3 text-right">Total</th>
                        <th class="px-4 py-3 text-center">Prioridad</th>
                        <th class="px-4 py-3 text-center">Estado</th>
                        <th class="px-4 py-3 text-left">Fecha</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedidos as $pedido)
                    <tr data-status="{{ $pedido->status }}" data-fecha="{{ $pedido->created_at->format('Y-m-d') }}">
                        <td class="px-4 py-3 font-medium">{{ $pedido->code }}</td>
                        <td class="px-4 py-3">{{ $pedido->customer_names_surnames }}</td>
                        <td class="px-4 py-3">{{ $pedido->customer_dni }}</td>
                        <td class="px-4 py-3">{{ $pedido->customer_phone ?? '-' }}</td>
                        <td class="px-4 py-3 text-right font-medium">S/ {{ number_format($pedido->total, 2) }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($pedido->priority === 'urgente')
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-medium">
                                    <i class="bi bi-exclamation-triangle-fill mr-1"></i>Urgente
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs">Normal</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            @switch($pedido->status)
                                @case('pendiente')
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-medium">Pendiente</span>
                                    @break
                                @case('confirmado')
                                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-medium">Confirmado</span>
                                    @break
                                @case('convertido')
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-medium">Convertido</span>
                                    @break
                                @case('cancelado')
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-medium">Cancelado</span>
                                    @break
                            @endswitch
                        </td>
                        <td class="px-4 py-3">{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-1">
                                <!-- Ver detalles -->
                                <button onclick="verDetalles({{ $pedido->id }})" class="text-blue-600 hover:text-blue-800 p-1" title="Ver detalles">
                                    <i class="bi bi-eye"></i>
                                </button>

                                @if($pedido->status !== 'convertido' && $pedido->status !== 'cancelado')
                                    <!-- Editar -->
                                    <a href="{{ route('pedidos.edit', $pedido->id) }}" class="text-yellow-600 hover:text-yellow-800 p-1" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    @if($pedido->status === 'pendiente')
                                        <!-- Confirmar -->
                                        <button onclick="cambiarEstado({{ $pedido->id }}, 'confirmado')" class="text-blue-600 hover:text-blue-800 p-1" title="Confirmar">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    @endif

                                    @if($pedido->status === 'confirmado')
                                        <!-- Convertir a venta -->
                                        <button onclick="convertirAVenta({{ $pedido->id }})" class="text-green-600 hover:text-green-800 p-1" title="Convertir a venta">
                                            <i class="bi bi-cart-check"></i>
                                        </button>
                                    @endif

                                    <!-- Cancelar -->
                                    <button onclick="cambiarEstado({{ $pedido->id }}, 'cancelado')" class="text-red-600 hover:text-red-800 p-1" title="Cancelar">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                @endif

                                @if($pedido->status === 'convertido' && $pedido->sale_id)
                                    <!-- Ver venta -->
                                    <a href="{{ route('sale.detallesVenta', $pedido->sale_id) }}" class="text-green-600 hover:text-green-800 p-1" title="Ver venta">
                                        <i class="bi bi-receipt"></i>
                                    </a>
                                @endif

                                @if($pedido->status !== 'convertido')
                                    <!-- Eliminar -->
                                    <button onclick="eliminarPedido({{ $pedido->id }})" class="text-red-600 hover:text-red-800 p-1" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Detalles -->
    <div id="modalDetalles" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b flex justify-between items-center">
                <h3 class="text-lg font-semibold">Detalles del Pedido</h3>
                <button onclick="cerrarModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div id="modalContent" class="p-6">
                <!-- Contenido cargado dinámicamente -->
            </div>
        </div>
    </div>

    <script>
    // Inicializar DataTables
    document.addEventListener('DOMContentLoaded', function() {
        if ($.fn.DataTable) {
            window.pedidosTable = $('#pedidosTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                language: {
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ pedidos",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ pedidos",
                    infoEmpty: "0 pedidos",
                    infoFiltered: "(filtrado de _MAX_ totales)",
                    zeroRecords: "No se encontraron pedidos",
                    emptyTable: "No hay pedidos registrados",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                },
                dom: '<"flex justify-between items-center px-3 py-2"lf>rt<"flex justify-between items-center px-3 py-2 border-t border-gray-200"ip>',
                columnDefs: [
                    { targets: [8], orderable: false },
                    { targets: [4], className: 'text-right' },
                    { targets: [5, 6, 8], className: 'text-center' }
                ],
                order: [[0, 'desc']]
            });

            // Filtro personalizado
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                if (settings.nTable.id !== 'pedidosTable') return true;

                let statusFilter = document.getElementById('status_filter').value;
                let fechaDesde = document.getElementById('fecha_desde').value;
                let fechaHasta = document.getElementById('fecha_hasta').value;

                let row = settings.aoData[dataIndex].nTr;
                if (!row) return true;

                // Filtrar por estado
                if (statusFilter && row.dataset.status !== statusFilter) {
                    return false;
                }

                // Filtrar por fechas
                if (fechaDesde || fechaHasta) {
                    let rowFecha = row.dataset.fecha;
                    if (fechaDesde && rowFecha < fechaDesde) return false;
                    if (fechaHasta && rowFecha > fechaHasta) return false;
                }

                return true;
            });
        }
    });

    function aplicarFiltros() {
        if (window.pedidosTable) {
            window.pedidosTable.draw();
        }
    }

    function limpiarFiltros() {
        document.getElementById('fecha_desde').value = '';
        document.getElementById('fecha_hasta').value = '';
        document.getElementById('status_filter').value = '';
        aplicarFiltros();
    }

    function verDetalles(id) {
        fetch(`${baseUrl}/pedido/detalles/${id}`)
            .then(response => response.json())
            .then(pedido => {
                let itemsHtml = '';
                if (pedido.items && pedido.items.length > 0) {
                    itemsHtml = `
                        <h4 class="font-medium mb-2">Productos</h4>
                        <table class="w-full text-sm mb-4">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-2 py-1 text-left">Producto</th>
                                    <th class="px-2 py-1 text-center">Cant.</th>
                                    <th class="px-2 py-1 text-right">P. Unit.</th>
                                    <th class="px-2 py-1 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${pedido.items.map(item => `
                                    <tr class="border-b">
                                        <td class="px-2 py-1">${item.product?.description || 'N/A'}</td>
                                        <td class="px-2 py-1 text-center">${item.quantity}</td>
                                        <td class="px-2 py-1 text-right">S/ ${parseFloat(item.unit_price).toFixed(2)}</td>
                                        <td class="px-2 py-1 text-right">S/ ${parseFloat(item.total).toFixed(2)}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    `;
                }

                let servicesHtml = '';
                if (pedido.services && pedido.services.length > 0) {
                    servicesHtml = `
                        <h4 class="font-medium mb-2">Servicios</h4>
                        <table class="w-full text-sm mb-4">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-2 py-1 text-left">Servicio</th>
                                    <th class="px-2 py-1 text-right">Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${pedido.services.map(service => `
                                    <tr class="border-b">
                                        <td class="px-2 py-1">${service.service_name}</td>
                                        <td class="px-2 py-1 text-right">S/ ${parseFloat(service.price).toFixed(2)}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    `;
                }

                document.getElementById('modalContent').innerHTML = `
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Código</p>
                            <p class="font-medium">${pedido.code}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Estado</p>
                            <p class="font-medium capitalize">${pedido.status}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Cliente</p>
                            <p class="font-medium">${pedido.customer_names_surnames}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">DNI</p>
                            <p class="font-medium">${pedido.customer_dni || '-'}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Teléfono</p>
                            <p class="font-medium">${pedido.customer_phone || '-'}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Dirección</p>
                            <p class="font-medium">${pedido.customer_address || '-'}</p>
                        </div>
                    </div>

                    ${itemsHtml}
                    ${servicesHtml}

                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="flex justify-between mb-1">
                            <span>Subtotal:</span>
                            <span>S/ ${parseFloat(pedido.subtotal).toFixed(2)}</span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span>IGV (18%):</span>
                            <span>S/ ${parseFloat(pedido.igv).toFixed(2)}</span>
                        </div>
                        <div class="flex justify-between font-bold text-lg">
                            <span>Total:</span>
                            <span>S/ ${parseFloat(pedido.total).toFixed(2)}</span>
                        </div>
                    </div>

                    ${pedido.observation ? `
                        <div class="mt-4 p-3 bg-yellow-50 rounded-lg">
                            <p class="text-sm text-gray-500">Observaciones</p>
                            <p>${pedido.observation}</p>
                        </div>
                    ` : ''}
                `;

                document.getElementById('modalDetalles').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'No se pudieron cargar los detalles', 'error');
            });
    }

    function cerrarModal() {
        document.getElementById('modalDetalles').classList.add('hidden');
    }

    function cambiarEstado(id, nuevoEstado) {
        let mensaje = nuevoEstado === 'confirmado' ? '¿Confirmar este pedido?' : '¿Cancelar este pedido?';
        let icon = nuevoEstado === 'confirmado' ? 'question' : 'warning';

        Swal.fire({
            title: mensaje,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: nuevoEstado === 'confirmado' ? '#3b82f6' : '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sí',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`${baseUrl}/pedido/cambiar-estado`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        pedido_id: id,
                        status: nuevoEstado
                    })
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
                    Swal.fire('Error', 'Ocurrió un error', 'error');
                });
            }
        });
    }

    function convertirAVenta(id) {
        Swal.fire({
            title: '¿Convertir pedido a venta?',
            text: 'Se abrirá el formulario de ventas con los datos del pedido',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sí, convertir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirigir a la página de crear venta con el pedido_id
                window.location.href = `${baseUrl}/sales/create?pedido_id=${id}`;
            }
        });
    }

    function eliminarPedido(id) {
        Swal.fire({
            title: '¿Eliminar pedido?',
            text: 'Esta acción no se puede deshacer',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`${baseUrl}/pedidos/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Eliminado', data.message, 'success').then(() => {
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
    </script>
</x-app-layout>
