<!-- resources\views\sales\index.blade.php -->
<x-app-layout>
    <x-breadcrumb title="Registro de Ventas" subtitle="ventas" />

    <!-- Bootstrap 5 para modales (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Contenedor principal -->
    <div class="px-3 py-4">
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

        <!-- Tabla con filtros y botón agregar -->
        <div class="bg-white rounded-lg overflow-hidden border border-gray-200">
            <!-- Encabezado con filtros y botón agregar -->
            <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
                    <!-- Filtros -->
                    <div class="flex flex-col sm:flex-row gap-2 items-start sm:items-center flex-1">
                        <select id="document_type_id" class="border border-gray-300 rounded-md py-2 px-3 text-xs">
                            <option value="">Todos los documentos</option>
                            @foreach ($documentTypes as $documentType)
                                <option value="{{ $documentType->id }}">{{ $documentType->name }}</option>
                            @endforeach
                        </select>

                        <div class="flex items-center gap-2">
                            <label for="fecha_desde" class="text-xs font-medium text-gray-600">Desde:</label>
                            <input type="date" id="fecha_desde" class="border border-gray-300 rounded-md py-2 px-3 text-xs">
                        </div>

                        <div class="flex items-center gap-2">
                            <label for="fecha_hasta" class="text-xs font-medium text-gray-600">Hasta:</label>
                            <input type="date" id="fecha_hasta" class="border border-gray-300 rounded-md py-2 px-3 text-xs">
                        </div>

                        <button type="button" onclick="aplicarFiltros()" 
                                class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md text-xs transition-colors">
                            <i class="bi bi-funnel mr-1"></i>Filtrar
                        </button>
                    </div>

                    <!-- Botón Agregar -->
                    <a href="{{ route('sales.create') }}"
                        class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-md flex items-center justify-center transition-colors text-sm">
                        <i class="bi bi-plus-lg mr-1"></i>Agregar
                    </a>
                </div>
            </div>

            <!-- Tabla -->
            <div class="overflow-x-auto">
                <table id="salesTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">N°</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">Documento</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Cliente</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">DNI</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Vendedor</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Mecánico</th>
                            <th class="px-3 py-2 text-right text-xs font-semibold text-gray-600 uppercase">SubTotal</th>
                            <th class="px-3 py-2 text-right text-xs font-semibold text-gray-600 uppercase">IGV</th>
                            <th class="px-3 py-2 text-right text-xs font-semibold text-gray-600 uppercase">Total</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">Fecha</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($sales as $sale)
                            <tr class="hover:bg-blue-50 transition-colors"
                                data-document-type="{{ $sale->document_type_id }}"
                                data-fecha="{{ \Carbon\Carbon::parse($sale->fecha_registro)->format('Y-m-d') }}">
                                <td class="px-3 py-2 text-sm text-gray-700 text-center">{{ $sale->code }}</td>
                                <td class="px-3 py-2 text-sm font-medium text-gray-900 text-center">
                                    <a href="javascript:void(0)" 
                                       onclick="{{ $sale->document_type_id == 6 ? 'generarPDFNota(' . $sale->id . ')' : 'generarPDF(' . $sale->id . ')' }}"
                                       class="text-blue-600 hover:text-blue-800">
                                        {{ $sale->serie }} - {{ $sale->number }}
                                    </a>
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-600">
                                    {{ $sale->customer_names_surnames ?? 'Sin cliente' }}
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-600">{{ $sale->customer_dni }}</td>
                                <td class="px-3 py-2 text-sm text-gray-600">
                                    {{ $sale->userRegister->name ?? 'Sin vendedor' }}
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-600">
                                    {{ $sale->mechanic->name ?? 'Sin mecánico' }}
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-600 text-right">
                                    S/. {{ number_format($sale->total_price - $sale->igv, 2) }}
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-600 text-right">
                                    S/. {{ number_format($sale->igv, 2) }}
                                </td>
                                <td class="px-3 py-2 text-sm font-medium text-gray-900 text-right">
                                    S/. {{ number_format($sale->total_price, 2) }}
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-600 text-center">
                                    {{ \Carbon\Carbon::parse($sale->fecha_registro)->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <!-- Ver detalles -->
                                        <button onclick="verDetalles({{ $sale->id }})" 
                                                class="text-blue-600 hover:text-blue-800 transition-colors" 
                                                title="Ver detalles">
                                            <i class="bi bi-eye text-base"></i>
                                        </button>
                                        
                                        <!-- Eliminar -->
                                        <button onclick="deleteSale({{ $sale->id }})" 
                                                class="text-red-600 hover:text-red-800 transition-colors {{ $sale->status_sunat == 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                title="Eliminar"
                                                {{ $sale->status_sunat == 1 ? 'disabled' : '' }}>
                                            <i class="bi bi-trash text-base"></i>
                                        </button>
                                        
                                        <!-- PDF -->
                                        <button onclick="{{ $sale->document_type_id == 6 ? 'generarPDFNota(' . $sale->id . ')' : 'generarPDF(' . $sale->id . ')' }}"
                                                class="text-red-600 hover:text-red-800 transition-colors" 
                                                title="Generar PDF">
                                            <i class="bi bi-filetype-pdf text-base"></i>
                                        </button>
                                        
                                        <!-- Enviar SUNAT -->
                                        <button onclick="enviarSunat({{ $sale->id }})"
                                                class="{{ $sale->status_sunat == 1 ? 'text-blue-600' : 'text-green-600' }} hover:opacity-80 transition-opacity {{ $sale->status_sunat == 1 ? 'cursor-not-allowed' : '' }}"
                                                title="{{ $sale->status_sunat == 1 ? 'Enviado a SUNAT' : 'Enviar a SUNAT' }}"
                                                {{ $sale->status_sunat == 1 ? 'disabled' : '' }}>
                                            <i class="bi {{ $sale->status_sunat == 1 ? 'bi-send-check' : 'bi-send-slash' }} text-base"></i>
                                        </button>
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
<!-- Modal de detalles - Estilo Bootstrap -->
<div class="modal fade" id="saleDetailsModal" tabindex="-1" aria-labelledby="saleDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-lg-down modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                <h5 class="modal-title d-flex align-items-center" id="saleDetailsModalLabel">
                    <i class="bi bi-receipt me-2"></i>
                    <span>Detalles de la Venta</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-4">
                <div id="saleDetailsContent">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <h6 class="text-muted">Cargando detalles de la venta...</h6>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
@endpush

<style>
/* Estilos para el modal */
.modal-header {
    border-bottom: none;
    padding: 1.25rem 1.5rem;
}

.modal-title {
    font-size: 1.25rem;
    font-weight: 600;
}

.btn-close-white {
    filter: invert(1) grayscale(100%) brightness(200%);
    opacity: 0.8;
}

.btn-close-white:hover {
    opacity: 1;
}

.info-section {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.info-section h4 {
    color: #1f2937;
    font-weight: 600;
    font-size: 1.125rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
}

.info-row {
    display: flex;
    justify-content: space-between;
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
}
</style>

<script>
// Función para ver detalles de la venta
async function verDetalles(saleId) {
    const modal = new bootstrap.Modal(document.getElementById('saleDetailsModal'));
    const content = document.getElementById('saleDetailsContent');
    
    // Mostrar loading
    content.innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <h6 class="text-muted">Cargando detalles de la venta...</h6>
        </div>
    `;
    
    modal.show();
    
    try {
        let url = `{{ route('sale.detallesVenta', ':id') }}`.replace(':id', saleId);
        let response = await fetch(url);
        let data = await response.json();
        
        // Construir HTML de detalles
        let html = `
            <div class="info-section">
                <h4><i class="bi bi-person-circle me-2 text-blue-600"></i>Información General</h4>
                <div class="info-row">
                    <span class="info-label">Cliente:</span>
                    <span class="info-value">${data.sale.customer_names_surnames || 'Sin cliente'}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">DNI:</span>
                    <span class="info-value">${data.sale.customer_dni || 'N/A'}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Vendedor:</span>
                    <span class="info-value">${data.sale.user_register ? data.sale.user_register.name : 'N/A'}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Fecha:</span>
                    <span class="info-value">${data.sale.fecha_registro}</span>
                </div>
            </div>
            
            <div class="info-section">
                <h4><i class="bi bi-cart-check me-2 text-blue-600"></i>Detalles de la Compra</h4>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Tipo</th>
                                <th>Descripción</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Precio Unit.</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
        `;
        
        data.sale.sale_items.forEach(item => {
            let tipo = item.item_type.includes("Product") ? "Producto" : "Servicio";
            let descripcion = item.item.description || item.item.name;
            let total = (item.quantity * parseFloat(item.unit_price)).toFixed(2);
            
            html += `
                <tr>
                    <td>${tipo}</td>
                    <td>${descripcion}</td>
                    <td class="text-center">${item.quantity}</td>
                    <td class="text-end">S/. ${parseFloat(item.unit_price).toFixed(2)}</td>
                    <td class="text-end">S/. ${total}</td>
                </tr>
            `;
        });
        
        html += `
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-end mt-3">
                    <div class="border rounded p-3" style="min-width: 250px;">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-medium">SubTotal:</span>
                            <span class="fw-bold">S/. ${(data.sale.total_price - data.sale.igv).toFixed(2)}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-medium">IGV:</span>
                            <span class="fw-bold">S/. ${parseFloat(data.sale.igv).toFixed(2)}</span>
                        </div>
                        <div class="d-flex justify-content-between border-top pt-2">
                            <span class="fw-bold">Total:</span>
                            <span class="fw-bold text-primary fs-5">S/. ${parseFloat(data.sale.total_price).toFixed(2)}</span>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Agregar devoluciones si existen
        if (data.sale.devoluciones && data.sale.devoluciones.length > 0) {
            html += `
                <div class="info-section">
                    <h4><i class="bi bi-arrow-return-left me-2 text-blue-600"></i>Devoluciones</h4>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Producto</th>
                                    <th class="text-center">Cantidad</th>
                                    <th>Fecha</th>
                                    <th>Usuario</th>
                                    <th>Motivo</th>
                                </tr>
                            </thead>
                            <tbody>
            `;
            
            data.sale.devoluciones.forEach(devolucion => {
                devolucion.items.forEach(item => {
                    html += `
                        <tr>
                            <td>${item.sale_item.item.description || item.sale_item.item.name}</td>
                            <td class="text-center">${item.quantity_returned}</td>
                            <td>${new Date(devolucion.created_at).toLocaleString()}</td>
                            <td>${devolucion.user_register ? devolucion.user_register.name : 'N/A'}</td>
                            <td>${devolucion.reason || 'Sin motivo'}</td>
                        </tr>
                    `;
                });
            });
            
            html += `
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
        }
        
        content.innerHTML = html;
    } catch (error) {
        console.error("Error obteniendo los detalles:", error);
        content.innerHTML = `
            <div class="text-center py-5">
                <i class="bi bi-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                <h6 class="text-danger mt-3">Error al cargar los detalles</h6>
                <p class="text-muted">Por favor, intenta nuevamente</p>
                <button class="btn btn-outline-primary" onclick="verDetalles(${saleId})">
                    <i class="bi bi-arrow-clockwise me-1"></i>Reintentar
                </button>
            </div>
        `;
    }
}

// Función para eliminar venta
async function deleteSale(saleId) {
    const result = await Swal.fire({
        title: '¿Estás seguro?',
        text: "No podrás revertir esta acción",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    });
    
    if (!result.isConfirmed) return;
    
    try {
        let url = `{{ route('sales.destroy', ':id') }}`.replace(':id', saleId);
        let response = await fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        
        if (response.ok) {
            Swal.fire({
                icon: 'success',
                title: 'Venta Eliminada',
                text: 'La venta se ha eliminado correctamente',
                showConfirmButton: false,
                timer: 2000
            });
            // Recargar la página para actualizar la tabla
            setTimeout(() => window.location.reload(), 2000);
        } else {
            throw new Error('Error al eliminar la venta');
        }
    } catch (error) {
        console.error("Error al eliminar la venta:", error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo eliminar la venta',
            showConfirmButton: true
        });
    }
}

// Función para generar PDF
function generarPDF(saleId) {
    let url = `{{ route('sales.pdf', ':id') }}`.replace(':id', saleId);
    window.open(url, '_blank');
}

// Función para generar PDF de nota de venta
function generarPDFNota(saleId) {
    let url = `{{ route('salesNota.pdf', ':id') }}`.replace(':id', saleId);
    window.open(url, '_blank');
}

// Función para enviar a SUNAT
async function enviarSunat(saleId) {
    try {
        let url = `{{ route('sales.enviarSunat', ':id') }}`.replace(':id', saleId);
        let response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        
        if (response.ok) {
            Swal.fire({
                icon: 'success',
                title: 'Venta Enviada a SUNAT',
                text: 'La venta se ha enviado correctamente',
                showConfirmButton: false,
                timer: 2000
            });
            setTimeout(() => window.location.reload(), 2000);
        } else {
            throw new Error('Error al enviar a SUNAT');
        }
    } catch (error) {
        console.error("Error al enviar a SUNAT:", error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo enviar la venta a SUNAT',
            showConfirmButton: true
        });
    }
}

// Inicializar DataTables
document.addEventListener('DOMContentLoaded', function() {
    // Filtro personalizado de DataTables
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            if (settings.nTable.id !== 'salesTable') {
                return true;
            }
            
            let documentTypeId = document.getElementById('document_type_id').value;
            let fechaDesde = document.getElementById('fecha_desde').value;
            let fechaHasta = document.getElementById('fecha_hasta').value;
            
            let row = window.salesTable.row(dataIndex).node();
            if (!row) return true;
            
            // Filtrar por tipo de documento
            if (documentTypeId && row.dataset.documentType != documentTypeId) {
                return false;
            }
            
            // Filtrar por rango de fechas
            if (fechaDesde || fechaHasta) {
                let rowFecha = row.dataset.fecha;
                if (fechaDesde && rowFecha < fechaDesde) return false;
                if (fechaHasta && rowFecha > fechaHasta) return false;
            }
            
            return true;
        }
    );
    
    // Inicializar DataTable
    if ($.fn.DataTable) {
        window.salesTable = $('#salesTable').DataTable({
            deferRender: true,
            processing: false,
            stateSave: false,
            responsive: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            language: {
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_ ventas",
                info: "Mostrando _START_ a _END_ de _TOTAL_ ventas",
                infoEmpty: "0 ventas",
                infoFiltered: "(filtrado de _MAX_ totales)",
                zeroRecords: "No se encontraron ventas",
                emptyTable: "No hay ventas registradas",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior"
                }
            },
            dom: '<"flex justify-between items-center px-3 py-2"lf>rt<"flex justify-between items-center px-3 py-2 border-t border-gray-200"ip>',
            columnDefs: [
                { targets: [10], orderable: false }, // Acciones no ordenables
                { targets: [10], className: 'text-center' },
                { targets: [6, 7, 8], className: 'text-right' } // Montos alineados a la derecha
            ],
            order: [[9, 'desc']], // Ordenar por fecha descendente
            autoWidth: false,
            scrollX: false
        });
    }
});

// Función para aplicar filtros
function aplicarFiltros() {
    if (window.salesTable) {
        window.salesTable.draw();
    }
}


</script>

</x-app-layout>