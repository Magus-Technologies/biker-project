<!-- resources\views\clientes-mayoristas\index.blade.php -->
<x-app-layout>
    <!-- Breadcrumb -->
    <x-breadcrumb title="Lista de Clientes Mayoristas" subtitle="Clientes" />

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
                <a href="{{ route('clientes-mayoristas.create') }}"
                    class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-md flex items-center transition-colors text-sm">
                    <i class="bi bi-plus-lg mr-1"></i>
                    Agregar Cliente
                </a>
            </div>

            <div class="overflow-x-auto">
                <table id="clientesTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                                Código
                            </th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                                Nombres y Apellidos
                            </th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                                Negocio
                            </th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                                Tienda
                            </th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                                Teléfono
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
                        @forelse($clientes as $cliente)
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="px-3 py-2 text-sm text-gray-700">
                                    {{ $cliente->codigo }}
                                </td>
                                <td class="px-3 py-2 text-sm font-medium text-gray-900">
                                    {{ $cliente->nombre_completo }}
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-600">
                                    {{ $cliente->nombre_negocio }}
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-600">
                                    {{ $cliente->tienda ?? 'N/A' }}
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-600">
                                    {{ $cliente->telefono }}
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <span class="px-2 py-1 inline-flex text-xs font-medium rounded {{ $cliente->status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $cliente->status ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button onclick="mostrarDetallesCliente({{ $cliente->id }})" 
                                                class="text-blue-600 hover:text-blue-800 transition-colors" 
                                                title="Ver detalles">
                                            <i class="bi bi-eye text-base"></i>
                                        </button>
                                        <a href="{{ route('clientes-mayoristas.edit', $cliente->id) }}" 
                                           class="text-purple-600 hover:text-purple-800 transition-colors" 
                                           title="Editar">
                                            <i class="bi bi-pencil text-base"></i>
                                        </a>
                                        <button class="text-red-600 hover:text-red-800 transition-colors" 
                                                title="Eliminar">
                                            <i class="bi bi-trash text-base"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-3 py-8 text-center text-gray-500">
                                    <i class="bi bi-inbox text-4xl text-gray-300 mb-2"></i>
                                    <p class="text-sm">No hay clientes mayoristas registrados</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@push('modals')
<!-- Modal mejorado y responsive para detalles del cliente mayorista - Estilo Bootstrap -->
<div class="modal fade" id="clienteDetailsModal" tabindex="-1" aria-labelledby="clienteDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-lg-down modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-gradient-to-r from-green-600 to-green-800 text-white">
                <h5 class="modal-title d-flex align-items-center" id="clienteDetailsModalLabel">
                    <i class="bi bi-shop me-2"></i>
                    <span>Detalles del Cliente Mayorista</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-0">
                <div id="clienteDetailsContent" class="h-100 overflow-auto">
                    <div class="text-center py-5">
                        <div class="spinner-border text-success mb-3" role="status" style="width: 3rem; height: 3rem;">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <h6 class="text-muted">Cargando detalles del cliente mayorista...</h6>
                        <p class="text-muted mb-0">Por favor espere un momento</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Cerrar
                </button>
                <button type="button" id="editClienteBtn" class="btn btn-success" style="display: none;">
                    <i class="bi bi-pencil-square me-1"></i>Editar
                </button>
            </div>
        </div>
    </div>
</div>
@endpush

<style>
/* Estilos específicos para el modal de cliente mayorista */
.modal-header {
    border-bottom: none;
    padding: 1.25rem 1.5rem;
    background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
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

/* Contenido del cliente con diseño mejorado */
.cliente-details-container {
    padding: 1.5rem;
}

.cliente-header {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    color: white;
    padding: 2rem;
    border-radius: 0.75rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.cliente-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 4px solid white;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    object-fit: cover;
}

.cliente-avatar-placeholder {
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
    color: #059669;
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
    
    .cliente-header {
        padding: 2.5rem;
    }
    
    .cliente-details-container {
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
#clienteDetailsContent::-webkit-scrollbar {
    width: 8px;
}

#clienteDetailsContent::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

#clienteDetailsContent::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    border-radius: 4px;
}

#clienteDetailsContent::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #047857 0%, #065f46 100%);
}
</style>

<script>
// Función para mostrar detalles del cliente mayorista - Versión Bootstrap Modal
function mostrarDetallesCliente(clienteId) {
    const modal = new bootstrap.Modal(document.getElementById('clienteDetailsModal'), {
        backdrop: 'static',
        keyboard: true
    });
    const content = document.getElementById('clienteDetailsContent');
    const editBtn = document.getElementById('editClienteBtn');
    
    // Mostrar loading
    content.innerHTML = `
        <div class="loading-container">
            <div class="spinner-border text-success mb-3" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <h6 class="text-muted">Cargando detalles del cliente mayorista...</h6>
            <p class="text-muted mb-0">Por favor espere un momento</p>
        </div>
    `;
    
    // Ocultar botón de editar
    editBtn.style.display = 'none';
    
    modal.show();
    
    // Cargar detalles
    fetch(`{{ route('clientes-mayoristas.detalles', ['id' => '__clienteId__']) }}`.replace('__clienteId__', clienteId))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                content.innerHTML = data.html;
                
                // Mostrar botón editar si tiene permisos
                {{-- @can('actualizar-clientes-mayoristas') --}}
                    editBtn.style.display = 'inline-block';
                    editBtn.onclick = () => {
                        window.location.href = `/clientes-mayoristas/${clienteId}/edit`;
                    };
                {{-- @endcan --}}
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
                    <button class="btn btn-outline-success" onclick="mostrarDetallesCliente(${clienteId})">
                        <i class="bi bi-arrow-clockwise me-1"></i>Reintentar
                    </button>
                </div>
            `;
        });
}

// Inicializar DataTables - Optimizado para carga rápida
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar DataTable en la tabla de clientes mayoristas
    if ($.fn.DataTable) {
        $('#clientesTable').DataTable({
            // Optimizaciones de rendimiento
            deferRender: true,
            processing: false,
            stateSave: false,
            
            // Configuración básica
            responsive: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            
            // Idioma español
            language: {
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_ clientes",
                info: "Mostrando _START_ a _END_ de _TOTAL_ clientes",
                infoEmpty: "0 clientes",
                infoFiltered: "(filtrado de _MAX_ totales)",
                zeroRecords: "No se encontraron clientes",
                emptyTable: "No hay clientes mayoristas registrados",
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
function cerrarModal() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('clienteDetailsModal'));
    if (modal) {
        modal.hide();
    }
}
</script>

</x-app-layout>