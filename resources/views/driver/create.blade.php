<x-app-layout>
    <!-- Breadcrumb -->
    <x-breadcrumb 
        title="Nuevo Cliente" 
        parent="Clientes" 
        parentUrl="{{ route('drives.index') }}"
        subtitle="Crear" 
    />

    <div class="px-3 py-4">
        <!-- Header -->
        <div class="bg-white rounded-lg px-4 py-3 mb-3 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-700">
                <i class="bi bi-person-plus mr-2 text-blue-600"></i>
                Registro de Cliente
            </h2>
            <a href="{{ route('drives.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition-colors text-sm">
                <i class="bi bi-arrow-left mr-1"></i>
                Regresar
            </a>
        </div>

        <form id="formCustomer" class="space-y-4">
            @csrf
            
            <!-- Datos Personales -->
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-4 py-3 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-800 flex items-center">
                        <i class="bi bi-person-vcard mr-2 text-blue-600"></i>
                        Datos Personales
                    </h3>
                </div>
                <div class="p-4">
                    <div class="flex flex-col lg:flex-row gap-6">
                        <!-- Columna de Formulario -->
                        <div class="flex-1">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <!-- Tipo Documento -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Tipo Documento
                                    </label>
                                    <select name="tipo_doc" id="tipo_doc" class="w-full border border-gray-300 rounded-md py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500">
                                        <option value="">Seleccione</option>
                                        <option value="DNI" selected>DNI</option>
                                        <option value="Pasaporte">Pasaporte</option>
                                        <option value="Carnet">Carnet de Extranjería</option>
                                    </select>
                                </div>

                                <!-- N° Documento -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        N° Documento <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex gap-2">
                                        <input name="nro_documento" type="text" placeholder="12345678" id="nro_documento" required
                                            class="flex-1 border border-gray-300 rounded-md py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500">
                                        <button id="buscarDni" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 rounded-md transition-colors" type="button" title="Buscar DNI">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Nombres -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Nombres <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" placeholder="Nombres" name="nombres" id="nombres" required
                                        class="w-full border border-gray-300 rounded-md py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500">
                                </div>

                                <!-- Apellido Paterno -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Apellido Paterno <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" placeholder="Apellido Paterno" name="apellido_paterno" id="apellido_paterno" required
                                        class="w-full border border-gray-300 rounded-md py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500">
                                </div>

                                <!-- Apellido Materno -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Apellido Materno
                                    </label>
                                    <input type="text" placeholder="Apellido Materno" name="apellido_materno" id="apellido_materno"
                                        class="w-full border border-gray-300 rounded-md py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500">
                                </div>

                                <!-- Fecha Nacimiento -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Fecha de Nacimiento
                                    </label>
                                    <input type="date" name="fecha_nacimiento"
                                        class="w-full border border-gray-300 rounded-md py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500">
                                </div>

                                <!-- Teléfono -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Teléfono <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" placeholder="999999999" name="telefono" required
                                        class="w-full border border-gray-300 rounded-md py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500">
                                </div>

                                <!-- Correo -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Correo Electrónico
                                    </label>
                                    <input type="email" placeholder="correo@ejemplo.com" name="correo"
                                        class="w-full border border-gray-300 rounded-md py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Columna de Foto -->
                        <div class="lg:w-56 flex-shrink-0">
                            <div class="sticky top-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="bi bi-camera mr-1"></i>
                                    Foto
                                </label>
                                <div id="photo-preview" class="flex items-center justify-center p-3 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 h-56 mb-2">
                                    <span id="photo-placeholder" class="text-gray-400 text-xs text-center">
                                        <i class="bi bi-image text-3xl block mb-1"></i>
                                        Vista previa
                                    </span>
                                    <img id="preview-image" class="hidden max-w-full max-h-full object-contain rounded" />
                                </div>
                                <input type="file" id="photo" name="photo" accept="image/*"
                                    class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Datos del Vehículo -->
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-4 py-3 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-800 flex items-center">
                        <i class="bi bi-car-front mr-2 text-purple-600"></i>
                        Datos del Vehículo
                    </h3>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Número de Placa -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Número de Placa <span class="text-red-500">*</span>
                            </label>
                            <input type="text" placeholder="ABC-123" name="nro_placa" required
                                class="w-full border border-gray-300 rounded-md py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500 uppercase">
                        </div>

                        <!-- Número de Motor -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Número de Motor
                            </label>
                            <input type="text" placeholder="Motor" name="nro_motor"
                                class="w-full border border-gray-300 rounded-md py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Número de Chasis -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Número de Chasis <span class="text-red-500">*</span>
                            </label>
                            <input type="text" placeholder="Chasis" name="nro_chasis" required
                                class="w-full border border-gray-300 rounded-md py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dirección -->
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-4 py-3 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-800 flex items-center">
                        <i class="bi bi-geo-alt mr-2 text-green-600"></i>
                        Dirección
                    </h3>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Departamento -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Departamento
                            </label>
                            <select name="regions_id" id="regions_id" class="w-full border border-gray-300 rounded-md py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500">
                                <option value="">Seleccione</option>
                                @foreach ($regions as $region)
                                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="departamento" id="departamento_name">
                        </div>

                        <!-- Provincia -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Provincia
                            </label>
                            <select name="provinces_id" id="provinces_id" class="w-full border border-gray-300 rounded-md py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500" disabled>
                                <option value="">Seleccione</option>
                            </select>
                            <input type="hidden" name="provincia" id="provincia_name">
                        </div>

                        <!-- Distrito -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Distrito
                            </label>
                            <select name="districts_id" id="districts_id" class="w-full border border-gray-300 rounded-md py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500" disabled>
                                <option value="">Seleccione</option>
                            </select>
                            <input type="hidden" name="distrito" id="distrito_name">
                        </div>

                        <!-- Dirección Detalle -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Av./Cal./Pj./Urb.
                            </label>
                            <input type="text" placeholder="Dirección detallada" name="direccion_detalle"
                                class="w-full border border-gray-300 rounded-md py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contacto de Emergencia -->
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-red-50 to-orange-50 px-4 py-3 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-800 flex items-center">
                        <i class="bi bi-telephone-plus mr-2 text-red-600"></i>
                        Contacto de Emergencia
                    </h3>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Nombres Contacto -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Nombres Completos
                            </label>
                            <input type="text" placeholder="Nombre del contacto" name="nombres_contacto"
                                class="w-full border border-gray-300 rounded-md py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Teléfono Contacto -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Teléfono
                            </label>
                            <input type="text" placeholder="999999999" name="telefono_contacto"
                                class="w-full border border-gray-300 rounded-md py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Parentesco -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Parentesco
                            </label>
                            <input type="text" placeholder="Ej: Padre, Madre, Hermano" name="parentesco_contacto"
                                class="w-full border border-gray-300 rounded-md py-2 px-3 text-sm focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('drives.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-6 rounded-md transition-colors">
                    <i class="bi bi-x-lg mr-1"></i>
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md transition-colors">
                    <i class="bi bi-save mr-1"></i>
                    Registrar Cliente
                </button>
            </div>
        </form>
    </div>

    <script>
    let form = document.getElementById('formCustomer');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(form);

        // Mostrar loading
        Swal.fire({
            title: 'Guardando...',
            text: 'Por favor espere',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

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
                                errorMessages += `• ${err.errors[field].join(', ')}\n`;
                            }
                        } else if (err.error) {
                            errorMessages = err.error;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Errores de Validación',
                            text: errorMessages,
                            confirmButtonColor: '#ef4444'
                        });

                        throw new Error('Error en la respuesta del servidor');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Cliente registrado!',
                        text: data.message,
                        confirmButtonColor: '#10b981',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '{{ route("drives.index") }}';
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    document.addEventListener('DOMContentLoaded', () => {
        // Departamento -> Provincia -> Distrito
        document.getElementById('regions_id').addEventListener('change', function() {
            const regionId = this.value;
            const selectedOption = this.options[this.selectedIndex];
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
            document.getElementById('distrito_name').value = selectedOption.text;
        });

        function fetchProvinces(regionId) {
            fetch(`${baseUrl}/api/provinces/${regionId}`)
                .then(response => response.json())
                .then(data => {
                    const provinceSelect = document.getElementById('provinces_id');
                    provinceSelect.removeAttribute('disabled');
                    clearSelect('districts_id');
                    updateSelectOptions('provinces_id', data.provinces);
                })
                .catch(error => console.error('Error:', error));
        }

        function fetchDistricts(provinceId) {
            fetch(`${baseUrl}/api/districts/${provinceId}`)
                .then(response => response.json())
                .then(data => {
                    const districtSelect = document.getElementById('districts_id');
                    districtSelect.removeAttribute('disabled');
                    updateSelectOptions('districts_id', data.districts);
                })
                .catch(error => console.error('Error:', error));
        }

        function updateSelectOptions(selectId, options) {
            const select = document.getElementById(selectId);
            select.innerHTML = '<option value="">Seleccione</option>';
            options.forEach(option => {
                const opt = document.createElement('option');
                opt.value = option.id;
                opt.textContent = option.name;
                select.appendChild(opt);
            });
        }

        function clearSelect(selectId) {
            const select = document.getElementById(selectId);
            select.innerHTML = '<option value="">Seleccione</option>';
            select.setAttribute('disabled', 'disabled');
            
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
        const inputDni = document.getElementById('nro_documento');
        const token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InN5c3RlbWNyYWZ0LnBlQGdtYWlsLmNvbSJ9.yuNS5hRaC0hCwymX_PjXRoSZJWLNNBeOdlLRSUGlHGA';

        inputDni.addEventListener('input', () => {
            const dni = inputDni.value;
            if (dni.length === 8) {
                fetch(`https://dniruc.apisperu.com/api/v1/dni/${dni}?token=${token}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success === false) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'DNI no encontrado',
                                text: data.message || 'No se pudo encontrar el DNI',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            document.getElementById('apellido_paterno').value = data.apellidoPaterno || '';
                            document.getElementById('apellido_materno').value = data.apellidoMaterno || '';
                            document.getElementById('nombres').value = data.nombres || '';
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'DNI encontrado',
                                timer: 1000,
                                showConfirmButton: false
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        });

        // Hacer funciones globales
        window.clearSelect = clearSelect;
        window.updateSelectOptions = updateSelectOptions;
        window.fetchProvinces = fetchProvinces;
        window.fetchDistricts = fetchDistricts;
    });
    </script>
</x-app-layout>
