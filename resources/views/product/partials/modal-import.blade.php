<!-- resources/views/product/partials/modal-import.blade.php -->
<div id="importModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-40">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md m-4">
        <div class="flex justify-between items-center p-4 border-b">
            <h2 class="text-lg font-semibold">Importar Productos</h2>
            <button id="btnCloseImportModal" class="text-gray-500 hover:text-gray-700 text-2xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="p-6">
            <a href="{{ route('plantilla.descargar') }}" class="flex items-center justify-center text-blue-600 hover:text-blue-800 mb-4 bg-blue-50 p-3 rounded-lg border border-blue-200">
                <i class="fas fa-download mr-2"></i>
                Descargar Plantilla de Importación
            </a>

            <form id="importForm" enctype="multipart/form-data">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Seleccionar archivo (.xlsx, .csv)</label>
                    <input type="file" id="importFile" name="file" required 
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                </div>
                
                <div class="flex space-x-3 mt-6">
                    <button type="button" id="btnCancelImport" class="w-full bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded-lg transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition-colors flex items-center justify-center">
                        <i class="fas fa-upload mr-2"></i>
                        Importar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
