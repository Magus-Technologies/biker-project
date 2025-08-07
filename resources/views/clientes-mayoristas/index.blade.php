<!-- resources\views\clientes-mayoristas\index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lista de Clientes Mayoristas
        </h2>
    </x-slot>

    <!-- CDN Bootstrap y Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Lista de Clientes Mayoristas</h2>
            <a href="{{ route('clientes-mayoristas.create') }}"
                class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg flex items-center transition-all duration-300">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Agregar Cliente
            </a>
        </div>

        <!-- Mensajes de éxito o error -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Tabla de registros -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-5">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Código
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nombres y Apellidos
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nombre del Negocio
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tienda
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Teléfono
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($clientes as $cliente)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $cliente->codigo }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $cliente->nombre_completo }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $cliente->nombre_negocio }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $cliente->tienda ?? 'N/A' }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $cliente->telefono }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <button type="button" id="btn-{{ $cliente->id }}"
                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full shadow-md {{ $cliente->status == 1 ? 'bg-green-200 text-green-700' : 'text-red-700 bg-red-200' }}"
                                    onclick="confirmDelete({{ $cliente->id }}, '{{ $cliente->status == 1 ? '¿Está seguro de desactivar este registro?' : '¿Está seguro de activar este registro?' }}')">
                                    @if ($cliente->status == 1)
                                        Activado
                                    @else
                                        Deshabilitado
                                    @endif
                                </button>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <!-- Botón Ver Detalles -->
                                    <button onclick="mostrarDetallesCliente({{ $cliente->id }})"
                                        class="inline-flex items-center px-2 py-1 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-md transition-colors duration-200"
                                        title="Ver detalles">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                    
                                    {{-- @can('actualizar-clientes-mayoristas') --}}
                                        <!-- Botón Editar -->
                                        <a href="{{ route('clientes-mayoristas.edit', $cliente->id) }}"
                                            class="inline-flex items-center px-2 py-1 bg-indigo-100 hover:bg-indigo-200 text-indigo-600 rounded-md transition-colors duration-200"
                                            title="Editar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                    {{-- @endcan --}}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-3 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <p class="text-lg font-medium">No hay clientes mayoristas registrados</p>
                                    <p class="text-sm text-gray-400">Comienza agregando un nuevo cliente mayorista</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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

// Inicializar tooltips de Bootstrap si están disponibles
document.addEventListener('DOMContentLoaded', function() {
    // Verificar si Bootstrap Tooltip está disponible
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