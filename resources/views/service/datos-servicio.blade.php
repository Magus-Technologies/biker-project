<x-app-layout>
    <x-breadcrumb 
        title="Registrar Servicio" 
        parent="Servicios" 
        parentUrl="{{ route('services.index') }}"
        subtitle="Nuevo Servicio" 
    />

    <div class="px-3 py-4">
        <div class="w-full" id="descripDoc" role="tabpanel" aria-labelledby="descripDoc-tab">
            <form class="p-4 sm:p-6 bg-white rounded-lg shadow-md" id="formService">
                @csrf
                <h5 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Detalle del Servicio</h5>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 sm:gap-4 mb-4">
                <div class="w-full">
                    <label for="num_doc" class="block text-sm font-medium text-gray-700 mb-1">Nº Motor *</label>
                    <div class="flex gap-2">
                        <input name="nro_motor" id="nro_motor" type="text" placeholder="Ingrese número de motor" required
                            class="block w-full p-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <button id="buscarDrive" class="py-2 px-3 sm:px-4 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition flex-shrink-0"
                            type="button" onclick="searchDrive()">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div class="w-full">
                    <label for="datos_driver" class="block text-sm font-medium text-gray-700 mb-1">Nombres y Apellidos</label>
                    <input name="datos_driver" id="datos_driver" type="text" placeholder="Nombres del conductor" readonly
                        class="block w-full p-2 text-sm border border-gray-300 rounded-md shadow-sm bg-gray-50">
                </div>
                <input name="drive_id" id="drive_id" type="hidden">
                <input name="car_id" id="car_id" type="hidden">
            </div>

            <!-- Lista de Vehículos -->
            <div class="mb-4">
                <div class="flex flex-col gap-2" id="listaVehiculos"></div>
            </div>

            <!-- Mecánico -->
            <div class="mb-4">
                <label for="datos_mecanico" class="block text-sm font-medium text-gray-700 mb-1">Mecánico Asignado *</label>
                <div class="flex gap-2">
                    <input name="datos_mecanico" id="datos_mecanico" type="text" placeholder="Seleccione un mecánico" readonly required
                        class="block w-full p-2 text-sm border border-gray-300 rounded-md shadow-sm bg-gray-50">
                    <input name="mechanics_id" id="mechanics_id" type="hidden">
                    <button onclick="mostrarModal()" type="button"
                        class="py-2 px-3 sm:px-4 bg-green-500 text-white rounded-md hover:bg-green-600 transition whitespace-nowrap flex-shrink-0">
                        <i class="bi bi-person-plus mr-1"></i>Seleccionar
                    </button>
                </div>
            </div>

            <!-- Detalle -->
            <div class="mb-6">
                <label for="detalle" class="block text-sm font-medium text-gray-700 mb-1">Detalle del Problema *</label>
                <textarea name="detalle" id="detalle" rows="5" required
                    class="block w-full p-3 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 resize-none"
                    placeholder="Describa el problema del vehículo..."></textarea>
            </div>

            <!-- Botones -->
            <div class="flex flex-col sm:flex-row justify-center gap-3 pt-6 border-t">
                <button id="registrar" type="button"
                    class="w-full sm:w-auto px-6 py-2 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition font-medium text-sm"
                    onclick="guardarServicio()">
                    <i class="bi bi-check-circle mr-2"></i>Registrar Servicio
                </button>
                <a href="{{ route('services.index') }}"
                    class="w-full sm:w-auto px-6 py-2 bg-gray-500 text-white rounded-lg shadow-md hover:bg-gray-600 transition font-medium text-center text-sm">
                    <i class="bi bi-x-circle mr-2"></i>Cancelar
                </a>
            </div>

            <!-- Modal Mecánicos -->
            <div id="modalMecanicos"
                class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center z-50 p-4">
                <div class="bg-white p-4 sm:p-6 rounded-lg shadow-lg w-full max-w-md max-h-[80vh] overflow-y-auto">
                    <h3 class="text-lg sm:text-xl font-semibold mb-4 border-b pb-2">Mecánicos Disponibles</h3>
                    <div id="listaMecanicosModal" class="space-y-2"></div>
                    <button onclick="cerrarModal()" type="button"
                        class="mt-4 w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                        <i class="bi bi-x-circle mr-2"></i>Cerrar
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
<script>
    let contenedorListadoCar = '';

    function mostrarModal() {
        document.getElementById('modalMecanicos').classList.remove('hidden');
        fetch('{{ route('obtener.MecanicosDisponibles') }}')
            .then(response => response.json())
            .then(data => {
                let contenedor = document.getElementById('listaMecanicosModal');
                contenedor.innerHTML = '';

                data.forEach(mecanico => {
                    let row = `
                    <div class="flex justify-between items-center p-2 border-b">
                        <span>${mecanico.name} ${mecanico.apellidos} </span>
                        <button onclick="seleccionarMecanico(${mecanico.id}, '${mecanico.name} ${mecanico.apellidos}'); cerrarModal()" 
                            class="px-3 py-1 bg-blue-500 text-white rounded-lg" type="button">
                            Asignar
                        </button>
                    </div>
                `;
                    contenedor.innerHTML += row;
                });
            });
    }

    function cerrarModal() {
        document.getElementById('modalMecanicos').classList.add('hidden');
    }

    function seleccionarMecanico(id, datos) {
        document.getElementById('mechanics_id').value = id;
        document.getElementById('datos_mecanico').value = datos;
    }

    function searchDrive() {
        let nro_motor = document.getElementById('nro_motor').value;

        fetch(`{{ route('buscar.Vehiculo') }}?nro_motor=${encodeURIComponent(nro_motor)}`, {
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
                        title: 'Error',
                        text: data.error,
                        showConfirmButton: false,
                        timer: 2000
                    });
                    document.getElementById('drive_id').value = '';
                    document.getElementById('datos_driver').value = '';
                    document.getElementById('car_id').value = '';
                    contenedorListadoCar.innerHTML = '';
                    return;
                }

                if (data.drive.nombres === null || data.drive.apellido_paterno === null || data.drive
                    .apellido_materno === null) {
                    document.getElementById('datos_driver').value =
                        'Este numero de motor no tiene nombres y apellidos';
                    document.getElementById('drive_id').value = data.drive.id;
                } else {
                    document.getElementById('drive_id').value = data.drive.id;
                    document.getElementById('datos_driver').value = data.drive.nombres + ' ' + data.drive
                        .apellido_paterno + ' ' + data.drive.apellido_materno;
                }

                contenedorListadoCar = document.getElementById('listaVehiculos');
                contenedorListadoCar.innerHTML = '';
                data.car.forEach(car => {
                    let row = `
                        <div class="grid grid-cols-7 gap-1 border-b items-center p-2 border">
                            <span class="text-left">Placa: ${car.placa ? car.placa : 'Sin placa'}</span>
                            <span class="text-left">Marca: ${car.marca ? car.marca : 'Sin marca'}</span>
                            <span class="text-left">Modelo: ${car.modelo ? car.modelo : 'Sin modelo'}</span>
                            <span class="text-left">Color: ${car.color ? car.color : 'Sin color'}</span>
                            <span class="text-left">Año: ${car.anio ? car.anio : 'Sin año'}</span>
                            <button onclick="seleccionarVehiculo(this, ${car.id}); cerrarModal()" 
                                class="px-3 py-1 bg-blue-500 text-white rounded-lg" type="button">
                                Asignar
                            </button>
                        </div>
                    `;
                    contenedorListadoCar.innerHTML += row;
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
    let selectedVehicleButton = null;

    function seleccionarVehiculo(btn, id) {
        if (selectedVehicleButton && selectedVehicleButton !== btn) {
            selectedVehicleButton.classList.remove("bg-green-500");
            selectedVehicleButton.classList.add("bg-blue-500");
            selectedVehicleButton.innerText = "Asignar";
        }
        btn.classList.remove("bg-blue-500");
        btn.classList.add("bg-green-500");
        btn.innerText = "Asignado";
        selectedVehicleButton = btn;
        document.getElementById('car_id').value = id;
    }

    let form = document.getElementById('formService');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(form);

        fetch('{{ route('services.store') }}', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        let errorMessages = '';
                        if (err.errors) {
                            for (let field in err.errors) {
                                errorMessages += `${field}: ${err.errors[field].join(', ')}\n`;
                            }
                        } else if (err.error) {
                            errorMessages = err.error;
                        } else if (err.errorPago) {
                            errorMessages = err.errorPago;
                        }

                        if (errorMessages) {
                            Swal.fire({
                                title: 'Errores de Validación',
                                text: errorMessages,
                                icon: 'error',
                                confirmButtonText: 'Aceptar'
                            });
                        }

                        throw new Error('Error en la respuesta del servidor');
                    });
                }

                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script>
