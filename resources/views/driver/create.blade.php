<!-- resources\views\driver\create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registro de Conductor
        </h2>
    </x-slot>
    <div class=" w-3/4 mx-auto py-8">
        <!-- Botón de regresar -->
        <div class="mb-4">
            <a href="{{ route('drives.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg shadow-md hover:bg-gray-700 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Regresar
            </a>
        </div>

        <form id="formCustomer">
            @csrf
            <h5 class="text-lg font-semibold mb-4">Datos del Conductor</h5>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-4">
                <div>
                    <label for="tipo_doc" class="block text-sm font-medium text-gray-700">Tipo Documento</label>
                    <select name="tipo_doc" id="tipo_doc"
                        class="form-select block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm">
                        <option value="">Seleccione un Documento</option>
                        <option value="DNI">DNI</option>
                        <option value="Pasaporte">Pasaporte</option>
                        <option value="Carnet">Carnet de Extranjería</option>
                    </select>
                </div>
                <div>
                    <label for="nro_documento" class="block text-sm font-medium text-gray-700">N° Documento <span class="text-red-500">*</span></label>
                    <div class="flex mt-2">
                        <input name="nro_documento" type="text" placeholder="Ingrese Documento" id="nro_documento" required
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                        <button id="buscarDni" class="ml-2 py-2 px-4 bg-yellow-500 text-white rounded-md"
                            type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <!-- COMENTADO: Nacionalidad ya no se usa
                <div>
                    <label for="nacionalidad" class="block text-sm font-medium text-gray-700">Nacionalidad</label>
                    <input type="text" name="nacionalidad" id="nacionalidad"
                        class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                -->
                <div class="col-span-1 lg:col-span-1 row-span-4">
                    <label for="photo" class="block text-sm font-medium text-gray-700">Foto</label>
                    <div class="mt-2">
                        <input type="file" id="photo" name="photo" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:py-2 file:px-4 file:border file:rounded-lg file:bg-gray-100 hover:file:bg-gray-200" />
                        <div id="photo-preview"
                            class="mt-2 flex items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg min-h-[120px]">
                            <span id="photo-placeholder" class="text-gray-500">Sube una foto</span>
                            <img id="preview-image" class="hidden max-w-full max-h-32 object-cover rounded" />
                        </div>
                    </div>
                </div>
                <div>
                    <label for="nombres" class="block text-sm font-medium text-gray-700">Nombres</label>
                    <input type="text" placeholder="Nombre" name="nombres" id="nombres"
                        class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="apellido_paterno" class="block text-sm font-medium text-gray-700">Apellido
                        Paterno</label>
                    <input type="text" placeholder="Apellido Paterno" name="apellido_paterno" id="apellido_paterno"
                        class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="apellido_materno" class="block text-sm font-medium text-gray-700">Apellido
                        Materno</label>
                    <input type="text" placeholder="Apellido Materno" name="apellido_materno" id="apellido_materno"
                        class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- COMENTADO: Nº de Licencia ya no se usa
                <div>
                    <label for="nro_licencia" class="block text-sm font-medium text-gray-700">Nº de Licencia</label>
                    <input type="text" name="nro_licencia"
                        class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                -->
                <!-- COMENTADO: Lic. Categoría ya no se usa
                <div>
                    <label for="licencia_categoria" class="block text-sm font-medium text-gray-700">Lic.
                        Categoría</label>
                    <select name="licencia_categoria"
                        class="form-select block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm">
                        <option value="">Seleccionar</option>
                        <option value="AI">AI</option>
                        <option value="AIIA">AIIA</option>
                        <option value="AIIB">AIIB</option>
                        <option value="AIIIA">AIIIA</option>
                        <option value="AIIIB">AIIIB</option>
                        <option value="AIIIC">AIIIC</option>
                    </select>
                </div>
                -->
                <div>
                    <label for="nro_motor" class="block text-sm font-medium text-gray-700">Número de Motor</label>
                    <input type="text" name="nro_motor"
                        class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <!-- NUEVO CAMPO: Número de Chasis -->
                <div>
                    <label for="nro_chasis" class="block text-sm font-medium text-gray-700">Número de Chasis <span class="text-red-500">*</span></label>
                    <input type="text" name="nro_chasis" required
                        class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <!-- NUEVO CAMPO: Número de Placa -->
                <div>
                    <label for="nro_placa" class="block text-sm font-medium text-gray-700">Número de Placa <span class="text-red-500">*</span></label>
                    <input type="text" name="nro_placa" required
                        class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">Fecha de
                        Nacimiento</label>
                    <input type="date" name="fecha_nacimiento"
                        class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="telefono" class="block text-sm font-medium text-gray-700">Nº de Teléfono <span class="text-red-500">*</span></label>
                    <input type="text" name="telefono" required
                        class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="correo" class="block text-sm font-medium text-gray-700">Correo</label>
                    <input type="email" name="correo"
                        class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm">
                </div>
            </div>
            <div class="my-6 shadow-lg p-5 rounded-lg border-r-gray-500 " style="border: 2px solid rgb(215,215,215);">
                <h5 class="text-lg font-semibold mb-4">Dirección</h5>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="regions_id" class="block text-sm font-medium text-gray-700">Departamento</label>
                        <select name="regions_id" id="regions_id" class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm">
                            <option value="">Seleccione un Departamento</option>
                            @foreach ($regions as $region)
                                <option value="{{ $region->id }}">{{ $region->name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="departamento" id="departamento_name">
                    </div>
                    <div>
                        <label for="provinces_id" class="block text-sm font-medium text-gray-700">Provincia</label>
                        <select name="provinces_id" id="provinces_id" class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm" disabled>
                            <option value="">Seleccione una opción</option>
                        </select>
                        <input type="hidden" name="provincia" id="provincia_name">
                    </div>
                    <div>
                        <label for="districts_id" class="block text-sm font-medium text-gray-700">Distrito</label>
                        <select name="districts_id" id="districts_id" class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm" disabled>
                            <option value="">Seleccione una opción</option>
                        </select>
                        <input type="hidden" name="distrito" id="distrito_name">
                    </div>
                    <div>
                        <label for="direccion_detalle"
                            class="block text-sm font-medium text-gray-700">Av./Cal./Pj./Urb./Mz./Lt./Otros</label>
                        <input type="text" name="direccion_detalle"
                            class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>
            </div>

            <div class="my-6 shadow-lg p-5 rounded-lg border-r-gray-500 " style="border: 2px solid rgb(215,215,215);">
                <h5 class="text-lg font-semibold mb-4">Contacto de Emergencia</h5>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label for="nombres_contacto" class="block text-sm font-medium text-gray-700">Nombres</label>
                        <input type="text" name="nombres_contacto"
                            class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label for="telefono_contacto" class="block text-sm font-medium text-gray-700">N°
                            Telefono</label>
                        <input type="text" name="telefono_contacto"
                            class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label for="parentesco_contacto"
                            class="block text-sm font-medium text-gray-700">Parentesco</label>
                        <input type="text" name="parentesco_contacto"
                            class="block w-full mt-2 p-2 border border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>
            </div>
            <div class="flex justify-center space-x-4 mt-6">
                <button id="registrar"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition"
                    type="submit">
                    Registrar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
<script>
    let form = document.getElementById('formCustomer');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(form);

        fetch('{{ route('drives.store') }}', {
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
                    }).then(() => {
                        // Limpiar formulario después del éxito
                        form.reset();
                        document.getElementById('preview-image').classList.add('hidden');
                        document.getElementById('photo-placeholder').classList.remove('hidden');
                        // Resetear selects
                        clearSelect('provinces_id');
                        clearSelect('districts_id');
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    document.addEventListener('DOMContentLoaded', () => {
        // BUSCADOR DEPARTAMENTO PROVINCIA DISTRITO
        document.getElementById('regions_id').addEventListener('change', function() {
            const regionId = this.value;
            const selectedOption = this.options[this.selectedIndex];
            
            // Guardar el nombre del departamento
            document.getElementById('departamento_name').value = selectedOption.text;
            
            if (regionId !== '') {
                fetchProvinces(regionId);
            } else {
                clearSelect('provinces_id');
                clearSelect('districts_id');
                document.getElementById('departamento_name').value = '';
            }
        });

        document.getElementById('provinces_id').addEventListener('change', function() {
            const provinceId = this.value;
            const selectedOption = this.options[this.selectedIndex];
            
            // Guardar el nombre de la provincia
            document.getElementById('provincia_name').value = selectedOption.text;
            
            if (provinceId !== '') {
                fetchDistricts(provinceId);
            } else {
                clearSelect('districts_id');
                document.getElementById('provincia_name').value = '';
            }
        });

        document.getElementById('districts_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            // Guardar el nombre del distrito
            document.getElementById('distrito_name').value = selectedOption.text;
        });

        function fetchProvinces(regionId) {
            fetch(`/biker-project/public/api/provinces/${regionId}`)
                .then(response => response.json())
                .then(data => {
                    const provinceSelect = document.getElementById('provinces_id');
                    provinceSelect.removeAttribute('disabled');
                    clearSelect('districts_id');
                    updateSelectOptions('provinces_id', data.provinces);
                })
                .catch(error => console.error('Error fetching provinces:', error));
        }

        function fetchDistricts(provinceId) {
            fetch(`/biker-project/public/api/districts/${provinceId}`)
                .then(response => response.json())
                .then(data => {
                    const districtSelect = document.getElementById('districts_id');
                    districtSelect.removeAttribute('disabled');
                    updateSelectOptions('districts_id', data.districts);
                })
                .catch(error => console.error('Error fetching districts:', error));
        }

        function updateSelectOptions(selectId, options) {
            const select = document.getElementById(selectId);
            select.innerHTML = '<option value="">Seleccione una opción</option>';
            options.forEach(option => {
                const opt = document.createElement('option');
                opt.value = option.id;
                opt.textContent = option.name;
                select.appendChild(opt);
            });
        }

        function clearSelect(selectId) {
            const select = document.getElementById(selectId);
            select.innerHTML = '<option value="">Seleccione una opción</option>';
            select.setAttribute('disabled', 'disabled');
            
            // Limpiar campos hidden correspondientes
            if (selectId === 'provinces_id') {
                document.getElementById('provincia_name').value = '';
                document.getElementById('distrito_name').value = '';
            } else if (selectId === 'districts_id') {
                document.getElementById('distrito_name').value = '';
            }
        }

        // Preview de imagen
        const photoInput = document.getElementById('photo');
        const previewImage = document.getElementById('preview-image');
        const placeholder = document.getElementById('photo-placeholder');

        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                previewImage.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }
        });

        // API DNI
        const Inputnum_doc = document.getElementById('nro_documento');
        const token =
            'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InN5c3RlbWNyYWZ0LnBlQGdtYWlsLmNvbSJ9.yuNS5hRaC0hCwymX_PjXRoSZJWLNNBeOdlLRSUGlHGA';

        Inputnum_doc.addEventListener('input', () => {
            const num_doc = Inputnum_doc.value;
            if (num_doc.length === 8) {
                fetch(`https://dniruc.apisperu.com/api/v1/dni/${num_doc}?token=${token}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la solicitud');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success === false) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'No se pudo encontrar el DNI',
                                showConfirmButton: false,
                                timer: 2000
                            });
                            document.getElementById('apellido_paterno').value = '';
                            document.getElementById('apellido_materno').value = '';
                            document.getElementById('nombres').value = '';
                        } else {
                            document.getElementById('apellido_paterno').value = data
                                .apellidoPaterno || '';
                            document.getElementById('apellido_materno').value = data
                                .apellidoMaterno || '';
                            document.getElementById('nombres').value = data.nombres || '';
                        }

                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un problema con la solicitud',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    });
            } else {
                document.getElementById('apellido_paterno').value = '';
                document.getElementById('apellido_materno').value = '';
                document.getElementById('nombres').value = '';
            }
        });

        // Hacer las funciones globales para que puedan ser llamadas desde otros lugares
        window.clearSelect = clearSelect;
        window.updateSelectOptions = updateSelectOptions;
        window.fetchProvinces = fetchProvinces;
        window.fetchDistricts = fetchDistricts;
    })
</script>