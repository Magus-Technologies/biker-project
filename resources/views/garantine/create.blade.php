<x-app-layout>
    <!-- Breadcrumb -->
    <x-breadcrumb 
        title="Registrar Garantía" 
        parent="Garantías" 
        parentUrl="{{ route('garantines.index') }}"
        subtitle="Registrar" 
    />

    <div class="px-3 py-4">
        <div class="w-full" id="vehiculo" role="tabpanel" aria-labelledby="vehiculo-tab">
        <form class="p-4 sm:p-6 bg-white rounded-lg shadow-md" id="formGarantine" enctype="multipart/form-data">
            @csrf
            <h5 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Datos de Garantía</h5>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 sm:gap-4 mb-4">
                <div class="w-full">
                    <label for="num_doc" class="block text-sm font-medium text-gray-700 mb-1">Nº Documento *</label>
                    <div class="flex gap-2">
                        <input name="n_documento" id="n_documento" type="text" placeholder="Ingrese Documento" required
                            class="block w-full p-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <button class="py-2 px-3 sm:px-4 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition flex-shrink-0" type="button"
                            onclick="apiDNI()">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div class="w-full">
                    <label for="datos_cliente" class="block text-sm font-medium text-gray-700 mb-1">Nombres y Apellidos *</label>
                    <input name="datos_cliente" id="datos_cliente" type="text" placeholder="Nombres completos" required
                        class="block w-full p-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <h5 class="text-lg font-semibold text-gray-800 mb-4 mt-6 border-b pb-2">Datos del Vehículo</h5>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 mb-4">
                <div class="w-full">
                    <label for="marca" class="block text-sm font-medium text-gray-700 mb-1">Marca</label>
                    <input type="text" name="marca"
                        class="block w-full p-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="w-full">
                    <label for="modelo" class="block text-sm font-medium text-gray-700 mb-1">Modelo</label>
                    <input type="text" name="modelo"
                        class="block w-full p-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="w-full">
                    <label for="anio" class="block text-sm font-medium text-gray-700 mb-1">Año</label>
                    <input type="text" name="anio"
                        class="block w-full p-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-4">
                <div class="w-full">
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                    <input type="text" name="color"
                        class="block w-full p-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="w-full">
                    <label for="nro_motor" class="block text-sm font-medium text-gray-700 mb-1">Número de Motor *</label>
                    <input type="text" name="nro_motor" required
                        class="block w-full p-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="w-full">
                    <label for="nro_chasis" class="block text-sm font-medium text-gray-700 mb-1">Número de Chasis</label>
                    <input type="text" name="nro_chasis"
                        class="block w-full p-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="w-full">
                    <label for="celular" class="block text-sm font-medium text-gray-700 mb-1">Número de Celular</label>
                    <input type="text" name="celular"
                        class="block w-full p-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-6 w-full lg:col-span-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kilometraje</label>
                    <div id="kilometraje-group" class="flex flex-wrap gap-2">
                        <button type="button"
                            class="km-btn px-3 py-2 text-xs sm:text-sm rounded-lg border border-gray-300 bg-gray-200 text-gray-700 hover:bg-blue-400 hover:text-white transition flex-shrink-0"
                            data-value="0-5000">0-5000 km</button>
                        <button type="button"
                            class="km-btn px-3 py-2 text-xs sm:text-sm rounded-lg border border-gray-300 bg-gray-200 text-gray-700 hover:bg-blue-400 hover:text-white transition flex-shrink-0"
                            data-value="5000-10000">5000-10000 km</button>
                        <button type="button"
                            class="km-btn px-3 py-2 text-xs sm:text-sm rounded-lg border border-gray-300 bg-gray-200 text-gray-700 hover:bg-blue-400 hover:text-white transition flex-shrink-0"
                            data-value="10000-15000">10000-15000 km</button>
                        <button type="button"
                            class="km-btn px-3 py-2 text-xs sm:text-sm rounded-lg border border-gray-300 bg-gray-200 text-gray-700 hover:bg-blue-400 hover:text-white transition flex-shrink-0"
                            data-value="15000-20000">15000-20000 km</button>
                        <button type="button"
                            class="km-btn px-3 py-2 text-xs sm:text-sm rounded-lg border border-gray-300 bg-gray-200 text-gray-700 hover:bg-blue-400 hover:text-white transition flex-shrink-0"
                            data-value="20000+">20000+ km</button>
                    </div>
                    <input type="hidden" name="kilometrajes" id="kilometrajes">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Boleta y DUA <span
                            class="text-xs text-gray-500">(PDF, puedes subir varios)</span></label>
                    <div class="relative flex items-center">
                        <label for="boleta-dua-input"
                            class="flex items-center cursor-pointer px-4 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700 transition">
                            <svg class="w-5 h-5 mr-2 text-white" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v6m0 0l-3-3m3 3l3-3M12 4v8" />
                            </svg>
                            Seleccionar Archivos PDF
                        </label>
                        <input type="file" name="boleta_dua[]" id="boleta-dua-input" multiple
                            accept="application/pdf" class="hidden">
                    </div>
                    <ul id="boleta-dua-list"
                        class="mt-3 bg-gray-50 rounded-lg px-4 py-3 border border-gray-200 space-y-2"></ul>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-center gap-3 mt-6 pt-6 border-t">
                <button id="registrar"
                    class="w-full sm:w-auto px-6 py-2 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition font-medium text-sm"
                    type="submit">
                    <i class="bi bi-check-circle mr-2"></i>Registrar Garantía
                </button>
                <a href="{{ route('garantines.index') }}"
                    class="w-full sm:w-auto px-6 py-2 bg-gray-500 text-white rounded-lg shadow-md hover:bg-gray-600 transition font-medium text-center text-sm">
                    <i class="bi bi-x-circle mr-2"></i>Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
