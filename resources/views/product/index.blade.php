<!-- resources\views\product\index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Lista de Productos</h2>
    </x-slot>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.tailwindcss.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Header con controles -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <!-- Botones de vista -->
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <div class="flex items-center space-x-2">
                    <button id="btnVistaTabla" class="flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <i class="fas fa-table mr-2"></i>
                        Vista Tabla
                    </button>
                    <button id="btnVistaGrid" class="flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                        <i class="fas fa-th-large mr-2"></i>
                        Vista Grid
                    </button>
                </div>

                <div class="flex items-center space-x-2">
                    @can('agregar-productos')
                        <a href="{{ route('products.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg flex items-center transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Agregar Producto
                        </a>
                    @endcan
                </div>
            </div>

            <!-- Filtros y controles -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-4">
                <!-- Selector de almacén -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Almacén</label>
                    <select name="almacen" id="almacen" class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="todos">Todos los almacenes</option>
                        @foreach ($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Campo de búsqueda -->
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Buscar productos</label>
                    <div class="flex">
                        <input type="text" id="buscar" name="buscar" placeholder="Código, descripción, modelo..." 
                               class="flex-1 border border-gray-300 rounded-l-lg py-2 px-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button id="btnBuscar" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-r-lg transition-colors">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Controles de exportación -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Exportar</label>
                    <div class="flex">
                        <select id="exportFilter" class="flex-1 border border-gray-300 rounded-l-lg py-2 px-3 text-sm">
                            <option value="productos">Por Productos</option>
                            <option value="stock_minimo">Por Stock Mínimo</option>
                            <option value="precio">Por Precio</option>
                        </select>
                        <button id="btnExport" class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-2 rounded-r-lg transition-colors">
                            <i class="fas fa-download"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Botón de importar -->
            <div class="flex justify-end">
                <button id="btnOpenImportModal" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg flex items-center transition-colors">
                    <i class="fas fa-upload mr-2"></i>
                    Importar Productos
                </button>
            </div>
        </div>

        <!-- Mensajes de éxito o error -->
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 text-green-800 px-4 py-3 rounded-lg mb-4 flex items-center shadow-sm">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border-l-4 border-red-400 text-red-800 px-4 py-3 rounded-lg mb-4 flex items-center shadow-sm">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Vista de Tabla -->
        <div id="vistaTabla" class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <!-- Header de la tabla -->
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-table mr-2 text-blue-600"></i>
                        Lista de Productos
                    </h3>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Total: <span class="font-semibold" id="totalProducts">0</span> productos</span>
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-sm transition-colors">
                            <i class="fas fa-sync-alt mr-1"></i>
                            Actualizar
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table id="productsTable" class="min-w-full">
                    <thead class="bg-gradient-to-r from-gray-100 to-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-hashtag text-gray-500"></i>
                                    <span>#</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-code text-gray-500"></i>
                                    <span>Código</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-barcode text-gray-500"></i>
                                    <span>Código Barras</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                                <div class="flex items-center justify-center space-x-1">
                                    <i class="fas fa-image text-gray-500"></i>
                                    <span>Imagen</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-info-circle text-gray-500"></i>
                                    <span>Descripción</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-cube text-gray-500"></i>
                                    <span>Modelo</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-map-marker-alt text-gray-500"></i>
                                    <span>Ubicación</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-warehouse text-gray-500"></i>
                                    <span>Almacén</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-tag text-gray-500"></i>
                                    <span>Marca</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-ruler text-gray-500"></i>
                                    <span>Unidad</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-dollar-sign text-gray-500"></i>
                                    <span>Precio</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                                <div class="flex items-center justify-center space-x-1">
                                    <i class="fas fa-boxes text-gray-500"></i>
                                    <span>Stock</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                                <div class="flex items-center justify-center space-x-1">
                                    <i class="fas fa-cogs text-gray-500"></i>
                                    <span>Acciones</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white" id="productsTableBody">
                        <!-- Los datos se cargarán aquí dinámicamente -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Vista de Grid -->
        <div id="vistaGrid" class="hidden">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6" id="productsGrid">
                <!-- Las cards se cargarán aquí dinámicamente -->
            </div>
            
            <!-- Paginación para grid -->
            <div class="flex justify-center mt-8">
                <nav class="flex items-center space-x-2" id="gridPagination">
                    <!-- La paginación se generará dinámicamente -->
                </nav>
            </div>
        </div>
    </div>

    <!-- Modal de imágenes mejorado -->
    <div id="imagesModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg w-11/12 md:w-3/4 lg:w-1/2 max-h-[90vh] overflow-hidden">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-semibold">Imágenes del Producto</h3>
                <button class="text-gray-500 hover:text-gray-700 text-xl" onclick="closeModalImages()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper" id="swiperWrapper"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Importación -->
    <div id="importModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-40">
        <div class="bg-white rounded-lg w-96 max-w-[90vw]">
            <div class="flex justify-between items-center p-6 border-b">
                <h2 class="text-lg font-semibold">Importar Productos</h2>
                <button id="btnCloseImportModal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-6">
                <a href="{{ route('plantilla.descargar') }}" class="flex items-center text-blue-600 hover:text-blue-800 mb-4">
                    <i class="fas fa-download mr-2"></i>
                    Descargar Plantilla
                </a>

                <form id="importForm" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Seleccionar archivo</label>
                        <input type="file" id="importFile" name="file" required 
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    
                    <div class="flex space-x-3">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-upload mr-2"></i>
                            Importar
                        </button>
                        <button type="button" id="btnCancelImport" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-lg transition-colors">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts necesarios -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.tailwindcss.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Estilos personalizados para DataTables */
        .dataTables_wrapper {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }
        
        .dataTables_wrapper .dataTables_length select {
            @apply border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500;
        }
        
        .dataTables_wrapper .dataTables_filter input {
            @apply border border-gray-300 rounded-lg px-4 py-2 text-sm bg-white shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400;
        }
        
        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label {
            @apply text-sm font-medium text-gray-700;
        }
        
        .dataTables_wrapper .dataTables_info {
            @apply text-sm text-gray-600 font-medium;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            @apply px-4 py-2 mx-1 rounded-lg border border-gray-300 text-gray-700 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-700 transition-all duration-200 font-medium;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            @apply bg-blue-600 text-white border-blue-600 shadow-md;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            @apply opacity-50 cursor-not-allowed;
        }
        
        /* Estilos para las filas de la tabla */
        #productsTable tbody tr {
            @apply border-b border-gray-100 hover:bg-blue-50 transition-colors duration-200;
        }
        
        #productsTable tbody tr:nth-child(even) {
            @apply bg-gray-50;
        }
        
        #productsTable tbody tr:hover {
            @apply bg-blue-50 shadow-sm;
        }
        
        #productsTable tbody td {
            @apply px-6 py-4 text-sm;
        }
        
        /* Estilos para los badges de stock */
        .stock-badge {
            @apply inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold;
        }
        
        .stock-badge.in-stock {
            @apply bg-green-100 text-green-800 border border-green-200;
        }
        
        .stock-badge.out-of-stock {
            @apply bg-red-100 text-red-800 border border-red-200;
        }
        
        .stock-badge.low-stock {
            @apply bg-yellow-100 text-yellow-800 border border-yellow-200;
        }
        
        /* Botón de imagen */
        .image-button {
            @apply w-10 h-10 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg flex items-center justify-center transition-colors duration-200 cursor-pointer;
        }
        
        .image-button:hover {
            @apply shadow-md;
        }
        
        /* Botones de acción */
        .action-button {
            @apply w-8 h-8 rounded-lg flex items-center justify-center transition-all duration-200 cursor-pointer;
        }
        
        .action-button.edit {
            @apply bg-indigo-100 hover:bg-indigo-200 text-indigo-600 hover:shadow-md;
        }
        
        .action-button.delete {
            @apply bg-red-100 hover:bg-red-200 text-red-600 hover:shadow-md;
        }
        
        .action-button.view {
            @apply bg-green-100 hover:bg-green-200 text-green-600 hover:shadow-md;
        }

        /* Estilos para las cards */
        .product-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Responsive para la tabla */
        @media (max-width: 768px) {
            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter {
                float: none;
                text-align: center;
                margin-bottom: 1rem;
            }
        }
    </style>

    <script>
        let currentView = 'tabla';
        let allProducts = [];
        let currentPage = 1;
        const itemsPerPage = 12;
        let dataTable;

        document.addEventListener('DOMContentLoaded', function() {
            initializeDataTable();
            loadAllProducts();
            initializeEventListeners();
        });

        function initializeDataTable() {
            dataTable = $('#productsTable').DataTable({
                responsive: true,
                pageLength: 15,
                lengthMenu: [[10, 15, 25, 50, 100], [10, 15, 25, 50, 100]],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
                    search: "Buscar en tabla:",
                    lengthMenu: "Mostrar _MENU_ productos por página",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ productos",
                    infoEmpty: "Mostrando 0 a 0 de 0 productos",
                    infoFiltered: "(filtrado de _MAX_ productos totales)",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                },
                dom: '<"flex flex-col lg:flex-row justify-between items-center mb-6 space-y-4 lg:space-y-0"<"flex items-center"l><"flex items-center"f>>rt<"flex flex-col sm:flex-row justify-between items-center mt-6 pt-4 border-t border-gray-200"<"text-sm text-gray-600"i><"flex items-center space-x-2"p>>',
                columnDefs: [
                    { targets: [3, 12], orderable: false }, // Imagen y Acciones no ordenables
                    { targets: [0, 3, 11, 12], className: 'text-center' }, // Centrar columnas específicas
                ],
                order: [[1, 'asc']], // Ordenar por código por defecto
                drawCallback: function() {
                    // Aplicar estilos después de cada redibujado
                    $('#productsTable tbody tr').addClass('hover:bg-blue-50 transition-colors duration-200');
                }
            });
        }

        function initializeEventListeners() {
            // Toggle entre vistas
            document.getElementById('btnVistaTabla').addEventListener('click', () => switchView('tabla'));
            document.getElementById('btnVistaGrid').addEventListener('click', () => switchView('grid'));

            // Búsqueda
            document.getElementById('btnBuscar').addEventListener('click', (e) => {
                e.preventDefault();
                loadAllProducts();
            });

            // Enter en el campo de búsqueda
            document.getElementById('buscar').addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    loadAllProducts();
                }
            });

            // Cambio de almacén
            document.getElementById('almacen').addEventListener('change', () => {
                loadAllProducts();
            });

            // Modales
            document.getElementById('btnOpenImportModal').addEventListener('click', () => {
                document.getElementById('importModal').classList.remove('hidden');
            });

            document.getElementById('btnCloseImportModal').addEventListener('click', () => {
                document.getElementById('importModal').classList.add('hidden');
            });

            document.getElementById('btnCancelImport').addEventListener('click', () => {
                document.getElementById('importModal').classList.add('hidden');
            });

            // Exportación
            document.getElementById('btnExport').addEventListener('click', (e) => {
                e.preventDefault();
                const filter = document.getElementById('exportFilter').value;
                window.location.href = `{{ route('products.export') }}?filter=${encodeURIComponent(filter)}`;
            });

            // Formulario de importación
            document.getElementById('importForm').addEventListener('submit', handleImport);
        }

        function switchView(view) {
            const btnTabla = document.getElementById('btnVistaTabla');
            const btnGrid = document.getElementById('btnVistaGrid');
            const vistaTabla = document.getElementById('vistaTabla');
            const vistaGrid = document.getElementById('vistaGrid');

            currentView = view;

            if (view === 'tabla') {
                btnTabla.classList.remove('bg-gray-200', 'text-gray-700');
                btnTabla.classList.add('bg-red-600', 'text-white');
                btnGrid.classList.remove('bg-red-600', 'text-white');
                btnGrid.classList.add('bg-gray-200', 'text-gray-700');
                
                vistaTabla.classList.remove('hidden');
                vistaGrid.classList.add('hidden');
                
                if (dataTable) {
                    dataTable.columns.adjust().draw();
                }
            } else {
                btnGrid.classList.remove('bg-gray-200', 'text-gray-700');
                btnGrid.classList.add('bg-red-600', 'text-white');
                btnTabla.classList.remove('bg-red-600', 'text-white');
                btnTabla.classList.add('bg-gray-200', 'text-gray-700');
                
                vistaTabla.classList.add('hidden');
                vistaGrid.classList.remove('hidden');
                
                renderGridView();
            }
        }

        function loadAllProducts() {
            const buscarValue = document.getElementById('buscar').value;
            const almacen = document.getElementById('almacen').value;
            
            fetch(`{{ route('products.search') }}?buscar=${encodeURIComponent(buscarValue)}&almacen=${encodeURIComponent(almacen)}`)
                .then(response => response.json())
                .then(products => {
                    allProducts = products;
                    if (currentView === 'tabla') {
                        renderTableView(products);
                    } else {
                        renderGridView();
                    }
                })
                .catch(error => {
                    console.error('Error en la búsqueda:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al cargar los productos'
                    });
                });
        }

        function renderTableView(products) {
            if (!dataTable) return;
            
            dataTable.clear();
            
            // Actualizar contador
            document.getElementById('totalProducts').textContent = products.length;
            
            products.forEach(product => {
                const rowIndex = dataTable.rows().count() + 1;
                
                const stock = product.stocks && product.stocks.length > 0 
                    ? product.stocks.reduce((total, s) => total + s.quantity, 0) 
                    : 0;
                
                let stockBadge, stockClass;
                if (stock > 10) {
                    stockClass = 'in-stock';
                    stockBadge = `<span class="stock-badge ${stockClass}">
                         <i class="fas fa-check-circle text-green-500 mr-1"></i>
                         <span class="font-bold text-green-500">${stock}</span>
                       </span>`;
                } else if (stock > 0) {
                    stockClass = 'low-stock';
                    stockBadge = `<span class="stock-badge ${stockClass}">
                         <i class="fas fa-exclamation-triangle mr-1 text-yellow-500"></i>
                         <span class="font-bold">${stock}</span>
                       </span>`;
                } else {
                    stockClass = 'out-of-stock';
                    stockBadge = `<span class="stock-badge ${stockClass}">
                         <i class="fas fa-times-circle mr-1 text-red-600"></i>
                         <span class="font-bold">Sin stock</span>
                       </span>`;
                }

                const imageColumn = product.images && product.images.length > 0
                    ? `<button onclick="openModal(${product.id})" class="image-button" title="Ver imágenes">
                         <i class="fas fa-eye text-blue-600"></i>
                       </button>`
                    : `<div class="image-button opacity-50 cursor-not-allowed" title="Sin imágenes">
                         <i class="fas fa-image"></i>
                       </div>`;

                const priceSelect = product.prices && product.prices.length > 0
                    ? `<select class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-full bg-white shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                         ${product.prices.map(price => `
                             <option value="${price.price}">
                                 ${getPriceTypeLabel(price.type)} - S/ ${parseFloat(price.price).toFixed(2)}
                             </option>
                         `).join('')}
                       </select>`
                    : '<span class="text-gray-400 text-sm italic">Sin precios</span>';

                const actions = `
                    <div class="flex items-center justify-center space-x-2">
                        <a href="/products/${product.id}" class="action-button view" title="Ver detalles">
                            <i class="fas fa-eye text-blue-600 text-xs"></i>
                        </a>
                        <a href="/products/${product.id}/edit" class="action-button edit" title="Editar">
                            <i class="fas fa-edit text-yellow-600 text-xs"></i>
                        </a>
                        <form action="/products/${product.id}" method="POST" style="display: inline;" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="action-button delete" title="Eliminar">
                                <i class="fas fa-trash text-red-600 text-xs"></i>
                            </button>
                        </form>
                    </div>
                `;

                dataTable.row.add([
                    `<span class="text-gray-600 font-medium">${rowIndex}</span>`,
                    product.code_sku || '-',
                    product.code_bar || '-',
                    `<div class="flex justify-center">${imageColumn}</div>`,
                    `<div class="max-w-sm">
                       <p class="font-semibold text-gray-900 leading-tight" title="${product.description || ''}">${product.description || '-'}</p>
                     </div>`,
                    `<span class="text-gray-700 font-medium">${product.model || '-'}</span>`,
                    `<span class="text-gray-600">${product.location || '-'}</span>`,
                    `<span class="text-gray-700 font-medium">${product.warehouse?.name || '-'}</span>`,
                    `<span class="text-gray-700 font-medium">${product.brand?.name || '-'}</span>`,
                    `<span class="text-gray-600">${product.unit?.name || '-'}</span>`,
                    priceSelect,
                    `<div class="flex justify-center">${stockBadge}</div>`,
                    actions
                ]);
            });
            
            dataTable.draw();
        }

        function renderGridView() {
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const pageProducts = allProducts.slice(startIndex, endIndex);
            
            const gridContainer = document.getElementById('productsGrid');
            
            if (pageProducts.length === 0) {
                gridContainer.innerHTML = `
                    <div class="col-span-full text-center py-12">
                        <i class="fas fa-box-open text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500 text-lg">No hay productos disponibles</p>
                    </div>
                `;
                return;
            }
            
            const cardsHtml = pageProducts.map(product => {
                const stock = product.stocks && product.stocks.length > 0 
                    ? product.stocks.reduce((total, s) => total + s.quantity, 0) 
                    : 0;
                
                const mainPrice = product.prices && product.prices.length > 0 
                    ? product.prices[0].price 
                    : '0.00';
                
                const imageUrl = product.images && product.images.length > 0 
                    ? product.images[0].image_path 
                    : null;

                return `
                    <div class="product-card bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                        <div class="relative">
                            ${imageUrl 
                                ? `<img src="${imageUrl}" alt="${product.description}" class="w-full h-48 object-cover cursor-pointer" onclick="openModal(${product.id})">`
                                : `<div class="w-full h-48 bg-gray-100 flex items-center justify-center cursor-pointer" onclick="openModal(${product.id})">
                                     <i class="fas fa-image text-4xl text-gray-400"></i>
                                     <span class="ml-2 text-gray-500">Sin imagen</span>
                                   </div>`
                            }
                            <div class="absolute top-2 right-2">
                                <span class="bg-white bg-opacity-90 text-xs font-medium px-2 py-1 rounded-full ${stock > 0 ? 'text-green-600' : 'text-red-600'}">
                                    <i class="fas ${stock > 0 ? 'fa-check-circle' : 'fa-times-circle'} mr-1"></i>
                                    ${stock > 0 ? stock : 'Sin stock'}
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <div class="mb-2">
                                <h3 class="font-semibold text-gray-900 text-sm line-clamp-2 mb-1" title="${product.description || ''}">
                                    ${product.description || 'Sin descripción'}
                                </h3>
                                <p class="text-xs text-gray-500">${product.code_sku || ''}</p>
                            </div>
                            
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-xs text-gray-600 bg-gray-100 px-2 py-1 rounded">
                                    ${product.unit?.name || 'UNIDAD'}
                                </span>
                                <span class="text-lg font-bold text-gray-900">
                                    S/ ${mainPrice}
                                </span>
                            </div>
                            
                            <div class="flex space-x-2">
                                <a href="/products/${product.id}/edit" class="flex-1 bg-blue-600 hover:bg-red-700 text-white text-sm font-medium py-2 px-3 rounded text-center transition-colors">
                                    <i class="fas fa-edit mr-1"></i>
                                    Editar
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
            
            gridContainer.innerHTML = cardsHtml;
            renderGridPagination();
        }

        function renderGridPagination() {
            const totalPages = Math.ceil(allProducts.length / itemsPerPage);
            const paginationContainer = document.getElementById('gridPagination');
            
            if (totalPages <= 1) {
                paginationContainer.innerHTML = '';
                return;
            }
            
            let paginationHtml = '';
            
            // Botón anterior
            if (currentPage > 1) {
                paginationHtml += `
                    <button onclick="changePage(${currentPage - 1})" class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                `;
            }
            
            // Números de página
            const startPage = Math.max(1, currentPage - 2);
            const endPage = Math.min(totalPages, currentPage + 2);
            
            for (let i = startPage; i <= endPage; i++) {
                paginationHtml += `
                    <button onclick="changePage(${i})" class="px-3 py-2 text-sm ${i === currentPage 
                        ? 'bg-blue-600 text-white' 
                        : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100'
                    } rounded-lg transition-colors">
                        ${i}
                    </button>
                `;
            }
            
            // Botón siguiente
            if (currentPage < totalPages) {
                paginationHtml += `
                    <button onclick="changePage(${currentPage + 1})" class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                `;
            }
            
            paginationContainer.innerHTML = paginationHtml;
        }

        function changePage(page) {
            currentPage = page;
            renderGridView();
        }

        function getPriceTypeLabel(type) {
            const labels = {
                'buy': 'Compra',
                'sucursalA': 'Sucursal A',
                'sucursalB': 'Sucursal B',
                'wholesale': 'Mayorista'
            };
            return labels[type] || type;
        }

        function openModal(productId) {
            fetch(`/productos/${productId}/imagenes`)
                .then(response => response.json())
                .then(images => {
                    const swiperWrapper = document.getElementById("swiperWrapper");
                    
                    if (!images || images.length === 0) {
                        swiperWrapper.innerHTML = `
                            <div class="swiper-slide flex items-center justify-center h-64">
                                <div class="text-center text-gray-500">
                                    <i class="fas fa-image text-4xl mb-2"></i>
                                    <p>No hay imágenes disponibles</p>
                                </div>
                            </div>
                        `;
                    } else {
                        const slidesHtml = images.map(img => `
                            <div class="swiper-slide">
                                <div class="flex justify-center items-center h-96">
                                    <img src="${img.image_path}" class="max-w-full max-h-full object-contain rounded-lg" alt="Producto">
                                </div>
                            </div>
                        `).join('');
                        
                        swiperWrapper.innerHTML = slidesHtml;
                    }
                    
                    document.getElementById("imagesModal").classList.remove("hidden");
                    
                    // Inicializar Swiper
                    setTimeout(() => {
                        new Swiper(".mySwiper", {
                            loop: images.length > 1,
                            navigation: {
                                nextEl: ".swiper-button-next",
                                prevEl: ".swiper-button-prev",
                            },
                            pagination: {
                                el: ".swiper-pagination",
                                clickable: true,
                            },
                            autoplay: false,
                        });
                    }, 100);
                })
                .catch(error => {
                    console.error("Error obteniendo imágenes:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudieron cargar las imágenes'
                    });
                });
        }

        function closeModalImages() {
            document.getElementById("imagesModal").classList.add("hidden");
        }

        function handleImport(e) {
            e.preventDefault();
            
            const formData = new FormData();
            const fileInput = document.getElementById('importFile');
            
            if (!fileInput.files[0]) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor selecciona un archivo'
                });
                return;
            }
            
            formData.append('importFile', fileInput.files[0]);
            
            // Mostrar loading
            Swal.fire({
                title: 'Importando...',
                text: 'Por favor espera mientras se procesan los datos',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            fetch("{{ route('products.import') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                Swal.close();
                
                if (!data.success) {
                    const errorMessages = data.message;
                    const htmlMessage = Array.isArray(errorMessages) 
                        ? errorMessages.join('<br>') 
                        : errorMessages;
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Importación Fallida',
                        html: htmlMessage,
                        width: '800px'
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Importación Exitosa',
                        text: data.message,
                    });
                    
                    document.getElementById('importModal').classList.add('hidden');
                    loadAllProducts();
                }
            })
            .catch(error => {
                Swal.close();
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al procesar la importación'
                });
            });
        }

        // Cerrar modales al hacer clic fuera
        document.addEventListener('click', function(e) {
            const importModal = document.getElementById('importModal');
            const imagesModal = document.getElementById('imagesModal');
            
            if (e.target === importModal) {
                importModal.classList.add('hidden');
            }
            
            if (e.target === imagesModal) {
                closeModalImages();
            }
        });
    </script>

@push('scripts')
<script>
    window.routes = {
        productsSearch: '{{ route("products.search") }}',
        productsImages: '/productos/{productId}/imagenes',
        productsExport: '{{ route("products.export") }}',
        productsImport: '{{ route("products.import") }}',
        csrfToken: '{{ csrf_token() }}'
    };
</script>
@endpush

</x-app-layout>