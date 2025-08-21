<!-- resources\views\buy\index.blade.php-->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-shopping-cart mr-2"></i>{{ __('Gestión de Compras') }}
        </h2>
    </x-slot>

    <!-- CDN Bootstrap y Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filtros -->
         <div class="bg-white overflow-visible shadow-xl sm:rounded-lg mb-6">
               <div class="p-6 bg-white border-b border-gray-200 overflow-visible">
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
                        
                        <!--
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Proveedor</label>
                            <select id="supplier_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Todos los proveedores</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->nombre_negocio }}</option>
                                @endforeach
                            </select>
                        </div>
                        -->
                    </div>
                    
                    <!-- Botones de Acción - Responsive -->
                    <div class="mt-4">
                        <!-- Vista Desktop (pantallas grandes) -->
                        <div class="hidden lg:flex justify-between items-center">
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

                        <!-- Vista Mobile/Tablet (pantallas pequeñas) -->
                 <div class="lg:hidden">
    <div class="flex flex-col space-y-3 relative">
                                <!-- Botones principales siempre visibles -->
                                <div class="flex space-x-2">
                                    <button onclick="filterBuys()" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-normal text-sm py-2 px-3 rounded">
                                        <i class="fas fa-search mr-1"></i>Buscar
                                    </button>
                                    <button onclick="clearFilters()" class="flex-1 bg-gray-500 hover:bg-gray-700 text-white font-normal text-sm py-2 px-3 rounded">
                                        <i class="fas fa-eraser mr-1"></i>Limpiar
                                    </button>
                                </div>

                            <div class="flex space-x-2 justify-between overflow-visible">
                                    <!-- Dropdown de Opciones -->
                               <div class="relative dropdown-container" style="z-index: 1000;">
                                       <button onclick="toggleMobileDropdown()" id="mobileDropdownButton" 
        class="bg-gray-600 hover:bg-gray-700 text-white font-normal text-sm py-2 px-3 rounded flex items-center justify-between min-w-[120px]">
    <span><i class="fas fa-cog mr-1"></i>Opciones</span>
    <i class="fas fa-chevron-down" id="dropdownIcon"></i>
</button>
                               
                             <!-- Dropdown Menu -->
<div id="mobileDropdownMenu" class="dropdown-menu hidden">
                                            <div class="py-1">
                                                <button onclick="exportReports('pdf')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                                    <i class="fas fa-file-pdf mr-2 text-red-600"></i>Exportar PDF
                                                </button>
                                                <button onclick="exportReports('excel')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                                    <i class="fas fa-file-excel mr-2 text-green-600"></i>Exportar Excel
                                                </button>
                                                <button onclick="showImportModal()" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                                    <i class="fas fa-upload mr-2 text-green-500"></i>Importar
                                                </button>
                                                <button onclick="downloadTemplate()" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                                    <i class="fas fa-download mr-2 text-blue-500"></i>Descargar Plantilla
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Botón Nueva Compra -->
                                  <a href="{{ route('buys.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm py-2 px-4 rounded-lg shadow-lg flex items-center justify-center whitespace-nowrap">
        <i class="fas fa-plus mr-1"></i>Nueva
    </a>
                                </div>
                            </div>
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
                                    <!-- 
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-building mr-1"></i>Proveedor
                                    </th>
                                    -->
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-calendar mr-1"></i>Fecha
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-dollar-sign mr-1"></i>Total
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-info-circle mr-1"></i>Estado Productos
                                    </th>
                                    <!--
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-store mr-1"></i>Tienda
                                    </th>
                                    -->
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
                    
                    <!-- Controles de Paginación -->
                    <div id="paginationContainer" class="bg-white px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                        <div class="flex items-center">
                            <span id="paginationInfo" class="text-sm text-gray-700">
                                Mostrando 1 a 15 de 100 resultados
                            </span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <select id="perPageSelect" class="border-gray-300 rounded-md shadow-sm text-sm" onchange="changePerPage()">
                                <option value="15">15 por página</option>
                                <option value="25">25 por página</option>
                                <option value="50">50 por página</option>
                                <option value="100">100 por página</option>
                            </select>
                            
                            <div id="paginationButtons" class="flex space-x-1">
                                <!-- Los botones se generarán dinámicamente -->
                            </div>
                        </div>
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

