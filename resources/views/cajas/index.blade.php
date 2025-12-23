<x-app-layout>
    <x-breadcrumb title="Gestión de Cajas" subtitle="cajas" />

    <div class="px-3 py-4">
        <!-- Header con botones -->
        <div class="bg-white rounded-lg px-4 py-3 mb-3 flex flex-wrap justify-between items-center gap-3">
            @if($cajaAbierta)
                <a href="{{ route('cajas.show', $cajaAbierta->id) }}" 
                   class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition-colors text-sm">
                    <i class="bi bi-eye mr-2"></i>Ver Mi Caja Abierta
                </a>
            @else
                @can('abrir-caja')
                    <a href="{{ route('cajas.create') }}" 
                       class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-md transition-colors text-sm">
                        <i class="bi bi-plus-lg mr-2"></i>Abrir Caja
                    </a>
                @endcan
            @endif
        </div>

        <!-- Mensajes de éxito o error -->
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 text-green-700 px-4 py-2 rounded mb-3 text-sm">
                <i class="bi bi-check-circle mr-1"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-400 text-red-700 px-4 py-2 rounded mb-3 text-sm">
                <i class="bi bi-exclamation-circle mr-1"></i>{{ session('error') }}
            </div>
        @endif

        <!-- Estado de caja actual -->
        @if($cajaAbierta)
            <div class="bg-green-50 border-l-4 border-green-400 text-green-700 px-4 py-2 rounded mb-3 text-sm">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div>
                        <p class="font-semibold">
                            <i class="bi bi-unlock-fill mr-1"></i>Tienes una caja abierta
                        </p>
                        <p class="text-xs mt-1">
                            Código: <strong>{{ $cajaAbierta->codigo }}</strong> | 
                            Apertura: {{ $cajaAbierta->fecha_apertura->format('d/m/Y H:i') }} |
                            Monto Inicial: S/ {{ number_format($cajaAbierta->monto_inicial, 2) }}
                        </p>
                    </div>
                    <a href="{{ route('cajas.show', $cajaAbierta->id) }}" 
                       class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-medium transition-colors">
                        Ver Detalle
                    </a>
                </div>
            </div>
        @endif

        <!-- Tabla de cajas -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Código
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Usuario
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tienda
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Apertura
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Cierre
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Monto Inicial
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total Ventas
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($cajas as $caja)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $caja->codigo }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $caja->usuario->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $caja->tienda->nombre ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $caja->fecha_apertura->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $caja->fecha_cierre ? $caja->fecha_cierre->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                S/ {{ number_format($caja->monto_inicial, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                                S/ {{ number_format($caja->total_ventas, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($caja->estado === 'abierta')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="bi bi-unlock-fill mr-1"></i>Abierta
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        <i class="bi bi-lock-fill mr-1"></i>Cerrada
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('cajas.show', $caja->id) }}" 
                                       class="text-blue-600 hover:text-blue-800" title="Ver detalle">
                                        <i class="bi bi-eye text-lg"></i>
                                    </a>
                                    
                                    @if($caja->estado === 'abierta' && $caja->user_id === auth()->id())
                                        <a href="{{ route('cajas.close', $caja->id) }}" 
                                           class="text-red-600 hover:text-red-800" title="Cerrar caja">
                                            <i class="bi bi-lock text-lg"></i>
                                        </a>
                                    @endif
                                    
                                    @if($caja->estado === 'cerrada')
                                        <a href="{{ route('cajas.reporte', $caja->id) }}" 
                                           class="text-green-600 hover:text-green-800" title="Ver reporte">
                                            <i class="bi bi-file-earmark-pdf text-lg"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center text-gray-500">
                                <i class="bi bi-inbox text-4xl mb-2"></i>
                                <p>No hay cajas registradas</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación -->
        <div class="mt-6">
            {{ $cajas->links() }}
        </div>
    </div>
</x-app-layout>
