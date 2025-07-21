<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Registro de Socios --}}
        </h2>
    </x-slot>
    <div class="w-3/4 mx-auto py-8" id="vehiculo" role="tabpanel" aria-labelledby="vehiculo-tab">
        <form class="p-6 bg-white rounded-lg shadow-md" id="formGarantine" enctype="multipart/form-data">
            @csrf
            <h5 class="text-lg font-semibold text-gray-800 mb-4">Datos de Garantia</h5>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="num_doc" class="block text-sm font-medium text-gray-700">N� documento</label>
                    <div class="flex mt-2">
                        <input name="n_documento" id="n_documento" type="text" placeholder="Ingrese Documento"
                            class="block w-full  border border-gray-300 rounded-md shadow-sm">
                        <button class="ml-2 py-2 px-4 bg-yellow-500 text-white rounded-md" type="button"
                            onclick="apiDNI()">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div>
                    <label for="datos_cliente" class="block text-sm font-medium text-gray-700">Nombres y
                        apellidos</label>
                    <div class="flex mt-2">
                        <input name="datos_cliente" id="datos_cliente" type="text" placeholder="Ingrese Documento"
                            class="block w-full  border border-gray-300 rounded-md shadow-sm">

                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                <div>
                    <label for="marca" class="block text-sm font-medium text-gray-700">Marca</label>
                    <input type="text" name="marca"
                        class="block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="modelo" class="block text-sm font-medium text-gray-700">Modelo</label>
                    <input type="text" name="modelo"
                        class="block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="anio" class="block text-sm font-medium text-gray-700">Año</label>
                    <input type="text" name="anio"
                        class="block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
                    <input type="text" name="color"
                        class="block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="nro_motor" class="block text-sm font-medium text-gray-700">Numero de motor</label>
                    <input type="text" name="nro_motor"
                        class="block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="nro_chasis" class="block text-sm font-medium text-gray-700">Numero de chasis</label>
                    <input type="text" name="nro_chasis"
                        class="block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="nro_chasis" class="block text-sm font-medium text-gray-700">Numero de celular</label>
                    <input type="text" name="celular"
                        class="block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">NUMERO DE KILOMETRAJE</label>
                    <div id="kilometraje-group" class="flex space-x-4">
                        <button type="button"
                            class="km-btn px-4 py-2 rounded-lg border border-gray-300 bg-gray-200 text-gray-700 focus:outline-none"
                            data-value="500">500</button>
                        <button type="button"
                            class="km-btn px-4 py-2 rounded-lg border border-gray-300 bg-gray-200 text-gray-700 focus:outline-none"
                            data-value="2500">2500</button>
                        <button type="button"
                            class="km-btn px-4 py-2 rounded-lg border border-gray-300 bg-gray-200 text-gray-700 focus:outline-none"
                            data-value="5000">5000</button>
                    </div>
                    <input type="hidden" name="kilometrajes" id="kilometrajes">
                    <!-- Guardar� los seleccionados separados por coma, ejemplo: 500,2500 -->
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


    // Puedes poner este script al final de tu archivo blade o en tu secci�n de scripts
    document.addEventListener('DOMContentLoaded', function() {
        const btns = document.querySelectorAll('.km-btn');
        const input = document.getElementById('kilometrajes');
        // Ordenar los valores para control
        const orderedValues = [500, 2500, 5000];
        // Estado seleccionado
        let selected = [];

        btns.forEach(btn => {
            btn.addEventListener('click', function() {
                const val = parseInt(this.getAttribute('data-value'));
                const idx = orderedValues.indexOf(val);

                // Si ya est� seleccionado, lo deselecciona solo si los posteriores no est�n seleccionados
                if (selected.includes(val)) {
                    // Solo permite quitar si no hay posteriores seleccionados
                    const posteriores = orderedValues.slice(idx + 1);
                    const posterioresMarcados = posteriores.some(v => selected.includes(v));
                    if (posterioresMarcados) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Primero desmarque los siguientes',
                            text: 'Debe desmarcar primero los kilometrajes mayores antes de este.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        return;
                    }
                    // Quitar la selecci�n
                    selected = selected.filter(v => v !== val);
                    this.classList.remove('bg-green-500', 'text-white');
                    this.classList.add('bg-gray-200', 'text-gray-700');
                } else {
                    // Solo permite marcar si el anterior est� marcado (o es el primero)
                    if (idx === 0 || selected.includes(orderedValues[idx - 1])) {
                        selected.push(val);
                        selected = selected.sort((a, b) => a - b);
                        this.classList.remove('bg-gray-200', 'text-gray-700');
                        this.classList.add('bg-green-500', 'text-white');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Seleccione el anterior',
                            text: 'Debe marcar primero el kilometraje anterior.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                }
                input.value = selected.join(',');
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

        // Env�a la petici�n por fetch
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
                                title: 'Errores de Validaci�n',
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
                        title: '�Exito!',
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
