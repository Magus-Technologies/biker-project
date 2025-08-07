<!-- resources\views\driver\partials\driver-details.blade.php -->
<!-- Contenido del conductor con diseño Bootstrap profesional -->
<div class="driver-details-container">
    <!-- Header con foto y datos principales -->
    <div class="driver-header">
        <div class="d-flex flex-column flex-md-row align-items-center text-center text-md-start">
            <div class="mb-3 mb-md-0 me-md-4">
                @if($driver->foto)
                    <img src="{{ asset('storage/' . $driver->foto) }}" 
                         alt="Foto del conductor" 
                         class="driver-avatar">
                @else
                    <div class="driver-avatar-placeholder">
                        <i class="bi bi-person" style="font-size: 2rem; color: white;"></i>
                    </div>
                @endif
            </div>
            <div class="flex-grow-1">
                <h2 class="mb-2 fw-bold" style="font-size: 1.5rem;">
                    {{ $driver->nombres }} {{ $driver->apellido_paterno }} {{ $driver->apellido_materno }}
                </h2>
                <p class="mb-2 opacity-75" style="font-size: 1.1rem;">
                    <i class="bi bi-hash me-1"></i>Código: {{ $driver->codigo }}
                </p>
                <div class="mt-2">
                    <span class="status-badge {{ $driver->status ? 'status-active' : 'status-inactive' }}">
                        <i class="bi bi-{{ $driver->status ? 'check-circle' : 'x-circle' }} me-1"></i>
                        {{ $driver->status ? 'Activo' : 'Inactivo' }}
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
                <span class="info-value">{{ $driver->tipo_doc ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">N° Documento:</span>
                <span class="info-value">{{ $driver->nro_documento ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Fecha de Nacimiento:</span>
                <span class="info-value">
                    {{ $driver->fecha_nacimiento ? \Carbon\Carbon::parse($driver->fecha_nacimiento)->format('d/m/Y') : 'N/A' }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Teléfono:</span>
                <span class="info-value">{{ $driver->telefono ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Correo:</span>
                <span class="info-value">{{ $driver->correo ?? 'N/A' }}</span>
            </div>
        </div>

        <!-- Información del Vehículo -->
        <div class="info-section">
            <h4>
                <i class="bi bi-car-front"></i>
                Información del Vehículo
            </h4>
            <div class="info-row">
                <span class="info-label">N° Motor:</span>
                <span class="info-value">{{ $driver->nro_motor ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">N° Chasis:</span>
                <span class="info-value">{{ $driver->nro_chasis ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">N° Placa:</span>
                <span class="info-value">{{ $driver->nro_placa ?? 'N/A' }}</span>
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
                <span class="info-value">{{ $driver->departamento ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Provincia:</span>
                <span class="info-value">{{ $driver->provincia ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Distrito:</span>
                <span class="info-value">{{ $driver->distrito ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Dirección:</span>
                <span class="info-value">{{ $driver->direccion_detalle ?? 'N/A' }}</span>
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
                <span class="info-value">{{ $driver->nombres_contacto ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Teléfono:</span>
                <span class="info-value">{{ $driver->telefono_contacto ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Parentesco:</span>
                <span class="info-value">{{ $driver->parentesco_contacto ?? 'N/A' }}</span>
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
                    <span class="info-value">{{ $driver->userRegistered->name ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Fecha de Registro:</span>
                    <span class="info-value">
                        {{ $driver->fecha_registro ? \Carbon\Carbon::parse($driver->fecha_registro)->format('d/m/Y H:i') : 'N/A' }}
                    </span>
                </div>
            </div>
            @if($driver->userUpdated)
                <div class="col-md-6">
                    <div class="info-row">
                        <span class="info-label">Actualizado por:</span>
                        <span class="info-value">{{ $driver->userUpdated->name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Fecha de Actualización:</span>
                        <span class="info-value">
                            {{ $driver->fecha_actualizacion ? \Carbon\Carbon::parse($driver->fecha_actualizacion)->format('d/m/Y H:i') : 'N/A' }}
                        </span>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
