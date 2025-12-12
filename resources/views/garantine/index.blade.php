<x-app-layout>
    <!-- Breadcrumb -->
    <x-breadcrumb title="Lista de Garantías" subtitle="Garantías" />

    <!-- Contenedor principal con poco padding -->
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

        <!-- Tabla con botón agregar integrado -->
        <div class="bg-white rounded-lg overflow-hidden border border-gray-200">
            <!-- Botón Agregar en la esquina superior derecha -->
            <div class="px-4 py-3 flex justify-end border-b border-gray-200">
                <a href="{{ route('garantines.create') }}"
                    class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-md flex items-center transition-colors text-sm">
                    <i class="bi bi-plus-lg mr-1"></i>
                    Agregar
                </a>
            </div>

            <div class="overflow-x-auto">
                <table id="garantiasTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                                Código
                            </th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                                Nombres y Apellidos
                            </th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                                DNI
                            </th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                                Marca
                            </th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                                Modelo
                            </th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                                Año
                            </th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                                Color
                            </th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                                Nº Chasis
                            </th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                                Nº Motor
                            </th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                                Registrador
                            </th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">
                                Estado
                            </th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($garantias as $garantia)
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="px-3 py-2 text-sm text-gray-700">
                                    {{ $garantia->codigo }}
                                </td>
                                <td class="px-3 py-2 text-sm font-medium text-gray-900">
                                    {{ $garantia->nombres_apellidos }}
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-600">
                                    {{ $garantia->nro_documento }}
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-600">
                                    {{ $garantia->marca }}
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-600">
                                    {{ $garantia->modelo }}
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-600">
                                    {{ $garantia->anio }}
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-600">
                                    {{ $garantia->color }}
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-600">
                                    {{ $garantia->nro_chasis }}
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-600">
                                    {{ $garantia->nro_motor }}
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-600">
                                    {{ $garantia->userRegistered->name }}
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <button type="button" id="btn-{{ $garantia->id }}"
                                        class="px-2 py-1 inline-flex text-xs font-medium rounded {{ $garantia->status == 1 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}"
                                        onclick="confirmDelete({{ $garantia->id }}, '{{ $garantia->status == 1 ? '¿Está seguro de desactivar este registro?' : '¿Está seguro de activar este registro?' }}')">
                                        @if ($garantia->status == 1)
                                            Activado
                                        @else
                                            Deshabilitado
                                        @endif
                                    </button>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <a href="{{ route('garantines.edit', $garantia->id) }}" class="text-blue-600 hover:text-blue-800 transition-colors mr-3" title="Editar">
                                        <i class="bi bi-pencil text-base"></i>
                                    </a>
                                    <form id="delete-form-{{ $garantia->id }}" action="{{ route('garantines.destroy', $garantia->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="text-red-600 hover:text-red-800 transition-colors" title="Eliminar" onclick="confirmDeleteGarantia({{ $garantia->id }})">
                                            <i class="bi bi-trash text-base"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="px-3 py-8 text-center text-gray-500">
                                    <i class="bi bi-inbox text-4xl text-gray-300 mb-2"></i>
                                    <p class="text-sm">No hay garantías registradas</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<script>
// Inicializar DataTables
document.addEventListener('DOMContentLoaded', function() {
    if ($.fn.DataTable) {
        $('#garantiasTable').DataTable({
            deferRender: true,
            processing: false,
            stateSave: false,
            responsive: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            language: {
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_ garantías",
                info: "Mostrando _START_ a _END_ de _TOTAL_ garantías",
                infoEmpty: "0 garantías",
                infoFiltered: "(filtrado de _MAX_ totales)",
                zeroRecords: "No se encontraron garantías",
                emptyTable: "No hay garantías registradas",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior"
                }
            },
            dom: '<"flex justify-between items-center px-3 py-2"lf>rt<"flex justify-between items-center px-3 py-2 border-t border-gray-200"ip>',
            columnDefs: [
                { targets: [10, 11], orderable: false, className: 'text-center' }
            ],
            order: [[0, 'asc']],
            autoWidth: false,
            scrollX: false
        });
    }
});

// Función para confirmar eliminación con SweetAlert
function confirmDeleteGarantia(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta garantía será eliminada permanentemente",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>

</x-app-layout>
