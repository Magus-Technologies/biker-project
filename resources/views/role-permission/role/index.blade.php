<x-app-layout>
    <!-- Breadcrumb -->
    <x-breadcrumb title="Usuarios del Sistema" subtitle="Usuarios"/>
    
    <!-- Contenedor principal -->
    <div class="px-3 py-4">
        <!-- Navegación de tabs -->
        <div class="bg-white rounded-lg px-4 py-3 mb-3 flex flex-wrap gap-2">
            <a href="{{ url('roles') }}"
                class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-500 transition-colors text-sm font-medium">
                <i class="bi bi-shield-check mr-1"></i>
                Roles
            </a>
            <a href="{{ route('permissions.index') }}"
                class="bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-500 transition-colors text-sm font-medium">
                <i class="bi bi-key mr-1"></i>
                Permisos
            </a>
            <a href="{{ url('users') }}"
                class="bg-yellow-600 text-white py-2 px-4 rounded-md hover:bg-yellow-500 transition-colors text-sm font-medium">
                <i class="bi bi-people mr-1"></i>
                Trabajadores
            </a>
        </div>

        <!-- Mensajes -->
        @if (session('status'))
            <div class="bg-green-50 border-l-4 border-green-400 text-green-700 px-4 py-2 rounded mb-3 text-sm">
                <i class="bi bi-check-circle mr-1"></i>{{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-400 text-red-700 px-4 py-2 rounded mb-3 text-sm">
                <i class="bi bi-exclamation-circle mr-1"></i>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Tabla de Roles -->
        <div class="bg-white rounded-lg overflow-hidden border border-gray-200">
            <!-- Header con botón agregar -->
            <div class="px-4 py-3 flex justify-between items-center border-b border-gray-200">
                <h4 class="text-lg font-semibold text-gray-800">
                    <i class="bi bi-shield-check mr-2 text-indigo-600"></i>
                    Roles del Sistema
                </h4>
                @can('crear-rol')
                    <button onclick="openModal('createRoleModal')"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors text-sm">
                        <i class="bi bi-plus-lg mr-1"></i>
                        Agregar Rol
                    </button>
                @endcan
            </div>

            <div class="overflow-x-auto">
                <table id="rolesTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">
                                Código
                            </th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">
                                Nombre
                            </th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($roles as $role)
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="px-3 py-2 text-sm text-gray-700 text-center">
                                    {{ $role->id }}
                                </td>
                                <td class="px-3 py-2 text-sm font-medium text-gray-900 text-center">
                                    {{ $role->name }}
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ url('roles/' . $role->id . '/give-permissions') }}"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded-md transition-colors text-xs font-medium"
                                            title="Editar Permisos">
                                            <i class="bi bi-key mr-1"></i>
                                            Permisos
                                        </a>

                                        @can('actualizar-rol')
                                            <button onclick="openEditModal({{ $role->id }}, '{{ $role->name }}')"
                                                class="bg-green-600 hover:bg-green-700 text-white py-1 px-3 rounded-md transition-colors text-xs font-medium"
                                                title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        @endcan

                                        @can('eliminar-rol')
                                            <a href="{{ url('roles/' . $role->id . '/delete') }}"
                                                onclick="return confirm('¿Estás seguro de eliminar este rol?')"
                                                class="bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded-md transition-colors text-xs font-medium"
                                                title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-3 py-8 text-center text-gray-500">
                                    <i class="bi bi-inbox text-4xl text-gray-300 mb-2"></i>
                                    <p class="text-sm">No hay roles registrados</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Crear Rol -->
    <x-modal-form id="createRoleModal" title="Crear Nuevo Rol" action="{{ url('roles') }}" method="POST">
        <div class="mb-4">
            <label for="create_name" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="bi bi-tag mr-1"></i>
                Nombre del Rol
            </label>
            <input type="text" name="name" id="create_name" required
                class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Ej: Administrador, Vendedor, etc.">
        </div>
    </x-modal-form>

    <!-- Modal Editar Rol -->
    <x-modal-form id="editRoleModal" title="Editar Rol" action="" method="PUT">
        <div class="mb-4">
            <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="bi bi-tag mr-1"></i>
                Nombre del Rol
            </label>
            <input type="text" name="name" id="edit_name" required
                class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
    </x-modal-form>

    <style>
    /* Forzar que DataTables no calcule mal los anchos */
    #rolesTable_wrapper table {
        width: 100% !important;
    }
    #rolesTable thead th:nth-child(1),
    #rolesTable tbody td:nth-child(1) {
        width: 80px !important;
        text-align: center !important;
    }
    #rolesTable thead th:nth-child(2),
    #rolesTable tbody td:nth-child(2) {
        text-align: center !important;
    }
    #rolesTable thead th:nth-child(3),
    #rolesTable tbody td:nth-child(3) {
        width: 350px !important;
        text-align: center !important;
    }
    </style>

    <script>
    function openEditModal(roleId, roleName) {
        document.getElementById('edit_name').value = roleName;
        document.getElementById('editRoleModal').querySelector('form').action = `/roles/${roleId}`;
        openModal('editRoleModal');
    }

    // Inicializar DataTables
    document.addEventListener('DOMContentLoaded', function() {
        if ($.fn.DataTable) {
            const table = $('#rolesTable').DataTable({
                deferRender: true,
                processing: false,
                stateSave: false,
                responsive: false,
                pageLength: 10,
                lengthMenu: [[10, 25, 50], [10, 25, 50]],
                language: {
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ roles",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ roles",
                    infoEmpty: "0 roles",
                    infoFiltered: "(filtrado de _MAX_ totales)",
                    zeroRecords: "No se encontraron roles",
                    emptyTable: "No hay roles registrados",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                },
                dom: '<"flex justify-between items-center px-3 py-2"lf>rt<"flex justify-between items-center px-3 py-2 border-t border-gray-200"ip>',
                columnDefs: [
                    { targets: 0, width: '80px' },
                    { targets: 2, width: '350px', orderable: false }
                ],
                order: [[0, 'asc']],
                autoWidth: false,
                scrollX: false
            });
        }
    });
    </script>

</x-app-layout>
