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
                                    @can('actualizar-trabajadores')
                                        <a href="{{ url('users/' . $user->id . '/edit') }}"
                                            class="bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-500 transition-all duration-300 mx-2">
                                            Editar
                                        </a>
                                    @endcan
                                    @can('eliminar-trabajadores')
                                        <a href="{{ url('users/' . $user->id . '/delete') }}"
                                            class="{{ $user->status == 1 ? 'bg-red-600 hover:bg-red-500' : 'bg-green-600 hover:bg-green-500' }} text-white py-2 px-4 rounded-md transition-all duration-300 mx-2">
                                            {{ $user->status == 1 ? 'Desactivar' : 'Activar' }}
                                        </a>
                                    @endcan
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
                const response = await fetch('/tiendas');
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
                const response = await fetch('/tiendas', {
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
                const response = await fetch(`/tiendas/${id}/toggle`, {
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