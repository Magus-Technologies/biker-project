<!-- resources\views\mechanic\index.blade.php -->
<x-app-layout>
    <x-breadcrumb title="Lista de Mecánicos" subtitle="mecánicos" />

    <!-- Contenedor principal -->
    <div class="px-3 py-4">
        <!-- Mensajes de éxito o error -->
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 text-green-700 px-4 py-2 rounded mb-3 text-sm">
                <i class="bi bi-check-circle mr-1"></i>{{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border-l-4 border-red-400 text-red-700 px-4 py-2 rounded mb-3 text-sm">
                <i class="bi bi-exclamation-circle mr-1"></i>{{ session('error') }}
            </div>
        @endif

        <!-- Tabla -->
        <div class="bg-white rounded-lg overflow-hidden border border-gray-200">
            <!-- Tabla -->
            <div class="overflow-x-auto">
                <table id="mechanicsTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">Código</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">Nombres y Apellidos</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">DNI</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">Teléfono</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">Dirección</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">Correo</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">Estado</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($mechanics as $mechanic)
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="px-3 py-2 text-sm text-gray-700 text-center">{{ $mechanic->codigo }}</td>
                                <td class="px-3 py-2 text-sm font-medium text-gray-900 text-center">
                                    {{ $mechanic->name }} {{ $mechanic->apellidos }}
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-600 text-center">{{ $mechanic->dni }}</td>
                                <td class="px-3 py-2 text-sm text-gray-600 text-center">{{ $mechanic->telefono }}</td>
                                <td class="px-3 py-2 text-sm text-gray-600 text-center">{{ $mechanic->direccion }}</td>
                                <td class="px-3 py-2 text-sm text-gray-600 text-center">{{ $mechanic->correo }}</td>
                                <td class="px-3 py-2 text-center">
                                    <span id="status-badge-{{ $mechanic->id }}" class="px-2 py-1 inline-flex text-xs font-medium rounded-full
                                        {{ $mechanic->status_mechanic == 1 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $mechanic->status_mechanic == 1 ? 'Disponible' : 'No disponible' }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button type="button" class="text-blue-600 hover:text-blue-800 transition-colors"
                                                title="Cambiar estado"
                                                onclick="confirmToggleStatusMechanic({{ $mechanic->id }}, {{ $mechanic->status_mechanic }})">
                                            <i class="bi bi-arrow-repeat text-base"></i>
                                        </button>
                                        <form id="delete-form-mechanic-{{ $mechanic->id }}" action="{{ route('mechanics.destroy', $mechanic->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-600 hover:text-red-800 transition-colors"
                                                    title="Eliminar" onclick="confirmDeleteMechanic({{ $mechanic->id }})">
                                                <i class="bi bi-trash text-base"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Inicializar DataTables
        document.addEventListener('DOMContentLoaded', function() {
            if ($.fn.DataTable) {
                $('#mechanicsTable').DataTable({
                    deferRender: true,
                    processing: false,
                    stateSave: false,
                    responsive: true,
                    pageLength: 10,
                    lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                    language: {
                        search: "Buscar:",
                        lengthMenu: "Mostrar _MENU_ mecánicos",
                        info: "Mostrando _START_ a _END_ de _TOTAL_ mecánicos",
                        infoEmpty: "0 mecánicos",
                        infoFiltered: "(filtrado de _MAX_ totales)",
                        zeroRecords: "No se encontraron mecánicos",
                        emptyTable: "No hay mecánicos registrados",
                        paginate: {
                            first: "Primero",
                            last: "Último",
                            next: "Siguiente",
                            previous: "Anterior"
                        }
                    },
                    dom: '<"flex justify-between items-center px-3 py-2"lf>rt<"flex justify-between items-center px-3 py-2 border-t border-gray-200"ip>',
                    columnDefs: [
                        { targets: [6, 7], orderable: false }, // Estado y Acciones no ordenables
                        { targets: [6, 7], className: 'text-center' }
                    ],
                    order: [[0, 'asc']], // Ordenar por código
                    autoWidth: false,
                    scrollX: false
                });
            }
        });

        // Función para cambiar el estado del mecánico (toggle)
        function confirmToggleStatusMechanic(mechanicId, currentStatus) {
            const newStatus = currentStatus == 1 ? 0 : 1;
            const message = currentStatus == 1
                ? '¿Estás seguro de desactivar este mecánico?'
                : '¿Estás seguro de activar este mecánico?';

            Swal.fire({
                title: '¿Estás seguro?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, cambiar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Hacer petición AJAX para cambiar el estado
                    fetch(`/mechanics/${mechanicId}/toggle-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ status: newStatus })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Actualizar el badge visualmente
                            const badge = document.getElementById(`status-badge-${mechanicId}`);
                            if (newStatus == 1) {
                                badge.className = 'px-2 py-1 inline-flex text-xs font-medium rounded-full bg-green-100 text-green-700';
                                badge.textContent = 'Disponible';
                            } else {
                                badge.className = 'px-2 py-1 inline-flex text-xs font-medium rounded-full bg-red-100 text-red-700';
                                badge.textContent = 'No disponible';
                            }

                            Swal.fire('¡Actualizado!', data.message, 'success');

                            // Actualizar el estado en el botón para la próxima vez
                            const toggleBtn = document.querySelector(`button[onclick*="confirmToggleStatusMechanic(${mechanicId}"]`);
                            if (toggleBtn) {
                                toggleBtn.setAttribute('onclick', `confirmToggleStatusMechanic(${mechanicId}, ${newStatus})`);
                            }
                        } else {
                            Swal.fire('Error', data.message || 'No se pudo cambiar el estado', 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'Ocurrió un error al cambiar el estado', 'error');
                    });
                }
            });
        }

        // Función para eliminar mecánico (desactivar permanentemente)
        function confirmDeleteMechanic(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Este mecánico será desactivado permanentemente",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-mechanic-' + id).submit();
                }
            });
        }
    </script>

    <style>
        /* FORZAR alineación centrada en tabla de mecánicos */
        #mechanicsTable thead th {
            text-align: center !important;
        }
        
        #mechanicsTable tbody td {
            text-align: center !important;
        }
        
        /* Línea del encabezado más visible */
        #mechanicsTable thead th {
            border-bottom: 2px solid #6b7280 !important;
        }
    </style>

</x-app-layout>
