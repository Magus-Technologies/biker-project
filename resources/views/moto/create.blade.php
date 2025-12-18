<x-app-layout>
    <x-breadcrumb 
        title="Registrar Moto" 
        parent="Motos" 
        parentUrl="{{ route('motos.index') }}" 
        subtitle="Crear" 
    />

    <div class="px-3 py-4">
        <div class="bg-white rounded-lg shadow-lg p-4 md:p-6 border border-gray-200 max-w-4xl mx-auto">
            <form id="formMoto">
                @csrf
                <h5 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">
                    <i class="bi bi-motorcycle mr-2 text-blue-600"></i>
                    Datos de la Moto
                </h5>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="nro_motor" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-gear mr-1 text-gray-500"></i>Número de Motor *
                        </label>
                        <input type="text" name="nro_motor" id="nro_motor" required
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="nro_chasis" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-hash mr-1 text-gray-500"></i>Número de Chasis
                        </label>
                        <input type="text" name="nro_chasis" id="nro_chasis"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label for="marca" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-award mr-1 text-gray-500"></i>Marca *
                        </label>
                        <input type="text" name="marca" id="marca" value="{{ $marca ?? '' }}" {{ $marca ? 'readonly' : '' }} required
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $marca ? 'bg-gray-50' : '' }}">
                    </div>
                    <div>
                        <label for="modelo" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-tag mr-1 text-gray-500"></i>Modelo *
                        </label>
                        <input type="text" name="modelo" id="modelo" required
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="anio" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-calendar mr-1 text-gray-500"></i>Año
                        </label>
                        <input type="text" name="anio" id="anio" placeholder="2024"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-palette mr-1 text-gray-500"></i>Color
                        </label>
                        <input type="text" name="color" id="color"
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="lugar_provisional" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-geo-alt mr-1 text-gray-500"></i>Lugar Provisional
                        </label>
                        <input type="text" name="lugar_provisional" id="lugar_provisional" placeholder="Ej: Taller, Almacén, etc."
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-center gap-3 pt-4 border-t">
                    <a href="{{ route('motos.index') }}" class="px-6 py-2 bg-gray-500 text-white rounded-lg shadow-md hover:bg-gray-600 transition text-center text-sm">
                        <i class="bi bi-x-lg mr-1"></i>
                        Cancelar
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition text-sm">
                        <i class="bi bi-save mr-1"></i>
                        Registrar Moto
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
document.getElementById('formMoto').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch('{{ route("motos.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: data.message,
                confirmButtonColor: '#10b981'
            }).then(() => {
                window.location.href = '{{ route("motos.index") }}';
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message,
                confirmButtonColor: '#ef4444'
            });
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrió un error al registrar la moto',
            confirmButtonColor: '#ef4444'
        });
    }
});
</script>