@push('modals')
    <!-- Modal de Detalles de Compra - NUEVO DISEÑO RESPONSIVO -->
    <div class="modal fade" id="buyDetailsModal" tabindex="-1" aria-labelledby="buyDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-lg-down modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-gradient-to-r from-indigo-600 to-indigo-800 text-white">
                    <h5 class="modal-title d-flex align-items-center" id="buyDetailsModalLabel">
                        <i class="fas fa-shopping-cart me-2"></i>
                        <span>Detalles de Compra #<span id="buyNumber"></span></span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body p-0">
                    <div id="buyDetailsContent" class="h-100 overflow-auto">
                        <div class="text-center py-5">
                            <div class="spinner-border text-indigo-600 mb-3" role="status" style="width: 3rem; height: 3rem;">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <h6 class="text-muted">Cargando detalles de la compra...</h6>
                            <p class="text-muted mb-0">Por favor espere un momento</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endpush

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
  <style>
.dropdown-menu {
    position: absolute !important;
    top: calc(100% + 4px) !important;
    left: 0 !important;
    z-index: 9999 !important;
    display: block !important;
    min-width: 200px !important;
    background: white !important;
    border: 1px solid #d1d5db !important;
    border-radius: 0.375rem !important;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
    margin-top: 2px !important;
}

.dropdown-menu.hidden {
    display: none !important;
}

/* Asegurar que los contenedores padre no corten el dropdown */
.dropdown-container {
    position: relative !important;
    overflow: visible !important;
}

.dropdown-container * {
    overflow: visible !important;
}

/* ===== ESTILOS ESPECÍFICOS PARA MODAL DE COMPRAS RESPONSIVO ===== */

/* Estilos del modal de compras - header personalizado */
.modal-header {
    flex-shrink: 0;
    padding: 1.25rem 1.5rem;
    border-bottom: none;
    background: linear-gradient(135deg, #4338ca 0%, #3730a3 100%) !important;
}

.modal-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0;
}

.btn-close-white {
    filter: invert(1) grayscale(100%) brightness(200%);
    opacity: 0.8;
}

.btn-close-white:hover {
    opacity: 1;
}

.modal-body {
    padding: 0;
    position: relative;
}

.modal-footer {
    border-top: 1px solid #dee2e6;
    padding: 1rem 1.5rem;
}

/* Contenido del modal de compras con diseño mejorado */
.compra-details-container {
    padding: 1.5rem;
}

