 <!-- Modal de Escaneo de Códigos -->
    <div id="scanModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" style="z-index: 9999;">
        <div class="relative top-20 mx-auto p-6 border w-11/12 max-w-md shadow-lg rounded-md bg-white">
            <div class="text-center">
                <!-- Header -->
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">
                        <i class="fas fa-qrcode mr-2"></i>ESCANEAR CÓDIGOS ÚNICOS DEL PRODUCTO
                    </h3>
                </div>

                <!-- Información del Producto -->
                <div class="bg-gray-50 p-3 rounded-lg mb-4 text-left">
                    <div class="mb-2">
                        <span class="font-semibold text-gray-700">Producto:</span>
                        <p id="scanProductName" class="text-sm text-gray-900"></p>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-700">Cantidad esperada:</span>
                        <span id="scanExpectedQuantity" class="text-sm text-gray-900 font-bold"></span>
                    </div>
                </div>

                <!-- Input de Escaneo -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Código escaneado:</label>
                    <div class="flex">
                        <input type="text" id="scannedCodeInput" 
                               class="flex-1 border-gray-300 rounded-l-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Escanee o ingrese el código"
                               onkeypress="handleScanKeyPress(event)">
                        <button onclick="addScannedCode()" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-r-md">
                            <i class="fas fa-plus"></i> Agregar
                        </button>
                    </div>
                </div>

                <!-- Lista de Códigos Escaneados -->
                <div class="mb-4">
                    <h4 class="font-semibold text-gray-700 mb-2">Códigos escaneados:</h4>
                    <div id="scannedCodesList" class="bg-gray-50 border rounded p-3 max-h-32 overflow-y-auto text-left">
                        <p class="text-gray-500 text-sm">Ningún código escaneado aún...</p>
                    </div>
                </div>

                <!-- Progreso -->
                <div class="mb-4">
                    <div class="bg-gray-200 rounded-full h-2 mb-2">
                        <div id="scanProgress" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                    <p id="scanProgressText" class="text-sm font-semibold text-gray-700">Progreso: 0/0 códigos escaneados</p>
                    <p id="scanStatusText" class="text-xs text-gray-600 mt-1">Esperando códigos...</p>
                </div>

                <!-- Botones -->
                <div class="flex justify-between">
                    <button onclick="closeScanModal()" 
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Cancelar
                    </button>
                    <button id="saveScanButton" onclick="saveScanCodes()" 
                            class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded opacity-50 cursor-not-allowed"
                            disabled>
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>