<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="bi bi-currency-dollar me-2"></i>
            Lista de Precios - Año {{ $year }}
        </h2>
    </x-slot>

    <!-- CDN Bootstrap y Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <!-- Header Card -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-2xl font-bold mb-2">
                                <i class="bi bi-currency-dollar me-2"></i>
                                Lista de Precios - Año {{ $year }}
                            </h3>
                            <p class="text-blue-100 mb-0">
                                <i class="bi bi-info-circle me-1"></i>
                                LA LISTA DE PRECIOS SE SACARÁ EN BASE A LAS COMPRAS
                            </p>
                        </div>
                        <div class="d-flex gap-3 align-items-center">
                            <!-- Filtro por año -->
                            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-2">
                                <select id="yearFilter" class="form-select border-0 bg-transparent text-white" style="min-width: 120px;">
                                    @foreach($yearsAvailable as $yearOption)
                                        <option value="{{ $yearOption }}" {{ $yearOption == $year ? 'selected' : '' }} class="text-dark">
                                            {{ $yearOption }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Botones de exportación -->
                            <button class="btn btn-success btn-sm shadow-sm" onclick="exportarExcel()">
                                <i class="bi bi-file-earmark-excel me-1"></i> EXCEL
                            </button>
                            <button class="btn btn-danger btn-sm shadow-sm" onclick="exportarPDF()">
                                <i class="bi bi-file-earmark-pdf me-1"></i> PDF
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <!-- Leyenda de colores mejorada -->
                    <div class="mb-4 p-4 bg-gray-50 rounded-lg border">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h6 class="mb-2 text-gray-700 fw-bold">
                                    <i class="bi bi-palette me-1"></i>
                                    Leyenda de Colores:
                                </h6>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge badge-estable px-3 py-2">
                                        <i class="bi bi-check-circle me-1"></i>ESTABLES
                                    </span>
                                    <span class="badge badge-alto px-3 py-2">
                                        <i class="bi bi-arrow-up-circle me-1"></i>ALTOS
                                    </span>
                                    <span class="badge badge-bajo px-3 py-2">
                                        <i class="bi bi-arrow-down-circle me-1"></i>BAJOS
                                    </span>
                                    <span class="badge badge-normal px-3 py-2">
                                        <i class="bi bi-dash-circle me-1"></i>NORMALES
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>
                                    Última actualización: {{ now()->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tabla de precios mejorada -->
                    <div class="table-responsive shadow-sm rounded-lg overflow-hidden">
                        <table class="table table-hover mb-0 precios-table">
                            <thead class="table-header">
                                <tr>
                                    <th rowspan="2" class="text-center align-middle sticky-col">
                                        <i class="bi bi-upc-scan me-1"></i>CÓDIGO
                                    </th>
                                    <th rowspan="2" class="text-center align-middle sticky-col-2">
                                        <i class="bi bi-box me-1"></i>DESCRIPCIÓN
                                    </th>
                                    <th colspan="12" class="text-center year-header">
                                        <i class="bi bi-calendar3 me-2"></i>AÑO {{ $year }} - MESES
                                    </th>
                                </tr>
                                <tr class="months-header">
                                    <th class="text-center month-col">ENE</th>
                                    <th class="text-center month-col">FEB</th>
                                    <th class="text-center month-col">MAR</th>
                                    <th class="text-center month-col">ABR</th>
                                    <th class="text-center month-col">MAY</th>
                                    <th class="text-center month-col">JUN</th>
                                    <th class="text-center month-col">JUL</th>
                                    <th class="text-center month-col">AGO</th>
                                    <th class="text-center month-col">SEP</th>
                                    <th class="text-center month-col">OCT</th>
                                    <th class="text-center month-col">NOV</th>
                                    <th class="text-center month-col">DIC</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($preciosProductos as $index => $item)
                                <tr class="product-row" data-index="{{ $index }}">
                                    <td class="text-center fw-bold sticky-col code-cell">
                                        <span class="code-badge">
                                            {{ $item['producto']->code_sku ?? $item['producto']->code }}
                                        </span>
                                    </td>
                                    <td class="sticky-col-2 description-cell">
                                        <div class="product-info">
                                            <span class="product-name">{{ $item['producto']->description }}</span>
                                            @if($item['producto']->brand)
                                                <small class="text-muted d-block">{{ $item['producto']->brand->name }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    
                                    @for($mes = 1; $mes <= 12; $mes++)
                                        <td class="text-center precio-cell month-cell" 
                                            data-product-id="{{ $item['producto']->id }}"
                                            data-year="{{ $year }}"
                                            data-month="{{ $mes }}"
                                            data-bs-toggle="tooltip"
                                            title="Click para ver detalles">
                                            @if($item['precios'][$mes])
                                                <span class="precio-valor {{ getPrecioClass($item['precios'], $mes) }}"
                                                      onclick="verDetallesPrecio({{ $item['producto']->id }}, {{ $year }}, {{ $mes }})">
                                                    <i class="bi bi-currency-dollar price-icon"></i>
                                                    {{ number_format($item['precios'][$mes], 2) }}
                                                </span>
                                            @else
                                                <span class="precio-vacio">
                                                    <i class="bi bi-dash"></i>
                                                </span>
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="14" class="text-center py-5 empty-state">
                                        <div class="empty-content">
                                            <i class="bi bi-inbox display-1 text-muted mb-3"></i>
                                            <h5 class="text-muted">No hay datos de precios</h5>
                                            <p class="text-muted mb-0">No se encontraron precios para el año {{ $year }}</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(count($preciosProductos) > 0)
                    <div class="mt-4 p-3 bg-light rounded">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="stat-item">
                                    <i class="bi bi-box text-primary fs-4"></i>
                                    <div class="stat-number">{{ count($preciosProductos) }}</div>
                                    <div class="stat-label">Productos</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-item">
                                    <i class="bi bi-calendar3 text-success fs-4"></i>
                                    <div class="stat-number">{{ $year }}</div>
                                    <div class="stat-label">Año Actual</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-item">
                                    <i class="bi bi-graph-up text-info fs-4"></i>
                                    <div class="stat-number">12</div>
                                    <div class="stat-label">Meses</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-item">
                                    <i class="bi bi-clock text-warning fs-4"></i>
                                    <div class="stat-number">{{ now()->format('H:i') }}</div>
                                    <div class="stat-label">Actualizado</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal mejorado para detalles de precio -->
    <div class="modal fade" id="detallesPrecioModal" tabindex="-1" aria-labelledby="detallesPrecioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="detallesPrecioModalLabel">
                        <i class="bi bi-graph-up me-2"></i>
                        Detalles de Precios
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="detallesPrecioContent">
                        <div class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <p class="mt-2 text-muted">Cargando detalles...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    /* Estilos principales */
    .precios-table {
        font-size: 0.9rem;
        border: none;
    }

    .table-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        color: white;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .table-header th {
        border: none;
        padding: 12px 8px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.8rem;
    }

    .months-header th {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        font-size: 0.75rem;
        padding: 8px 6px;
    }

    .year-header {
        background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%);
        font-size: 0.9rem;
        font-weight: 700;
    }

    /* Columnas fijas */
    .sticky-col {
        position: sticky;
        left: 0;
        background: #f8fafc;
        z-index: 5;
        border-right: 2px solid #e2e8f0;
        min-width: 100px;
    }

    .sticky-col-2 {
        position: sticky;
        left: 100px;
        background: #f8fafc;
        z-index: 5;
        border-right: 2px solid #e2e8f0;
        min-width: 200px;
    }

    /* Filas de productos */
    .product-row {
        transition: all 0.2s ease;
    }

    .product-row:hover {
        background-color: #f1f5f9;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .product-row:nth-child(even) {
        background-color: #fafbfc;
    }

    /* Celdas de código */
    .code-cell {
        font-family: 'Courier New', monospace;
    }

    .code-badge {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: white;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    /* Información del producto */
    .product-info {
        padding: 4px 0;
    }

    .product-name {
        font-weight: 600;
        color: #1f2937;
        line-height: 1.2;
    }

    /* Celdas de precios */
    .precio-cell {
        padding: 8px 4px;
        vertical-align: middle;
        min-width: 80px;
    }

    .precio-valor {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 10px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.3s ease;
        min-width: 70px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        text-decoration: none;
        color: white !important;
    }

    .precio-valor:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .price-icon {
        font-size: 0.7rem;
        margin-right: 2px;
    }

    /* Clases de colores para precios */
    .precio-estable {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: 1px solid #047857;
    }

    .precio-alto {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: 1px solid #1d4ed8;
    }

    .precio-bajo {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        border: 1px solid #b91c1c;
    }

    .precio-normal {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border: 1px solid #b45309;
        color: #000 !important;
    }

    .precio-vacio {
        color: #9ca3af;
        font-size: 1.2rem;
    }

    /* Badges de leyenda */
    .badge-estable {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
    }

    .badge-alto {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        border: none;
    }

    .badge-bajo {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        border: none;
    }

    .badge-normal {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #000;
        border: none;
    }

    /* Estado vacío */
    .empty-state {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    }

    .empty-content {
        padding: 40px 20px;
    }

    /* Estadísticas */
    .stat-item {
        padding: 15px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        margin: 5px;
        transition: transform 0.2s ease;
    }

    .stat-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin: 5px 0;
    }

    .stat-label {
        font-size: 0.8rem;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sticky-col, .sticky-col-2 {
            position: static;
        }
        
        .precio-valor {
            padding: 4px 6px;
            font-size: 0.7rem;
            min-width: 50px;
        }
        
        .table-header th {
            padding: 8px 4px;
            font-size: 0.7rem;
        }
        
        .month-col {
            min-width: 60px;
        }
    }

    /* Animaciones */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .product-row {
        animation: fadeIn 0.3s ease forwards;
    }

    /* Scrollbar personalizada */
    .table-responsive::-webkit-scrollbar {
        height: 8px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border-radius: 4px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    }
    </style>

    <script>
    // Cambiar año
    document.getElementById('yearFilter').addEventListener('change', function() {
        const year = this.value;
        window.location.href = `{{ route('precios-productos.index') }}?year=${year}`;
    });

    // Exportar a Excel
    function exportarExcel() {
        const year = document.getElementById('yearFilter').value;
        window.open(`{{ route('precios-productos.export-excel') }}?year=${year}`, '_blank');
    }

    // Exportar a PDF
    function exportarPDF() {
        const year = document.getElementById('yearFilter').value;
        window.open(`{{ route('precios-productos.export-pdf') }}?year=${year}`, '_blank');
    }

    // Exportar a Excel
    function exportarExcel() {
        const year = document.getElementById('yearFilter').value;
        window.open(`{{ route('precios-productos.export-excel') }}?year=${year}`, '_blank');
    }

    // Exportar a PDF
    function exportarPDF() {
        const year = document.getElementById('yearFilter').value;
        window.open(`{{ route('precios-productos.export-pdf') }}?year=${year}`, '_blank');
    }

    // Ver detalles de precio mejorado
    function verDetallesPrecio(productId, year, month) {
        const modal = new bootstrap.Modal(document.getElementById('detallesPrecioModal'));
        const content = document.getElementById('detallesPrecioContent');
        
        // Mostrar loading mejorado
        content.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary mb-3" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <h6 class="text-muted">Cargando detalles de precios...</h6>
                <p class="text-muted mb-0">Por favor espere un momento</p>
            </div>
        `;
        
        modal.show();
        
        // Cargar detalles
        fetch(`{{ route('precios-productos.detalles') }}?product_id=${productId}&year=${year}&month=${month}`)
            .then(response => response.json())
            .then(data => {
                let html = `
                    <div class="mb-4">
                        <div class="alert alert-info d-flex align-items-center">
                            <i class="bi bi-info-circle me-2"></i>
                            <div>
                                <strong>Compras del mes de ${getMonthName(month)} ${year}</strong>
                                <br><small>Se muestran todas las compras registradas para este producto en el mes seleccionado</small>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th><i class="bi bi-calendar3 me-1"></i>Fecha</th>
                                    <th><i class="bi bi-building me-1"></i>Proveedor</th>
                                    <th><i class="bi bi-shop me-1"></i>Tienda</th>
                                    <th><i class="bi bi-box me-1"></i>Cantidad</th>
                                    <th><i class="bi bi-currency-dollar me-1"></i>Precio Unit.</th>
                                    <th><i class="bi bi-calculator me-1"></i>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                `;
                
                if (data.length > 0) {
                    let totalGeneral = 0;
                    let cantidadTotal = 0;
                    
                    data.forEach(item => {
                        const total = item.quantity * item.price;
                        totalGeneral += total;
                        cantidadTotal += parseInt(item.quantity);
                        
                        html += `
                            <tr>
                                <td>
                                    <span class="badge bg-primary">${formatDate(item.buy.fecha_registro)}</span>
                                </td>
                                <td>
                                    <div>
                                        <strong>${item.buy.supplier ? item.buy.supplier.nombre_negocio : 'N/A'}</strong>
                                        ${item.buy.supplier && item.buy.supplier.nro_documento ? 
                                            `<br><small class="text-muted">${item.buy.supplier.nro_documento}</small>` : ''}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">${item.buy.tienda ? item.buy.tienda.nombre : 'N/A'}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">${item.quantity}</span>
                                </td>
                                <td class="text-end">
                                    <strong class="text-success">S/ ${parseFloat(item.price).toFixed(2)}</strong>
                                </td>
                                <td class="text-end">
                                    <strong class="text-primary">S/ ${total.toFixed(2)}</strong>
                                </td>
                            </tr>
                        `;
                    });
                    
                    // Fila de totales
                    html += `
                        <tr class="table-warning">
                            <td colspan="3" class="text-end"><strong>TOTALES:</strong></td>
                            <td class="text-center"><strong>${cantidadTotal}</strong></td>
                            <td class="text-end"><strong>Promedio: S/ ${(totalGeneral/cantidadTotal).toFixed(2)}</strong></td>
                            <td class="text-end"><strong>S/ ${totalGeneral.toFixed(2)}</strong></td>
                        </tr>
                    `;
                } else {
                    html += `
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="bi bi-inbox display-6 d-block mb-2"></i>
                                    <h6>No hay compras registradas</h6>
                                    <p class="mb-0">No se encontraron compras para este producto en ${getMonthName(month)} ${year}</p>
                                </div>
                            </td>
                        </tr>
                    `;
                }
                
                html += `
                            </tbody>
                        </table>
                    </div>
                `;
                
                content.innerHTML = html;
            })
            .catch(error => {
                content.innerHTML = `
                    <div class="alert alert-danger d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <div>
                            <strong>Error al cargar los detalles</strong>
                            <br><small>${error.message}</small>
                        </div>
                    </div>
                `;
            });
    }

    function getMonthName(month) {
        const months = [
            '', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];
        return months[month];
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('es-PE', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
    }

    // Inicializar tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    </script>
</x-app-layout>