.compra-header {
    background: linear-gradient(135deg, #4338ca 0%, #3730a3 100%);
    color: white;
    padding: 2rem;
    border-radius: 0.75rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.info-section {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
}

.info-section h4 {
    color: #1f2937;
    font-weight: 600;
    font-size: 1.125rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
}

.info-section h4 i {
    margin-right: 0.5rem;
    color: #4338ca;
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #e5e7eb;
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    color: #6b7280;
    font-weight: 500;
    font-size: 0.875rem;
}

.info-value {
    color: #1f2937;
    font-weight: 600;
    font-size: 0.875rem;
    text-align: right;
    max-width: 60%;
    word-break: break-word;
}

/* Pestañas del modal */
.tab-button {
    border-bottom: 2px solid transparent;
    padding: 0.75rem 1rem;
    font-weight: 500;
    font-size: 0.875rem;
    transition: all 0.2s ease;
    cursor: pointer;
    background: none;
    border-left: none;
    border-right: none;
    border-top: none;
}

.tab-button.active {
    border-bottom-color: #4338ca !important;
    color: #4338ca !important;
}

.tab-button:not(.active) {
    color: #6b7280;
}

.tab-button:not(.active):hover {
    color: #374151;
}

.tab-content {
    padding-top: 1rem;
}

.tab-content.hidden {
    display: none !important;
}

/* Tabla de productos en el modal */
.modal-table-container {
    background: white;
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
    position: relative !important;
}

.modal-table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    position: relative !important;
}

.modal-table {
    margin-bottom: 0;
    font-size: 0.875rem;
    min-width: 700px;
    position: relative !important;
}

@media (max-width: 576px) {
    .modal-table {
        font-size: 0.8rem;
        min-width: 600px;
    }
}

.modal-table thead th {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    color: white;
    border: none;
    padding: 12px 8px;
    font-weight: 600;
    font-size: 0.8rem;
    white-space: nowrap;
    position: sticky !important;
    top: 0 !important;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

@media (max-width: 576px) {
    .modal-table thead th {
        padding: 8px 6px;
        font-size: 0.75rem;
    }
}

.modal-table tbody td {
    padding: 12px 8px;
    border-bottom: 1px solid #e5e7eb;
    vertical-align: middle;
    background: white;
    color: #1f2937;
    position: relative !important;
}

@media (max-width: 576px) {
    .modal-table tbody td {
        padding: 8px 6px;
        font-size: 0.8rem;
    }
}

.modal-table tbody tr:nth-child(even) {
    background-color: #f8fafc !important;
}

.modal-table tbody tr:hover {
    background-color: #f1f5f9 !important;
}

/* Badges en modal */
.modal-badge {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
    border-radius: 0.375rem;
    font-weight: 600;
    position: relative !important;
    display: inline-flex;
    align-items: center;
}

@media (max-width: 576px) {
    .modal-badge {
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
    }
}

/* Estado badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 9999px;
    font-size: 0.875rem;
    font-weight: 600;
}

.status-active {
    background-color: #d1fae5;
    color: #065f46;
}

.status-inactive {
    background-color: #fee2e2;
    color: #991b1b;
}

/* Grid responsive para las secciones */
.info-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
}

@media (min-width: 768px) {
    .info-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .compra-header {
        padding: 2.5rem;
    }
    
    .compra-details-container {
        padding: 2rem;
    }
}

@media (min-width: 1024px) {
    .info-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Grid para una sola sección - ancho completo */
.info-grid-single {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
    max-width: 100%;
}

@media (min-width: 768px) {
    .info-grid-single {
        grid-template-columns: 1fr;
        max-width: 100%;
    }
}

@media (min-width: 1024px) {
    .info-grid-single {
        grid-template-columns: 1fr;
        max-width: 100%;
    }
}

/* Loading state */
.loading-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 300px;
    color: #6b7280;
}

/* Error state */
.error-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 300px;
    color: #dc2626;
    padding: 2rem;
    text-align: center;
}

/* Scrollbar personalizada para modal */
#buyDetailsContent::-webkit-scrollbar {
    width: 8px;
}

#buyDetailsContent::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

#buyDetailsContent::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #4338ca 0%, #3730a3 100%);
    border-radius: 4px;
}

#buyDetailsContent::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #3730a3 0%, #312e81 100%);
}

/* Scrollbar para tabla en modal */
.modal-table-responsive::-webkit-scrollbar {
    height: 8px;
}

.modal-table-responsive::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

.modal-table-responsive::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #4338ca 0%, #3730a3 100%);
    border-radius: 4px;
}

.modal-table-responsive::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #3730a3 0%, #312e81 100%);
}

/* Indicador de scroll */
.scroll-indicator {
    text-align: center;
    padding: 0.5rem;
    font-size: 0.75rem;
    color: #6b7280;
    font-style: italic;
    background: #f9fafb;
    border-top: 1px solid #e5e7eb;
    position: relative !important;
}

@media (min-width: 768px) {
    .scroll-indicator {
        display: none;
    }
}

/* Responsive específico para móviles muy pequeños */
@media (max-width: 576px) {
    .compra-details-container {
        padding: 1rem;
    }
    
    .compra-header {
        padding: 1.5rem;
    }
    
    .info-section {
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    .info-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }
    
    .info-value {
        text-align: left;
        max-width: 100%;
    }
}

/* Botones en cuotas */
.installment-button {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.installment-button:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Alert en modal */
.modal-alert {
    margin: 1rem 1rem 0 1rem;
    border-radius: 0.5rem;
    border: none;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    position: relative !important;
}

@media (max-width: 576px) {
    .modal-alert {
        margin: 0.5rem 0.5rem 0 0.5rem;
        font-size: 0.85rem;
    }
}

/* Asegurar que las pestañas se vean bien en móvil */
@media (max-width: 576px) {
    .tab-button {
        padding: 0.5rem 0.75rem;
        font-size: 0.8rem;
    }
}
</style>

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

    // Configurar selector de elementos por página
    document.getElementById('perPageSelect').value = perPage;

 // Cerrar dropdown al hacer clic fuera
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('mobileDropdownMenu');
    const button = document.getElementById('mobileDropdownButton');
    
    if (dropdown && button && !button.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.classList.add('hidden');
        const icon = document.getElementById('dropdownIcon');
        if (icon) {
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        }
    }
});

});

