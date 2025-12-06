<x-app-layout>
    <!-- Breadcrumb -->
    <x-breadcrumb 
        title="Editar Garantía" 
        parent="Garantías" 
        parentUrl="{{ route('garantines.index') }}"
        subtitle="Editar #{{ $garantine->codigo }}" 
    />

    <div class="px-3 py-4">
        <div class="w-full">
            <form class="p-4 sm:p-6 bg-white rounded-lg shadow-md" id="formGarantine" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <h5 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Datos de Garantía</h5>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 sm:gap-4 mb-4">
                    <div class="w-full">
                        <label for="n_documento" class="block text-sm font-medium text-gray-700 mb-1">Nº Documento *</label>
                        <div class="flex gap-2">
                            <input name="n_documento" id="n_documento" type="text" placeholder="Ingrese Documento" required
                                value="{{ $garantine->nro_documento }}"
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
                            value="{{ $garantine->nombres_apellidos }}"
                            class="block w-full p-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <h5 class="text-lg font-semibold text-gray-800 mb-4 mt-6 border-b pb-2">Datos del Vehículo</h5>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 mb-4">
                    <div class="w-full">
                        <label for="marca" class="block text-sm font-medium text-gray-700 mb-1">Marca</label>
                        <input type="text" name="marca" value="{{ $garantine->marca }}"
                            class="block w-full p-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="w-full">
                        <label for="modelo" class="block text-sm font-medium text-gray-700 mb-1">Modelo</label>
                        <input type="text" name="modelo" value="{{ $garantine->modelo }}"
                            class="block w-full p-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="w-full">
                        <label for="anio" class="block text-sm font-medium text-gray-700 mb-1">Año</label>
                        <input type="text" name="anio" value="{{ $garantine->anio }}"
                            class="block w-full p-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 mb-4">
                    <div class="w-full">
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                        <input type="text" name="color" value="{{ $garantine->color }}"
                            class="block w-full p-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="w-full">
                        <label for="nro_motor" class="block text-sm font-medium text-gray-700 mb-1">Número de Motor *</label>
                        <input type="text" name="nro_motor" value="{{ $garantine->nro_motor }}" required
                            class="block w-full p-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="w-full">
                        <label for="nro_chasis" class="block text-sm font-medium text-gray-700 mb-1">Número de Chasis</label>
                        <input type="text" name="nro_chasis" value="{{ $garantine->nro_chasis }}"
                            class="block w-full p-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 sm:gap-4 mb-4">
                    <div class="w-full">
                        <label for="celular" class="block text-sm font-medium text-gray-700 mb-1">Número de Celular</label>
                        <input type="text" name="celular" value="{{ $garantine->celular }}"
                            class="block w-full p-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="w-full">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kilometraje</label>
                        <div id="kilometraje-group" class="flex flex-wrap gap-2">
                            @foreach(['0-500', '500-2500', '2500-5000'] as $km)
                                <button type="button"
                                    class="km-btn px-3 py-2 text-xs sm:text-sm rounded-lg border border-gray-300 {{ $garantine->kilometrajes == $km ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }} hover:bg-blue-400 hover:text-white transition flex-shrink-0"
                                    data-value="{{ $km }}">
                                    {{ $km }} km
                                </button>
                            @endforeach
                        </div>
                        <input type="hidden" name="kilometrajes" id="kilometrajes" value="{{ $garantine->kilometrajes }}">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Boleta/DUA (PDF)</label>
                    
                    @if($garantine->boleta_dua_pdfs)
                        @php
                            $pdfs = json_decode($garantine->boleta_dua_pdfs, true) ?? [];
                        @endphp
                        @if(count($pdfs) > 0)
                            <div class="mb-3 p-3 bg-gray-50 rounded-lg">
                                <p class="text-sm font-medium text-gray-700 mb-2">Archivos actuales:</p>
                                <div class="space-y-2">
                                    @foreach($pdfs as $index => $pdf)
                                        <div class="flex items-center justify-between p-2 bg-white rounded border">
                                            <span class="text-sm text-gray-700">{{ $pdf['original_name'] ?? 'Archivo ' . ($index + 1) }}</span>
                                            <a href="{{ asset('storage/' . $pdf['stored_path']) }}" target="_blank" 
                                                class="text-blue-600 hover:text-blue-800 text-sm">
                                                <i class="bi bi-download mr-1"></i>Ver PDF
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif
                    
                    <input type="file" name="boleta_dua[]" id="boleta_dua" accept=".pdf" multiple
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-500 mt-1">Puedes agregar más archivos PDF</p>
                </div>

                <div class="flex flex-col sm:flex-row justify-center gap-3 mt-6 pt-6 border-t">
                    <button id="btnActualizar" type="button"
                        class="w-full sm:w-auto px-6 py-2 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition font-medium text-sm">
                        <i class="bi bi-check-circle mr-2"></i>Actualizar Garantía
                    </button>
                    <a href="{{ route('garantines.index') }}"
                        class="w-full sm:w-auto px-6 py-2 bg-gray-500 text-white rounded-lg shadow-md hover:bg-gray-600 transition font-medium text-center text-sm">
                        <i class="bi bi-x-circle mr-2"></i>Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Kilometraje buttons
        const kmButtons = document.querySelectorAll('.km-btn');
        const kmInput = document.getElementById('kilometrajes');

        kmButtons.forEach(button => {
            button.addEventListener('click', function() {
                kmButtons.forEach(btn => {
                    btn.classList.remove('bg-blue-500', 'text-white');
                    btn.classList.add('bg-gray-200', 'text-gray-700');
                });
                
                this.classList.remove('bg-gray-200', 'text-gray-700');
                this.classList.add('bg-blue-500', 'text-white');
                
                kmInput.value = this.dataset.value;
            });
        });

        // Submit form
        document.getElementById('btnActualizar').addEventListener('click', function() {
            const formData = new FormData(document.getElementById('formGarantine'));

            fetch('{{ route("garantines.update", $garantine->id) }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
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
                        text: data.message || 'Error al actualizar la garantía',
                        confirmButtonColor: '#ef4444'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al actualizar la garantía',
                    confirmButtonColor: '#ef4444'
                });
            });
        });
    });

    // API DNI function
    function apiDNI() {
        const dni = document.getElementById('n_documento').value;
        if (dni.length !== 8) {
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: 'El DNI debe tener 8 dígitos',
                confirmButtonColor: '#f59e0b'
            });
            return;
        }

        fetch(`https://dniruc.apisperu.com/api/v1/dni/${dni}?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImFkbWluaXN0cmFkb3JAZ21haWwuY29tIn0.Y_EB6yNRu_bRdQzjqMNYzKPNKqJMCHZKJLgWKLBJLQo`)
            .then(response => response.json())
            .then(data => {
                if (data.nombres) {
                    document.getElementById('datos_cliente').value = `${data.nombres} ${data.apellidoPaterno} ${data.apellidoMaterno}`;
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se encontró información para este DNI',
                        confirmButtonColor: '#ef4444'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al consultar el DNI',
                    confirmButtonColor: '#ef4444'
                });
            });
    }
</script>
