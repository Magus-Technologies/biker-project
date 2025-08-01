<!-- resources\views\clientes-mayoristas\index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lista de Clientes Mayoristas
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Lista de Clientes Mayoristas</h2>
            <a href="{{ route('clientes-mayoristas.create') }}"
                class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg flex items-center transition-all duration-300">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Agregar Cliente
            </a>
        </div>

        <!-- Mensajes de éxito o error -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Tabla de registros -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-5">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Código
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nombres y Apellidos
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nombre del Negocio
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tienda
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Teléfono
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($clientes as $cliente)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $cliente->codigo }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $cliente->nombre_completo }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $cliente->nombre_negocio }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $cliente->tienda ?? 'N/A' }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $cliente->telefono }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <button type="button" id="btn-{{ $cliente->id }}"
                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full shadow-md {{ $cliente->status == 1 ? 'bg-green-200 text-green-700' : 'text-red-700 bg-red-200' }}"
                                    onclick="confirmDelete({{ $cliente->id }}, '{{ $cliente->status == 1 ? '¿Está seguro de desactivar este registro?' : '¿Está seguro de activar este registro?' }}')">
                                    @if ($cliente->status == 1)
                                        Activado
                                    @else
                                        Deshabilitado
                                    @endif
                                </button>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <!-- Botón Ver Detalles -->
                                    <button onclick="mostrarDetallesCliente({{ $cliente->id }})"
                                        class="inline-flex items-center px-2 py-1 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-md transition-colors duration-200"
                                        title="Ver detalles">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                    
                                    {{-- @can('actualizar-clientes-mayoristas') --}}
                                        <!-- Botón Editar -->
                                        <a href="{{ route('clientes-mayoristas.edit', $cliente->id) }}"
                                            class="inline-flex items-center px-2 py-1 bg-indigo-100 hover:bg-indigo-200 text-indigo-600 rounded-md transition-colors duration-200"
                                            title="Editar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                    {{-- @endcan --}}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-3 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <p class="text-lg font-medium">No hay clientes mayoristas registrados</p>
                                    <p class="text-sm text-gray-400">Comienza agregando un nuevo cliente mayorista</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de Detalles del Cliente Mayorista - Responsive -->
    <div id="clienteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <!-- Contenedor del Modal - Responsive -->
        <div class="relative
                    md:top-20 md:mx-auto md:p-5 md:border md:w-11/12 md:max-w-2xl md:shadow-lg md:rounded-md md:bg-white
                    top-0 mx-0 p-0 border-0 w-full max-w-none shadow-none rounded-none bg-white">
            <!-- Header del Modal -->
            <div class="flex items-center justify-between p-4 border-b border-gray-200
                        md:static sticky top-0 bg-white z-10">
                <h3 class="text-xl font-semibold text-gray-900">
                    Detalles del Cliente Mayorista
                </h3>
                <button onclick="cerrarModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Contenido del Modal -->
            <div id="modalContent" class="p-4 md:p-6 md:max-h-[70vh] overflow-y-auto">
                <!-- Loading spinner -->
                <div id="loadingSpinner" class="flex justify-center items-center py-8">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                </div>
                <!-- Contenido dinámico se cargará aquí -->
                <div id="clienteDetails" class="hidden"></div>
            </div>

            <!-- Footer del Modal - Sticky en móviles -->
            <div class="flex items-center justify-end p-4 border-t border-gray-200 space-x-2
                        md:static sticky bottom-0 bg-white z-10">
                <button onclick="cerrarModal()"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                    Cerrar
                </button>
                <button id="editClienteBtn"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors hidden">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Editar
                </button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Función para mostrar detalles del cliente mayorista
        function mostrarDetallesCliente(clienteId) {
            const modal = document.getElementById('clienteModal');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const clienteDetails = document.getElementById('clienteDetails');
            const editBtn = document.getElementById('editClienteBtn');
            
            // Mostrar modal y loading
            modal.classList.remove('hidden');
            loadingSpinner.classList.remove('hidden');
            clienteDetails.classList.add('hidden');
            editBtn.classList.add('hidden');
            
            // Prevenir scroll del body en móviles
            document.body.style.overflow = 'hidden';
            
            // Hacer petición AJAX
            // fetch(`/clientes-mayoristas/${clienteId}/detalles`)
         fetch(`{{ route('clientes-mayoristas.detalles', ['id' => '__clienteId__']) }}`.replace('__clienteId__', clienteId))
            
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadingSpinner.classList.add('hidden');
                        clienteDetails.innerHTML = data.html;
                        clienteDetails.classList.remove('hidden');
                        
                        // Mostrar botón editar
                        editBtn.classList.remove('hidden');
                        editBtn.onclick = () => {
                            window.location.href = `/clientes-mayoristas/${clienteId}/edit`;
                        };
                    } else {
                        throw new Error(data.message || 'Error al cargar los detalles');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    loadingSpinner.classList.add('hidden');
                    clienteDetails.innerHTML = `
                        <div class="text-center py-8">
                            <div class="text-red-500 mb-4">
                                <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-600">Error al cargar los detalles del cliente mayorista</p>
                        </div>
                    `;
                    clienteDetails.classList.remove('hidden');
                });
        }

        // Función para cerrar modal
        function cerrarModal() {
            document.getElementById('clienteModal').classList.add('hidden');
            // Restaurar scroll del body
            document.body.style.overflow = 'auto';
        }

        // Cerrar modal al hacer clic fuera de él (solo en desktop)
        document.getElementById('clienteModal').addEventListener('click', function(e) {
            if (e.target === this && window.innerWidth >= 768) {
                cerrarModal();
            }
        });

        // Cerrar modal con tecla Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                cerrarModal();
            }
        });
    </script>

</x-app-layout>