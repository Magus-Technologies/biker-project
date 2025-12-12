<!-- resources\views\driver\index.blade.php -->
<x-app-layout>
    <x-breadcrumb title="Lista de Conductores" subtitle="clientes" />
 

    <!-- Bootstrap 5 para modales (CDN - no está en package.json) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Contenedor principal con poco padding -->
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

        <!-- Tabla con botón agregar integrado -->
        <div class="bg-white rounded-lg overflow-hidden border border-gray-200">
            <!-- Botón Agregar en la esquina superior derecha -->
            <div class="px-4 py-3 flex justify-end border-b border-gray-200">
                <a href="{{ route('drives.create') }}"
                    class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-md flex items-center transition-colors text-sm">
                    <i class="bi bi-plus-lg mr-1"></i>
                    Agregar
                </a>
            </div>

            <div class="overflow-x-auto">
                <table id="driversTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                                Código
                            </th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                                Nombres y Apellidos
                            </th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                                Documento
                            </th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                                Teléfono
                            </th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                                Correo
                            </th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">
                                Estado
                            </th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($drives as $drive)
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="px-3 py-2 text-sm text-gray-700">
                                    {{ $drive->codigo }}
                                </td>
                                <td class="px-3 py-2 text-sm font-medium text-gray-900">
                                    {{ $drive->nombres }} {{ $drive->apellido_paterno }} {{ $drive->apellido_materno }}
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-600">
                                    {{ $drive->tipo_documento ?? 'DNI' }}: {{ $drive->nro_documento ?? 'N/A' }}
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-600">
                                    {{ $drive->telefono ?? 'N/A' }}
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-600">
                                    {{ $drive->correo ?? 'N/A' }}
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <span class="px-2 py-1 inline-flex text-xs font-medium rounded {{ $drive->status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $drive->status ? 'Aprobado' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button onclick="showDriverDetails({{ $drive->id }})" 
                                                class="text-blue-600 hover:text-blue-800 transition-colors" 
                                                title="Ver detalles">
                                            <i class="bi bi-eye text-base"></i>
                                        </button>
                                        @can('actualizar-conductores')
                                            <a href="{{ route('drives.edit', $drive->id) }}" 
                                               class="text-purple-600 hover:text-purple-800 transition-colors" 
                                               title="Editar">
                                                <i class="bi bi-pencil text-base"></i>
                                            </a>
                                        @endcan
                                        <form id="delete-form-driver-{{ $drive->id }}" action="{{ route('drives.destroy', $drive->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-600 hover:text-red-800 transition-colors"
                                                    title="Eliminar" onclick="confirmDeleteDriver({{ $drive->id }})">
                                                <i class="bi bi-trash text-base"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-3 py-8 text-center text-gray-500">
                                    <i class="bi bi-person-badge text-4xl text-gray-300 mb-2"></i>
                                    <p class="text-sm">No hay conductores registrados</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@push('modals')
<!-- Modal mejorado y responsive para detalles del conductor - Estilo Bootstrap -->
<div class="modal fade" id="driverDetailsModal" tabindex="-1" aria-labelledby="driverDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-lg-down modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                <h5 class="modal-title d-flex align-items-center" id="driverDetailsModalLabel">
                    <i class="bi bi-person-circle me-2"></i>
                    <span>Detalles del Conductor</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-0">
                <div id="driverDetailsContent" class="h-100 overflow-auto">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <h6 class="text-muted">Cargando detalles del conductor...</h6>
                        <p class="text-muted mb-0">Por favor espere un momento</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Cerrar
                </button>
                <button type="button" id="editDriverBtn" class="btn btn-primary" style="display: none;">
                    <i class="bi bi-pencil-square me-1"></i>Editar
                </button>
            </div>
        </div>
    </div>
</div>
@endpush

<style>
/* Estilos específicos para el modal de conductor */
.modal-header {
    border-bottom: none;
    padding: 1.25rem 1.5rem;
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
}

.modal-footer {
    border-top: 1px solid #dee2e6;
    padding: 1rem 1.5rem;
}

/* Contenido del conductor con diseño mejorado */
.driver-details-container {
    padding: 1.5rem;
}