// Función para toggle del dropdown móvil
function toggleMobileDropdown() {
    const dropdown = document.getElementById('mobileDropdownMenu');
    const icon = document.getElementById('dropdownIcon');
    
    if (dropdown && icon) {
        dropdown.classList.toggle('hidden');
        
        if (dropdown.classList.contains('hidden')) {
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        } else {
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
        }
    }
}

// Variables globales para paginación
let currentPage = 1;
let perPage = 15;
let totalPages = 1;

// Reemplaza la función filterBuys() completa:
function filterBuys(page = 1) {
    currentPage = page;
    
    const filters = {
        fecha_desde: document.getElementById('fecha_desde').value,
        fecha_hasta: document.getElementById('fecha_hasta').value,
        products_status: document.getElementById('products_status').value,
        page: currentPage,
        per_page: perPage
    };
    
    fetch('{{ route("buy.filteredList") }}?' + new URLSearchParams(filters))
        .then(response => response.json())
        .then(data => {
            renderBuysTable(data.data);
            updatePagination(data);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar las compras');
        });
}

// Función nueva para actualizar la paginación
function updatePagination(paginationData) {
    const { current_page, last_page, per_page, total, from, to } = paginationData;
    
    totalPages = last_page;
    currentPage = current_page;
    
    // Actualizar información de paginación
    const paginationInfo = document.getElementById('paginationInfo');
    if (total === 0) {
        paginationInfo.textContent = 'No se encontraron resultados';
    } else {
        paginationInfo.textContent = `Mostrando ${from} a ${to} de ${total} resultados`;
    }
    
    // Generar botones de paginación
    generatePaginationButtons();
}

// Función nueva para generar botones de paginación
function generatePaginationButtons() {
    const paginationButtons = document.getElementById('paginationButtons');
    paginationButtons.innerHTML = '';
    
    if (totalPages <= 1) return;
    
    // Botón anterior
    if (currentPage > 1) {
        const prevButton = createPaginationButton('Anterior', currentPage - 1, false, 'fas fa-chevron-left');
        paginationButtons.appendChild(prevButton);
    }
    
    // Números de página
    const startPage = Math.max(1, currentPage - 2);
    const endPage = Math.min(totalPages, currentPage + 2);
    
    if (startPage > 1) {
        paginationButtons.appendChild(createPaginationButton('1', 1));
        if (startPage > 2) {
            const dots = document.createElement('span');
            dots.className = 'px-3 py-2 text-gray-500';
            dots.textContent = '...';
            paginationButtons.appendChild(dots);
        }
    }
    
    for (let i = startPage; i <= endPage; i++) {
        const button = createPaginationButton(i, i, i === currentPage);
        paginationButtons.appendChild(button);
    }
    
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            const dots = document.createElement('span');
            dots.className = 'px-3 py-2 text-gray-500';
            dots.textContent = '...';
            paginationButtons.appendChild(dots);
        }
        paginationButtons.appendChild(createPaginationButton(totalPages, totalPages));
    }
    
    // Botón siguiente
    if (currentPage < totalPages) {
        const nextButton = createPaginationButton('Siguiente', currentPage + 1, false, 'fas fa-chevron-right');
        paginationButtons.appendChild(nextButton);
    }
}

// Función nueva para crear botones de paginación
function createPaginationButton(text, page, isActive = false, iconClass = null) {
    const button = document.createElement('button');
    button.className = isActive 
        ? 'px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-md'
        : 'px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50';
    
    if (iconClass) {
        button.innerHTML = `<i class="${iconClass} mr-1"></i>${text}`;
    } else {
        button.textContent = text;
    }
    
    if (!isActive) {
        button.onclick = () => filterBuys(page);
    }
    
    return button;
}

// Función nueva para cambiar elementos por página
function changePerPage() {
    perPage = parseInt(document.getElementById('perPageSelect').value);
    filterBuys(1); // Volver a la primera página
}

