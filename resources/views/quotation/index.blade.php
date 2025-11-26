<x-app-layout>
    <x-breadcrumb title="Lista de Cotizaciones" subtitle="cotizaciones" />

    <!-- Contenedor principal -->
    <div class="px-3 py-4">
        <!-- Header con controles -->
        <div class="bg-white rounded-lg overflow-hidden border border-gray-200">
            <!-- Encabezado con filtros y botón agregar -->
            <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
                    <!-- Filtros -->
                    <div class="flex flex-col sm:flex-row gap-2 items-start sm:items-center flex-1">
                        <div class="flex items-center gap-2">
                            <label for="fecha_desde" class="text-xs font-medium text-gray-600">Desde:</label>
                            <input type="date" id="fecha_desde" class="border border-gray-300 rounded-md py-2 px-3 text-xs">
                        </div>

                        <div class="flex items-center gap-2">
                            <label for="fecha_hasta" class="text-xs font-medium text-gray-600">Hasta:</label>
                            <input type="date" id="fecha_hasta" class="border border-gray-300 rounded-md py-2 px-3 text-xs">
                        </div>

                        <button type="button" onclick="finAllQuotations()" 
                                class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md text-xs transition-colors">
                            <i class="bi bi-funnel mr-1"></i>Filtrar
                        </button>
                    </div>

                    <!-- Botón Agregar -->
                    <a href="{{ route('quotations.create') }}"
                        class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-md flex items-center justify-center transition-colors text-sm">
                        <i class="bi bi-plus-lg mr-1"></i>Agregar
                    </a>
                </div>
            </div>

        <!-- Mensajes de éxito/error -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-4 flex items-center">
                <i class="bi bi-check-circle-fill mr-2"></i>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4 flex items-center">
                <i class="bi bi-exclamation-triangle-fill mr-2"></i>
                {{ session('error') }}
            </div>
        @endif

            <!-- Tabla -->
            <div class="overflow-x-auto">
                <table id="quotationsTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">Item</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Cliente</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">DNI</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Vendedor</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Mecánico</th>
                            <th class="px-3 py-2 text-right text-xs font-semibold text-gray-600 uppercase">SubTotal</th>
                            <th class="px-3 py-2 text-right text-xs font-semibold text-gray-600 uppercase">IGV</th>
                            <th class="px-3 py-2 text-right text-xs font-semibold text-gray-600 uppercase">Total</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">Fecha</th>
                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach ($quotations as $quotation)
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="px-3 py-2 text-sm text-gray-700 text-center">{{ $quotation->code }}</td>
                                <td class="px-3 py-2 text-sm text-gray-600">{{ $quotation->customer_names_surnames ?? 'Sin cliente' }}</td>
                                <td class="px-3 py-2 text-sm text-gray-600">{{ $quotation->customer_dni }}</td>
                                <td class="px-3 py-2 text-sm text-gray-600">{{ $quotation->userRegister->name ?? 'Sin vendedor' }}</td>
                                <td class="px-3 py-2 text-sm text-gray-600">{{ $quotation->mechanic->name ?? 'Sin mecánico' }}</td>
                                <td class="px-3 py-2 text-sm text-gray-600 text-right">S/. {{ number_format($quotation->total_price - $quotation->igv, 2) }}</td>
                                <td class="px-3 py-2 text-sm text-gray-600 text-right">S/. {{ number_format($quotation->igv, 2) }}</td>
                                <td class="px-3 py-2 text-sm font-medium text-gray-900 text-right">S/. {{ number_format($quotation->total_price, 2) }}</td>
                                <td class="px-3 py-2 text-sm text-gray-600 text-center">{{ $quotation->fecha_registro }}</td>
                                <td class="px-3 py-2 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button onclick="verDetalles({{ $quotation->id }})" 
                                                class="text-blue-600 hover:text-blue-800 transition-colors" 
                                                title="Ver detalles">
                                            <i class="bi bi-eye text-base"></i>
                                        </button>
                                        <button onclick="editQuotation({{ $quotation->id }})" 
                                                class="{{ $quotation->status_sale == '0' ? 'text-yellow-600 hover:text-yellow-800' : 'text-gray-400 cursor-not-allowed' }} transition-colors" 
                                                title="Editar" 
                                                {{ $quotation->status_sale == '0' ? '' : 'disabled' }}>
                                            <i class="bi bi-pencil-square text-base"></i>
                                        </button>
                                        <button onclick="deleteQuotation({{ $quotation->id }})" 
                                                class="text-red-600 hover:text-red-800 transition-colors" 
                                                title="Eliminar">
                                            <i class="bi bi-trash3-fill text-base"></i>
                                        </button>
                                        <button onclick="generarPDF({{ $quotation->id }})" 
                                                class="text-red-600 hover:text-red-800 transition-colors" 
                                                title="Generar PDF">
                                            <i class="bi bi-filetype-pdf text-base"></i>
                                        </button>
                                        <button onclick="venderQuotation({{ $quotation->id }})" 
                                                class="{{ $quotation->status_sale == '0' ? 'text-yellow-600 hover:text-yellow-800' : 'text-gray-400 cursor-not-allowed' }} transition-colors" 
                                                title="{{ $quotation->status_sale == '0' ? 'Vender' : 'Ya vendido' }}" 
                                                {{ $quotation->status_sale == '0' ? '' : 'disabled' }}>
                                            <i class="bi {{ $quotation->status_sale == '0' ? 'bi-cart-check' : 'bi-cart-x' }} text-base"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal de detalles -->
    <div id="detalleModal" class="fixed inset-0 bg-black bg-opacity-40 hidden flex justify-center items-center p-4 z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6 relative max-h-[90vh] overflow-y-auto">
            <!-- Botón de cierre -->
            <button onclick="cerrarModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-900 text-2xl font-bold">
                &times;
            </button>

            <!-- Encabezado -->
            <h2 class="text-xl font-semibold text-gray-800 text-center mb-4">Detalles de la Cotización</h2>

            <!-- Información general -->
            <div class="grid grid-cols-2 gap-3 text-sm text-gray-700 border-b pb-4 mb-4">
                <p><strong>Cliente:</strong> <span id="ventaCliente"></span></p>
                <p><strong>DNI:</strong> <span id="ventaDni"></span></p>
                <p><strong>Vendedor:</strong> <span id="ventaVendedor"></span></p>
                <p><strong>Fecha:</strong> <span id="ventaFecha"></span></p>
            </div>

            <!-- Tabla de detalles -->
            <div class="mb-4">
                <h3 class="text-md font-semibold text-gray-700 mb-2">Detalles de la Cotización</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-700 border border-gray-300">
                        <thead class="bg-gray-100 border-b border-gray-300">
                            <tr>
                                <th class="py-2 px-3 border-r border-gray-300">Tipo</th>
                                <th class="py-2 px-3 border-r border-gray-300">Descripción</th>
                                <th class="py-2 px-3 text-center border-r border-gray-300">Cantidad</th>
                                <th class="py-2 px-3 text-center border-r border-gray-300">Precio Unitario</th>
                                <th class="py-2 px-3 text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody id="listaDetalles" class="divide-y divide-gray-300"></tbody>
                    </table>
                </div>
            </div>

            <!-- Totales -->
            <div class="space-y-2 text-sm font-semibold">
                <p>SubTotal: S/ <input type="text" id="ventaSubTotal" class="border px-2 py-1 w-24 bg-gray-100 rounded" readonly></p>
                <p>IGV: S/ <input type="number" id="ventaIGV" value="0" step="0.01" class="border px-2 py-1 w-24 rounded" oninput="calcularSubtotal()"></p>
                <p>Total: S/ <input type="number" id="ventaTotal" value="0" step="0.01" class="border px-2 py-1 w-24 rounded" oninput="calcularSubtotal()"></p>
            </div>

            <!-- Botón cerrar -->
            <div class="mt-6 text-center">
                <button onclick="cerrarModal()" class="bg-gray-800 text-white px-6 py-2 rounded-lg hover:bg-gray-900 transition">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    @push('modals')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @endpush

    <style>
        /* Estilos para el modal */
        .modal-header {
            border-bottom: none;
            padding: 1.25rem 1.5rem;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .info-section {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .info-section h4 {
            color: #1f2937;
            font-weight: 600;
            font-size: 1.125rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #6b7280;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .info-value {
            color: #1f2937;
            font-weight: 600;
            font-size: 0.875rem;
        }
    </style>

    <script>
        let quotationsTable;
        let allQuotations = @json($quotations);

        document.addEventListener('DOMContentLoaded', () => {
            // Inicializar DataTables
            quotationsTable = $('#quotationsTable').DataTable({
                deferRender: true,
                processing: false,
                stateSave: false,
                responsive: true,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                language: {
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ cotizaciones",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ cotizaciones",
                    infoEmpty: "0 cotizaciones",
                    infoFiltered: "(filtrado de _MAX_ totales)",
                    zeroRecords: "No se encontraron cotizaciones",
                    emptyTable: "No hay cotizaciones registradas",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                },
                dom: '<"flex justify-between items-center px-3 py-2"lf>rt<"flex justify-between items-center px-3 py-2 border-t border-gray-200"ip>',
                columnDefs: [
                    { targets: [9], orderable: false }, // Acciones no ordenables
                    { targets: [9], className: 'text-center' },
                    { targets: [5, 6, 7], className: 'text-right' } // Montos alineados a la derecha
                ],
                order: [[8, 'desc']], // Ordenar por fecha descendente
                autoWidth: false,
                scrollX: false
            });

            // Configurar fechas
            let today = new Date();
            let formattedDate = today.toISOString().split('T')[0];
            document.getElementById('fecha_desde').value = formattedDate;
            document.getElementById('fecha_hasta').value = formattedDate;

            // Cargar cotizaciones
            finAllQuotations();
        });



        function finAllQuotations() {
            let desde = document.getElementById('fecha_desde').value;
            let hasta = document.getElementById('fecha_hasta').value;
            
            fetch(`{{ route('quotations.filtroPorfecha') }}?fecha_desde=${encodeURIComponent(desde)}&fecha_hasta=${encodeURIComponent(hasta)}`)
                .then(response => response.json())
                .then(data => {
                    allQuotations = data;
                    quotationsTable.clear();
                    
                    if (data.length > 0) {
                        data.forEach(quotation => {
                            const subtotal = (Number(quotation.total_price) || 0) - (Number(quotation.igv) || 0);
                            quotationsTable.row.add([
                                quotation.code,
                                quotation.customer_names_surnames ?? 'Sin cliente',
                                quotation.customer_dni,
                                quotation.user_register?.name ?? 'Sin vendedor',
                                quotation.mechanic?.name ?? 'Sin mecánico',
                                subtotal.toFixed(2),
                                Number(quotation.igv).toFixed(2),
                                Number(quotation.total_price).toFixed(2),
                                quotation.fecha_registro,
                                `<div class="flex justify-center gap-1">
                                    <button onclick="verDetalles(${quotation.id})" class="text-blue-500 hover:text-blue-700 p-1" title="Ver detalles">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                    <button onclick="editQuotation(${quotation.id})" class="p-1 ${quotation.status_sale == '0' ? 'text-yellow-500 hover:text-yellow-700' : 'text-gray-400 cursor-not-allowed'}" ${quotation.status_sale == '0' ? '' : 'disabled'}>
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button onclick="deleteQuotation(${quotation.id})" class="text-red-500 hover:text-red-700 p-1">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                    <button onclick="generarPDF(${quotation.id})" class="text-red-500 hover:text-red-700 p-1">
                                        <i class="bi bi-filetype-pdf"></i>
                                    </button>
                                    <button onclick="venderQuotation(${quotation.id})" class="p-1 ${quotation.status_sale == '0' ? 'text-yellow-500 hover:text-yellow-700' : 'text-gray-400 cursor-not-allowed'}" ${quotation.status_sale == '0' ? '' : 'disabled'}>
                                        <i class="bi ${quotation.status_sale == '0' ? 'bi-cart-check' : 'bi-cart-x'}"></i>
                                    </button>
                                </div>`
                            ]);
                        });
                    }
                    quotationsTable.draw();
                });
        }

        async function verDetalles(quotationId) {
            try {
                let url = `{{ route('quotations.detallesQuotation', ':id') }}`.replace(':id', quotationId);
                let response = await fetch(url);
                let data = await response.json();

                document.getElementById("ventaCliente").textContent = data.quotation.customer_names_surnames;
                document.getElementById("ventaVendedor").textContent = data.quotation.user_register.name;
                document.getElementById("ventaDni").textContent = data.quotation.customer_dni;
                document.getElementById("ventaFecha").textContent = data.quotation.fecha_registro;
                document.getElementById('ventaSubTotal').value = parseFloat(data.quotation.total_price - data.quotation.igv).toFixed(2);
                document.getElementById('ventaIGV').value = data.quotation.igv;
                document.getElementById('ventaTotal').value = parseFloat(data.quotation.total_price).toFixed(2);

                let listaDetalles = document.getElementById("listaDetalles");
                listaDetalles.innerHTML = "";

                data.quotation.quotation_items.forEach(item => {
                    let fila = document.createElement("tr");
                    const total = (item.quantity || 1) * parseFloat(item.unit_price);
                    fila.innerHTML = `
                        <td class="py-2 px-3">${item.item_type.includes("Product") ? "Producto" : "Servicio"}</td>
                        <td class="py-2 px-3">${item.item.description || item.item.name}</td>
                        <td class="py-2 px-3 text-center">${item.quantity ?? "1"}</td>
                        <td class="py-2 px-3 text-center">S/ ${parseFloat(item.unit_price).toFixed(2)}</td>
                        <td class="py-2 px-3 text-center">S/ ${total.toFixed(2)}</td>
                    `;
                    listaDetalles.appendChild(fila);
                });

                document.getElementById("detalleModal").classList.remove("hidden");
            } catch (error) {
                console.error("Error obteniendo los detalles:", error);
            }
        }

        async function editQuotation(quotationId) {
            let url = `{{ route('quotations.edit', ':id') }}`.replace(':id', quotationId);
            window.location.href = url;
        }

        async function deleteQuotation(quotationId) {
            const result = await Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esta acción",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            });
            
            if (!result.isConfirmed) return;

            try {
                let url = `{{ route('quotations.destroy', ':id') }}`.replace(':id', quotationId);
                let response = await fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Cotización Eliminada',
                        text: 'La cotización se ha eliminado correctamente',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    finAllQuotations();
                }
            } catch (error) {
                console.error("Error al eliminar:", error);
            }
        }

        async function generarPDF(quotationId) {
            try {
                let url = `{{ route('quotations.pdf', ':id') }}`.replace(':id', quotationId);
                window.open(url, '_blank');
            } catch (error) {
                console.error("Error al generar el PDF:", error);
            }
        }

        async function venderQuotation(quotationId) {
            try {
                const response = await fetch(`{{ route('quotations.vender', ':id') }}`.replace(':id', quotationId), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Venta Realizada',
                        text: 'La cotización se ha convertido en venta',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    finAllQuotations();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        function cerrarModal() {
            document.getElementById("detalleModal").classList.add("hidden");
        }
    </script>
</x-app-layout>
