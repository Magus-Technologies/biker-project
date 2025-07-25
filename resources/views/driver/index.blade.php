<!-- resources\views\driver\index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lista de Conductores
        </h2>
    </x-slot>

    <div class="max-w-7xl  mx-auto px-4 py-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Lista de Conductores</h2>
            <a href="{{ route('drives.create') }}"
                class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg flex items-center transition-all duration-300">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Agregar
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
                            Nº Motor
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nº Placa
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
                    @forelse($drives as $drive)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $drive->codigo }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $drive->nombres }} {{ $drive->apellido_paterno }} {{ $drive->apellido_materno }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $drive->nro_motor ?? 'N/A' }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $drive->nro_placa ?? 'N/A' }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $drive->telefono ?? 'N/A' }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <button type="button" id="btn-{{ $drive->id }}"
                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full shadow-md {{ $drive->status == 1 ? 'bg-green-200 text-green-700' : 'text-red-700 bg-red-200' }}"
                                    onclick="confirmDelete({{ $drive->id }}, '{{ $drive->status == 1 ? '¿Está seguro de desactivar este registro?' : '¿Está seguro de activar este registro?' }}')">
                                    @if ($drive->status == 1)
                                        Activado
                                    @else
                                        Deshabilitado
                                    @endif
                                </button>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <!-- Botón Ver Detalles -->
                                    <button onclick="showDriverDetails({{ $drive->id }})"
                                        class="inline-flex items-center px-2 py-1 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-md transition-colors duration-200"
                                        title="Ver detalles">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                    
                                    @can('actualizar-conductores')
                                        <!-- Botón Editar -->
                                        <a href="{{ route('drives.edit', $drive->id) }}"
                                            class="inline-flex items-center px-2 py-1 bg-indigo-100 hover:bg-indigo-200 text-indigo-600 rounded-md transition-colors duration-200"
                                            title="Editar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                    @endcan
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
                                    <p class="text-lg font-medium">No hay conductores registrados</p>
                                    <p class="text-sm text-gray-400">Comienza agregando un nuevo conductor</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de Detalles del Conductor - Responsive -->
    <div id="driverModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center">
        <!-- Contenedor del Modal - Responsive -->
        <div class="relative flex flex-col 
                    md:top-0 md:mx-auto md:p-0 md:border md:w-11/12 md:max-w-4xl md:shadow-lg md:rounded-md md:bg-white md:max-h-[90vh] md:overflow-hidden
                    top-0 mx-0 p-0 border-0 w-full max-w-none shadow-none rounded-none bg-white h-full">
            
            <!-- Header del Modal -->
            <div class="flex-shrink-0 flex items-center justify-between p-4 border-b border-gray-200 
                        md:static sticky top-0 bg-white z-10">
                <h3 class="text-xl font-semibold text-gray-900">
                    Detalles del Conductor
                </h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Contenido del Modal -->
            <div id="modalContent" class="flex-grow overflow-y-auto 
                                        p-4 md:p-6 
                                        pb-20 md:pb-6">
                <!-- Loading spinner -->
                <div id="loadingSpinner" class="flex justify-center items-center py-8">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                </div>
                
                <!-- Contenido dinámico se cargará aquí -->
                <div id="driverDetails" class="hidden"></div>
            </div>

            <!-- Footer del Modal - Sticky en móviles -->
            <div class="flex-shrink-0 flex items-center justify-end p-4 border-t border-gray-200 space-x-2
                        md:static sticky bottom-0 bg-white z-10">
                <button onclick="closeModal()" 
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                    Cerrar
                </button>
                <button id="editDriverBtn" 
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
        // Función para mostrar detalles del conductor
        function showDriverDetails(driverId) {
            const modal = document.getElementById('driverModal');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const driverDetails = document.getElementById('driverDetails');
            const editBtn = document.getElementById('editDriverBtn');
            
            // Mostrar modal y loading
            modal.classList.remove('hidden');
            loadingSpinner.classList.remove('hidden');
            driverDetails.classList.add('hidden');
            editBtn.classList.add('hidden');
            
            // Prevenir scroll del body en móviles
            document.body.style.overflow = 'hidden';
            
            // Hacer petición AJAX
          fetch(`{{ route('drives.details', ['id' => '__driverId__']) }}`.replace('__driverId__', driverId))
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadingSpinner.classList.add('hidden');
                        driverDetails.innerHTML = data.html;
                        driverDetails.classList.remove('hidden');
                        
                        // Mostrar botón editar si tiene permisos
                        @can('actualizar-conductores')
                            editBtn.classList.remove('hidden');
                            editBtn.onclick = () => {
                                window.location.href = `/drives/${driverId}/edit`;
                            };
                        @endcan
                    } else {
                        throw new Error(data.message || 'Error al cargar los detalles');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    loadingSpinner.classList.add('hidden');
                    driverDetails.innerHTML = `
                        <div class="text-center py-8">
                            <div class="text-red-500 mb-4">
                                <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-600">Error al cargar los detalles del conductor</p>
                        </div>
                    `;
                    driverDetails.classList.remove('hidden');
                });
        }

        // Función para cerrar modal
        function closeModal() {
            document.getElementById('driverModal').classList.add('hidden');
            // Restaurar scroll del body
            document.body.style.overflow = 'auto';
        }

        // Cerrar modal al hacer clic fuera de él (solo en desktop)
        document.getElementById('driverModal').addEventListener('click', function(e) {
            if (e.target === this && window.innerWidth >= 768) {
                closeModal();
            }
        });

        // Cerrar modal con tecla Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        // Manejar cambios de orientación en móviles
        window.addEventListener('orientationchange', function() {
            setTimeout(function() {
                const modal = document.getElementById('driverModal');
                if (!modal.classList.contains('hidden')) {
                    // Reajustar altura si es necesario
                    const modalContent = document.getElementById('modalContent');
                    modalContent.style.height = 'auto';
                }
            }, 100);
        });
    </script>

</x-app-layout>
