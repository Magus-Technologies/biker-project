<!-- resources\views\car\index.blade.php -->
<x-app-layout>
    <x-breadcrumb title="Registro de Vehículos" subtitle="vehículos" />

    <!-- Bootstrap 5 para modales (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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

        <!-- Tabla con botón agregar -->
        <div class="bg-white rounded-lg overflow-hidden border border-gray-200">
            <!-- Botón Agregar en la esquina superior derecha -->
            <div class="px-4 py-3 flex justify-end border-b border-gray-200">
                <a href="{{ route('cars.create') }}"
                    class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-md flex items-center transition-colors text-sm">
                    <i class="bi bi-plus-lg mr-1"></i>Agregar
                </a>
            </div>

            <!-- Tabla -->
            <div class="overflow-x-auto">
                <table id="carsTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Código</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Conductor</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Placa</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Nº Motor</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">Estado</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($cars as $car)
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="px-3 py-2 text-sm text-gray-700">{{ $car->codigo }}</td>
                                <td class="px-3 py-2 text-sm font-medium text-gray-900">
                                    {{ $car->driver->nombres ?? '' }} 
                                    {{ $car->driver->apellido_paterno ?? '' }} 
                                    {{ $car->driver->apellido_materno ?? '' }}
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-600">{{ $car->placa ?? 'Sin placa' }}</td>
                                <td class="px-3 py-2 text-sm text-gray-600">{{ $car->driver->nro_motor ?? 'N/A' }}</td>
                                <td class="px-3 py-2 text-center">
                                    <button type="button" 
                                            id="btn-{{ $car->id }}"
                                            class="px-2 py-1 inline-flex text-xs font-medium rounded-full 
                                                {{ $car->status == 1 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}"
                                            onclick="confirmStatusChange({{ $car->id }}, '{{ $car->status == 1 ? '¿Está seguro de desactivar este vehículo?' : '¿Está seguro de activar este vehículo?' }}')">
                                        {{ $car->status == 1 ? 'Activo' : 'Inactivo' }}
                                    </button>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <!-- Editar -->
                                        <a href="{{ route('cars.edit', $car->id) }}"
                                           class="text-purple-600 hover:text-purple-800 transition-colors" 
                                           title="Editar">
                                            <i class="bi bi-pencil text-base"></i>
                                        </a>
                                        
                                        <!-- Eliminar -->
                                        <button onclick="confirmDelete({{ $car->id }})" 
                                                class="text-red-600 hover:text-red-800 transition-colors" 
                                                title="Eliminar">
                                            <i class="bi bi-trash text-base"></i>
                                        </button>
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
                $('#carsTable').DataTable({
                    deferRender: true,
                    processing: false,
                    stateSave: false,
                    responsive: true,
                    pageLength: 10,
                    lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                    language: {
                        search: "Buscar:",
                        lengthMenu: "Mostrar _MENU_ vehículos",
                        info: "Mostrando _START_ a _END_ de _TOTAL_ vehículos",
                        infoEmpty: "0 vehículos",
                        infoFiltered: "(filtrado de _MAX_ totales)",
                        zeroRecords: "No se encontraron vehículos",
                        emptyTable: "No hay vehículos registrados",
                        paginate: {
                            first: "Primero",
                            last: "Último",
                            next: "Siguiente",
                            previous: "Anterior"
                        }
                    },
                    dom: '<"flex justify-between items-center px-3 py-2"lf>rt<"flex justify-between items-center px-3 py-2 border-t border-gray-200"ip>',
                    columnDefs: [
                        { targets: [4, 5], orderable: false }, // Estado y Acciones no ordenables
                        { targets: [4, 5], className: 'text-center' }
                    ],
                    order: [[0, 'asc']], // Ordenar por código
                    autoWidth: false,
                    scrollX: false
                });
            }
        });

        // Función para confirmar cambio de estado
        function confirmStatusChange(carId, message) {
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
                    // Aquí debes implementar la ruta para cambiar el estado
                    Swal.fire(
                        'Pendiente',
                        'Debes implementar la ruta para cambiar el estado del vehículo',
                        'info'
                    );
                }
            });
        }

        // Función para eliminar vehículo
        async function confirmDelete(carId) {
            const result = await Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas eliminar este vehículo?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            });
            
            if (!result.isConfirmed) return;
            
            try {
                let url = `{{ route('cars.destroy', ':id') }}`.replace(':id', carId);
                let response = await fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Vehículo Eliminado',
                        text: 'El vehículo se ha eliminado correctamente',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    // Recargar la página
                    setTimeout(() => window.location.reload(), 2000);
                } else {
                    throw new Error('Error al eliminar el vehículo');
                }
            } catch (error) {
                console.error("Error al eliminar:", error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo eliminar el vehículo',
                    showConfirmButton: true
                });
            }
        }
    </script>

</x-app-layout>
