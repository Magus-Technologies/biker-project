<!-- resources\views\role-permission\workers\index.blade.php -->
<x-app-layout>
    <div class="container mx-auto mt-8 px-6">
        <!-- Botones de navegación -->
        <div class="mb-6">
            <a href="{{ url('roles') }}"
                class="bg-blue-600 text-white py-3 px-6 rounded-md hover:bg-blue-500 transition-all duration-300 mx-1">Roles</a>
            <a href="{{ url('permissions') }}"
                class="bg-green-600 text-white py-3 px-6 rounded-md hover:bg-teal-500 transition-all duration-300 mx-1">Permisos</a>
            <a href="{{ url('users') }}"
                class="bg-yellow-600 text-white py-3 px-6 rounded-md hover:bg-yellow-500 transition-all duration-300 mx-1">Trabajadores</a>
            
            <!-- Nuevo botón para gestionar tiendas -->
            @can('agregar-trabajadores')
                <button onclick="openTiendaModal()" 
                    class="bg-purple-600 text-white py-3 px-6 rounded-md hover:bg-purple-500 transition-all duration-300 mx-1">
                    Tiendas
                </button>
            @endcan
        </div>

        <!-- Mensaje de estado -->
        @if (session('status'))
            <div class="bg-green-200 text-green-800 p-4 rounded-md mb-6">
                {{ session('status') }}
            </div>
        @endif

        <!-- Card de usuarios -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-yellow-600 to-yellow-800 text-white p-6">
                <h4 class="text-2xl font-semibold">Trabajadores</h4>
                @can('agregar-trabajadores')
                    <a href="{{ url('users/create') }}"
                        class="bg-indigo-600 text-white py-2 px-6 rounded-md hover:bg-indigo-500 transition-all duration-300 float-right">
                        Agregar
                    </a>
                @endcan
            </div>
            <div class="p-6">
                <table class="min-w-full bg-white border border-gray-300 rounded-md shadow-md">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 text-left text-gray-600">Id</th>
                            <th class="p-2 text-left text-gray-600">Nombres y Apellidos</th>
                            <th class="p-2 text-left text-gray-600">Email</th>
                            <th class="p-2 text-left text-gray-600">Tienda</th>
                            <th class="p-2 text-left text-gray-600">Estado</th>
                            <th class="p-2 text-left text-gray-600">Rol</th>
                            <th class="p-2 text-left text-gray-600">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-t">
                                <td class="p-2 text-gray-800">{{ $user->id }}</td>
                                <td class="p-2 text-gray-800">{{ $user->name }} {{ $user->apellidos }}</td>
                                <td class="p-2 text-gray-800">{{ $user->email }}</td>
                                <td class="p-2 text-gray-800">{{ $user->tienda->nombre ?? 'Sin asignar' }}</td>
                                <td>
                                    @if ($user->status == 1)
                                        <span class="inline-block px-3 py-1 text-sm font-medium text-white bg-green-500 rounded-full">
                                            Activo
                                        </span>
                                    @else
                                        <span class="inline-block px-3 py-1 text-sm font-medium text-white bg-red-500 rounded-full">
                                            Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td class="p-2">
                                    @if (!empty($user->getRoleNames()))
                                        @foreach ($user->getRoleNames() as $rolename)
                                            <label class="badge bg-primary mx-1">{{ $rolename }}</label>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="p-1">
                                    <div class="flex items-center gap-1">
                                        @can('actualizar-trabajadores')
                                            <a href="{{ url('users/' . $user->id . '/edit') }}"
                                                class="inline-flex items-center justify-center text-white p-2 rounded-md hover:opacity-80 transition-all duration-300"
                                                title="Editar">
                                                <i class="bi bi-pencil-square text-yellow-500 text-lg"></i>
                                            </a>
                                        @endcan
                                        @can('eliminar-trabajadores')
                                            @php
                                                $isAdmin = $user->hasRole('Administrador');
                                                $isSelf = $user->id === auth()->id();
                                            @endphp
                                            
                                            @if(!$isAdmin || $isSelf)
                                                <a href="{{ url('users/' . $user->id . '/delete') }}"
                                                    onclick="return confirmToggleStatus(event, '{{ $user->name }}', {{ $user->status }})"
                                                    class="inline-flex items-center justify-center text-white p-2 rounded-md hover:opacity-80 transition-all duration-300 {{ $isSelf ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                    title="{{ $isSelf ? 'No puedes desactivar tu propia cuenta' : ($user->status == 1 ? 'Desactivar' : 'Activar') }}"
                                                    {{ $isSelf ? 'onclick="return false;"' : '' }}>
                                                    <i class="bi {{ $user->status == 1 ? 'bi-toggle-on text-green-500' : 'bi-toggle-off text-gray-400' }} text-lg"></i>
                                                </a>
                                            @else
                                                <span class="inline-flex items-center justify-center text-white p-2 rounded-md opacity-50 cursor-not-allowed"
                                                    title="Los administradores no pueden ser desactivados">
                                                    <i class="bi bi-toggle-on text-green-500 text-lg"></i>
                                                </span>
                                            @endif
                                            
                                            @if(!$isAdmin && !$isSelf)
                                                <button onclick="confirmDelete(event, {{ $user->id }}, '{{ $user->name }}')"
                                                    class="inline-flex items-center justify-center text-white p-2 rounded-md hover:opacity-80 transition-all duration-300"
                                                    title="Eliminar permanentemente">
                                                    <i class="bi bi-trash3-fill text-red-500 text-lg"></i>
                                                </button>
                                            @else
                                                <span class="inline-flex items-center justify-center text-white p-2 rounded-md opacity-50 cursor-not-allowed"
                                                    title="{{ $isSelf ? 'No puedes eliminar tu propia cuenta' : 'Los administradores no pueden ser eliminados' }}">
                                                    <i class="bi bi-trash3-fill text-gray-400 text-lg"></i>
                                                </span>
                                            @endif
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal para gestionar tiendas -->
    <div id="tiendaModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <!-- Header del modal -->
                <div class="flex justify-between items-center pb-3 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Agregar Tienda</h3>
                    <button onclick="closeTiendaModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Formulario para agregar tienda -->
                <div class="mt-4 mb-6">
                    <form id="formTienda" class="flex gap-3">
                        @csrf
                        <div class="flex-1">
                            <input type="text" 
                                   id="nombreTienda" 
                                   name="nombre" 
                                   placeholder="Nombre de la tienda" 
                                   required
                                   class="w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-blue-300 focus:outline-none">
                        </div>
                        <button type="submit" 
                                class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-500 transition-all">
                            Agregar
                        </button>
                    </form>
                </div>

                <!-- Lista de tiendas -->
                <div class="max-h-96 overflow-y-auto">
                    <table class="min-w-full bg-white border border-gray-300 rounded-md">
                        <thead class="bg-gray-100 sticky top-0">
                            <tr>
                                <th class="p-3 text-left text-gray-600">Item</th>
                                <th class="p-3 text-left text-gray-600">Nombre</th>
                                <th class="p-3 text-left text-gray-600">Estado</th>
                                <th class="p-3 text-left text-gray-600">Creado por</th>
                                <th class="p-3 text-left text-gray-600">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tiendaTableBody">
                            <!-- Se llenará dinámicamente -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Función de confirmación con doble alerta para administradores
        async function confirmToggleStatus(event, userName, currentStatus) {
            event.preventDefault();
            
            const userRole = '{{ auth()->user()->getRoleNames()->first() }}';
            const action = currentStatus == 1 ? 'desactivar' : 'activar';
            const url = event.currentTarget.href;
            
            // Primera confirmación
            const result = await Swal.fire({
                title: `¿${action.charAt(0).toUpperCase() + action.slice(1)} trabajador?`,
                html: `¿Estás seguro de que deseas ${action} a <strong>${userName}</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: currentStatus == 1 ? '#f59e0b' : '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: `Sí, ${action}`,
                cancelButtonText: 'Cancelar'
            });
            
            if (!result.isConfirmed) {
                return false;
            }
            
            // Segunda confirmación solo para administradores
            if (userRole === 'Administrador') {
                const secondConfirm = await Swal.fire({
                    title: '⚠️ Confirmación de Administrador',
                    html: `Esta acción ${action === 'desactivar' ? 'desactivará' : 'activará'} al trabajador <strong>${userName}</strong>.<br>¿Estás completamente seguro?`,
                    icon: currentStatus == 1 ? 'warning' : 'info',
                    showCancelButton: true,
                    confirmButtonColor: currentStatus == 1 ? '#d33' : '#10b981',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: `Sí, ${action} definitivamente`,
                    cancelButtonText: 'Cancelar'
                });
                
                if (!secondConfirm.isConfirmed) {
                    return false;
                }
            }
            
            // Si pasó todas las confirmaciones, redirigir
            window.location.href = url;
            return false;
        }
        
        // Función para eliminar trabajador con doble confirmación para administradores
        async function confirmDelete(event, userId, userName) {
            event.preventDefault();
            
            const userRole = '{{ auth()->user()->getRoleNames()->first() }}';
            
            // Primera confirmación
            const result = await Swal.fire({
                title: '¿Eliminar trabajador?',
                html: `¿Estás seguro de que deseas eliminar a <strong>${userName}</strong>?<br><small class="text-gray-500">Esta acción no se puede deshacer</small>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            });
            
            if (!result.isConfirmed) {
                return false;
            }
            
            // Segunda confirmación solo para administradores
            if (userRole === 'Administrador') {
                const secondConfirm = await Swal.fire({
                    title: '⚠️ Confirmación de Administrador',
                    html: `Esta acción eliminará <strong>permanentemente</strong> al trabajador <strong>${userName}</strong>.<br><br>Se perderán todos sus datos asociados.<br><br>¿Estás completamente seguro?`,
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Sí, eliminar definitivamente',
                    cancelButtonText: 'Cancelar'
                });
                
                if (!secondConfirm.isConfirmed) {
                    return false;
                }
            }
            
            // Si pasó todas las confirmaciones, hacer la petición DELETE
            try {
                const response = await fetch(`{{ url('users') }}/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Eliminado',
                        text: data.message || 'El trabajador ha sido eliminado correctamente',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'No se pudo eliminar el trabajador',
                        confirmButtonColor: '#ef4444'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al eliminar el trabajador',
                    confirmButtonColor: '#ef4444'
                });
            }
            
            return false;
        }
        
        // Funciones para el modal de tiendas
        function openTiendaModal() {
            document.getElementById('tiendaModal').classList.remove('hidden');
            loadTiendas();
        }

        function closeTiendaModal() {
            document.getElementById('tiendaModal').classList.add('hidden');
            document.getElementById('formTienda').reset();
        }

        // Cargar tiendas
        async function loadTiendas() {
            try {
                const response = await fetch('{{ route('tiendas.index') }}');
                const data = await response.json();
                
                if (data.success) {
                    renderTiendas(data.tiendas);
                }
            } catch (error) {
                console.error('Error al cargar tiendas:', error);
            }
        }

        // Renderizar tiendas en la tabla
        function renderTiendas(tiendas) {
            const tbody = document.getElementById('tiendaTableBody');
            tbody.innerHTML = '';

            tiendas.forEach(tienda => {
                const row = `
                    <tr class="border-t">
                        <td class="p-3">${tienda.id}</td>
                        <td class="p-3">${tienda.nombre}</td>
                        <td class="p-3">
                            <span class="inline-block px-3 py-1 text-sm font-medium text-white rounded-full ${tienda.status ? 'bg-green-500' : 'bg-red-500'}">
                                ${tienda.status ? 'Activa' : 'Inactiva'}
                            </span>
                        </td>
                        <td class="p-3">${tienda.usuario_registro?.name || 'N/A'}</td>
                        <td class="p-3">
                            <button onclick="toggleTienda(${tienda.id})" 
                                    class="${tienda.status ? 'bg-red-600 hover:bg-red-500' : 'bg-green-600 hover:bg-green-500'} text-white py-1 px-3 rounded-md text-sm transition-all">
                                ${tienda.status ? 'Desactivar' : 'Activar'}
                            </button>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        }

        // Agregar nueva tienda
        document.getElementById('formTienda').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            try {
                const response = await fetch('{{ route('tiendas.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                    
                    this.reset();
                    loadTiendas();
                } else {
                    let errorMessages = '';
                    if (data.errors) {
                        for (let field in data.errors) {
                            errorMessages += `${data.errors[field].join(', ')}\n`;
                        }
                    }
                    
                    Swal.fire({
                        title: 'Error',
                        text: errorMessages || data.message,
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Ocurrió un problema al crear la tienda',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        });

        // Toggle estado de tienda
        async function toggleTienda(id) {
            try {
                const response = await fetch(`{{ route('tiendas.toggle', ['id' => '__ID__']) }}`.replace('__ID__', id), {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                    
                    loadTiendas();
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // Cerrar modal al hacer clic fuera
        document.getElementById('tiendaModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeTiendaModal();
            }
        });
    </script>
</x-app-layout>