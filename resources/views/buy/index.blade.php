<!-- resources\views\buy\index.blade.php -->
<x-app-layout>
    <x-breadcrumb title="Gestión de Compras" subtitle="compras" />

    <!-- CDN Bootstrap y Bootstrap Icons -->
    <link href="{{ asset('css/buy-index.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Contenedor principal -->
    <div class="px-3 py-4">
        <!-- Filtros y acciones -->
        <div class="bg-white rounded-lg overflow-hidden border border-gray-200 mb-4">
            <!-- Encabezado con filtros -->
            <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                <h3 class="text-base font-semibold text-gray-700 mb-3 flex items-center">
                    <i class="bi bi-filter mr-2 text-blue-600"></i>Filtros de Búsqueda
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Fecha Desde</label>
                        <input type="date" id="fecha_desde"
                            class="w-full border border-gray-300 rounded-md py-2 px-3 text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Fecha Hasta</label>
                        <input type="date" id="fecha_hasta"
                            class="w-full border border-gray-300 rounded-md py-2 px-3 text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Estado de Productos</label>
                        <select id="products_status" class="w-full border border-gray-300 rounded-md py-2 px-3 text-xs">
                            <option value="">Todos</option>
                            <option value="recibidos">Productos Recibidos</option>
                            <option value="pendientes">Pendientes de Llegada</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="mt-3 flex flex-col sm:flex-row sm:justify-between gap-2">
                <!-- Botones de filtro -->
                <div class="flex gap-2 flex-wrap">
                    <button onclick="filterBuys()"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md text-xs transition-colors">
                        <i class="bi bi-search mr-1"></i>Buscar
                    </button>
                    <button onclick="clearFilters()"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md text-xs transition-colors">
                        <i class="bi bi-eraser mr-1"></i>Limpiar
                    </button>
                    <button onclick="exportReports('pdf')"
                        class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md text-xs transition-colors">
                        <i class="bi bi-file-pdf mr-1"></i>PDF
                    </button>
                    <button onclick="exportReports('excel')"
                        class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md text-xs transition-colors">
                        <i class="bi bi-file-excel mr-1"></i>Excel
                    </button>
                    <button onclick="showImportModal()"
                        class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-md text-xs transition-colors">
                        <i class="bi bi-upload mr-1"></i>Importar
                    </button>
                    <button onclick="downloadTemplate()"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md text-xs transition-colors">
                        <i class="bi bi-download mr-1"></i>Plantilla
                    </button>
                </div>

                <!-- Botón Nueva Compra -->
                <a href="{{ route('buys.create') }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md flex items-center justify-center transition-colors text-sm">
                    <i class="bi bi-plus mr-1"></i>Nueva Compra
                </a>
            </div>
        </div>
    </div>

    <!-- Lista de Compras -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
            <h3 class="text-base font-semibold text-gray-700 flex items-center">
                <i class="bi bi-list mr-2 text-blue-600"></i>Lista de Compras
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" id="buysTable">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase">
                            Item
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">
                            Serie/Número
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">
                            Fecha
                        </th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-700 uppercase">
                            Total
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase">
                            Estado Productos
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-xs">
                    @foreach($buys as $index => $buy)
                        <tr class="hover:bg-gray-50"
                            data-fecha="{{ \Carbon\Carbon::parse($buy->fecha_registro)->format('Y-m-d') }}"
                            data-products-status="{{ $buy->delivery_status }}">
                            <td class="px-4 py-3 text-center text-sm">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 text-sm">{{ $buy->serie }}-{{ $buy->number }}</td>
                            <td class="px-4 py-3 text-sm">
                                {{ \Carbon\Carbon::parse($buy->fecha_registro)->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3 text-sm text-right">
                                S/ {{ number_format($buy->total_price, 2) }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($buy->delivery_status === 'received')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="bi bi-check mr-1"></i>Recibidos
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="bi bi-truck mr-1"></i>Carretera
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex space-x-2 justify-center">
                                    <button onclick="viewDetails({{ $buy->id }})"
                                            class="text-blue-600 hover:text-blue-900"
                                            title="Ver detalles">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button onclick="downloadPDF({{ $buy->id }})"
                                            class="text-red-600 hover:text-red-900"
                                            title="Descargar PDF">
                                        <i class="bi bi-file-pdf"></i>
                                    </button>
                                    @if($buy->delivery_status === 'pending')
                                        <button onclick="receiveProducts({{ $buy->id }})"
                                                class="text-green-600 hover:text-green-900"
                                                title="Recibir productos">
                                            <i class="bi bi-truck"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>

    @push('modals')
        @include('buy.partials.details-modal')
    @endpush
    @include('buy.partials.import-modal')
    @include('buy.partials.reception-modal')
    @include('buy.partials.scan-modal')

</x-app-layout>

<script>
    let importData = [];
    let selectedBuys = [];
    let buysTable;

    document.addEventListener('DOMContentLoaded', function () {
        // Configurar fechas por defecto (último mes)
        const today = new Date();
        const lastMonth = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());

        document.getElementById('fecha_desde').value = lastMonth.toISOString().split('T')[0];
        document.getElementById('fecha_hasta').value = today.toISOString().split('T')[0];

        // Inicializar DataTable SIN AJAX (datos ya en HTML)
        if ($.fn.DataTable) {
            buysTable = $('#buysTable').DataTable({
                deferRender: true,
                processing: false,
                stateSave: false,
                responsive: true,
                pageLength: 15,
                lengthMenu: [[10, 15, 25, 50, 100], [10, 15, 25, 50, 100]],
                language: {
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ compras",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ compras",
                    infoEmpty: "0 compras",
                    infoFiltered: "(filtrado de _MAX_ totales)",
                    zeroRecords: "No se encontraron compras",
                    emptyTable: "No hay compras registradas",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                },
                dom: '<"flex justify-between items-center px-3 py-2"lf>rt<"flex justify-between items-center px-3 py-2 border-t border-gray-200"ip>',
                columnDefs: [
                    { targets: [5], orderable: false }, // Acciones no ordenables
                    { targets: [5], className: 'text-center' },
                    { targets: [3], className: 'text-right' } // Total alineado a la derecha
                ],
                order: [[2, 'desc']], // Ordenar por fecha descendente
                autoWidth: false,
                scrollX: false
            });

            // Filtro personalizado de DataTables (como sales)
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    if (settings.nTable.id !== 'buysTable') {
                        return true;
                    }

                    let fechaDesde = document.getElementById('fecha_desde').value;
                    let fechaHasta = document.getElementById('fecha_hasta').value;
                    let productsStatus = document.getElementById('products_status').value;

                    // Obtener la fila usando la API de DataTables
                    let row = settings.aoData[dataIndex].nTr;
                    if (!row) return true;

                    // Filtrar por rango de fechas
                    if (fechaDesde || fechaHasta) {
                        let rowFecha = row.dataset.fecha;
                        if (rowFecha) {
                            if (fechaDesde && rowFecha < fechaDesde) return false;
                            if (fechaHasta && rowFecha > fechaHasta) return false;
                        }
                    }

                    // Filtrar por estado de productos
                    if (productsStatus) {
                        let rowStatus = row.dataset.productsStatus;
                        let expectedStatus = productsStatus === 'recibidos' ? 'received' : 'pending';
                        if (rowStatus !== expectedStatus) return false;
                    }

                    return true;
                }
            );
        }
    });

    // Función para filtrar compras (redibujar DataTable con filtros)
    function filterBuys() {
        if (buysTable) {
            buysTable.draw();
        }
    }

    // Función para limpiar filtros
    function clearFilters() {
        const today = new Date();
        const lastMonth = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());

        document.getElementById('fecha_desde').value = lastMonth.toISOString().split('T')[0];
        document.getElementById('fecha_hasta').value = today.toISOString().split('T')[0];
        document.getElementById('products_status').value = '';
        filterBuys();
    }

    // Función para exportar reportes
    function exportReports(format) {
        const filters = {
            fecha_desde: document.getElementById('fecha_desde').value,
            fecha_hasta: document.getElementById('fecha_hasta').value,
            products_status: document.getElementById('products_status').value,
            format: format
        };

        window.open('{{ route("buy.exportReports") }}?' + new URLSearchParams(filters));
    }

    // Función para descargar plantilla
    function downloadTemplate() {
        window.open('{{ route("buy.downloadTemplate") }}');
    }

    // Funciones de modales de importación
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

        const submitButton = document.querySelector('#uploadForm button[type="submit"]');
        const originalText = submitButton.innerHTML;
        submitButton.innerHTML = '<i class="bi bi-spinner fa-spin mr-1"></i>Procesando...';
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
                    importData = data.data || [];
                    selectedBuys = [...importData];

                    if (data.errors && data.errors.length > 0) {
                        showErrors(data.errors);
                    } else {
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

        const importButton = document.querySelector('button[onclick="importSelectedBuys()"]');
        const originalText = importButton.innerHTML;
        importButton.innerHTML = '<i class="bi bi-spinner fa-spin mr-1"></i>Importando...';
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

    // Funciones de detalles y acciones
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
        const modal = new bootstrap.Modal(document.getElementById('buyDetailsModal'), {
            backdrop: 'static',
            keyboard: true
        });
        const content = document.getElementById('buyDetailsContent');

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
                        <i class="bi bi-exclamation-triangle" style="font-size: 3rem;"></i>
                    </div>
                    <h6 class="text-danger">Error al cargar los detalles</h6>
                    <p class="text-muted mb-3">${error.message}</p>
                    <button class="btn btn-outline-primary" onclick="showBuyDetailsModal(${buyId})">
                        <i class="bi bi-sync-alt me-1"></i>Reintentar
                    </button>
                </div>
            `;
            });
    }

    function populateBuyDetailsModalResponsive(buy) {
        const content = document.getElementById('buyDetailsContent');

        const deliveryStatusBadge = buy.delivery_status === 'received'
            ? '<span class="status-badge status-active"><i class="bi bi-check-circle me-1"></i>Recibidos</span>'
            : '<span class="status-badge status-inactive"><i class="bi bi-clock me-1"></i>Pendientes</span>';

        const paymentTypeBadge = buy.payment_type === 'cash'
            ? '<span class="modal-badge bg-success text-white"><i class="bi bi-money-bill me-1"></i>Contado</span>'
            : '<span class="modal-badge bg-warning text-dark"><i class="bi bi-credit-card me-1"></i>Crédito</span>';

        let html = `
        <div class="compra-details-container">
            <div class="compra-header">
                <div class="d-flex flex-column flex-md-row align-items-center text-center text-md-start">
                    <div class="flex-grow-1">
                        <h2 class="mb-2 fw-bold" style="font-size: 1.5rem;">
                            Compra ${buy.serie}-${buy.number}
                        </h2>
                        <p class="mb-2 opacity-75" style="font-size: 1rem;">
                            <i class="bi bi-calendar me-1"></i>${new Date(buy.fecha_registro).toLocaleDateString()}
                        </p>
                        <div class="mt-3 d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                            ${deliveryStatusBadge}
                            ${paymentTypeBadge}
                            <span class="modal-badge bg-primary text-white">
                                <i class="bi bi-dollar-sign me-1"></i>S/ ${parseFloat(buy.total_price).toFixed(2)}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="info-grid-single">
                <div class="info-section">
                    <h4>
                        <i class="bi bi-shopping-cart"></i>
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

            <div class="border-bottom border-gray-200 mb-4">
                <nav class="nav nav-tabs" id="buyTabs">
                    <button class="tab-button active" onclick="showTab('products')" id="productsTab">
                        <i class="bi bi-box me-1"></i>Productos
                    </button>
                    <button class="tab-button" onclick="showTab('installments')" id="installmentsTab">
                        <i class="bi bi-credit-card me-1"></i>Cuotas
                        ${buy.payment_methods && buy.payment_methods.some(pm => pm.credit_installments && pm.credit_installments.length > 0)
                ? `<span class="badge bg-danger ms-1">${buy.payment_methods.reduce((total, pm) => total + (pm.credit_installments ? pm.credit_installments.length : 0), 0)}</span>`
                : ''}
                    </button>
                </nav>
            </div>

            <div id="productsContent" class="tab-content">
                <div class="modal-table-container">
                    <div class="modal-table-responsive">
                        <table class="table modal-table">
                            <thead>
                                <tr>
                                    <th><i class="bi bi-box me-1"></i>Producto</th>
                                    <th><i class="bi bi-qrcode me-1"></i>SKU</th>
                                    <th><i class="bi bi-sort-numeric-up me-1"></i>Cantidad</th>
                                    <th><i class="bi bi-dollar-sign me-1"></i>Precio Unit.</th>
                                    <th><i class="bi bi-calculator me-1"></i>Subtotal</th>
                                    <th><i class="bi bi-tags me-1"></i>Códigos</th>
                                </tr>
                            </thead>
                            <tbody>
    `;

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
                    <i class="bi bi-inbox display-6 d-block mb-3"></i>
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

            <div id="installmentsContent" class="tab-content hidden">
    `;

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
                              <i class="bi bi-check me-1"></i>Marcar Pagado
                           </button>`
                            : `<button onclick="markInstallmentPending(${installment.id})"
                                  class="btn btn-warning btn-sm">
                              <i class="bi bi-undo me-1"></i>Marcar Pendiente
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
                                <th class="text-center"><i class="bi bi-hashtag me-1"></i>Cuota #</th>
                                <th><i class="bi bi-credit-card me-1"></i>Método de Pago</th>
                                <th class="text-center"><i class="bi bi-dollar-sign me-1"></i>Monto</th>
                                <th class="text-center"><i class="bi bi-calendar me-1"></i>F. Vencimiento</th>
                                <th class="text-center"><i class="bi bi-info-circle me-1"></i>Estado</th>
                                <th class="text-center"><i class="bi bi-calendar-check me-1"></i>F. Pagado</th>
                                <th class="text-center"><i class="bi bi-cogs me-1"></i>Acciones</th>
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
                    <i class="bi bi-info-circle display-6 d-block mb-3"></i>
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
        document.getElementById('buyNumber').textContent = `${buy.serie}-${buy.number}`;
    }

    function getInstallmentStatusBadge(status) {
        const badges = {
            'pendiente': '<span class="modal-badge bg-warning text-dark"><i class="bi bi-clock me-1"></i>Pendiente</span>',
            'pagado': '<span class="modal-badge bg-success text-white"><i class="bi bi-check me-1"></i>Pagado</span>',
            'vencido': '<span class="modal-badge bg-danger text-white"><i class="bi bi-exclamation me-1"></i>Vencido</span>'
        };
        return badges[status] || status;
    }

    function showTab(tabName) {
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });

        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('active');
        });

        document.getElementById(tabName + 'Content').classList.remove('hidden');
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

    // Variables para recepción
    let currentReceptionData = null;
    let currentScanProduct = null;
    let scannedCodes = [];
    let expectedQuantity = 0;
    let receptionProducts = {};

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

        receptionProducts = {};

        buy.buy_items.forEach(item => {
            const isUniqueCode = item.product.control_type === 'codigo_unico';

            receptionProducts[item.product.id] = {
                product_id: item.product.id,
                expected_quantity: item.quantity,
                quantity_received: item.quantity,
                scanned_codes: [],
                is_unique_code: isUniqueCode
            };

            const controlBadge = isUniqueCode
                ? '<span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-semibold"><i class="bi bi-qrcode mr-1"></i>Código Único</span>'
                : '<span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold"><i class="bi bi-sort-numeric-up mr-1"></i>Cantidad</span>';

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
                   <i class="bi bi-qrcode mr-1"></i>Escanear
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

        reproducirSonidoEscaner();
        updateScanDisplay();
    }

    function updateScanDisplay() {
        const listDiv = document.getElementById('scannedCodesList');
        const progressBar = document.getElementById('scanProgress');
        const progressText = document.getElementById('scanProgressText');
        const statusText = document.getElementById('scanStatusText');
        const saveButton = document.getElementById('saveScanButton');

        if (scannedCodes.length === 0) {
            listDiv.innerHTML = '<p class="text-gray-500 text-sm">Ningún código escaneado aún...</p>';
        } else {
            listDiv.innerHTML = `
            <div class="bg-black p-2 rounded">
                ${scannedCodes.map((code, index) =>
                `<div class="flex justify-between items-center py-1 text-green-400">
                        <span class="text-sm font-mono">${index + 1}. ${code}</span>
                        <button onclick="removeScannedCode(${index})" class="text-red-400 hover:text-red-300 text-xs ml-2">
                            <i class="bi bi-times"></i>
                        </button>
                     </div>`
            ).join('')}
            </div>
        `;
        }

        const progress = (scannedCodes.length / expectedQuantity) * 100;
        progressBar.style.width = progress + '%';
        progressText.textContent = `Progreso: ${scannedCodes.length}/${expectedQuantity} códigos escaneados`;

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

        const savedCodesCount = scannedCodes.length;

        receptionProducts[currentScanProduct].scanned_codes = [...scannedCodes];
        receptionProducts[currentScanProduct].quantity_received = scannedCodes.length;

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

        const products = Object.values(receptionProducts);

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

        const processButton = document.querySelector('button[onclick="processReception()"]');
        const originalText = processButton.innerHTML;
        processButton.innerHTML = '<i class="bi bi-spinner fa-spin mr-1"></i>Procesando...';
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
                        filterBuys(); // Recargar tabla DataTable
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
