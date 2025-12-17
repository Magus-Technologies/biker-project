<x-app-layout>
    <x-breadcrumb 
        title="Editar Moto" 
        parent="Motos" 
        parentUrl="{{ route('cars.index') }}" 
        subtitle="Editar" 
    />

    <div class="px-3 py-4">
        <!-- Formulario -->
        <div class="bg-white rounded-lg shadow-lg p-4 md:p-6 border border-gray-200">
            <form id="formCar">
                @csrf
                <h5 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">
                    <i class="bi bi-info-circle mr-2 text-blue-600"></i>
                    Datos del Vehículo
                </h5>
                
                <!-- Búsqueda de conductor -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label for="nro_motor" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-gear mr-1 text-gray-500"></i>N° Motor
                        </label>
                        <div class="flex gap-2">
                            <input name="nro_motor" id="nro_motor" type="text" value="{{ $car->driver->nro_motor ?? '' }}" placeholder="Ingrese número de motor"
                                class="flex-1 p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <button id="buscarDrive" class="py-2 px-4 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md transition-colors text-sm"
                                type="button" onclick="searchDrive()">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label for="datos_driver" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-person mr-1 text-gray-500"></i>Nombres y Apellidos
                        </label>
                        <input name="datos_driver" id="datos_driver" type="text" placeholder="Busque por N° motor" readonly
                            value="{{ ($car->driver->nombres ?? '') . ' ' . ($car->driver->apellido_paterno ?? '') . ' ' . ($car->driver->apellido_materno ?? '') }}"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <input name="drive_id" id="drive_id" type="hidden" value="{{ $car->drives_id }}">
                    </div>
                </div>
                
                <!-- Datos del vehículo -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div>
                        <label for="n_placa" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-card-text mr-1 text-gray-500"></i>N° Placa
                        </label>
                        <input type="text" name="n_placa" value="{{ $car->placa ?? '' }}"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="marca" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-award mr-1 text-gray-500"></i>Marca
                        </label>
                        <input type="text" name="marca" value="{{ $car->marca ?? '' }}"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="modelo" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-tag mr-1 text-gray-500"></i>Modelo
                        </label>
                        <input type="text" name="modelo" value="{{ $car->modelo ?? '' }}"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="anio" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-calendar mr-1 text-gray-500"></i>Año
                        </label>
                        <input type="text" name="anio" value="{{ $car->anio ?? '' }}"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-palette mr-1 text-gray-500"></i>Color
                        </label>
                        <input type="text" name="color" value="{{ $car->color ?? '' }}"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="tipo_condicion" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-check-circle mr-1 text-gray-500"></i>Condición
                        </label>
                        <select name="tipo_condicion" class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="" {{ $car->condicion == '' ? 'selected' : '' }}>Seleccionar</option>
                            <option value="Propio" {{ $car->condicion == 'Propio' ? 'selected' : '' }}>Propio</option>
                            <option value="Alquilado" {{ $car->condicion == 'Alquilado' ? 'selected' : '' }}>Alquilado</option>
                        </select>
                    </div>
                    <div>
                        <label for="nro_chasis" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-hash mr-1 text-gray-500"></i>Número de Chasis
                        </label>
                        <input type="text" name="nro_chasis" value="{{ $car->nro_chasis ?? '' }}"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="lugar_provisional" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-geo-alt mr-1 text-gray-500"></i>Lugar Provisional
                        </label>
                        <input type="text" name="lugar_provisional" value="{{ $car->lugar_provisional ?? '' }}" placeholder="Ej: Taller, Garaje, etc."
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <!-- Fechas de vencimiento -->
                <h5 class="text-lg font-semibold mb-4 mt-6 text-gray-800 border-b pb-2">
                    <i class="bi bi-calendar-check mr-2 text-green-600"></i>
                    Fechas de Vencimiento
                </h5>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label for="fecha_soat" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-shield-check mr-1 text-gray-500"></i>Fecha Vencimiento SOAT
                        </label>
                        <input type="date" name="fecha_soat" value="{{ $car->fecha_soat ? \Carbon\Carbon::parse($car->fecha_soat)->format('Y-m-d') : '' }}"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="fecha_seguro" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-shield-fill-check mr-1 text-gray-500"></i>Fecha Vencimiento Seguro Vehicular
                        </label>
                        <input type="date" name="fecha_seguro" value="{{ $car->fecha_seguro ? \Carbon\Carbon::parse($car->fecha_seguro)->format('Y-m-d') : '' }}"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-center gap-3 mt-6 pt-4 border-t">
                    <a href="{{ route('cars.index') }}" class="px-6 py-2 bg-gray-500 text-white rounded-lg shadow-md hover:bg-gray-600 transition text-center text-sm">
                        <i class="bi bi-x-lg mr-1"></i>
                        Cancelar
                    </a>
                    <button id="registrar"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition text-sm"
                        type="submit">
                        <i class="bi bi-save mr-1"></i>
                        Actualizar Moto
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
    let formCar = document.getElementById('formCar');

    function searchDrive() {
        let nro_motor = document.getElementById('nro_motor').value;

        fetch(`{{ route('buscar.Driver') }}?nro_motor=${encodeURIComponent(nro_motor)}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error('Error en la respuesta del servidor', err);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'No encontrado',
                        text: data.error,
                        confirmButtonColor: '#ef4444'
                    });
                    document.getElementById('drive_id').value = '';
                    document.getElementById('datos_driver').value = '';
                    return;
                } else {
                    if (data.drive.nombres === null || data.drive.apellido_paterno === null || data.drive.apellido_materno === null) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Datos incompletos',
                            text: 'Este número de motor no tiene nombres y apellidos registrados',
                            confirmButtonColor: '#f59e0b'
                        });
                        document.getElementById('datos_driver').value = 'Sin nombres y apellidos';
                        document.getElementById('drive_id').value = data.drive.id;
                        return;
                    }
                    document.getElementById('drive_id').value = data.drive.id;
                    document.getElementById('datos_driver').value = data.drive.nombres + ' ' + data.drive.apellido_paterno + ' ' + data.drive.apellido_materno;
                    
                    Swal.fire({
                        icon: 'success',
                        title: '¡Encontrado!',
                        text: 'Conductor encontrado correctamente',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
    
    formCar.addEventListener('submit', async function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        formData.append('_method', 'PUT');
        
        try {
            let response = await fetch('{{ route('cars.update', $car) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            let data = await response.json();

            if (!response.ok) {
                let errorMessages = '';
                if (data.errors) {
                    for (let field in data.errors) {
                        errorMessages += `${field}: ${data.errors[field].join(', ')}\n`;
                    }
                } else if (data.error) {
                    errorMessages = data.error;
                }

                Swal.fire({
                    title: 'Errores de Validación',
                    text: errorMessages,
                    icon: 'error',
                    confirmButtonColor: '#ef4444'
                });
            } else if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: data.message,
                    confirmButtonColor: '#10b981'
                }).then(() => {
                    window.location.href = '{{ route("cars.index") }}';
                });
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'Ocurrió un problema al actualizar la moto',
                icon: 'error',
                confirmButtonColor: '#ef4444'
            });
        }
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        // Cargar datos del conductor al iniciar
        if (document.getElementById('nro_motor').value) {
            searchDrive();
        }
    });
</script>
