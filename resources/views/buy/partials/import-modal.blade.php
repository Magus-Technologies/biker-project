    <!-- Modal de Importación -->
    <div id="importModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-6xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <!-- Paso 1: Subir archivo -->
                <div id="step1" class="step-content">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-upload mr-2"></i>Importar Compras - Paso 1: Subir Archivo
                    </h3>
                    <form id="uploadForm" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Archivo Excel</label>
                            <input type="file" name="file" accept=".xlsx,.xls,.csv" required 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <p class="text-sm text-gray-500 mt-1">Formatos soportados: Excel (.xlsx, .xls) y CSV</p>
                        </div>
                        <div class="flex justify-between">
                            <button type="button" onclick="hideImportModal()" 
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancelar
                            </button>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-search mr-1"></i>Procesar Archivo
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Paso 2: Preview y selección -->
                <div id="step2" class="step-content hidden">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-eye mr-2"></i>Importar Compras - Paso 2: Revisar y Seleccionar
                    </h3>
                    
                    <!-- Errores -->
                    <div id="importErrors" class="hidden mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <h4 class="font-bold">Errores encontrados:</h4>
                        <ul id="errorsList" class="list-disc list-inside mt-2"></ul>
                    </div>

                    <!-- Controles de selección -->
                    <div class="mb-4 flex justify-between items-center">
                        <div>
                            <button type="button" onclick="selectAllBuys()" 
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm">
                                <i class="fas fa-check-double mr-1"></i>Seleccionar Todo
                            </button>
                            <button type="button" onclick="deselectAllBuys()" 
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-3 rounded text-sm ml-2">
                                <i class="fas fa-times mr-1"></i>Deseleccionar Todo
                            </button>
                        </div>
                        <div>
                            <span id="selectedCount" class="text-sm text-gray-600">0 compras seleccionadas</span>
                        </div>
                    </div>

                    <!-- Tabla de preview -->
                    <div class="overflow-y-auto max-h-96 border rounded">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 sticky top-0">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                        <input type="checkbox" id="selectAllCheckbox" onchange="toggleAllBuys()">
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                </tr>
                            </thead>
                            <tbody id="previewTableBody" class="bg-white divide-y divide-gray-200">
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-between mt-4">
                        <button type="button" onclick="backToStep1()" 
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-arrow-left mr-1"></i>Volver
                        </button>
                        <div>
                            <button type="button" onclick="hideImportModal()" 
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Cancelar
                            </button>
                            <button type="button" onclick="importSelectedBuys()" 
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-save mr-1"></i>Importar Seleccionadas
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>