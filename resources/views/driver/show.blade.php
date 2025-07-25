<!-- resources\views\driver\show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalles del Conductor
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 px-4">
        <!-- Botón de regresar -->
        <div class="mb-6">
            <a href="{{ route('drives.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg shadow-md hover:bg-gray-700 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Regresar a la lista
            </a>
        </div>

        <!-- Información del conductor -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header con foto y datos principales -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-8">
                <div class="flex items-center space-x-6">
                    <div class="flex-shrink-0">
                        @if($driver->foto)
                            <img src="{{ asset('storage/' . $driver->foto) }}" 
                                 alt="Foto del conductor" 
                                 class="w-24 h-24 rounded-full border-4 border-white shadow-lg object-cover">
                        @else
                            <div class="w-24 h-24 rounded-full border-4 border-white shadow-lg bg-gray-300 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="text-white">
                        <h1 class="text-3xl font-bold">{{ $driver->nombres }} {{ $driver->apellido_paterno }} {{ $driver->apellido_materno }}</h1>
                        <p class="text-blue-100 text-lg">Código: {{ $driver->codigo }}</p>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $driver->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $driver->status ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenido principal -->
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Información Personal -->
                    <div class="space-y-6">
                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Información Personal</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tipo de Documento:</span>
                                    <span class="font-medium">{{ $driver->tipo_doc ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">N° Documento:</span>
                                    <span class="font-medium">{{ $driver->nro_documento ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Fecha de Nacimiento:</span>
                                    <span class="font-medium">
                                        {{ $driver->fecha_nacimiento ? \Carbon\Carbon::parse($driver->fecha_nacimiento)->format('d/m/Y') : 'N/A' }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Teléfono:</span>
                                    <span class="font-medium">{{ $driver->telefono ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Correo:</span>
                                    <span class="font-medium">{{ $driver->correo ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Información del Vehículo -->
                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Vehículo</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">N° Motor:</span>
                                    <span class="font-medium">{{ $driver->nro_motor ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">N° Chasis:</span>
                                    <span class="font-medium">{{ $driver->nro_chasis ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">N° Placa:</span>
                                    <span class="font-medium">{{ $driver->nro_placa ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dirección y Contacto -->
                    <div class="space-y-6">
                        <!-- Dirección -->
                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Dirección</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Departamento:</span>
                                    <span class="font-medium">{{ $driver->departamento ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Provincia:</span>
                                    <span class="font-medium">{{ $driver->provincia ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Distrito:</span>
                                    <span class="font-medium">{{ $driver->distrito ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Dirección:</span>
                                    <span class="font-medium">{{ $driver->direccion_detalle ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Contacto de Emergencia -->
                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Contacto de Emergencia</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Nombres:</span>
                                    <span class="font-medium">{{ $driver->nombres_contacto ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Teléfono:</span>
                                    <span class="font-medium">{{ $driver->telefono_contacto ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Parentesco:</span>
                                    <span class="font-medium">{{ $driver->parentesco_contacto ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Información del Sistema -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Sistema</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Registrado por:</span>
                                    <span class="font-medium">{{ $driver->userRegistered->name ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Fecha de Registro:</span>
                                    <span class="font-medium">
                                        {{ $driver->fecha_registro ? \Carbon\Carbon::parse($driver->fecha_registro)->format('d/m/Y H:i') : 'N/A' }}
                                    </span>
                                </div>
                                @if($driver->userUpdated)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Última actualización por:</span>
                                        <span class="font-medium">{{ $driver->userUpdated->name }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Fecha de actualización:</span>
                                        <span class="font-medium">
                                            {{ $driver->fecha_actualizacion ? \Carbon\Carbon::parse($driver->fecha_actualizacion)->format('d/m/Y H:i') : 'N/A' }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="mt-8 flex justify-center space-x-4">
                    @can('actualizar-conductores')
                        <a href="{{ route('drives.edit', $driver->id) }}" 
                           class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Editar Conductor
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>