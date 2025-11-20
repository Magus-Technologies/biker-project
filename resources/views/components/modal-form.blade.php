<!-- resources/views/components/modal-form.blade.php -->
@props(['id', 'title', 'action', 'method' => 'POST'])

<div id="{{ $id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center p-4 z-50">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md">
        <!-- Header del Modal -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white px-6 py-4 flex justify-between items-center rounded-t-xl">
            <h3 class="text-lg font-semibold flex items-center">
                <i class="bi bi-pencil-square mr-2"></i>
                {{ $title }}
            </h3>
            <button onclick="closeModal('{{ $id }}')" class="text-white hover:text-gray-200 text-2xl transition">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <!-- Contenido del Modal -->
        <form action="{{ $action }}" method="POST" class="p-6">
            @csrf
            @if($method !== 'POST')
                @method($method)
            @endif

            {{ $slot }}

            <!-- Botones -->
            <div class="flex gap-3 mt-6">
                <button type="button" onclick="closeModal('{{ $id }}')" 
                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors">
                    <i class="bi bi-x-circle mr-1"></i>
                    Cancelar
                </button>
                <button type="submit" 
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    <i class="bi bi-check-circle mr-1"></i>
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}
</script>
