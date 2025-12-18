<x-app-layout>
    <x-breadcrumb title="Motos" subtitle="Gestión de Motos" />

    <div class="px-3 py-4">
        <!-- Mensajes -->
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

        <!-- Vista de Iconos de Marcas -->
        <div id="vistaIconos" class="bg-white rounded-lg border border-gray-200 p-6">
            <!-- Header con botones de agregar -->
            <div class="flex flex-wrap justify-end items-center gap-2 mb-6">
                <button onclick="abrirModalMarca()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center transition-colors text-sm">
                    <i class="bi bi-plus-lg mr-1"></i>Agregar Marca
                </button>
                <a href="{{ route('motos.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg flex items-center transition-colors text-sm">
                    <i class="bi bi-plus-lg mr-1"></i>Agregar Moto
                </a>
            </div>

            <!-- Grid de Marcas de Motos (Dinámico desde BD) -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($brands as $brand)
                    <div class="marca-card group relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 h-32" 
                         style="background: linear-gradient(135deg, {{ $brand->color_from }} 0%, {{ $brand->color_to }} 100%);">
                        <!-- Botón de configuración -->
                        <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                            <button onclick="abrirMenuMarca(event, {{ $brand->id }}, '{{ $brand->name }}', '{{ $brand->color_from }}', '{{ $brand->color_to }}')" 
                                    class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-full w-8 h-8 flex items-center justify-center transition">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                        </div>
                        
                        <!-- Link a la marca -->
                        <a href="{{ route('motos.marca.show', $brand->slug) }}" class="absolute inset-0">
                            <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity"></div>
                            <div class="relative h-full flex items-center justify-center px-2">
                                <span class="text-white font-bold text-xl sm:text-2xl tracking-wider drop-shadow-lg text-center">{{ $brand->name }}</span>
                            </div>
                        </a>
                        
                        <div class="absolute bottom-2 right-2 bg-white bg-opacity-20 text-white text-xs px-2 py-1 rounded-full">
                            <span class="count-marca" data-marca="{{ $brand->name }}">0</span> motos
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Modal para agregar/editar marca -->
        <div id="modalMarca" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="bi bi-plus-circle mr-2 text-blue-600"></i>
                        <span id="modalTitle">Agregar Nueva Marca</span>
                    </h3>
                    <button onclick="cerrarModalMarca()" class="text-gray-500 hover:text-gray-700">
                        <i class="bi bi-x-lg text-xl"></i>
                    </button>
                </div>
                
                <form id="formMarca" onsubmit="guardarMarca(event)">
                    @csrf
                    <input type="hidden" id="marca_id" name="marca_id">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Marca</label>
                            <input type="text" id="marca_name" name="name" required
                                class="w-full p-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Color Inicial</label>
                                <input type="color" id="marca_color_from" name="color_from" value="#3b82f6" required
                                    class="w-full h-10 border border-gray-300 rounded-md cursor-pointer">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Color Final</label>
                                <input type="color" id="marca_color_to" name="color_to" value="#1e40af" required
                                    class="w-full h-10 border border-gray-300 rounded-md cursor-pointer">
                            </div>
                        </div>
                        
                        <div class="flex justify-end gap-2 mt-6">
                            <button type="button" onclick="cerrarModalMarca()" 
                                class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition text-sm">
                                Cancelar
                            </button>
                            <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                                <i class="bi bi-save mr-1"></i>Guardar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Menú contextual de marca -->
        <div id="menuMarca" class="hidden fixed bg-white rounded-lg shadow-xl border border-gray-200 py-2 z-50" style="min-width: 150px;">
            <button onclick="editarMarca()" class="w-full px-4 py-2 text-left text-sm hover:bg-gray-100 flex items-center gap-2">
                <i class="bi bi-pencil text-blue-600"></i>
                Editar
            </button>
            <button onclick="desactivarMarca()" class="w-full px-4 py-2 text-left text-sm hover:bg-gray-100 flex items-center gap-2">
                <i class="bi bi-toggle-off text-orange-600"></i>
                Desactivar
            </button>
        </div>
    </div>

    <script>
        let allMotos = @json($motos ?? []);

        document.addEventListener('DOMContentLoaded', function() {
            actualizarContadores();
        });

        let marcaSeleccionada = null;

        function abrirModalMarca() {
            document.getElementById('modalTitle').textContent = 'Agregar Nueva Marca';
            document.getElementById('marca_id').value = '';
            document.getElementById('formMarca').reset();
            document.getElementById('modalMarca').classList.remove('hidden');
        }

        function cerrarModalMarca() {
            document.getElementById('modalMarca').classList.add('hidden');
            document.getElementById('formMarca').reset();
            marcaSeleccionada = null;
        }

        function abrirMenuMarca(event, id, name, colorFrom, colorTo) {
            event.preventDefault();
            event.stopPropagation();
            
            marcaSeleccionada = { id, name, colorFrom, colorTo };
            
            const menu = document.getElementById('menuMarca');
            menu.classList.remove('hidden');
            
            const rect = event.target.closest('button').getBoundingClientRect();
            menu.style.top = `${rect.bottom + 5}px`;
            menu.style.left = `${rect.left}px`;
        }

        function editarMarca() {
            if (!marcaSeleccionada) return;
            
            document.getElementById('modalTitle').textContent = 'Editar Marca';
            document.getElementById('marca_id').value = marcaSeleccionada.id;
            document.getElementById('marca_name').value = marcaSeleccionada.name;
            document.getElementById('marca_color_from').value = marcaSeleccionada.colorFrom;
            document.getElementById('marca_color_to').value = marcaSeleccionada.colorTo;
            
            document.getElementById('menuMarca').classList.add('hidden');
            document.getElementById('modalMarca').classList.remove('hidden');
        }

        async function desactivarMarca() {
            if (!marcaSeleccionada) return;
            
            const result = await Swal.fire({
                title: '¿Desactivar marca?',
                text: `¿Estás seguro de desactivar la marca ${marcaSeleccionada.name}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, desactivar',
                cancelButtonText: 'Cancelar'
            });
            
            if (!result.isConfirmed) {
                document.getElementById('menuMarca').classList.add('hidden');
                return;
            }
            
            try {
                const response = await fetch(`{{ route('cars.index') }}/toggle-brand/${marcaSeleccionada.id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'Marca desactivada correctamente',
                        confirmButtonColor: '#10b981'
                    }).then(() => window.location.reload());
                } else {
                    throw new Error(data.message || 'Error al desactivar');
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'No se pudo desactivar la marca',
                    confirmButtonColor: '#ef4444'
                });
            }
            
            document.getElementById('menuMarca').classList.add('hidden');
        }

        document.addEventListener('click', function(e) {
            const menu = document.getElementById('menuMarca');
            if (!menu.contains(e.target) && !e.target.closest('.marca-card button')) {
                menu.classList.add('hidden');
            }
        });

        async function guardarMarca(event) {
            event.preventDefault();
            const formData = new FormData(event.target);
            const marcaId = document.getElementById('marca_id').value;
            
            const url = marcaId 
                ? `{{ route('cars.index') }}/update-brand/${marcaId}`
                : '{{ route("cars.storeBrand") }}';
            
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: marcaId ? 'Marca actualizada correctamente' : 'Marca agregada correctamente',
                        confirmButtonColor: '#10b981'
                    }).then(() => window.location.reload());
                } else {
                    throw new Error(data.message || 'Error al guardar');
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'No se pudo guardar la marca',
                    confirmButtonColor: '#ef4444'
                });
            }
        }

        function actualizarContadores() {
            const contadores = {};
            
            allMotos.forEach(moto => {
                const marca = moto.marca || '';
                if (marca) {
                    contadores[marca] = (contadores[marca] || 0) + 1;
                }
            });
            
            document.querySelectorAll('.count-marca').forEach(element => {
                const marca = element.dataset.marca;
                element.textContent = contadores[marca] || 0;
            });
        }
    </script>

</x-app-layout>
