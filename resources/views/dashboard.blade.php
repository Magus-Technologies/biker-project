<x-app-layout>
    <x-slot name="header">
        <!-- <div class="bg-blue-600 text-white py-3 px-6 rounded-lg shadow-lg">
            <h2 class="font-bold text-2xl text-center tracking-wide">
                REGISTRO DE USUARIOS
            </h2>
            <div class="mt-2 text-center">
                <p class="text-lg">
                    Bienvenido {{ auth()->user()->name }}, ¡Buenas 
                    @if(now()->hour < 12)
                        mañanas!
                    @elseif(now()->hour < 18)
                        tardes!
                    @else
                        noches!
                    @endif
                </p>
            </div>
        </div> -->
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Verificación de rol --}}
            @if (auth()->user()->hasRole('administrador'))
                <div class="mb-6">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        <p class="font-semibold">Acceso de Administrador</p>
                        <p class="text-sm">Tienes acceso completo al sistema de gestión.</p>
                    </div>
                </div>
            @elseif(auth()->user()->hasRole('mecanico'))
                <div class="mb-6">
                    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
                        <p class="font-semibold">Acceso de Mecánico</p>
                        <p class="text-sm">Puedes gestionar servicios y ver información de vehículos.</p>
                    </div>
                </div>
            @elseif(auth()->user()->hasRole('ventas'))
                <div class="mb-6">
                    <div class="bg-purple-100 border border-purple-400 text-purple-700 px-4 py-3 rounded">
                        <p class="font-semibold">Acceso de Ventas</p>
                        <p class="text-sm">Puedes gestionar ventas y cotizaciones.</p>
                    </div>
                </div>
            @else
                <div class="mb-6">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <p class="font-semibold">Acceso Restringido</p>
                        <p class="text-sm">No tienes los permisos necesarios para acceder a todas las secciones.</p>
                    </div>
                </div>
            @endif

            {{-- Métricas principales --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                {{-- Total Servicios --}}
                <div class="bg-blue-400 overflow-hidden shadow-xl rounded-lg">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-3xl font-bold">{{ $totalServicios }}</h3>
                                <p class="text-sm opacity-90">Total Servicios</p>
                            </div>
                            <div class="text-4xl opacity-75">
                                🔧
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('services.index') }}" class="text-xs underline hover:no-underline">
                                Más información →
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Servicios en Proceso --}}
                <div class="bg-red-500 overflow-hidden shadow-xl rounded-lg">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-3xl font-bold">{{ $serviciosEnProceso }}</h3>
                                <p class="text-sm opacity-90">En Proceso</p>
                            </div>
                            <div class="text-4xl opacity-75">
                                ⚠️
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('services.index') }}" class="text-xs underline hover:no-underline">
                                Más información →
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Servicios Completados --}}
                <div class="bg-green-500 overflow-hidden shadow-xl rounded-lg">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-3xl font-bold">+{{ $serviciosCompletados }}</h3>
                                <p class="text-sm opacity-90">Completados</p>
                            </div>
                            <div class="text-4xl opacity-75">
                                ✅
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('services.index') }}" class="text-xs underline hover:no-underline">
                                Más información →
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Total Conductores --}}
                <div class="bg-red-500 overflow-hidden shadow-xl rounded-lg">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-3xl font-bold">{{ $totalConductores }}</h3>
                                <p class="text-sm opacity-90">Total Conductores</p>
                            </div>
                            <div class="text-4xl opacity-75">
                                👨‍💼
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('drives.index') }}" class="text-xs underline hover:no-underline">
                                Más información →
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Secciones de datos --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Productos con Stock Bajo --}}
                <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                    <div class="bg-red-500 text-white px-6 py-4">
                        <h3 class="font-bold text-lg flex items-center">
                            ⚠️ Productos con Stock Bajo (Top 10)
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($productosStockBajo->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($productosStockBajo as $index => $producto)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-3 py-2 text-sm text-gray-900">{{ $index + 1 }}</td>
                                                <td class="px-3 py-2">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ Str::limit($producto->description, 30) }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $producto->brand->name ?? 'Sin marca' }}
                                                    </div>
                                                </td>
                                                <td class="px-3 py-2 text-sm text-gray-900">
                                                    {{ $producto->stock->quantity ?? 0 }} {{ $producto->unit->name ?? '' }}
                                                </td>
                                                <td class="px-3 py-2">
                                                    @if(($producto->stock->quantity ?? 0) <= 5)
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                            CRÍTICO
                                                        </span>
                                                    @else
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                            BAJO
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <p class="text-lg font-medium">No hay productos con stock bajo</p>
                                <p class="text-sm">Todos los productos tienen stock suficiente.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Servicios Pendientes --}}
                <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                    <div class="bg-red-500 text-white px-6 py-4">
                        <h3 class="font-bold text-lg flex items-center">
                            ⏳ Servicios Pendientes
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($serviciosPendientes->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($serviciosPendientes as $servicio)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-3 py-2 text-sm font-medium text-gray-900">
                                                    {{ $servicio->codigo ?? 'S-' . str_pad($servicio->id, 4, '0', STR_PAD_LEFT) }}
                                                </td>
                                                <td class="px-3 py-2">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $servicio->drive->nombres ?? 'N/A' }} {{ $servicio->drive->apellido_paterno ?? '' }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        DNI: {{ $servicio->drive->nro_documento ?? 'N/A' }}
                                                    </div>
                                                </td>
                                                <td class="px-3 py-2">
                                                    @if($servicio->status_service == 'pendiente')
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                            PENDIENTE
                                                        </span>
                                                    @elseif($servicio->status_service == 'en_proceso')
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                            EN PROCESO
                                                        </span>
                                                    @else
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                            {{ strtoupper($servicio->status_service ?? 'N/A') }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-3 py-2 text-sm text-gray-500">
                                                    {{ $servicio->created_at ? $servicio->created_at->format('d/m/Y') : 'N/A' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <p class="text-lg font-medium">No hay servicios pendientes</p>
                                <p class="text-sm">Todos los servicios están al día.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Conductores Recientes --}}
                <div class="bg-white overflow-hidden shadow-xl rounded-lg lg:col-span-2">
                    <div class="bg-green-500 text-white px-6 py-4">
                        <h3 class="font-bold text-lg flex items-center">
                            👨‍💼 Conductores Registrados Recientemente
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($conductoresRecientes->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nombres</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Documento</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Teléfono</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Licencia</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fecha Registro</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($conductoresRecientes as $conductor)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-3 py-2">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $conductor->nombres }} {{ $conductor->apellido_paterno }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $conductor->apellido_materno }}
                                                    </div>
                                                </td>
                                                <td class="px-3 py-2 text-sm text-gray-900">
                                                    {{ $conductor->nro_documento }}
                                                </td>
                                                <td class="px-3 py-2 text-sm text-gray-900">
                                                    {{ $conductor->telefono ?? 'N/A' }}
                                                </td>
                                                <td class="px-3 py-2 text-sm text-gray-900">
                                                    {{ $conductor->nro_licencia ?? 'N/A' }}
                                                    @if($conductor->categoria_licencia)
                                                        <span class="text-xs text-gray-500">({{ $conductor->categoria_licencia }})</span>
                                                    @endif
                                                </td>
                                                <td class="px-3 py-2 text-sm text-gray-500">
                                                    {{ $conductor->created_at ? $conductor->created_at->format('d/m/Y') : 'N/A' }}
                                                </td>
                                                <td class="px-3 py-2">
                                                    @if($conductor->status)
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                            ACTIVO
                                                        </span>
                                                    @else
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                            INACTIVO
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <p class="text-lg font-medium">No hay conductores registrados</p>
                                <p class="text-sm">Aún no se han registrado conductores en el sistema.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>