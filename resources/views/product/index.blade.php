<!-- resources\views\product\index.blade.php -->
<x-app-layout>
    <x-breadcrumb title="Lista de Productos" subtitle="productos" />

    <!-- Bootstrap 5 para modales -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <div class="px-3 py-4">
        <!-- Header con controles -->
        <div class="bg-white rounded-lg border border-gray-200 p-4 mb-4">
            <!-- Fila única con todos los controles -->
            <div class="flex flex-wrap lg:flex-nowrap items-center justify-between gap-2">
                <!-- Grupo izquierdo: Vista + Filtros -->
                <div class="flex flex-wrap lg:flex-nowrap items-center gap-2 min-w-0 flex-1">
                    <!-- Botones de vista -->
                    <div class="flex items-center space-x-1 bg-gray-100 p-1 rounded-lg shrink-0">
                        <button id="btnVistaTabla" class="flex items-center px-3 py-2 bg-white text-gray-700 rounded-md shadow-sm hover:bg-gray-50 transition-all text-sm font-medium whitespace-nowrap">
                            <i class="bi bi-list-ul mr-2"></i>
                            Tabla
                        </button>
                        <button id="btnVistaGrid" class="flex items-center px-3 py-2 text-gray-600 rounded-md hover:bg-white hover:shadow-sm transition-all text-sm font-medium whitespace-nowrap">
                            <i class="bi bi-grid-3x3-gap mr-2"></i>
                            Grid
                        </button>
                    </div>

                    <!-- Select de tienda -->
                    <div class="relative w-full sm:w-auto sm:min-w-[180px] sm:max-w-[200px] shrink">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="bi bi-shop text-gray-400 text-sm"></i>
                        </div>
                        <select name="tienda_id" id="tienda_id" class="w-full h-[38px] border border-gray-300 rounded-lg py-2 pl-10 pr-9 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none bg-white">
                            <option value="todos">Todas las tiendas</option>
                            @foreach ($tiendas as $tienda)
                                <option value="{{ $tienda->id }}">{{ $tienda->nombre }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="bi bi-chevron-down text-gray-400 text-xs"></i>
                        </div>
                    </div>

                    <!-- Exportar -->
                    <div class="flex shrink-0">
                        <select id="exportFilter" class="w-36 h-[38px] border border-gray-300 rounded-l-lg py-2 px-2 text-sm focus:ring-2 focus:ring-purple-500 bg-white">
                            <option value="productos">Productos</option>
                            <option value="stock_minimo">Stock Mín.</option>
                            <option value="precio">Precio</option>
                        </select>
                        <button id="btnExport" class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-2 rounded-r-lg transition-colors h-[38px] flex items-center justify-center" title="Exportar">
                            <i class="bi bi-download"></i>
                        </button>
                    </div>
                </div>

                <!-- Grupo derecho: Botones de acción -->
                <div class="flex items-center gap-2 shrink-0">
                    <button id="btnOpenImportModal" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg flex items-center justify-center transition-colors shadow-sm text-sm whitespace-nowrap">
                        <i class="bi bi-upload mr-2"></i>
                        Importar
                    </button>
                    
                    @can('agregar-productos')
                        <a href="{{ route('products.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg flex items-center justify-center transition-colors shadow-sm text-sm whitespace-nowrap">
                            <i class="bi bi-plus-lg mr-2"></i>
                            Agregar
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <!-- Mensajes de éxito o error -->
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 text-green-700 px-4 py-2 rounded mb-3 text-sm">
                <i class="bi bi-check-circle mr-1"></i>{{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border-l-4 border-red-400 text-red-700 px-4 py-2 rounded mb-3 text-sm">
                <i class="bi bi-exclamation-circle mr-1"></i>{{ session('error') }}
            </div>
        @endif

        <!-- Vista de Tabla -->
        <div id="vistaTabla" class="bg-white rounded-lg border border-gray-200 overflow-hidden">            
            <div class="overflow-x-auto">
                <table id="productsTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600">#</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600">CÓDIGO</th>
                            {{-- <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600">CÓDIGO BARRAS</th> --}}
                            {{-- <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600">IMAGEN</th> --}}
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600">DESCRIPCIÓN</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600">MODELO</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600">UBICACIÓN</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600">TIENDA</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600">MARCA</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600">UNIDAD</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600">PRECIO</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600">STOCK</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($products as $product)
                            @php
                                $stock = $product->stocks && $product->stocks->count() > 0 
                                    ? $product->stocks->sum('quantity') 
                                    : 0;
                            @endphp
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="px-3 py-2 text-sm text-gray-700 text-center">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2 text-sm text-gray-700 text-center">{{ $product->code_sku ?? '-' }}</td>
                                {{-- <td class="px-3 py-2 text-sm text-gray-700 text-center">{{ $product->code_bar ?? '-' }}</td> --}}
                                {{-- <td class="px-3 py-2 text-center">
                                    @if($product->images && $product->images->count() > 0)
                                        <button onclick="openModal({{ $product->id }})" class="w-10 h-10 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg flex items-center justify-center transition-colors mx-auto">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    @else
                                        <div class="w-10 h-10 bg-gray-100 text-gray-400 rounded-lg flex items-center justify-center mx-auto">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </td> --}}
                                <td class="px-3 py-2 text-sm text-gray-90 text-center0">
                                    <span class="font-medium" title="{{ $product->description }}">{{ Str::limit($product->description, 50) ?? '-' }}</span>
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-700 text-center">{{ $product->model ?? '-' }}</td>
                                <td class="px-3 py-2 text-sm text-gray-600 text-center">{{ $product->location ?? '-' }}</td>
                                <td class="px-3 py-2 text-sm text-gray-700 text-center">{{ $product->tienda->nombre ?? '-' }}</td>
                                <td class="px-3 py-2 text-sm text-gray-700 text-center">{{ $product->brand->name ?? '-' }}</td>
                                <td class="px-3 py-2 text-sm text-gray-600 text-center">{{ $product->unit->name ?? '-' }}</td>
                                <td class="px-3 py-2 text-sm text-gray-900 text-center">
                                    @if($product->prices && $product->prices->count() > 0)
                                        <select class="border border-gray-300 rounded px-2 py-1 text-xs">
                                            @foreach($product->prices as $price)
                                                <option>{{ $price->type }} - S/ {{ number_format($price->price, 2) }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <span class="text-gray-400 text-xs italic">Sin precios</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2 text-center">
                                    @if($stock > 10)
                                        <span class="px-2 py-1 inline-flex text-xs font-medium rounded-full bg-green-100 text-green-700">
                                            <i class="fas fa-check-circle mr-1"></i>{{ $stock }}
                                        </span>
                                    @elseif($stock > 0)
                                        <span class="px-2 py-1 inline-flex text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>{{ $stock }}
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs font-medium rounded-full bg-red-100 text-red-700">
                                            <i class="fas fa-times-circle mr-1"></i>Sin stock
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('products.show', $product->id) }}" class="text-blue-600 hover:text-blue-800 transition-colors" title="Ver">
                                            <i class="fas fa-eye text-base"></i>
                                        </a>
                                        <a href="{{ route('products.edit', $product->id) }}" class="text-purple-600 hover:text-purple-800 transition-colors" title="Editar">
                                            <i class="fas fa-edit text-base"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 transition-colors" title="Eliminar">
                                                <i class="fas fa-trash text-base"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        /* Ocultar flecha nativa del select en todos los navegadores */
        #tienda_id {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: none;
        }
        
        #tienda_id::-ms-expand {
            display: none;
        }
        
        /* Centrar headers y datos */
        #productsTable thead th {
            text-align: center !important;
        }
        
        #productsTable tbody td {
            text-align: center !important;
        }
        
        /* Línea del encabezado más visible */
        #productsTable thead th {
            border-bottom: 2px solid #6b7280 !important;
        }
    </style>

    <script>
        window.routes = {
            productsSearch: '{{ route("products.search") }}',
            productsExport: '{{ route("products.export") }}',
            productsImport: '{{ route("products.import") }}',
            productsShow: '{{ route("products.show", ['product' => '__ID__']) }}',
            productsEdit: '{{ route("products.edit", ['product' => '__ID__']) }}',
            productsDestroy: '{{ route("products.destroy", ['product' => '__ID__']) }}',
            productsImages: '{{ route("products.images", ['id' => '__ID__']) }}',
            csrfToken: '{{ csrf_token() }}'
        };

        let currentView = 'tabla';
        let allProducts = @json($products);
        let currentPage = 1;
        const itemsPerPage = 12;

        document.addEventListener('DOMContentLoaded', function() {
            initializeDataTable();
            initializeEventListeners();
        });

        function initializeDataTable() {
            if ($.fn.DataTable) {
                $('#productsTable').DataTable({
                    deferRender: true,
                    processing: false,
                    stateSave: false,
                    responsive: true,
                    pageLength: 15,
                    lengthMenu: [[10, 15, 25, 50, 100], [10, 15, 25, 50, 100]],
                    language: {
                        search: "Buscar:",
                        lengthMenu: "Mostrar _MENU_ productos",
                        info: "Mostrando _START_ a _END_ de _TOTAL_ productos",
                        infoEmpty: "0 productos",
                        infoFiltered: "(filtrado de _MAX_ totales)",
                        zeroRecords: "No se encontraron productos",
                        emptyTable: "No hay productos registrados",
                        paginate: {
                            first: "Primero",
                            last: "Último",
                            next: "Siguiente",
                            previous: "Anterior"
                        }
                    },
                    dom: '<"flex justify-between items-center px-3 py-2"lf>rt<"flex justify-between items-center px-3 py-2 border-t border-gray-200"ip>',
                    columnDefs: [
                        { targets: [9], orderable: false }, // Acciones no ordenables
                        { targets: '_all', className: 'text-center' }
                    ],
                    order: [[1, 'asc']] // Ordenar por código
                });

            }
        }

        function initializeEventListeners() {
            // Toggle entre vistas
            document.getElementById('btnVistaTabla').addEventListener('click', () => switchView('tabla'));
            document.getElementById('btnVistaGrid').addEventListener('click', () => switchView('grid'));

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
                // Activar botón tabla
                btnTabla.classList.remove('text-gray-600');
                btnTabla.classList.add('bg-white', 'text-gray-700', 'shadow-sm');
                
                // Desactivar botón grid
                btnGrid.classList.remove('bg-white', 'text-gray-700', 'shadow-sm');
                btnGrid.classList.add('text-gray-600');
                
                vistaTabla.classList.remove('hidden');
                vistaGrid.classList.add('hidden');
            } else {
                // Activar botón grid
                btnGrid.classList.remove('text-gray-600');
                btnGrid.classList.add('bg-white', 'text-gray-700', 'shadow-sm');
                
                // Desactivar botón tabla
                btnTabla.classList.remove('bg-white', 'text-gray-700', 'shadow-sm');
                btnTabla.classList.add('text-gray-600');
                
                vistaTabla.classList.add('hidden');
                vistaGrid.classList.remove('hidden');
                
                renderGridView();
            }
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
                    <div class="product-card bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="relative">
                            ${imageUrl 
                                ? `<img src="${imageUrl}" alt="${product.description}" class="w-full h-48 object-cover">`
                                : `<div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                                     <i class="fas fa-image text-4xl text-gray-400"></i>
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
                                <a href="${window.routes.productsEdit.replace('__ID__', product.id)}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-3 rounded text-center transition-colors">
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

        function openModal(productId) {
            fetch(window.routes.productsImages.replace('__ID__', productId))
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
                    setTimeout(() => location.reload(), 2000);
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

</x-app-layout>