<!-- resources\views\product\stockMin\index.blade.php -->
<x-app-layout>
    <!-- Breadcrumb -->
    <x-breadcrumb title="Control de Stock Mínimo" subtitle="Productos" />

    <!-- Contenedor principal con poco padding -->
    <div class="px-3 py-4">

        <!-- Filtros y Estadísticas -->
        <div class="bg-white rounded-lg px-4 py-3 mb-3">
            <!-- Filtro de Tienda y Botón Exportar -->
            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <label class="text-sm font-semibold text-gray-700 whitespace-nowrap">
                        Filtrar por Tienda/Sucursal:
                    </label>
                    <div class="relative" style="min-width: 280px; max-width: 400px;">
                        <select name="tienda_id" id="tienda_id"
                            class="w-full border border-gray-300 rounded-lg py-2.5 pl-10 pr-10 bg-white hover:border-blue-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm font-medium text-gray-700 cursor-pointer shadow-sm">
                            <option value="all" {{ $tiendaId == 'all' ? 'selected' : '' }}>
                                Todas las Tiendas/Sucursales
                            </option>
                            @foreach ($tiendas as $tienda)
                                <option value="{{ $tienda->id }}" {{ $tiendaId == $tienda->id ? 'selected' : '' }}>
                                    {{ $tienda->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="bi bi-funnel text-blue-600"></i>
                        </div>
                    </div>
                </div>
                <button onclick="exportarExcel()"
                    class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-md flex items-center transition-colors text-sm whitespace-nowrap">
                    <i class="bi bi-file-earmark-excel mr-1"></i>
                    Exportar Excel
                </button>
            </div>

          
        </div>

        <!-- Tabla sin sombras excesivas -->
        <div class="bg-white rounded-lg overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table id="stockMinTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                                Código
                            </th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                                Descripción
                            </th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                                Modelo
                            </th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">
                                Stock Mín
                            </th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">
                                Cantidad Actual
                            </th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                                Ubicación
                            </th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                                Tienda
                            </th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">
                                Estado
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($productosStockMin as $producto)
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="px-3 py-2 text-sm text-gray-700">
                                    <span class="bg-blue-100 text-blue-800 text-xs font-mono px-2 py-1 rounded">
                                        {{ $producto->code_sku ?? $producto->code }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-sm">
                                    <div class="font-medium text-gray-900">{{ $producto->description }}</div>
                                    @if($producto->brand)
                                        <div class="text-xs text-gray-500">{{ $producto->brand->name }}</div>
                                    @endif
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-600">
                                    {{ $producto->model ?? '-' }}
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <span class="px-2 py-1 inline-flex text-xs font-medium rounded bg-yellow-100 text-yellow-700">
                                        {{ $producto->minimum_stock }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    @if($producto->quantity == 0)
                                        <span class="px-2 py-1 inline-flex text-xs font-medium rounded bg-red-100 text-red-700">
                                            <i class="bi bi-x-circle mr-1"></i>{{ $producto->quantity }}
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs font-medium rounded bg-orange-100 text-orange-700">
                                            <i class="bi bi-exclamation-circle mr-1"></i>{{ $producto->quantity }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-600">
                                    {{ $producto->location ?? '-' }}
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-600">
                                    <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">
                                        {{ $tiendas->find($producto->tienda_id)->nombre ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    @if($producto->quantity == 0)
                                        <span class="px-2 py-1 inline-flex text-xs font-medium rounded bg-red-100 text-red-700">
                                            <i class="bi bi-x-circle mr-1"></i>Agotado
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs font-medium rounded bg-yellow-100 text-yellow-700">
                                            <i class="bi bi-exclamation-triangle mr-1"></i>Bajo
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-3 py-8 text-center text-gray-500">
                                    <i class="bi bi-check-circle text-4xl text-green-300 mb-2"></i>
                                    <p class="text-sm font-medium">¡Excelente!</p>
                                    <p class="text-xs">No hay productos con stock mínimo</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<script>
// Funciones de filtrado y exportación
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

// Inicializar DataTables - Optimizado para carga rápida
document.addEventListener('DOMContentLoaded', function() {
    if ($.fn.DataTable) {
        $('#stockMinTable').DataTable({
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
                lengthMenu: "Mostrar _MENU_ productos",
                info: "Mostrando _START_ a _END_ de _TOTAL_ productos",
                infoEmpty: "0 productos",
                infoFiltered: "(filtrado de _MAX_ totales)",
                zeroRecords: "No se encontraron productos",
                emptyTable: "No hay productos con stock mínimo",
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
                { targets: [3, 4, 7], orderable: true, className: 'text-center' }, // Stock Mín, Cantidad, Estado
                { targets: [0, 1, 2, 5, 6], orderable: true } // Resto de columnas ordenables
            ],
            
            // Ordenamiento inicial por cantidad actual (menor a mayor)
            order: [[4, 'asc']],
            
            // Dimensiones
            autoWidth: false,
            scrollX: false
        });
    }
});
</script>

</x-app-layout>