.driver-header {
    background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
    color: white;
    padding: 2rem;
    border-radius: 0.75rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.driver-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 4px solid white;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    object-fit: cover;
}

.driver-avatar-placeholder {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 4px solid white;
    background-color: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
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
    color: #3b82f6;
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
    
    .driver-header {
        padding: 2.5rem;
    }
    
    .driver-details-container {
        padding: 2rem;
    }
}

@media (min-width: 1024px) {
    .info-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .info-row {
        flex-direction: row;
        text-align: left;
    }
    
    .info-value {
        text-align: right;
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

/* Scrollbar personalizada */
#driverDetailsContent::-webkit-scrollbar {
    width: 8px;
}

#driverDetailsContent::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

#driverDetailsContent::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
    border-radius: 4px;
}

#driverDetailsContent::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
}
</style>

<script>
// Función para mostrar detalles del conductor - Versión Bootstrap Modal
function showDriverDetails(driverId) {
    const modal = new bootstrap.Modal(document.getElementById('driverDetailsModal'), {
        backdrop: 'static',
        keyboard: true
    });
    const content = document.getElementById('driverDetailsContent');
    const editBtn = document.getElementById('editDriverBtn');
    
    // Mostrar loading
    content.innerHTML = `
        <div class="loading-container">
            <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <h6 class="text-muted">Cargando detalles del conductor...</h6>
            <p class="text-muted mb-0">Por favor espere un momento</p>
        </div>
    `;
    
    // Ocultar botón de editar
    editBtn.style.display = 'none';
    
    modal.show();
    
    // Cargar detalles
    fetch(`{{ route('drives.details', ['id' => '__driverId__']) }}`.replace('__driverId__', driverId))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                content.innerHTML = data.html;
                
                // Mostrar botón editar si tiene permisos
                @can('actualizar-conductores')
                    editBtn.style.display = 'inline-block';
                    editBtn.onclick = () => {
                        window.location.href = `/drives/${driverId}/edit`;
                    };
                @endcan
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
                    <button class="btn btn-outline-primary" onclick="showDriverDetails(${driverId})">
                        <i class="bi bi-arrow-clockwise me-1"></i>Reintentar
                    </button>
                </div>
            `;
        });
}

// Inicializar DataTables - Optimizado para carga rápida
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar DataTable en la tabla de conductores
    if ($.fn.DataTable) {
        $('#driversTable').DataTable({
            // Optimizaciones de rendimiento
            deferRender: true,      // Renderizar solo las filas visibles
            processing: false,       // Sin mensaje de "Procesando..."
            stateSave: false,        // No guardar estado en localStorage
            
            // Configuración básica
            responsive: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            
            // Idioma español
            language: {
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_ conductores",
                info: "Mostrando _START_ a _END_ de _TOTAL_ conductores",
                infoEmpty: "0 conductores",
                infoFiltered: "(filtrado de _MAX_ totales)",
                zeroRecords: "No se encontraron conductores",
                emptyTable: "No hay conductores registrados",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior"
                }
            },
            
            // Layout personalizado
            dom: '<"flex justify-between items-center px-3 py-2"lf>rt<"flex justify-between items-center px-3 py-2 border-t border-gray-200"ip>',
            
            // Configuración de columnas
            columnDefs: [
                { targets: [5, 6], orderable: false }, // Estado y Acciones no ordenables
                { targets: [5, 6], className: 'text-center' } // Centrar Estado y Acciones
            ],
            
            // Ordenamiento inicial
            order: [[0, 'asc']], // Ordenar por código por defecto
            
            // Dimensiones
            autoWidth: false,
            scrollX: false
        });
    }
    
    // Inicializar tooltips de Bootstrap si están disponibles
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});

// Función para cerrar modal (mantener compatibilidad)
function closeModal() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('driverDetailsModal'));
    if (modal) {
        modal.hide();
    }
}

// Función para confirmar eliminación de conductor con SweetAlert
function confirmDeleteDriver(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Este conductor será desactivado",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-driver-' + id).submit();
        }
    });
}
</script>

</x-app-layout>