<script>
    let boletaDuaInput = document.getElementById('boleta-dua-input');
    let boletaDuaList = document.getElementById('boleta-dua-list');
    let selectedFiles = [];

    boletaDuaInput.addEventListener('change', function(e) {
        // Agrega nuevos archivos, evitando duplicados por nombre y tamaño
        for (let file of e.target.files) {
            if (!selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                selectedFiles.push(file);
            }
        }
        updateBoletaDuaList();
        // Limpia el input para poder volver a seleccionar los mismos archivos si se eliminan
        boletaDuaInput.value = '';
    });

    function formatBytes(bytes) {
        if (bytes === 0) return "0 Bytes";
        const k = 1024;
        const sizes = ["Bytes", "KB", "MB", "GB"];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i];
    }

    function updateBoletaDuaList() {
        boletaDuaList.innerHTML = '';
        if (selectedFiles.length === 0) {
            boletaDuaList.innerHTML = `<li class="text-xs text-gray-400">No hay archivos seleccionados.</li>`;
            return;
        }
        selectedFiles.forEach((file, idx) => {
            let li = document.createElement('li');
            li.className =
                "flex items-center justify-between bg-white p-2 rounded shadow-sm border border-gray-100";
            li.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span class="text-xs text-gray-700 mr-2 font-medium">${file.name}</span>
                <span class="text-xs text-gray-400">(${formatBytes(file.size)})</span>
            </div>
            <button type="button" class="ml-2 px-2 py-1 bg-red-100 text-red-600 rounded hover:bg-red-200 text-xs font-bold"
                onclick="removeBoletaDua(${idx})">
                Eliminar
            </button>
        `;
            boletaDuaList.appendChild(li);
        });
        // Actualiza el DataTransfer en el input para que solo suba los seleccionados
        let dt = new DataTransfer();
        selectedFiles.forEach(f => dt.items.add(f));
        boletaDuaInput.files = dt.files;
    }

    window.removeBoletaDua = function(idx) {
        selectedFiles.splice(idx, 1);
        updateBoletaDuaList();
    };

    // Inicializa la lista vacía si no hay archivos
    updateBoletaDuaList();


    // Manejo de botones de kilometraje - Simplificado
    document.addEventListener('DOMContentLoaded', function() {
        const btns = document.querySelectorAll('.km-btn');
        const input = document.getElementById('kilometrajes');

        btns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remover selección de todos los botones
                btns.forEach(b => {
                    b.classList.remove('bg-blue-500', 'text-white');
                    b.classList.add('bg-gray-200', 'text-gray-700');
                });
                
                // Seleccionar el botón clickeado
                this.classList.remove('bg-gray-200', 'text-gray-700');
                this.classList.add('bg-blue-500', 'text-white');
                
                // Guardar el valor
                input.value = this.getAttribute('data-value');
            });
        });
    });

    let formGarantine = document.getElementById('formGarantine');
    const Inputnum_doc = document.getElementById('n_documento');


    Inputnum_doc.addEventListener('input', () => {
        const token =
            'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InN5c3RlbWNyYWZ0LnBlQGdtYWlsLmNvbSJ9.yuNS5hRaC0hCwymX_PjXRoSZJWLNNBeOdlLRSUGlHGA';
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
                        document.getElementById('datos_cliente').value = '';
                    } else {
                        document.getElementById('datos_cliente').value = data.nombres + ' ' + data
                            .apellidoPaterno + ' ' + data.apellidoMaterno || ' ';
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

    formGarantine.addEventListener('submit', function(e) {
        e.preventDefault();

        // Crear FormData manualmente
        let formdata = new FormData();

        // Agrega todos los campos del formulario, excepto los archivos
        for (const element of formGarantine.elements) {
            if (element.name && element.type !== "file") {
                formdata.append(element.name, element.value);
            }
        }

        // Agrega los archivos PDF seleccionados manualmente
        selectedFiles.forEach(file => {
            formdata.append('boleta_dua[]', file);
        });

        // Envia la peticion por fetch
        fetch('{{ route('garantines.store') }}', {
                method: 'POST',
                body: formdata
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
                                title: 'Errores de Validacion',
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
                        confirmButtonColor: '#3b82f6'
                    }).then(() => {
                        window.location.href = '{{ route("garantines.index") }}';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Error al registrar la garantía',
                        confirmButtonColor: '#ef4444'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al procesar la solicitud',
                    confirmButtonColor: '#ef4444'
                });
            });
    });
</script>
