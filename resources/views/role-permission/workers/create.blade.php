<!-- resources\views\role-permission\workers\create.blade.php -->
<x-app-layout>
    <div class="container mx-auto mt-8 px-6">
        <div class="row justify-center">
            <div class="col-md-8">
                <!-- Mensajes de error -->
                @if ($errors->any())
                    <div class="bg-yellow-100 text-yellow-700 p-4 rounded-md mb-6 shadow-md">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Card de creación -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-6">
                        <h4 class="text-2xl font-semibold">Registrar Trabajador</h4>
                        <a href="{{ url('users') }}"
                            class="bg-red-600 hover:bg-red-500 text-white py-2 px-4 rounded-md transition-all float-right">
                            Atras
                        </a>
                    </div>
                    <div class="p-6">
                        <form action="{{ url('users') }}" method="POST">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <!-- DNI con autocompletado -->
                                <div class="mb-4">
                                    <label for="dni" class="block text-gray-700 font-medium">DNI <span class="text-red-500">*</span></label>
                                    <div class="flex mt-2">
                                        <input type="text" name="dni" id="dni" maxlength="8"
                                            class="w-full p-3 border rounded-md focus:ring focus:ring-blue-300 focus:outline-none" />
                                        <button id="buscarDni" type="button" 
                                            class="ml-2 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-3 rounded-md transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div id="dni-loading" class="hidden mt-2 text-blue-600 text-sm">
                                        <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-blue-600 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Buscando datos...
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="name" class="block text-gray-700 font-medium">Nombres <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" id="name"
                                        class="w-full mt-2 p-3 border rounded-md focus:ring focus:ring-blue-300 focus:outline-none" />
                                </div>
                                <div class="mb-4">
                                    <label for="apellidos" class="block text-gray-700 font-medium">Apellidos <span class="text-red-500">*</span></label>
                                    <input type="text" name="apellidos" id="apellidos"
                                        class="w-full mt-2 p-3 border rounded-md focus:ring focus:ring-blue-300 focus:outline-none" />
                                </div>
                                <div class="mb-4">
                                    <label for="telefono" class="block text-gray-700 font-medium">Telefono <span class="text-red-500">*</span></label>
                                    <input type="text" name="telefono" id="telefono"
                                        class="w-full mt-2 p-3 border rounded-md focus:ring focus:ring-blue-300 focus:outline-none" />
                                </div>
                                <div class="mb-4">
                                    <label for="direccion" class="block text-gray-700 font-medium">Direccion <span class="text-red-500">*</span></label>
                                    <input type="text" name="direccion" id="direccion"
                                        class="w-full mt-2 p-3 border rounded-md focus:ring focus:ring-blue-300 focus:outline-none" />
                                </div>
                                <div class="mb-4">
                                    <label for="correo" class="block text-gray-700 font-medium">Correo electronico <span class="text-red-500">*</span></label>
                                    <input type="email" name="correo" id="correo"
                                        class="w-full mt-2 p-3 border rounded-md focus:ring focus:ring-blue-300 focus:outline-none" />
                                </div>

                                <!-- Select de tiendas -->
                                <div class="mb-4">
                                    <label for="tienda_id" class="block text-gray-700 font-medium">Tienda</label>
                                    <select name="tienda_id" id="tienda_id"
                                        class="w-full mt-2 p-3 border rounded-md focus:ring focus:ring-blue-300 focus:outline-none">
                                        <option value="">Seleccione una tienda</option>
                                    </select>
                                </div>

                                <!-- Campo Email -->
                                <div class="mb-4">
                                    <label for="email" class="block text-gray-700 font-medium">Correo Usuario <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" id="email"
                                        class="w-full mt-2 p-3 border rounded-md focus:ring focus:ring-blue-300 focus:outline-none" />
                                </div>

                                <!-- Campo Contraseña -->
                                <div class="mb-4">
                                    <label for="password" class="block text-gray-700 font-medium">Contraseña <span class="text-red-500">*</span></label>
                                    <input type="password" name="password" id="password"
                                        class="w-full mt-2 p-3 border rounded-md focus:ring focus:ring-blue-300 focus:outline-none" />
                                </div>

                                <!-- Campo Roles -->
                                <div class="mb-4">
                                    <label for="roles" class="block text-gray-700 font-medium">Perfiles <span class="text-red-500">*</span></label>
                                    <select name="roles[]" id="roles"
                                        class="w-full mt-2 p-3 border rounded-md focus:ring focus:ring-blue-300 focus:outline-none"
                                        multiple>
                                        <option value="">Seleccione...</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role }}">{{ $role }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Botón Guardar -->
                            <div class="mt-6">
                                <button type="submit"
                                    class="w-full bg-green-600 text-white py-3 px-4 rounded-md hover:bg-green-500 transition-all">
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cargar tiendas al inicializar
            loadTiendas();

            // API DNI
            const dniInput = document.getElementById('dni');
            const buscarBtn = document.getElementById('buscarDni');
            const loadingDiv = document.getElementById('dni-loading');
            const token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InN5c3RlbWNyYWZ0LnBlQGdtYWlsLmNvbSJ9.yuNS5hRaC0hCwymX_PjXRoSZJWLNNBeOdlLRSUGlHGA';

            // Autocompletado al escribir DNI
            dniInput.addEventListener('input', function() {
                const dni = this.value;
                if (dni.length === 8 && /^\d{8}$/.test(dni)) {
                    buscarDNI(dni);
                } else {
                    // Limpiar campos si el DNI no es válido
                    clearPersonalData();
                }
            });

            // Búsqueda manual con botón
            buscarBtn.addEventListener('click', function() {
                const dni = dniInput.value;
                if (dni.length === 8 && /^\d{8}$/.test(dni)) {
                    buscarDNI(dni);
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'DNI inválido',
                        text: 'Por favor ingrese un DNI válido de 8 dígitos',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            });

            async function buscarDNI(dni) {
                loadingDiv.classList.remove('hidden');
                buscarBtn.disabled = true;

                try {
                    const response = await fetch(`https://dniruc.apisperu.com/api/v1/dni/${dni}?token=${token}`);
                    const data = await response.json();

                    if (data.success === false) {
                        Swal.fire({
                            icon: 'error',
                            title: 'DNI no encontrado',
                            text: data.message || 'No se pudo encontrar información para este DNI',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        clearPersonalData();
                    } else {
                        // Llenar campos con los datos obtenidos
                        document.getElementById('name').value = data.nombres || '';
                        document.getElementById('apellidos').value = `${data.apellidoPaterno || ''} ${data.apellidoMaterno || ''}`.trim();
                        
                        // Mostrar mensaje de éxito
                        Swal.fire({
                            icon: 'success',
                            title: '¡Datos encontrados!',
                            text: `Información cargada para ${data.nombres} ${data.apellidoPaterno}`,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de conexión',
                        text: 'Hubo un problema al consultar el DNI. Intente nuevamente.',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    clearPersonalData();
                } finally {
                    loadingDiv.classList.add('hidden');
                    buscarBtn.disabled = false;
                }
            }

            function clearPersonalData() {
                document.getElementById('name').value = '';
                document.getElementById('apellidos').value = '';
            }

            // Cargar tiendas activas
            async function loadTiendas() {
                try {
                    const response = await fetch('/biker-project/public/tiendas/activas');
                    const data = await response.json();
                    
                    if (data.success) {
                        const select = document.getElementById('tienda_id');
                        select.innerHTML = '<option value="">Seleccione una tienda</option>';
                        
                        data.tiendas.forEach(tienda => {
                            const option = document.createElement('option');
                            option.value = tienda.id;
                            option.textContent = tienda.nombre;
                            select.appendChild(option);
                        });
                    }
                } catch (error) {
                    console.error('Error al cargar tiendas:', error);
                }
            }

            // Generar email automático basado en nombre y apellidos
            document.getElementById('name').addEventListener('blur', generateEmail);
            document.getElementById('apellidos').addEventListener('blur', generateEmail);

            function generateEmail() {
                const name = document.getElementById('name').value.trim();
                const apellidos = document.getElementById('apellidos').value.trim();
                const emailField = document.getElementById('email');
                
                if (name && apellidos && !emailField.value) {
                    const firstName = name.split(' ')[0].toLowerCase();
                    const lastName = apellidos.split(' ')[0].toLowerCase();
                    const email = `${firstName}.${lastName}@empresa.com`;
                    emailField.value = email;
                }
            }
        });
    </script>
</x-app-layout>