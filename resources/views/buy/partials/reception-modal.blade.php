 <!-- Modal de Recepción de Productos -->
    <div id="receptionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <!-- Header del Modal -->
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-medium text-gray-900">
                        <i class="fas fa-truck mr-2"></i>Recepcionar Productos - Compra #<span id="receptionBuyNumber"></span>
                    </h3>
                    <button onclick="closeReceptionModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>

                <!-- Información General -->
                <div class="bg-gray-50 p-4 rounded-lg mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-600">Proveedor:</label>
                            <p id="receptionSupplier" class="text-sm text-gray-900 font-semibold"></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Tienda:</label>
                            <p id="receptionTienda" class="text-sm text-gray-900"></p>
                        </div>
                    </div>
                </div>

                <!-- Lista de Productos -->
                <div class="overflow-x-auto mb-4">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cant. Esperada</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cant. Recibida</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Control</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="receptionProductsTable" class="bg-white divide-y divide-gray-200">
                        </tbody>
                    </table>
                </div>

                <!-- Footer del Modal -->
                <div class="flex justify-between mt-6 pt-4 border-t">
                    <button onclick="closeReceptionModal()" 
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Cancelar
                    </button>
                    <button onclick="processReception()" 
                            class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-save mr-1"></i>Guardar Recepción
                    </button>
                </div>
            </div>
        </div>
    </div>