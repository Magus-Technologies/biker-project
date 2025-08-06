<!-- 1. REEMPLAZAR completamente buy/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-shopping-cart mr-2"></i>{{ __('Gestión de Compras') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filtros -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-filter mr-2"></i>Filtros de Búsqueda
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha Desde</label>
                            <input type="date" id="fecha_desde" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha Hasta</label>
                            <input type="date" id="fecha_hasta" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Estado de Productos</label>
                            <select id="products_status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Todos</option>
                                <option value="recibidos">Productos Recibidos</option>
                                <option value="pendientes">Pendientes de Llegada</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Proveedor</label>
                            <select id="supplier_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Todos los proveedores</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->nombre_negocio }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-4 flex justify-between items-center">
                        <!-- Grupo de botones de acciones principales -->
                        <div class="flex space-x-2">
                            <button onclick="filterBuys()" class="bg-blue-600 hover:bg-blue-700 text-white font-normal text-sm py-1.5 px-3 rounded">
                                <i class="fas fa-search mr-1"></i>Buscar
                            </button>
                            <button onclick="clearFilters()" class="bg-gray-500 hover:bg-gray-700 text-white font-normal text-sm py-1.5 px-3 rounded">
                                <i class="fas fa-eraser mr-1"></i>Limpiar
                            </button>
                        </div>

                        <!-- Grupo de botones de exportación e importación -->
                        <div class="flex space-x-2">
                            <button onclick="exportReports('pdf')" class="bg-red-600 hover:bg-red-700 text-white font-normal text-sm py-1.5 px-3 rounded">
                                <i class="fas fa-file-pdf mr-1"></i>PDF
                            </button>
                            <button onclick="exportReports('excel')" class="bg-green-600 hover:bg-green-700 text-white font-normal text-sm py-1.5 px-3 rounded">
                                <i class="fas fa-file-excel mr-1"></i>Excel
                            </button>
                            <button onclick="showImportModal()" class="bg-green-500 hover:bg-green-700 text-white font-normal text-sm py-1.5 px-3 rounded">
                                <i class="fas fa-upload mr-1"></i>Importar
                            </button>
                            <button onclick="downloadTemplate()" class="bg-blue-500 hover:bg-blue-700 text-white font-normal text-sm py-1.5 px-3 rounded">
                                <i class="fas fa-download mr-1"></i>Plantilla
                            </button>
                        </div>

                        <!-- Botón principal separado -->
                        <div>
                            <a href="{{ route('buys.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm py-2 px-4 rounded-lg shadow-lg">
                                <i class="fas fa-plus mr-1"></i>Nueva Compra
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Lista de Compras -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-list mr-2"></i>Lista de Compras
                    </h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200" id="buysTable">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-hashtag mr-1"></i>Serie/Número
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-building mr-1"></i>Proveedor
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-calendar mr-1"></i>Fecha
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-dollar-sign mr-1"></i>Total
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-info-circle mr-1"></i>Estado Productos
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-store mr-1"></i>Tienda
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-cogs mr-1"></i>Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="buysTableBody" class="bg-white divide-y divide-gray-200">
                                <!-- Datos cargados dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Proveedor</th>
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

    <!-- Modal de Detalles de Compra -->
    <div id="buyDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-6xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <!-- Header del Modal -->
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-medium text-gray-900">
                        <i class="fas fa-shopping-cart mr-2"></i>Detalles de Compra #<span id="buyNumber"></span>
                    </h3>
                    <button onclick="closeBuyDetailsModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>

                <!-- Información General -->
                <div class="bg-gray-50 p-4 rounded-lg mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-600">Proveedor:</label>
                            <p id="buySupplier" class="text-sm text-gray-900 font-semibold"></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Fecha:</label>
                            <p id="buyDate" class="text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Total:</label>
                            <p id="buyTotal" class="text-sm text-gray-900 font-bold text-green-600"></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Tienda:</label>
                            <p id="buyTienda" class="text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Tipo de Pago:</label>
                            <p id="buyPaymentType" class="text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Estado Productos:</label>
                            <p id="buyDeliveryStatus" class="text-sm"></p>
                        </div>
                    </div>
                </div>

                <!-- Pestañas -->
                <div class="border-b border-gray-200 mb-4">
                    <nav class="-mb-px flex space-x-8">
                        <button onclick="showTab('products')" id="productsTab" 
                                class="tab-button active border-b-2 border-blue-500 py-2 px-1 text-blue-600 font-medium text-sm">
                            <i class="fas fa-box mr-1"></i>Productos
                        </button>
                        <button onclick="showTab('installments')" id="installmentsTab" 
                                class="tab-button border-b-2 border-transparent py-2 px-1 text-gray-500 hover:text-gray-700 font-medium text-sm">
                            <i class="fas fa-credit-card mr-1"></i>Cuotas <span id="installmentsCount" class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full ml-1"></span>
                        </button>
                    </nav>
                </div>

                <!-- Contenido de Pestañas -->
                <!-- Pestaña Productos -->
                <div id="productsContent" class="tab-content">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">SKU</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio Unit.</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Códigos</th>
                                </tr>
                            </thead>
                            <tbody id="buyProductsTable" class="bg-white divide-y divide-gray-200">
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pestaña Cuotas -->
                <div id="installmentsContent" class="tab-content hidden">
                    <div id="noInstallmentsMessage" class="text-center py-8 text-gray-500 hidden">
                        <i class="fas fa-info-circle text-4xl mb-2"></i>
                        <p>Esta compra no tiene cuotas de crédito</p>
                    </div>
                    
                    <div id="installmentsTable" class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cuota #</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Método de Pago</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Monto</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Vencimiento</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Pagado</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="buyInstallmentsTable" class="bg-white divide-y divide-gray-200">
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Footer del Modal -->
                <div class="flex justify-end mt-6 pt-4 border-t">
                    <button onclick="closeBuyDetailsModal()" 
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

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

