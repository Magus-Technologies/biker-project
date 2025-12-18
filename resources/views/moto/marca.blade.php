<x-app-layout>
    <x-breadcrumb 
        title="Motos {{ $marca }}" 
        parent="Motos" 
        parentUrl="{{ route('motos.index') }}" 
        subtitle="{{ $marca }}" 
    />

    <div class="px-3 py-4">
        <!-- Header con marca y filtros -->
        <div class="bg-white rounded-lg px-4 py-3 mb-3">
            <div class="flex flex-wrap justify-between items-center gap-3 mb-3">
                <h2 class="text-lg font-semibold text-gray-700">
                    <i class="bi bi-motorcycle mr-2 text-blue-600"></i>
                    Motos {{ $marca }}
                </h2>
                <div class="flex gap-2">
                    <a href="{{ route('motos.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition-colors text-sm">
                        <i class="bi bi-arrow-left mr-1"></i>
                        Volver
                    </a>
                    <a href="{{ route('motos.create', ['marca' => $marca]) }}" class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-md transition-colors text-sm">
                        <i class="bi bi-plus-lg mr-1"></i>
                        Agregar
                    </a>
                </div>
            </div>
            
            <!-- Filtros de estado -->
            <div class="flex items-center gap-2 border-t pt-3">
                <span class="text-sm text-gray-600 font-medium">Filtrar por:</span>
                <button id="btnTodas" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium transition-colors">
                    TODAS
                </button>
                <button id="btnVendidas" class="px-4 py-2 bg-black text-white rounded-lg text-sm font-medium transition-colors">
                    VENDIDAS
                </button>
                <button id="btnLibres" class="px-4 py-2 bg-black text-white rounded-lg text-sm font-medium transition-colors">
                    LIBRES
                </button>
            </div>
        </div>

        <!-- Tabla de motos -->
        <div class="bg-white rounded-lg overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table id="motosTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Código</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Modelo</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Nº Motor</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Nº Chasis</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Color</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Año</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Lugar</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">Estado Moto</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">Estado Venta</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($motos as $moto)
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="px-3 py-2 text-sm text-gray-700">{{ $moto->codigo }}</td>
                                <td class="px-3 py-2 text-sm font-medium text-gray-900">{{ $moto->modelo ?? 'N/A' }}</td>
                                <td class="px-3 py-2 text-sm text-gray-600">{{ $moto->nro_motor ?? 'N/A' }}</td>
                                <td class="px-3 py-2 text-sm text-gray-600">{{ $moto->nro_chasis ?? 'N/A' }}</td>
                                <td class="px-3 py-2 text-sm text-gray-600">{{ $moto->color ?? 'N/A' }}</td>
                                <td class="px-3 py-2 text-sm text-gray-600">{{ $moto->anio ?? 'N/A' }}</td>
                                <td class="px-3 py-2 text-sm text-gray-600">{{ $moto->lugar_provisional ?? 'N/A' }}</td>
                                <td class="px-3 py-2 text-center">
                                    <span class="px-2 py-1 inline-flex text-xs font-medium rounded-full {{ $moto->status == 1 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $moto->status == 1 ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    @if($moto->esta_vendida ?? false)
                                        <span class="px-2 py-1 inline-flex text-xs font-medium rounded-full bg-red-100 text-red-700">
                                            VENDIDA
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs font-medium rounded-full bg-green-100 text-green-700">
                                            LIBRE
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('motos.edit', $moto->id) }}" class="text-purple-600 hover:text-purple-800 transition-colors" title="Editar">
                                            <i class="bi bi-pencil text-base"></i>
                                        </a>
                                        <form action="{{ route('motos.destroy', $moto->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 transition-colors" title="Eliminar">
                                                <i class="bi bi-trash text-base"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-3 py-8 text-center text-gray-500">
                                    <i class="bi bi-inbox text-4xl text-gray-300 mb-2"></i>
                                    <p class="text-sm">No hay motos registradas para esta marca</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        let dataTable = null;
        let currentEstado = 'todas';

        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar DataTable
            if ($.fn.DataTable && $('#motosTable tbody tr').length > 1) {
                dataTable = $('#motosTable').DataTable({
                    deferRender: true,
                    processing: false,
                    stateSave: false,
                    responsive: true,
                    pageLength: 10,
                    lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                    language: {
                        search: "Buscar:",
                        lengthMenu: "Mostrar _MENU_ motos",
                        info: "Mostrando _START_ a _END_ de _TOTAL_ motos",
                        infoEmpty: "0 motos",
                        infoFiltered: "(filtrado de _MAX_ totales)",
                        zeroRecords: "No se encontraron motos",
                        emptyTable: "No hay motos registradas",
                        paginate: {
                            first: "Primero",
                            last: "Último",
                            next: "Siguiente",
                            previous: "Anterior"
                        }
                    },
                    dom: '<"flex justify-between items-center px-3 py-2"lf>rt<"flex justify-between items-center px-3 py-2 border-t border-gray-200"ip>',
                    columnDefs: [
                        { targets: [7, 8, 9], orderable: false },
                        { targets: [7, 8, 9], className: 'text-center' }
                    ],
                    order: [[0, 'asc']]
                });
            }
            
            // Event listeners para filtros
            document.getElementById('btnTodas').addEventListener('click', () => filtrarPorEstado('todas'));
            document.getElementById('btnVendidas').addEventListener('click', () => filtrarPorEstado('vendidas'));
            document.getElementById('btnLibres').addEventListener('click', () => filtrarPorEstado('libres'));
        });

        function filtrarPorEstado(estado) {
            currentEstado = estado;
            
            const btnTodas = document.getElementById('btnTodas');
            const btnVendidas = document.getElementById('btnVendidas');
            const btnLibres = document.getElementById('btnLibres');
            
            // Reset todos los botones
            [btnTodas, btnVendidas, btnLibres].forEach(btn => {
                btn.classList.remove('bg-blue-600');
                btn.classList.add('bg-black');
            });
            
            // Activar el botón seleccionado
            if (estado === 'todas') {
                btnTodas.classList.add('bg-blue-600');
                btnTodas.classList.remove('bg-black');
            } else if (estado === 'vendidas') {
                btnVendidas.classList.add('bg-blue-600');
                btnVendidas.classList.remove('bg-black');
            } else if (estado === 'libres') {
                btnLibres.classList.add('bg-blue-600');
                btnLibres.classList.remove('bg-black');
            }
            
            // Filtrar la tabla según el estado de venta
            if (dataTable) {
                if (estado === 'todas') {
                    dataTable.column(8).search('').draw(); // Limpiar filtro de columna Estado Venta
                } else if (estado === 'vendidas') {
                    dataTable.column(8).search('VENDIDA').draw(); // Columna Estado Venta
                } else if (estado === 'libres') {
                    dataTable.column(8).search('LIBRE').draw(); // Columna Estado Venta
                }
            }
        }

        function confirmDelete(event) {
            event.preventDefault();
            
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas eliminar esta moto?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit();
                }
            });
            
            return false;
        }
    </script>
</x-app-layout>
