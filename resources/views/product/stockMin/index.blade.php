<!-- resources\views\product\stockMin\index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-exclamation-triangle text-yellow-500 mr-2"></i>
            Control de Stock Mínimo
        </h2>
    </x-slot>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Header con controles -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <div class="flex items-center space-x-4">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-warehouse mr-2 text-blue-600"></i>
                        Productos con Stock Mínimo
                    </h3>
                </div>

                <div class="flex items-center space-x-2">
                    <button onclick="exportarExcel()"
                        class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg flex items-center transition-colors">
                        <i class="fas fa-file-excel mr-2"></i>
                        Exportar Excel
                    </button>
                </div>
            </div>

            <!-- Filtros -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-store mr-1"></i>
                        Tipo de Tienda/Sucursal
                    </label>
                    <select name="tienda_id" id="tienda_id"
                        class="w-full border border-gray-300 rounded-lg py-3 px-4 bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700">
                        <option value="all" {{ $tiendaId == 'all' ? 'selected' : '' }}>
                            📦 Todas las Tiendas/Sucursales
                        </option>
                        @foreach ($tiendas as $tienda)
                            <option value="{{ $tienda->id }}" {{ $tiendaId == $tienda->id ? 'selected' : '' }}>
                                🏪 {{ $tienda->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Acciones</label>
                    <button onclick="filtrarProductos()"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                        <i class="fas fa-search mr-2"></i>
                        Aplicar Filtro
                    </button>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-4 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm">Total Productos</p>
                            <p class="text-2xl font-bold">{{ $totalProductos }}</p>
                        </div>
                        <i class="fas fa-box text-3xl text-blue-200"></i>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-4 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-yellow-100 text-sm">Productos Agotados</p>
                            <p class="text-2xl font-bold">{{ $productosAgotados }}</p>
                        </div>
                        <i class="fas fa-exclamation-triangle text-3xl text-yellow-200"></i>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-4 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm">Total Tiendas</p>
                            <p class="text-2xl font-bold">{{ $totalTiendas }}</p>
                        </div>
                        <i class="fas fa-store text-3xl text-green-200"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de productos -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-list mr-2 text-blue-600"></i>
                    Lista de Stock Mínimo
                    @if($tiendaId !== 'all')
                        - {{ $tiendas->find($tiendaId)->nombre ?? 'Tienda seleccionada' }}
                    @endif
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gradient-to-r from-gray-100 to-gray-50">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                                <i class="fas fa-hashtag mr-1"></i>Código
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                                <i class="fas fa-info-circle mr-1"></i>Descripción
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                                <i class="fas fa-cube mr-1"></i>Modelo
                            </th>
                            <th
                                class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                                <i class="fas fa-exclamation-circle mr-1"></i>Stock Mín
                            </th>
                            <th
                                class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                                <i class="fas fa-boxes mr-1"></i>Cantidad Actual
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                                <i class="fas fa-map-marker-alt mr-1"></i>Ubicación
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                                <i class="fas fa-store mr-1"></i>Tienda
                            </th>
                            <th
                                class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                                <i class="fas fa-thermometer-half mr-1"></i>Estado
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($productosStockMin as $producto)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="bg-blue-100 text-blue-800 text-xs font-mono px-2 py-1 rounded">
                                        {{ $producto->code_sku ?? $producto->code }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm">
                                        <div class="font-medium text-gray-900">{{ $producto->description }}</div>
                                        @if($producto->brand)
                                            <div class="text-gray-500">{{ $producto->brand->name }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $producto->model ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span
                                        class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded-full">
                                        {{ $producto->minimum_stock }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($producto->quantity == 0)
                                        <span class="bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded-full">
                                            <i class="fas fa-times mr-1"></i>{{ $producto->quantity }}
                                        </span>
                                    @else
                                        <span
                                            class="bg-orange-100 text-orange-800 text-xs font-semibold px-2 py-1 rounded-full">
                                            <i class="fas fa-exclamation mr-1"></i>{{ $producto->quantity }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $producto->location ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">
                                        {{ $tiendas->find($producto->tienda_id)->nombre ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($producto->quantity == 0)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i>Agotado
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>Bajo
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="text-gray-500">
                                        <i class="fas fa-check-circle text-6xl mb-4 text-green-400"></i>
                                        <h3 class="text-lg font-medium mb-2">¡Excelente!</h3>
                                        <p>No hay productos con stock mínimo en la(s) tienda(s) seleccionada(s)</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function filtrarProductos() {
            const tiendaId = document.getElementById('tienda_id').value;
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('tienda_id', tiendaId);
            window.location.href = currentUrl.toString();
        }

        function exportarExcel() {
            const tiendaId = document.getElementById('tienda_id').value;
            window.open(`{{ route('stock-minimo.export') }}?tienda_id=${tiendaId}`, '_blank');
        }


        // Auto-filtrar cuando cambie el select
        document.getElementById('tienda_id').addEventListener('change', function () {
            filtrarProductos();
        });
    </script>

    <style>
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }

        tbody tr:hover {
            background-color: #f8fafc;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .transition-colors {
            transition: all 0.2s ease;
        }
    </style>
</x-app-layout>