</x-app-layout>

<script>

let importData = [];
let selectedBuys = [];

document.addEventListener('DOMContentLoaded', function() {
    // Cargar compras al iniciar
    filterBuys();
    
    // Configurar fechas por defecto (último mes)
    const today = new Date();
    const lastMonth = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());
    
    document.getElementById('fecha_desde').value = lastMonth.toISOString().split('T')[0];
    document.getElementById('fecha_hasta').value = today.toISOString().split('T')[0];

    // Configurar formulario de upload
    document.getElementById('uploadForm').addEventListener('submit', function(e) {
        e.preventDefault();
        processImportFile();
    });

});

function filterBuys() {
    const filters = {
        fecha_desde: document.getElementById('fecha_desde').value,
        fecha_hasta: document.getElementById('fecha_hasta').value,
        products_status: document.getElementById('products_status').value,
        supplier_id: document.getElementById('supplier_id').value
    };
    
    fetch('{{ route("buy.filteredList") }}?' + new URLSearchParams(filters))
        .then(response => response.json())
        .then(data => {
            renderBuysTable(data);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar las compras');
        });
}

function renderBuysTable(buys) {
    const tbody = document.getElementById('buysTableBody');
    tbody.innerHTML = '';
    
    if (buys.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                    <i class="fas fa-inbox mr-2"></i>No se encontraron compras
                </td>
            </tr>
        `;
        return;
    }
    
    buys.forEach(buy => {
        const statusBadge = getStatusBadge(buy.products_status);
        const row = `
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    ${buy.serie}-${buy.number}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    ${buy.supplier ? buy.supplier.nombre_negocio : 'N/A'}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    ${new Date(buy.fecha_registro).toLocaleDateString()}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    S/ ${parseFloat(buy.total_price).toFixed(2)}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    ${statusBadge}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    ${buy.tienda ? buy.tienda.nombre : 'N/A'}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex space-x-2">
                        <button onclick="viewDetails(${buy.id})" 
                                class="text-blue-600 hover:text-blue-900">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button onclick="downloadPDF(${buy.id})" 
                                class="text-red-600 hover:text-red-900">
                            <i class="fas fa-file-pdf"></i>
                        </button>
                        ${buy.products_status === 'pendientes' ? 
                            `<button onclick="receiveProducts(${buy.id})" 
                                     class="text-green-600 hover:text-green-900">
                                <i class="fas fa-truck"></i>
                             </button>` : ''}
                    </div>
                </td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
}

function getStatusBadge(status) {
    const badges = {
        'recibidos': '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"><i class="fas fa-check mr-1"></i>Recibidos</span>',
        'pendientes': '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800"><i class="fas fa-clock mr-1"></i>Pendientes</span>'
    };
    return badges[status] || status;
}

function clearFilters() {
    document.getElementById('fecha_desde').value = '';
    document.getElementById('fecha_hasta').value = '';
    document.getElementById('products_status').value = '';
    document.getElementById('supplier_id').value = '';
    filterBuys();
}

function exportReports(format) {
    const filters = {
        fecha_desde: document.getElementById('fecha_desde').value,
        fecha_hasta: document.getElementById('fecha_hasta').value,
        products_status: document.getElementById('products_status').value,
        supplier_id: document.getElementById('supplier_id').value,
        format: format
    };
    
    window.open('{{ route("buy.exportReports") }}?' + new URLSearchParams(filters));
}

function downloadTemplate() {
   window.open('{{ route("buy.downloadTemplate") }}');
}

function showImportModal() {
   document.getElementById('importModal').classList.remove('hidden');
   showStep1();
}

function hideImportModal() {
   document.getElementById('importModal').classList.add('hidden');
   resetImportModal();
}

function showStep1() {
   document.getElementById('step1').classList.remove('hidden');
   document.getElementById('step2').classList.add('hidden');
}

function showStep2() {
   document.getElementById('step1').classList.add('hidden');
   document.getElementById('step2').classList.remove('hidden');
}

function backToStep1() {
   showStep1();
   resetImportData();
}

function resetImportModal() {
   showStep1();
   resetImportData();
   document.getElementById('uploadForm').reset();
}

function resetImportData() {
   importData = [];
   selectedBuys = [];
   document.getElementById('previewTableBody').innerHTML = '';
   document.getElementById('importErrors').classList.add('hidden');
   document.getElementById('selectedCount').textContent = '0 compras seleccionadas';
}

function processImportFile() {
   const formData = new FormData(document.getElementById('uploadForm'));
   
   // Mostrar loading
   const submitButton = document.querySelector('#uploadForm button[type="submit"]');
   const originalText = submitButton.innerHTML;
   submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Procesando...';
   submitButton.disabled = true;
   
   fetch('{{ route("buy.processImport") }}', {
       method: 'POST',
       body: formData,
       headers: {
           'X-CSRF-TOKEN': '{{ csrf_token() }}'
       }
   })
   .then(response => response.json())
   .then(data => {
       if (data.success) {
           importData = data.data;
           selectedBuys = [...importData]; // Seleccionar todo por defecto
           
           if (data.errors && data.errors.length > 0) {
               showErrors(data.errors);
           }
           
           renderPreviewTable();
           updateSelectedCount();
           showStep2();
       } else {
           alert('Error: ' + data.message);
       }
   })
   .catch(error => {
       console.error('Error:', error);
       alert('Error al procesar el archivo');
   })
   .finally(() => {
       submitButton.innerHTML = originalText;
       submitButton.disabled = false;
   });
}

function showErrors(errors) {
   const errorsDiv = document.getElementById('importErrors');
   const errorsList = document.getElementById('errorsList');
   
   errorsList.innerHTML = '';
   errors.forEach(error => {
       const li = document.createElement('li');
       li.textContent = error;
       errorsList.appendChild(li);
   });
   
   errorsDiv.classList.remove('hidden');
}

function renderPreviewTable() {
   const tbody = document.getElementById('previewTableBody');
   tbody.innerHTML = '';
   
   importData.forEach((item, index) => {
       const isSelected = selectedBuys.includes(item);
       const total = (item.cantidad * item.precio).toFixed(2);
       const statusText = item.delivery_status === 'received' ? 'Recibidos' : 'Pendientes';
       const statusClass = item.delivery_status === 'received' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800';
       
       const row = `
           <tr class="hover:bg-gray-50">
               <td class="px-4 py-2">
                   <input type="checkbox" 
                          data-index="${index}" 
                          ${isSelected ? 'checked' : ''} 
                          onchange="toggleBuySelection(${index})">
               </td>
               <td class="px-4 py-2 text-sm">${item.supplier.nombre_negocio}</td>
               <td class="px-4 py-2 text-sm">${item.fecha}</td>
               <td class="px-4 py-2 text-sm">${item.product.description}</td>
               <td class="px-4 py-2 text-sm">${item.cantidad}</td>
               <td class="px-4 py-2 text-sm">S/ ${parseFloat(item.precio).toFixed(2)}</td>
               <td class="px-4 py-2 text-sm font-semibold">S/ ${total}</td>
               <td class="px-4 py-2">
                   <span class="px-2 py-1 text-xs font-semibold rounded-full ${statusClass}">
                       ${statusText}
                   </span>
               </td>
           </tr>
       `;
       tbody.innerHTML += row;
   });
}

function toggleBuySelection(index) {
   const item = importData[index];
   const selectedIndex = selectedBuys.indexOf(item);
   
   if (selectedIndex > -1) {
       selectedBuys.splice(selectedIndex, 1);
   } else {
       selectedBuys.push(item);
   }
   
   updateSelectedCount();
   updateSelectAllCheckbox();
}

function toggleAllBuys() {
   const selectAllCheckbox = document.getElementById('selectAllCheckbox');
   
   if (selectAllCheckbox.checked) {
       selectAllBuys();
   } else {
       deselectAllBuys();
   }
}

function selectAllBuys() {
   selectedBuys = [...importData];
   updateSelectedCount();
   updateCheckboxes();
   document.getElementById('selectAllCheckbox').checked = true;
}

function deselectAllBuys() {
   selectedBuys = [];
   updateSelectedCount();
   updateCheckboxes();
   document.getElementById('selectAllCheckbox').checked = false;
}

function updateCheckboxes() {
   const checkboxes = document.querySelectorAll('input[data-index]');
   checkboxes.forEach((checkbox, index) => {
       const item = importData[index];
       checkbox.checked = selectedBuys.includes(item);
   });
}

function updateSelectAllCheckbox() {
   const selectAllCheckbox = document.getElementById('selectAllCheckbox');
   selectAllCheckbox.checked = selectedBuys.length === importData.length;
}

function updateSelectedCount() {
   document.getElementById('selectedCount').textContent = `${selectedBuys.length} compras seleccionadas`;
}

function importSelectedBuys() {
   if (selectedBuys.length === 0) {
       alert('Debe seleccionar al menos una compra para importar');
       return;
   }
   
   // Mostrar loading
   const importButton = document.querySelector('button[onclick="importSelectedBuys()"]');
   const originalText = importButton.innerHTML;
   importButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Importando...';
   importButton.disabled = true;
   
   fetch('{{ route("buy.importSelected") }}', {
       method: 'POST',
       headers: {
           'Content-Type': 'application/json',
           'X-CSRF-TOKEN': '{{ csrf_token() }}'
       },
       body: JSON.stringify({
           selected_buys: selectedBuys
       })
   })
   .then(response => response.json())
   .then(data => {
       if (data.success) {
           alert(`${data.message}\nCompras importadas: ${data.imported_count}`);
           
           if (data.errors && data.errors.length > 0) {
               console.log('Errores durante la importación:', data.errors);
           }
           
           hideImportModal();
           filterBuys(); // Recargar tabla
       } else {
           alert('Error: ' + data.message);
       }
   })
   .catch(error => {
       console.error('Error:', error);
       alert('Error al importar compras');
   })
   .finally(() => {
       importButton.innerHTML = originalText;
       importButton.disabled = false;
   });
}

function viewDetails(buyId) {
    showBuyDetailsModal(buyId);
}


function downloadPDF(buyId) {
    window.open(`/buy/pdf/${buyId}`, '_blank');
}

function receiveProducts(buyId) {
    showReceptionModal(buyId);
}

let currentBuyData = null;

function showBuyDetailsModal(buyId) {
    fetch(`/buy/modal-details/${buyId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                currentBuyData = data.buy;
                populateBuyDetailsModal(data.buy);
                document.getElementById('buyDetailsModal').classList.remove('hidden');
                showTab('products'); // Mostrar pestaña de productos por defecto
            } else {
                alert('Error al cargar los detalles de la compra');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar los detalles de la compra');
        });
}

function populateBuyDetailsModal(buy) {
    // Información general
    document.getElementById('buyNumber').textContent = `${buy.serie}-${buy.number}`;
    document.getElementById('buySupplier').textContent = buy.supplier ? buy.supplier.nombre_negocio : 'N/A';
    document.getElementById('buyDate').textContent = new Date(buy.fecha_registro).toLocaleDateString();
    document.getElementById('buyTotal').textContent = `S/ ${parseFloat(buy.total_price).toFixed(2)}`;
    document.getElementById('buyTienda').textContent = buy.tienda ? buy.tienda.nombre : 'N/A';
    document.getElementById('buyPaymentType').textContent = buy.payment_type === 'cash' ? 'Contado' : 'Crédito';
    
    // Estado de entrega
    const deliveryStatusElement = document.getElementById('buyDeliveryStatus');
    if (buy.delivery_status === 'received') {
        deliveryStatusElement.innerHTML = '<span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">Recibidos</span>';
    } else {
        deliveryStatusElement.innerHTML = '<span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold">Pendientes</span>';
    }

    // Productos
    populateProductsTable(buy.buy_items);
    
    // Cuotas
    populateInstallmentsTable(buy.payment_methods);
}

function populateProductsTable(buyItems) {
    const tbody = document.getElementById('buyProductsTable');
    tbody.innerHTML = '';

    buyItems.forEach(item => {
        const subtotal = (item.quantity * item.price).toFixed(2);
        const codesInfo = item.scanned_codes && item.scanned_codes.length > 0 
            ? `<span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">${item.scanned_codes.length} códigos</span>`
            : '<span class="text-xs text-gray-500">-</span>';

        const row = `
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-sm">
                    <div>
                        <p class="font-medium text-gray-900">${item.product.description}</p>
                        <p class="text-xs text-gray-500">${item.product.brand ? item.product.brand.name : ''}</p>
                    </div>
                </td>
                <td class="px-4 py-3 text-sm text-gray-900">${item.product.code_sku}</td>
                <td class="px-4 py-3 text-sm text-gray-900">${item.quantity} ${item.product.unit ? item.product.unit.name : ''}</td>
                <td class="px-4 py-3 text-sm text-gray-900">S/ ${parseFloat(item.price).toFixed(2)}</td>
                <td class="px-4 py-3 text-sm font-semibold text-gray-900">S/ ${subtotal}</td>
                <td class="px-4 py-3 text-sm">${codesInfo}</td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
}

function populateInstallmentsTable(paymentMethods) {
    const tbody = document.getElementById('buyInstallmentsTable');
    tbody.innerHTML = '';
    
    let totalInstallments = 0;

    paymentMethods.forEach(paymentMethod => {
        if (paymentMethod.credit_installments && paymentMethod.credit_installments.length > 0) {
            paymentMethod.credit_installments.forEach(installment => {
                totalInstallments++;
                const statusBadge = getInstallmentStatusBadge(installment.status);
                const paidDate = installment.paid_at ? new Date(installment.paid_at).toLocaleDateString() : '-';
                const dueDate = new Date(installment.due_date).toLocaleDateString();
                
                const actionButton = installment.status === 'pendiente' 
                    ? `<button onclick="markInstallmentPaid(${installment.id})" 
                              class="bg-green-500 hover:bg-green-700 text-white text-xs px-2 py-1 rounded">
                          <i class="fas fa-check mr-1"></i>Marcar Pagado
                       </button>`
                    : `<button onclick="markInstallmentPending(${installment.id})" 
                              class="bg-yellow-500 hover:bg-yellow-700 text-white text-xs px-2 py-1 rounded">
                          <i class="fas fa-undo mr-1"></i>Marcar Pendiente
                       </button>`;

                const row = `
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-medium">${installment.installment_number}</td>
                        <td class="px-4 py-3 text-sm">${paymentMethod.payment_method.name}</td>
                        <td class="px-4 py-3 text-sm font-semibold">S/ ${parseFloat(installment.amount).toFixed(2)}</td>
                        <td class="px-4 py-3 text-sm">${dueDate}</td>
                        <td class="px-4 py-3">${statusBadge}</td>
                        <td class="px-4 py-3 text-sm">${paidDate}</td>
                        <td class="px-4 py-3">${actionButton}</td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        }
    });

    // Actualizar contador de cuotas
    const installmentsCountElement = document.getElementById('installmentsCount');
    if (totalInstallments > 0) {
        installmentsCountElement.textContent = totalInstallments;
        installmentsCountElement.classList.remove('hidden');
        document.getElementById('noInstallmentsMessage').classList.add('hidden');
        document.getElementById('installmentsTable').classList.remove('hidden');
    } else {
        installmentsCountElement.classList.add('hidden');
        document.getElementById('noInstallmentsMessage').classList.remove('hidden');
        document.getElementById('installmentsTable').classList.add('hidden');
    }
}

