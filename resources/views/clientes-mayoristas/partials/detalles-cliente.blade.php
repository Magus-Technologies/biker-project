<!-- resources\views\clientes-mayoristas\partials\detalles-cliente.blade.php-->
<div class="space-y-4 md:space-y-6">
    <!-- Header con foto y datos principales -->
    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg px-4 md:px-6 py-4 md:py-6 text-white">
        <div class="flex flex-col md:flex-row items-center md:space-x-6 space-y-4 md:space-y-0">
            <div class="flex-shrink-0">
                @if($cliente->foto)
                    <img src="{{ asset('storage/' . $cliente->foto) }}" 
                         alt="Foto del cliente" 
                         class="w-16 h-16 md:w-20 md:h-20 rounded-full border-4 border-white shadow-lg object-cover">
                @else
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-full border-4 border-white shadow-lg bg-gray-300 flex items-center justify-center">
                        <svg class="w-8 h-8 md:w-10 md:h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                @endif
            </div>
            <div class="text-center md:text-left">
                <h2 class="text-xl md:text-2xl font-bold">{{ $cliente->nombre_completo }}</h2>
                <p class="text-green-100 text-base md:text-lg">Código: {{ $cliente->codigo }}</p>
                <p class="text-green-100 text-sm md:text-base">{{ $cliente->nombre_negocio }}</p>
                <div class="mt-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $cliente->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $cliente->status ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
        <!-- Información Personal -->
        <div class="bg-gray-50 rounded-lg p-3 md:p-4">
            <h3 class="text-base md:text-lg font-semibold text-gray-900 mb-3 md:mb-4 flex items-center">
                <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Información Personal
            </h3>
            <div class="space-y-2 md:space-y-3">
                <div class="flex flex-col md:flex-row md:justify-between">
                    <span class="text-gray-600 text-sm md:text-base">Tipo de Documento:</span>
                    <span class="font-medium text-sm md:text-base">{{ $cliente->tipo_doc ?? 'N/A' }}</span>
                </div>
                <div class="flex flex-col md:flex-row md:justify-between">
                    <span class="text-gray-600 text-sm md:text-base">N° Documento:</span>
                    <span class="font-medium text-sm md:text-base">{{ $cliente->nro_documento ?? 'N/A' }}</span>
                </div>
                <div class="flex flex-col md:flex-row md:justify-between">
                    <span class="text-gray-600 text-sm md:text-base">Teléfono:</span>
                    <span class="font-medium text-sm md:text-base">{{ $cliente->telefono ?? 'N/A' }}</span>
                </div>
                <div class="flex flex-col md:flex-row md:justify-between">
                    <span class="text-gray-600 text-sm md:text-base">Correo:</span>
                    <span class="font-medium text-sm md:text-base break-all">{{ $cliente->correo ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <!-- Información del Negocio -->
        <div class="bg-gray-50 rounded-lg p-3 md:p-4">
            <h3 class="text-base md:text-lg font-semibold text-gray-900 mb-3 md:mb-4 flex items-center">
                <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                Información del Negocio
            </h3>
            <div class="space-y-2 md:space-y-3">
                <div class="flex flex-col md:flex-row md:justify-between">
                    <span class="text-gray-600 text-sm md:text-base">Nombre del Negocio:</span>
                    <span class="font-medium text-sm md:text-base">{{ $cliente->nombre_negocio ?? 'N/A' }}</span>
                </div>
                <div class="flex flex-col md:flex-row md:justify-between">
                    <span class="text-gray-600 text-sm md:text-base">Tienda:</span>
                    <span class="font-medium text-sm md:text-base">{{ $cliente->tienda ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <!-- Dirección -->
        <div class="bg-gray-50 rounded-lg p-3 md:p-4">
            <h3 class="text-base md:text-lg font-semibold text-gray-900 mb-3 md:mb-4 flex items-center">
                <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Dirección
            </h3>
            <div class="space-y-2 md:space-y-3">
                <div class="flex flex-col md:flex-row md:justify-between">
                    <span class="text-gray-600 text-sm md:text-base">Departamento:</span>
                    <span class="font-medium text-sm md:text-base">{{ $cliente->departamento ?? 'N/A' }}</span>
                </div>
                <div class="flex flex-col md:flex-row md:justify-between">
                    <span class="text-gray-600 text-sm md:text-base">Provincia:</span>
                    <span class="font-medium text-sm md:text-base">{{ $cliente->provincia ?? 'N/A' }}</span>
                </div>
                <div class="flex flex-col md:flex-row md:justify-between">
                    <span class="text-gray-600 text-sm md:text-base">Distrito:</span>
                    <span class="font-medium text-sm md:text-base">{{ $cliente->distrito ?? 'N/A' }}</span>
                </div>
                <div class="flex flex-col md:flex-row md:justify-between">
                    <span class="text-gray-600 text-sm md:text-base">Dirección:</span>
                    <span class="font-medium text-sm md:text-base">{{ $cliente->direccion_detalle ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <!-- Contacto de Emergencia -->
        <div class="bg-gray-50 rounded-lg p-3 md:p-4">
            <h3 class="text-base md:text-lg font-semibold text-gray-900 mb-3 md:mb-4 flex items-center">
                <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
                Contacto de Emergencia
            </h3>
            <div class="space-y-2 md:space-y-3">
                <div class="flex flex-col md:flex-row md:justify-between">
                    <span class="text-gray-600 text-sm md:text-base">Nombres:</span>
                    <span class="font-medium text-sm md:text-base">{{ $cliente->nombres_contacto ?? 'N/A' }}</span>
                </div>
                <div class="flex flex-col md:flex-row md:justify-between">
                    <span class="text-gray-600 text-sm md:text-base">Teléfono:</span>
                    <span class="font-medium text-sm md:text-base">{{ $cliente->telefono_contacto ?? 'N/A' }}</span>
                </div>
                <div class="flex flex-col md:flex-row md:justify-between">
                    <span class="text-gray-600 text-sm md:text-base">Parentesco:</span>
                    <span class="font-medium text-sm md:text-base">{{ $cliente->parentesco_contacto ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Información del Sistema -->
    <div class="bg-gray-50 rounded-lg p-3 md:p-4">
        <h3 class="text-base md:text-lg font-semibold text-gray-900 mb-3 md:mb-4 flex items-center">
            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Información del Sistema
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-2 md:space-y-3">
                <div class="flex flex-col md:flex-row md:justify-between">
                    <span class="text-gray-600 text-sm md:text-base">Registrado por:</span>
                    <span class="font-medium text-sm md:text-base">{{ $cliente->usuarioRegistro->name ?? 'N/A' }}</span>
                </div>
                <div class="flex flex-col md:flex-row md:justify-between">
                    <span class="text-gray-600 text-sm md:text-base">Fecha de Registro:</span>
                    <span class="font-medium text-sm md:text-base">
                        {{ $cliente->created_at ? $cliente->created_at->format('d/m/Y H:i') : 'N/A' }}
                    </span>
                </div>
            </div>
            @if($cliente->usuarioActualizacion)
                <div class="space-y-2 md:space-y-3">
                    <div class="flex flex-col md:flex-row md:justify-between">
                        <span class="text-gray-600 text-sm md:text-base">Última actualización por:</span>
                        <span class="font-medium text-sm md:text-base">{{ $cliente->usuarioActualizacion->name }}</span>
                    </div>
                    <div class="flex flex-col md:flex-row md:justify-between">
                        <span class="text-gray-600 text-sm md:text-base">Fecha de actualización:</span>
                        <span class="font-medium text-sm md:text-base">
                            {{ $cliente->updated_at ? $cliente->updated_at->format('d/m/Y H:i') : 'N/A' }}
                        </span>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>