// Reemplaza la función renderBuysTable completa con esta versión modificada:
function renderBuysTable(buys) {
    const tbody = document.getElementById('buysTableBody');
    tbody.innerHTML = '';
    
    if (buys.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
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
                    ${new Date(buy.fecha_registro).toLocaleDateString()}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    S/ ${parseFloat(buy.total_price).toFixed(2)}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    ${statusBadge}
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

// Reemplaza la función getStatusBadge completa:
function getStatusBadge(status) {
    const badges = {
        'recibidos': '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"><i class="fas fa-check mr-1"></i>Recibidos</span>',
        'pendientes': '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800"><i class="fas fa-truck mr-1"></i>Carretera</span>'
    };
    return badges[status] || status;
}

function clearFilters() {
    document.getElementById('fecha_desde').value = '';
    document.getElementById('fecha_hasta').value = '';
    document.getElementById('products_status').value = '';
    filterBuys();
}

// Reemplaza la función exportReports() completa:
function exportReports(format) {
    const filters = {
        fecha_desde: document.getElementById('fecha_desde').value,
        fecha_hasta: document.getElementById('fecha_hasta').value,
        products_status: document.getElementById('products_status').value,
        // supplier_id: document.getElementById('supplier_id').value,  // Eliminado: campo ya no existe
        format: format
    };
    
    window.open('{{ route("buy.exportReports") }}?' + new URLSearchParams(filters));
    
    // Cerrar dropdown en móvil después de la acción
    const dropdown = document.getElementById('mobileDropdownMenu');
    if (dropdown && !dropdown.classList.contains('hidden')) {
        toggleMobileDropdown();
    }
}

function downloadTemplate() {
   window.open('{{ route("buy.downloadTemplate") }}');
   
   // Cerrar dropdown en móvil después de la acción
   const dropdown = document.getElementById('mobileDropdownMenu');
   if (dropdown && !dropdown.classList.contains('hidden')) {
       toggleMobileDropdown();
   }
}

function showImportModal() {
   document.getElementById('importModal').classList.remove('hidden');
   showStep1();
   
   // Cerrar dropdown en móvil después de la acción
   const dropdown = document.getElementById('mobileDropdownMenu');
   if (dropdown && !dropdown.classList.contains('hidden')) {
       toggleMobileDropdown();
   }
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

// Busca la función processImportFile() y reemplázala completamente:
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
       console.log('Response data:', data); // Para debug
       
       if (data.success) {
           importData = data.data || [];
           selectedBuys = [...importData]; // Seleccionar todo por defecto
           
           // Mostrar errores solo si existen
           if (data.errors && data.errors.length > 0) {
               showErrors(data.errors);
           } else {
               // Ocultar div de errores si no hay errores
               document.getElementById('importErrors').classList.add('hidden');
           }
           
           if (importData.length > 0) {
               renderPreviewTable();
               updateSelectedCount();
               showStep2();
           } else {
               alert('No se encontraron datos válidos para importar en el archivo.');
           }
       } else {
           alert('Error: ' + (data.message || 'Error desconocido'));
       }
   })
   .catch(error => {
       console.error('Error:', error);
       alert('Error al procesar el archivo: ' + error.message);
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

// Busca la función renderPreviewTable() y reemplázala completamente:
function renderPreviewTable() {
    const tbody = document.getElementById('previewTableBody');
    tbody.innerHTML = '';
    
    importData.forEach((item, index) => {
        const row = document.createElement('tr');
        const total = (item.cantidad * item.precio).toFixed(2);
        
        row.innerHTML = `
            <td class="px-4 py-2">
                <input type="checkbox" 
                       onchange="toggleBuySelection(${index})" 
                       ${selectedBuys.includes(item) ? 'checked' : ''}>
            </td>
            <td class="px-4 py-2">${new Date(item.fecha).toLocaleDateString()}</td>
            <td class="px-4 py-2">${item.product.description}</td>
            <td class="px-4 py-2">${item.cantidad}</td>
            <td class="px-4 py-2">S/ ${item.precio}</td>
            <td class="px-4 py-2">S/ ${total}</td>
            <td class="px-4 py-2">
                <span class="px-2 py-1 text-xs rounded ${item.delivery_status === 'received' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}">
                    ${item.delivery_status === 'received' ? 'Recibido' : 'Pendiente'}
                </span>
            </td>
        `;
        
        tbody.appendChild(row);
    });
}

function toggleBuySelection(index) {
    const item = importData[index];
    const itemIndex = selectedBuys.findIndex(selected => selected === item);
    
    if (itemIndex > -1) {
        selectedBuys.splice(itemIndex, 1);
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
    updatePreviewCheckboxes();
    updateSelectedCount();
    updateSelectAllCheckbox();
}

function deselectAllBuys() {
    selectedBuys = [];
    updatePreviewCheckboxes();
    updateSelectedCount();
    updateSelectAllCheckbox();
}

function updatePreviewCheckboxes() {
    const checkboxes = document.querySelectorAll('#previewTableBody input[type="checkbox"]');
    checkboxes.forEach((checkbox, index) => {
        const item = importData[index];
        checkbox.checked = selectedBuys.includes(item);
    });
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
    if (selectAllCheckbox) {
        selectAllCheckbox.checked = selectedBuys.length === importData.length;
    }
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

// NUEVA FUNCIÓN RESPONSIVA PARA MOSTRAR DETALLES DE COMPRA
function showBuyDetailsModal(buyId) {
    const modal = new bootstrap.Modal(document.getElementById('buyDetailsModal'), {
        backdrop: 'static',
        keyboard: true
    });
    const content = document.getElementById('buyDetailsContent');
    
    // Mostrar loading
    content.innerHTML = `
        <div class="loading-container">
            <div class="spinner-border text-indigo-600 mb-3" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <h6 class="text-muted">Cargando detalles de la compra...</h6>
            <p class="text-muted mb-0">Por favor espere un momento</p>
        </div>
    `;
    
    modal.show();
    
    // Cargar detalles
    fetch(`/buy/modal-details/${buyId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                currentBuyData = data.buy;
                populateBuyDetailsModalResponsive(data.buy);
            } else {
                throw new Error(data.message || 'Error al cargar los detalles');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            content.innerHTML = `
                <div class="error-container">
                    <div class="text-danger mb-4">
                        <i class="fas fa-exclamation-triangle" style="font-size: 3rem;"></i>
                    </div>
                    <h6 class="text-danger">Error al cargar los detalles</h6>
                    <p class="text-muted mb-3">${error.message}</p>
                    <button class="btn btn-outline-primary" onclick="showBuyDetailsModal(${buyId})">
                        <i class="fas fa-sync-alt me-1"></i>Reintentar
                    </button>
                </div>
            `;
        });
}

// NUEVA FUNCIÓN PARA POBLAR EL MODAL DE FORMA RESPONSIVA
function populateBuyDetailsModalResponsive(buy) {
    const content = document.getElementById('buyDetailsContent');
    
    // Información general mejorada
    const deliveryStatusBadge = buy.delivery_status === 'received' 
        ? '<span class="status-badge status-active"><i class="fas fa-check-circle me-1"></i>Recibidos</span>'
        : '<span class="status-badge status-inactive"><i class="fas fa-clock me-1"></i>Pendientes</span>';

    const paymentTypeBadge = buy.payment_type === 'cash' 
        ? '<span class="modal-badge bg-success text-white"><i class="fas fa-money-bill me-1"></i>Contado</span>'
        : '<span class="modal-badge bg-warning text-dark"><i class="fas fa-credit-card me-1"></i>Crédito</span>';

    let html = `
        <div class="compra-details-container">
            <!-- Header con información principal -->
            <div class="compra-header">
                <div class="d-flex flex-column flex-md-row align-items-center text-center text-md-start">
                    <div class="flex-grow-1">
                        <h2 class="mb-2 fw-bold" style="font-size: 1.5rem;">
                            Compra ${buy.serie}-${buy.number}
                        </h2>
                        
                        <p class="mb-2 opacity-75" style="font-size: 1rem;">
                            <i class="fas fa-calendar me-1"></i>${new Date(buy.fecha_registro).toLocaleDateString()}
                        </p>
                        <div class="mt-3 d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                            ${deliveryStatusBadge}
                            ${paymentTypeBadge}
                            <span class="modal-badge bg-primary text-white">
                                <i class="fas fa-dollar-sign me-1"></i>S/ ${parseFloat(buy.total_price).toFixed(2)}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grid de información -->
            <div class="info-grid-single">
                <!-- Información de la Compra -->
                <div class="info-section">
                    <h4>
                        <i class="fas fa-shopping-cart"></i>
                        Información de la Compra
                    </h4>
                    <div class="info-row">
                        <span class="info-label">Serie/Número:</span>
                        <span class="info-value">${buy.serie}-${buy.number}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Fecha:</span>
                        <span class="info-value">${new Date(buy.fecha_registro).toLocaleDateString()}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Total:</span>
                        <span class="info-value">S/ ${parseFloat(buy.total_price).toFixed(2)}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tipo de Pago:</span>
                        <span class="info-value">${buy.payment_type === 'cash' ? 'Contado' : 'Crédito'}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tienda:</span>
                        <span class="info-value">${buy.tienda ? buy.tienda.nombre : 'N/A'}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Estado Productos:</span>
                        <span class="info-value">${deliveryStatusBadge}</span>
                    </div>
                </div>
            </div>

            <!-- Pestañas -->
            <div class="border-bottom border-gray-200 mb-4">
                <nav class="nav nav-tabs" id="buyTabs">
                    <button class="tab-button active" onclick="showTab('products')" id="productsTab">
                        <i class="fas fa-box me-1"></i>Productos
                    </button>
                    <button class="tab-button" onclick="showTab('installments')" id="installmentsTab">
                        <i class="fas fa-credit-card me-1"></i>Cuotas
                        ${buy.payment_methods && buy.payment_methods.some(pm => pm.credit_installments && pm.credit_installments.length > 0) 
                            ? `<span class="badge bg-danger ms-1">${buy.payment_methods.reduce((total, pm) => total + (pm.credit_installments ? pm.credit_installments.length : 0), 0)}</span>` 
                            : ''}
                    </button>
                </nav>
            </div>

            <!-- Contenido de Pestañas -->
            <!-- Pestaña Productos -->
            <div id="productsContent" class="tab-content">
                <div class="modal-table-container">
                    <div class="modal-table-responsive">
                        <table class="table modal-table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-box me-1"></i>Producto</th>
                                    <th><i class="fas fa-qrcode me-1"></i>SKU</th>
                                    <th><i class="fas fa-sort-numeric-up me-1"></i>Cantidad</th>
                                    <th><i class="fas fa-dollar-sign me-1"></i>Precio Unit.</th>
                                    <th><i class="fas fa-calculator me-1"></i>Subtotal</th>
                                    <th><i class="fas fa-tags me-1"></i>Códigos</th>
                                </tr>
                            </thead>
                            <tbody>
    `;

    // Productos
    if (buy.buy_items && buy.buy_items.length > 0) {
        buy.buy_items.forEach(item => {
            const subtotal = (item.quantity * item.price).toFixed(2);
            const codesInfo = item.scanned_codes && item.scanned_codes.length > 0 
                ? `<span class="modal-badge bg-info text-white">${item.scanned_codes.length} códigos</span>`
                : '<span class="text-muted">-</span>';

            html += `
                <tr>
                    <td>
                        <div>
                            <div class="fw-medium text-gray-900">${item.product.description}</div>
                            ${item.product.brand ? `<small class="text-muted">${item.product.brand.name}</small>` : ''}
                        </div>
                    </td>
                    <td class="font-monospace">${item.product.code_sku}</td>
                    <td class="text-center">
                        <span class="modal-badge bg-secondary text-white">
                            ${item.quantity} ${item.product.unit ? item.product.unit.name : ''}
                        </span>
                    </td>
                    <td class="text-end">S/ ${parseFloat(item.price).toFixed(2)}</td>
                    <td class="text-end fw-bold">S/ ${subtotal}</td>
                    <td class="text-center">${codesInfo}</td>
                </tr>
            `;
        });
    } else {
        html += `
            <tr>
                <td colspan="6" class="text-center py-5 text-muted">
                    <i class="fas fa-inbox display-6 d-block mb-3"></i>
                    <h6>No hay productos registrados</h6>
                </td>
            </tr>
        `;
    }

    html += `
                            </tbody>
                        </table>
                    </div>
                    <div class="scroll-indicator d-md-none">
                        ← Desliza horizontalmente para ver más información →
                    </div>
                </div>
            </div>

            <!-- Pestaña Cuotas -->
            <div id="installmentsContent" class="tab-content hidden">
    `;

    // Verificar si hay cuotas
    let hasInstallments = false;
    let installmentsHtml = '';
    
    if (buy.payment_methods && buy.payment_methods.length > 0) {
        buy.payment_methods.forEach(paymentMethod => {
            if (paymentMethod.credit_installments && paymentMethod.credit_installments.length > 0) {
                hasInstallments = true;
                paymentMethod.credit_installments.forEach(installment => {
                    const statusBadge = getInstallmentStatusBadge(installment.status);
                    const paidDate = installment.paid_at ? new Date(installment.paid_at).toLocaleDateString() : '-';
                    const dueDate = new Date(installment.due_date).toLocaleDateString();
                    
                    const actionButton = installment.status === 'pendiente' 
                        ? `<button onclick="markInstallmentPaid(${installment.id})" 
                                  class="btn btn-success btn-sm">
                              <i class="fas fa-check me-1"></i>Marcar Pagado
                           </button>`
                        : `<button onclick="markInstallmentPending(${installment.id})" 
                                  class="btn btn-warning btn-sm">
                              <i class="fas fa-undo me-1"></i>Marcar Pendiente
                           </button>`;

                    installmentsHtml += `
                        <tr>
                            <td class="text-center fw-bold">${installment.installment_number}</td>
                            <td>${paymentMethod.payment_method.name}</td>
                            <td class="text-end fw-bold">S/ ${parseFloat(installment.amount).toFixed(2)}</td>
                            <td class="text-center">${dueDate}</td>
                            <td class="text-center">${statusBadge}</td>
                            <td class="text-center">${paidDate}</td>
                            <td class="text-center">${actionButton}</td>
                        </tr>
                    `;
                });
            }
        });
    }

    if (hasInstallments) {
        html += `
            <div class="modal-table-container">
                <div class="modal-table-responsive">
                    <table class="table modal-table">
                        <thead>
                            <tr>
                                <th class="text-center"><i class="fas fa-hashtag me-1"></i>Cuota #</th>
                                <th><i class="fas fa-credit-card me-1"></i>Método de Pago</th>
                                <th class="text-center"><i class="fas fa-dollar-sign me-1"></i>Monto</th>
                                <th class="text-center"><i class="fas fa-calendar me-1"></i>F. Vencimiento</th>
                                <th class="text-center"><i class="fas fa-info-circle me-1"></i>Estado</th>
                                <th class="text-center"><i class="fas fa-calendar-check me-1"></i>F. Pagado</th>
                                <th class="text-center"><i class="fas fa-cogs me-1"></i>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${installmentsHtml}
                        </tbody>
                    </table>
                </div>
                <div class="scroll-indicator d-md-none">
                    ← Desliza horizontalmente para ver más información →
                </div>
            </div>
        `;
    } else {
        html += `
            <div class="text-center py-5">
                <div class="text-muted">
                    <i class="fas fa-info-circle display-6 d-block mb-3"></i>
                    <h6>No hay cuotas de crédito</h6>
                    <p class="mb-0">Esta compra no tiene cuotas de crédito registradas</p>
                </div>
            </div>
        `;
    }

    html += `
            </div>
        </div>
    `;

    content.innerHTML = html;
    
    // Actualizar número en el título del modal
    document.getElementById('buyNumber').textContent = `${buy.serie}-${buy.number}`;
}

function getInstallmentStatusBadge(status) {
    const badges = {
        'pendiente': '<span class="modal-badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Pendiente</span>',
        'pagado': '<span class="modal-badge bg-success text-white"><i class="fas fa-check me-1"></i>Pagado</span>',
        'vencido': '<span class="modal-badge bg-danger text-white"><i class="fas fa-exclamation me-1"></i>Vencido</span>'
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
        button.classList.remove('active');
    });
    
    // Mostrar contenido seleccionado
    document.getElementById(tabName + 'Content').classList.remove('hidden');
    
    // Activar botón seleccionado
    document.getElementById(tabName + 'Tab').classList.add('active');
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