function getInstallmentStatusBadge(status) {
    const badges = {
        'pendiente': '<span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold"><i class="fas fa-clock mr-1"></i>Pendiente</span>',
        'pagado': '<span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold"><i class="fas fa-check mr-1"></i>Pagado</span>',
        'vencido': '<span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-semibold"><i class="fas fa-exclamation mr-1"></i>Vencido</span>'
    };
    return badges[status] || status;
}

function showTab(tabName) {
    // Ocultar todos los contenidos
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remover clase active de todos los botones
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Mostrar contenido seleccionado
    document.getElementById(tabName + 'Content').classList.remove('hidden');
    
    // Activar botón seleccionado
    const activeButton = document.getElementById(tabName + 'Tab');
    activeButton.classList.remove('border-transparent', 'text-gray-500');
    activeButton.classList.add('active', 'border-blue-500', 'text-blue-600');
}

function closeBuyDetailsModal() {
    document.getElementById('buyDetailsModal').classList.add('hidden');
    currentBuyData = null;
}

function markInstallmentPaid(installmentId) {
    if (!confirm('¿Está seguro de marcar esta cuota como pagada?')) {
        return;
    }

    fetch(`/buy/installment/${installmentId}/mark-paid`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            // Recargar los detalles del modal
            showBuyDetailsModal(currentBuyData.id);
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al marcar la cuota como pagada');
    });
}

