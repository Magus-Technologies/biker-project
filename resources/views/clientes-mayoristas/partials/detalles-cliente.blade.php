<!-- resources\views\clientes-mayoristas\partials\detalles-cliente.blade.php-->
<!-- Contenido del cliente mayorista con diseño Bootstrap profesional -->
<div class="cliente-details-container">
    <!-- Header con foto y datos principales -->
    <div class="cliente-header">
        <div class="d-flex flex-column flex-md-row align-items-center text-center text-md-start">
            <div class="mb-3 mb-md-0 me-md-4">
                @if($cliente->foto)
                    <img src="{{ asset('storage/' . $cliente->foto) }}" 
                         alt="Foto del cliente" 
                         class="cliente-avatar">
                @else
                    <div class="cliente-avatar-placeholder">
                        <i class="bi bi-shop" style="font-size: 2rem; color: white;"></i>
                    </div>
                @endif
            </div>
            <div class="flex-grow-1">
                <h2 class="mb-2 fw-bold" style="font-size: 1.5rem;">
                    {{ $cliente->nombre_completo }}
                </h2>
                <p class="mb-2 opacity-75" style="font-size: 1.1rem;">
                    <i class="bi bi-hash me-1"></i>Código: {{ $cliente->codigo }}
                </p>
                <p class="mb-2 opacity-75" style="font-size: 1rem;">
                    <i class="bi bi-shop me-1"></i>{{ $cliente->nombre_negocio }}
                </p>
                <div class="mt-2">
                    <span class="status-badge {{ $cliente->status ? 'status-active' : 'status-inactive' }}">
                        <i class="bi bi-{{ $cliente->status ? 'check-circle' : 'x-circle' }} me-1"></i>
                        {{ $cliente->status ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid de información -->
    <div class="info-grid">
        <!-- Información Personal -->
        <div class="info-section">
            <h4>
                <i class="bi bi-person-circle"></i>
                Información Personal
            </h4>
            <div class="info-row">
                <span class="info-label">Tipo de Documento:</span>
                <span class="info-value">{{ $cliente->tipo_doc ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">N° Documento:</span>
                <span class="info-value">{{ $cliente->nro_documento ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Teléfono:</span>
                <span class="info-value">{{ $cliente->telefono ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Correo:</span>
                <span class="info-value">{{ $cliente->correo ?? 'N/A' }}</span>
            </div>
        </div>

        <!-- Información del Negocio -->
        <div class="info-section">
            <h4>
                <i class="bi bi-shop"></i>
                Información del Negocio
            </h4>
            <div class="info-row">
                <span class="info-label">Nombre del Negocio:</span>
                <span class="info-value">{{ $cliente->nombre_negocio ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tienda:</span>
                <span class="info-value">{{ $cliente->tienda ?? 'N/A' }}</span>
            </div>
        </div>

        <!-- Dirección -->
        <div class="info-section">
            <h4>
                <i class="bi bi-geo-alt"></i>
                Dirección
            </h4>
            <div class="info-row">
                <span class="info-label">Departamento:</span>
                <span class="info-value">{{ $cliente->departamento ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Provincia:</span>
                <span class="info-value">{{ $cliente->provincia ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Distrito:</span>
                <span class="info-value">{{ $cliente->distrito ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Dirección:</span>
                <span class="info-value">{{ $cliente->direccion_detalle ?? 'N/A' }}</span>
            </div>
        </div>

        <!-- Contacto de Emergencia -->
        <div class="info-section">
            <h4>
                <i class="bi bi-telephone-plus"></i>
                Contacto de Emergencia
            </h4>
            <div class="info-row">
                <span class="info-label">Nombres:</span>
                <span class="info-value">{{ $cliente->nombres_contacto ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Teléfono:</span>
                <span class="info-value">{{ $cliente->telefono_contacto ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Parentesco:</span>
                <span class="info-value">{{ $cliente->parentesco_contacto ?? 'N/A' }}</span>
            </div>
        </div>
    </div>

    <!-- Información del Sistema -->
    <div class="info-section">
        <h4>
            <i class="bi bi-gear"></i>
            Información del Sistema
        </h4>
        <div class="row">
            <div class="col-md-6">
                <div class="info-row">
                    <span class="info-label">Registrado por:</span>
                    <span class="info-value">{{ $cliente->usuarioRegistro->name ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Fecha de Registro:</span>
                    <span class="info-value">
                        {{ $cliente->created_at ? $cliente->created_at->format('d/m/Y H:i') : 'N/A' }}
                    </span>
                </div>
            </div>
            @if($cliente->usuarioActualizacion)
                <div class="col-md-6">
                    <div class="info-row">
                        <span class="info-label">Actualizado por:</span>
                        <span class="info-value">{{ $cliente->usuarioActualizacion->name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Fecha de Actualización:</span>
                        <span class="info-value">
                            {{ $cliente->updated_at ? $cliente->updated_at->format('d/m/Y H:i') : 'N/A' }}
                        </span>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>