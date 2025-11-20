<!-- resources\views\service\index.blade.php -->
<x-app-layout>
    <x-breadcrumb title="Registro de Servicios" subtitle="servicios" />

    <!-- Bootstrap 5 para modales (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Contenedor principal -->
    <div class="px-3 py-4">
        <!-- Mensajes de éxito o error -->
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 text-green-700 px-4 py-2 rounded mb-3 text-sm">
                <i class="bi bi-check-circle mr-1"></i>{{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border-l-4 border-red-400 text-red-700 px-4 py-2 rounded mb-3 text-sm">
                <i class="bi bi-exclamation-circle mr-1"></i>{{ session('error') }}
            </div>
        @endif

        <!-- Tabla con filtros y botón agregar -->
        <div class="bg-white rounded-lg overflow-hidden border border-gray-200">
            <!-- Encabezado con filtros y botón agregar -->
            <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
                    <!-- Filtros -->
                    <div class="flex flex-col sm:flex-row gap-2 items-start sm:items-center flex-1">
                        <!-- Fechas -->
                        <div class="flex items-center gap-2">
                            <label for="fecha_desde" class="text-xs font-medium text-gray-600">Desde:</label>
                            <input type="date" id="fecha_desde" class="border border-gray-300 rounded-md py-2 px-3 text-xs">
                        </div>

                        <div class="flex items-center gap-2">
                            <label for="fecha_hasta" class="text-xs font-medium text-gray-600">Hasta:</label>
                            <input type="date" id="fecha_hasta" class="border border-gray-300 rounded-md py-2 px-3 text-xs">
                        </div>

                        <!-- Mecánico (solo si tiene permiso) -->
                        @can('filtrar-por-trabajador-servicios')
                            <select id="mechanic" class="border border-gray-300 rounded-md py-2 px-3 text-xs">
                                <option value="">Todos los mecánicos</option>
                                @foreach ($mechanics as $mechanic)
                                    <option value="{{ $mechanic->id }}">{{ $mechanic->name }} {{ $mechanic->apellidos }}</option>
                                @endforeach
                            </select>
                        @endcan

                        <!-- Estado (solo si tiene permiso) -->
                        @can('filtrar-por-estado-servicios')
                            <select id="estado-filtro" class="border border-gray-300 rounded-md py-2 px-3 text-xs">
                                <option value="">Todos los estados</option>
                                <option value="0">Pendiente</option>
                                <option value="1">Completo</option>
                                <option value="2">En proceso</option>
                            </select>
                        @endcan

                        <button type="button" onclick="aplicarFiltros()"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md text-xs transition-colors">
                            <i class="bi bi-funnel mr-1"></i>Filtrar
                        </button>
                    </div>

                    <!-- Botón Agregar -->
                    @can('agregar-servicios')
                        <a href="{{ route('services.create') }}"
                            class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-md flex items-center justify-center transition-colors text-sm">
                            <i class="bi bi-plus-lg mr-1"></i>Agregar
                        </a>
                    @endcan
                </div>
            </div>

            <!-- Tabla -->
            <div class="overflow-x-auto">
                <table id="servicesTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Código</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Motor</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Placa</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Mecánico</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">Estado</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Descripción</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">Fecha</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($servicios as $servicio)
                            <tr class="hover:bg-blue-50 transition-colors"
                                data-mechanic="{{ $servicio->users_id }}"
                                data-estado="{{ $servicio->status_service }}"
                                data-fecha="{{ \Carbon\Carbon::parse($servicio->fecha_registro)->format('Y-m-d') }}">

                                <td class="px-3 py-2 text-sm text-gray-700">{{ $servicio->codigo }}</td>
                                <td class="px-3 py-2 text-sm text-gray-600">{{ $servicio->drive->nro_motor ?? 'N/A' }}</td>
                                <td class="px-3 py-2 text-sm text-gray-600">{{ $servicio->car->placa ?? 'Sin placa' }}</td>
                                <td class="px-3 py-2 text-sm text-gray-600">
                                    {{ $servicio->user->name ?? '' }} {{ $servicio->user->apellidos ?? '' }}
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <span class="px-2 py-1 inline-flex text-xs font-medium rounded-full
                                        {{ $servicio->status_service == 1 ? 'bg-green-100 text-green-700' :
                                           ($servicio->status_service == 2 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                        {{ $servicio->status_service == 1 ? 'Completo' :
                                           ($servicio->status_service == 2 ? 'En proceso' : 'Pendiente') }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-600">{{ $servicio->descripcion }}</td>
                                <td class="px-3 py-2 text-sm text-gray-600 text-center">
                                    {{ \Carbon\Carbon::parse($servicio->fecha_registro)->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <button onclick="openModal({{ $servicio->id }})"
                                            class="text-blue-600 hover:text-blue-800 transition-colors"
                                            title="Ver/Agregar detalles">
                                        <i class="bi bi-eye text-base"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL AGREGAR DETALLES -->
    <div id="modalAgregarDetalles" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-96">
            <!-- Encabezado del modal -->
            <div class="flex justify-between items-center border-b px-4 py-2">
                <h5 class="text-lg font-semibold">Agregar Detalles</h5>
                <button class="close-modal text-gray-500 hover:text-gray-700"
                    onclick="toggleModal('modalAgregarDetalles', false)">&times;</button>
            </div>

            <!-- Contenido del modal -->
            <div class="p-4">
                <form id="formAgregarDetalles">
                    @csrf
                    <input type="hidden" id="serviceIdAgregar">

                    <!-- Selección de Estado -->
                    <div class="mb-3">
                        <label for="estado" class="block font-medium">Estado del Servicio</label>
                        <select id="estado" name="estado"
                            class="w-full border border-gray-300 rounded-lg py-2 px-4">
                            <option value="">Seleccione un estado</option>
                            <option value="0">Pendiente</option>
                            <option value="1">Completo</option>
                            <option value="2">En proceso</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="descripcionAgregar" class="block font-medium">Detalle del Servicio</label>
                        <textarea id="descripcionAgregar" class="w-full p-2 border rounded-lg"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg">
                        Guardar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL VER DETALLES -->
    <div id="modalVerDetalles" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-96">
            <div class="flex justify-between items-center border-b px-4 py-2">
                <h5 class="text-lg font-semibold">Detalles del Servicio</h5>
                <button class="close-modal text-gray-500 hover:text-gray-700"
                    onclick="toggleModal('modalVerDetalles', false)">&times;</button>
            </div>
            <div class="p-4">
                <input type="hidden" id="serviceIdDetalles">
                <p><strong>Descripción:</strong></p>
                <p id="descripcionVer"></p>
            </div>
        </div>
    </div>

    <script>
        window.authUser = @json(auth()->user()->load('roles'));

        function toggleModal(id, show) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.toggle('hidden', !show);
            }
        }

        document.getElementById("formAgregarDetalles").addEventListener("submit", function(event) {
            event.preventDefault();
            enviarDetalles();
        });

        async function enviarDetalles() {
            const serviceId = document.getElementById("serviceIdAgregar").value;
            const estado = document.getElementById("estado").value || null;
            const descripcion = document.getElementById("descripcionAgregar").value;

            const formData = {
                serviceId,
                estado,
                descripcion
            };

            try {
                const response = await fetch("{{ route('service.cambiarEstado') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Guardado',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                    toggleModal("modalAgregarDetalles", false);
                    // Recargar la página para actualizar la tabla
                    setTimeout(() => window.location.reload(), 2000);
                } else {
                    alert("Error al guardar: " + data.message);
                }
            } catch (error) {
                console.error("Error:", error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error,
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        }

        async function openModal(serviceId) {
            if (window.authUser?.roles?.some(role => role.name === 'mecanico')) {
                document.getElementById('serviceIdAgregar').value = serviceId;
                document.getElementById('modalAgregarDetalles').classList.remove('hidden');
            } else {
                try {
                    const response = await fetch(
                        `{{ route('service.verDetalles') }}?serviceId=${encodeURIComponent(serviceId)}`, {
                            method: "GET",
                            headers: {
                                "Content-Type": "application/json",
                            },
                        });

                    if (!response.ok) {
                        throw new Error("No se pudieron obtener los detalles del servicio.");
                    }

                    const data = await response.json();

                    // Mostrar los detalles en el modal
                    document.getElementById('serviceIdDetalles').value = serviceId;
                    document.getElementById('descripcionVer').textContent = data.service.detalle_servicio ||
                        'Sin descripción';
                    document.getElementById('modalVerDetalles').classList.remove('hidden');

                } catch (error) {
                    console.error("Error al obtener detalles:", error);
                    alert("Hubo un error al cargar los detalles del servicio.");
                }
            }
        }

        // Inicializar DataTables
        document.addEventListener('DOMContentLoaded', function() {
            // Filtro personalizado de DataTables
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    if (settings.nTable.id !== 'servicesTable') {
                        return true;
                    }

                    let mechanicFilter = document.getElementById('mechanic')?.value;
                    let estadoFilter = document.getElementById('estado-filtro')?.value;
                    let fechaDesde = document.getElementById('fecha_desde').value;
                    let fechaHasta = document.getElementById('fecha_hasta').value;

                    let row = window.servicesTable.row(dataIndex).node();
                    if (!row) return true;

                    // Filtrar por mecánico
                    if (mechanicFilter && row.dataset.mechanic != mechanicFilter) {
                        return false;
                    }

                    // Filtrar por estado
                    if (estadoFilter && row.dataset.estado != estadoFilter) {
                        return false;
                    }

                    // Filtrar por rango de fechas
                    if (fechaDesde || fechaHasta) {
                        let rowFecha = row.dataset.fecha;
                        if (fechaDesde && rowFecha < fechaDesde) return false;
                        if (fechaHasta && rowFecha > fechaHasta) return false;
                    }

                    return true;
                }
            );

            // Inicializar DataTable
            if ($.fn.DataTable) {
                window.servicesTable = $('#servicesTable').DataTable({
                    deferRender: true,
                    processing: false,
                    stateSave: false,
                    responsive: true,
                    pageLength: 10,
                    lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                    language: {
                        search: "Buscar:",
                        lengthMenu: "Mostrar _MENU_ servicios",
                        info: "Mostrando _START_ a _END_ de _TOTAL_ servicios",
                        infoEmpty: "0 servicios",
                        infoFiltered: "(filtrado de _MAX_ totales)",
                        zeroRecords: "No se encontraron servicios",
                        emptyTable: "No hay servicios registrados",
                        paginate: {
                            first: "Primero",
                            last: "Último",
                            next: "Siguiente",
                            previous: "Anterior"
                        }
                    },
                    dom: '<"flex justify-between items-center px-3 py-2"lf>rt<"flex justify-between items-center px-3 py-2 border-t border-gray-200"ip>',
                    columnDefs: [
                        { targets: [7], orderable: false }, // Acciones no ordenables
                        { targets: [4, 7], className: 'text-center' }
                    ],
                    order: [[6, 'desc']], // Ordenar por fecha descendente
                    autoWidth: false,
                    scrollX: false
                });
            }
        });

        // Función para aplicar filtros
        function aplicarFiltros() {
            if (window.servicesTable) {
                window.servicesTable.draw();
            }
        }
    </script>

</x-app-layout>