function markInstallmentPending(installmentId) {
    if (!confirm('¿Está seguro de marcar esta cuota como pendiente?')) {
        return;
    }

    fetch(`/buy/installment/${installmentId}/mark-pending`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            // Recargar los detalles del modal
            showBuyDetailsModal(currentBuyData.id);
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al cambiar el estado de la cuota');
    });
}

let currentReceptionData = null;
let currentScanProduct = null;
let scannedCodes = [];
let expectedQuantity = 0;
let receptionProducts = {};

// Función para reproducir sonido de escáner
function reproducirSonidoEscaner() {
    const audioContext = new (window.AudioContext || window.webkitAudioContext)();
    
    setTimeout(() => {
        const inputEdit = document.getElementById('scannedCodeInput');
        if (inputEdit) {
            inputEdit.readOnly = false;
            inputEdit.disabled = false;
            inputEdit.focus();
        }
    }, 100);
    
    const oscillator = audioContext.createOscillator();
    const gainNode = audioContext.createGain();
    
    oscillator.connect(gainNode);
    gainNode.connect(audioContext.destination);
    
    oscillator.frequency.value = 800;
    oscillator.type = "square";
    
    gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
    gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.1);
    
    oscillator.start(audioContext.currentTime);
    oscillator.stop(audioContext.currentTime + 0.1);
}


