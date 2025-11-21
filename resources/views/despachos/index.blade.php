<x-app-layout>
    <x-breadcrumb title="Despachos" parent="Ventas" parentUrl="{{ route('sales.index') }}" subtitle="Control de Entregas" />

    <div class="px-3 py-4">
        <!-- Estadísticas -->
        <div class="grid grid-cols-2 gap-3 mb-4">
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="text-yellow-600 text-sm font-medium">Pendientes de Entrega</div>
                <div class="text-3xl font-bold text-yellow-700">{{ $ventasPendientes->count() }}</div>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="text-green-600 text-sm font-medium">Entregados (últimos 50)</div>
                <div class="text-3xl font-bold text-green-700">{{ $ventasEntregadas->count() }}</div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white rounded-lg shadow">
            <div class="border-b">
                <nav class="flex">
                    <button onclick="showTab('pendientes')" id="tab-pendientes"
                        class="px-6 py-3 text-sm font-medium border-b-2 border-yellow-500 text-yellow-600">
                        Pendientes ({{ $ventasPendientes->count() }})
                    </button>
                    <button onclick="showTab('entregados')" id="tab-entregados"
                        class="px-6 py-3 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700">
                        Entregados ({{ $ventasEntregadas->count() }})
                    </button>
                </nav>
            </div>

            <!-- Tab Pendientes -->
            <div id="content-pendientes" class="p-4">
                @if($ventasPendientes->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left">Serie-Número</th>
                                <th class="px-4 py-3 text-left">Cliente</th>
                                <th class="px-4 py-3 text-left">Dirección</th>
                                <th class="px-4 py-3 text-left">Distrito</th>
                                <th class="px-4 py-3 text-right">Total</th>
                                <th class="px-4 py-3 text-left">Fecha Venta</th>
                                <th class="px-4 py-3 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ventasPendientes as $venta)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium">{{ $venta->serie }}-{{ $venta->number }}</td>
                                <td class="px-4 py-3">{{ $venta->customer_names_surnames }}</td>
                                <td class="px-4 py-3">{{ $venta->customer_address ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    @if($venta->district)
                                        {{ $venta->district->name }}
                                        @if($venta->district->province)
                                            , {{ $venta->district->province->name }}
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right font-medium">S/ {{ number_format($venta->total_price, 2) }}</td>
                                <td class="px-4 py-3">{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3 text-center">
                                    <button onclick="marcarEntregado({{ $venta->id }})"
                                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs">
                                        <i class="bi bi-check-lg mr-1"></i> Marcar Entregado
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-8 text-gray-500">
                    <i class="bi bi-check-circle text-4xl text-green-500"></i>
                    <p class="mt-2">No hay ventas pendientes de entrega</p>
                </div>
                @endif
            </div>

            <!-- Tab Entregados -->
            <div id="content-entregados" class="p-4 hidden">
                @if($ventasEntregadas->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left">Serie-Número</th>
                                <th class="px-4 py-3 text-left">Cliente</th>
                                <th class="px-4 py-3 text-left">Dirección</th>
                                <th class="px-4 py-3 text-right">Total</th>
                                <th class="px-4 py-3 text-left">Fecha Entrega</th>
                                <th class="px-4 py-3 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ventasEntregadas as $venta)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium">{{ $venta->serie }}-{{ $venta->number }}</td>
                                <td class="px-4 py-3">{{ $venta->customer_names_surnames }}</td>
                                <td class="px-4 py-3">{{ $venta->customer_address ?? '-' }}</td>
                                <td class="px-4 py-3 text-right font-medium">S/ {{ number_format($venta->total_price, 2) }}</td>
                                <td class="px-4 py-3">
                                    @if($venta->delivered_at)
                                        {{ \Carbon\Carbon::parse($venta->delivered_at)->format('d/m/Y H:i') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <button onclick="marcarPendiente({{ $venta->id }})"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">
                                        <i class="bi bi-arrow-counterclockwise mr-1"></i> Revertir
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-8 text-gray-500">
                    <i class="bi bi-box-seam text-4xl"></i>
                    <p class="mt-2">No hay entregas registradas</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
    function showTab(tab) {
        // Ocultar todos los contenidos
        document.getElementById('content-pendientes').classList.add('hidden');
        document.getElementById('content-entregados').classList.add('hidden');

        // Resetear estilos de tabs
        document.getElementById('tab-pendientes').classList.remove('border-yellow-500', 'text-yellow-600');
        document.getElementById('tab-pendientes').classList.add('border-transparent', 'text-gray-500');
        document.getElementById('tab-entregados').classList.remove('border-green-500', 'text-green-600');
        document.getElementById('tab-entregados').classList.add('border-transparent', 'text-gray-500');

        // Mostrar tab seleccionado
        document.getElementById('content-' + tab).classList.remove('hidden');

        if (tab === 'pendientes') {
            document.getElementById('tab-pendientes').classList.add('border-yellow-500', 'text-yellow-600');
            document.getElementById('tab-pendientes').classList.remove('border-transparent', 'text-gray-500');
        } else {
            document.getElementById('tab-entregados').classList.add('border-green-500', 'text-green-600');
            document.getElementById('tab-entregados').classList.remove('border-transparent', 'text-gray-500');
        }
    }

    function marcarEntregado(saleId) {
        Swal.fire({
            title: '¿Marcar como entregado?',
            text: 'Esta venta se moverá a la lista de entregados',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sí, marcar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`${baseUrl}/despacho/marcar-entregado`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ sale_id: saleId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Entregado',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Ocurrió un error', 'error');
                });
            }
        });
    }

    function marcarPendiente(saleId) {
        Swal.fire({
            title: '¿Revertir a pendiente?',
            text: 'Esta venta volverá a la lista de pendientes',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f59e0b',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sí, revertir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`${baseUrl}/despacho/marcar-pendiente`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ sale_id: saleId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Revertido',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Ocurrió un error', 'error');
                });
            }
        });
    }
    </script>
</x-app-layout>