function showReceptionModal(buyId) {
    fetch(`/buy/${buyId}/reception-data`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                currentReceptionData = data.buy;
                populateReceptionModal(data.buy);
                document.getElementById('receptionModal').classList.remove('hidden');
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar los datos de recepción');
        });
}

function populateReceptionModal(buy) {
    document.getElementById('receptionBuyNumber').textContent = `${buy.serie}-${buy.number}`;
    document.getElementById('receptionSupplier').textContent = buy.supplier ? buy.supplier.nombre_negocio : 'N/A';
    document.getElementById('receptionTienda').textContent = buy.tienda ? buy.tienda.nombre : 'N/A';

    const tbody = document.getElementById('receptionProductsTable');
    tbody.innerHTML = '';

    // Inicializar datos de recepción
    receptionProducts = {};

    buy.buy_items.forEach(item => {
        const isUniqueCode = item.product.control_type === 'codigo_unico';
        
        // Inicializar datos del producto
        receptionProducts[item.product.id] = {
            product_id: item.product.id,
            expected_quantity: item.quantity,
            quantity_received: item.quantity, // Por defecto, toda la cantidad
            scanned_codes: [],
            is_unique_code: isUniqueCode
        };

        const controlBadge = isUniqueCode 
            ? '<span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-semibold"><i class="fas fa-qrcode mr-1"></i>Código Único</span>'
            : '<span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold"><i class="fas fa-sort-numeric-up mr-1"></i>Cantidad</span>';

        const quantityInput = `<input type="number" 
                                     id="quantity_${item.product.id}" 
                                     value="${item.quantity}" 
                                     min="0" 
                                     max="${item.quantity}" 
                                     class="w-20 border-gray-300 rounded-md shadow-sm text-center"
                                     onchange="updateReceivedQuantity(${item.product.id}, this.value)">`;

        const actionButton = isUniqueCode 
            ? `<button onclick="openScanModal(${item.product.id}, '${item.product.description}', ${item.quantity})" 
                       class="bg-orange-500 hover:bg-orange-700 text-white text-xs px-3 py-1 rounded">
                   <i class="fas fa-qrcode mr-1"></i>Escanear
               </button>`
            : '<span class="text-xs text-gray-500">-</span>';

        const row = `
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-sm">
                    <div>
                        <p class="font-medium text-gray-900">${item.product.description}</p>
                        <p class="text-xs text-gray-500">SKU: ${item.product.code_sku}</p>
                    </div>
                </td>
                <td class="px-4 py-3 text-sm font-semibold text-center">${item.quantity}</td>
                <td class="px-4 py-3 text-sm text-center">${quantityInput}</td>
                <td class="px-4 py-3">${controlBadge}</td>
                <td class="px-4 py-3 text-center">${actionButton}</td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
}

function updateReceivedQuantity(productId, quantity) {
    if (receptionProducts[productId]) {
        receptionProducts[productId].quantity_received = parseInt(quantity) || 0;
    }
}

function openScanModal(productId, productName, expectedQty) {
    currentScanProduct = productId;
    expectedQuantity = expectedQty;
    scannedCodes = receptionProducts[productId].scanned_codes || [];

    document.getElementById('scanProductName').textContent = productName;
    document.getElementById('scanExpectedQuantity').textContent = expectedQty;
    
    updateScanDisplay();
    document.getElementById('scanModal').classList.remove('hidden');
    document.getElementById('scannedCodeInput').focus();
}

function handleScanKeyPress(event) {
    if (event.key === 'Enter') {
        addScannedCode();
    }
}

function addScannedCode() {
    const input = document.getElementById('scannedCodeInput');
    const code = input.value.trim();

    if (!code) {
        alert('Por favor ingrese un código');
        return;
    }

    if (scannedCodes.includes(code)) {
        alert('Este código ya ha sido escaneado');
        input.value = '';
        input.focus();
        return;
    }

    if (scannedCodes.length >= expectedQuantity) {
        alert('Ya se han escaneado todos los códigos necesarios');
        return;
    }

    scannedCodes.push(code);
    input.value = '';
    
    // Reproducir sonido de escáner al agregar código exitosamente
    reproducirSonidoEscaner();
    
    updateScanDisplay();
}

function updateScanDisplay() {
    const listDiv = document.getElementById('scannedCodesList');
    const progressBar = document.getElementById('scanProgress');
    const progressText = document.getElementById('scanProgressText');
    const statusText = document.getElementById('scanStatusText');
    const saveButton = document.getElementById('saveScanButton');

    // Actualizar lista con fondo negro y texto verde
    if (scannedCodes.length === 0) {
        listDiv.innerHTML = '<p class="text-gray-500 text-sm">Ningún código escaneado aún...</p>';
    } else {
        listDiv.innerHTML = `
            <div class="bg-black p-2 rounded">
                ${scannedCodes.map((code, index) => 
                    `<div class="flex justify-between items-center py-1 text-green-400">
                        <span class="text-sm font-mono">${index + 1}. ${code}</span>
                        <button onclick="removeScannedCode(${index})" class="text-red-400 hover:text-red-300 text-xs ml-2">
                            <i class="fas fa-times"></i>
                        </button>
                     </div>`
                ).join('')}
            </div>
        `;
    }

    // Actualizar progreso
    const progress = (scannedCodes.length / expectedQuantity) * 100;
    progressBar.style.width = progress + '%';
    progressText.textContent = `Progreso: ${scannedCodes.length}/${expectedQuantity} códigos escaneados`;

    // Actualizar estado
    const remaining = expectedQuantity - scannedCodes.length;
    if (remaining === 0) {
        statusText.textContent = '¡Todos los códigos han sido escaneados!';
        statusText.className = 'text-xs text-green-600 mt-1 font-semibold';
        saveButton.disabled = false;
        saveButton.classList.remove('opacity-50', 'cursor-not-allowed');
    } else {
        statusText.textContent = `Esperando códigos... (faltan ${remaining})`;
        statusText.className = 'text-xs text-gray-600 mt-1';
        saveButton.disabled = true;
        saveButton.classList.add('opacity-50', 'cursor-not-allowed');
    }
}

function removeScannedCode(index) {
    scannedCodes.splice(index, 1);
    updateScanDisplay();
}

function saveScanCodes() {
    if (scannedCodes.length !== expectedQuantity) {
        alert('Debe escanear todos los códigos requeridos');
        return;
    }

    // Guardar la cantidad antes de cerrar el modal
    const savedCodesCount = scannedCodes.length;

    // Guardar códigos en los datos de recepción
    receptionProducts[currentScanProduct].scanned_codes = [...scannedCodes];
    receptionProducts[currentScanProduct].quantity_received = scannedCodes.length;

    // Actualizar el input de cantidad en la tabla
    document.getElementById(`quantity_${currentScanProduct}`).value = scannedCodes.length;

    closeScanModal();
    alert(`${savedCodesCount} códigos guardados correctamente`);
}

function closeScanModal() {
    document.getElementById('scanModal').classList.add('hidden');
    scannedCodes = [];
    currentScanProduct = null;
    expectedQuantity = 0;
}

function closeReceptionModal() {
    document.getElementById('receptionModal').classList.add('hidden');
    currentReceptionData = null;
    receptionProducts = {};
}

function processReception() {
    if (!currentReceptionData) return;

    // Preparar datos para enviar
    const products = Object.values(receptionProducts);
    
    // Validar que productos con código único tengan todos los códigos
    for (let product of products) {
        if (product.is_unique_code && product.quantity_received > 0) {
            if (!product.scanned_codes || product.scanned_codes.length !== product.quantity_received) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Códigos faltantes',
                    text: `El producto requiere escanear ${product.quantity_received} códigos únicos`,
                    confirmButtonText: 'Entendido'
                });
                return;
            }
        }
    }

    // Mostrar loading
    const processButton = document.querySelector('button[onclick="processReception()"]');
    const originalText = processButton.innerHTML;
    processButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Procesando...';
    processButton.disabled = true;

    fetch(`/buy/${currentReceptionData.id}/process-reception`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ products: products })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: '¡Recepción exitosa!',
                text: data.message,
                confirmButtonText: 'Aceptar'
            }).then(() => {
                closeReceptionModal();
                filterBuys(); // Recargar tabla
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error en la recepción',
                text: data.message,
                confirmButtonText: 'Entendido'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error de conexión',
            text: 'Error al procesar la recepción',
            confirmButtonText: 'Entendido'
        });
    })
    .finally(() => {
        processButton.innerHTML = originalText;
        processButton.disabled = false;
    });
}

</script>