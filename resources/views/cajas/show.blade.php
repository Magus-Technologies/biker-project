<x-app-layout>
    <x-breadcrumb 
        title="Caja {{ $caja->codigo }}" 
        parent="Cajas" 
        parentUrl="{{ route('cajas.index') }}" 
        subtitle="Detalle" 
    />

    <div class="px-3 py-4">
        <!-- Header con botones -->
        <div class="bg-white rounded-lg px-4 py-3 mb-3 flex flex-wrap justify-between items-center gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-700">
                    <i class="bi bi-cash-coin mr-2 text-blue-600"></i>
                    Caja {{ $caja->codigo }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    {{ $caja->usuario->name }} | {{ $caja->fecha_apertura->format('d/m/Y H:i') }}
                </p>
            </div>
            
            <div class="flex gap-2">
                @if($caja->estado === 'abierta' && $caja->user_id === auth()->id())
                    <a href="{{ route('cajas.close', $caja->id) }}" 
                       class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md transition-colors text-sm">
                        <i class="bi bi-lock mr-1"></i>Cerrar Caja
                    </a>
                @endif
                
                <a href="{{ route('cajas.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition-colors text-sm">
                    <i class="bi bi-arrow-left mr-1"></i>Volver
                </a>
            </div>
        </div>

        <!-- Estado de la caja -->
        <div class="mb-6">
            @if($caja->estado === 'abierta')
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                    <p class="font-bold text-green-800">
                        <i class="bi bi-unlock-fill mr-2"></i>Caja Abierta
                    </p>
                </div>
            @else
                <div class="bg-gray-50 border-l-4 border-gray-500 p-4 rounded">
                    <p class="font-bold text-gray-800">
                        <i class="bi bi-lock-fill mr-2"></i>Caja Cerrada
                    </p>
                    <p class="text-sm text-gray-600 mt-1">
                        Cerrada el {{ $caja->fecha_cierre->format('d/m/Y H:i') }} por {{ $caja->usuarioCierre->name ?? 'N/A' }}
                    </p>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Resumen de Montos -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">
                        <i class="bi bi-calculator mr-2"></i>Resumen de Caja
                    </h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Monto Inicial -->
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Monto Inicial</p>
                            <p class="text-2xl font-bold text-blue-600">S/ {{ number_format($caja->monto_inicial, 2) }}</p>
                        </div>

                        <!-- Ventas Efectivo -->
                        <div class="bg-green-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Ventas Efectivo</p>
                            <p class="text-2xl font-bold text-green-600">S/ {{ number_format($caja->monto_ventas_efectivo, 2) }}</p>
                        </div>

                        <!-- Ventas Tarjeta -->
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Ventas Tarjeta</p>
                            <p class="text-2xl font-bold text-purple-600">S/ {{ number_format($caja->monto_ventas_tarjeta, 2) }}</p>
                        </div>

                        <!-- Ventas Transferencia -->
                        <div class="bg-indigo-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Ventas Transferencia</p>
                            <p class="text-2xl font-bold text-indigo-600">S/ {{ number_format($caja->monto_ventas_transferencia, 2) }}</p>
                        </div>

                        <!-- Gastos -->
                        <div class="bg-orange-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Gastos</p>
                            <p class="text-2xl font-bold text-orange-600">- S/ {{ number_format($caja->monto_gastos, 2) }}</p>
                        </div>

                        <!-- Retiros -->
                        <div class="bg-red-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Retiros</p>
                            <p class="text-2xl font-bold text-red-600">- S/ {{ number_format($caja->monto_retiros, 2) }}</p>
                        </div>

                        <!-- Depósitos -->
                        <div class="bg-teal-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Depósitos</p>
                            <p class="text-2xl font-bold text-teal-600">+ S/ {{ number_format($caja->monto_depositos, 2) }}</p>
                        </div>

                        <!-- Monto Final Esperado -->
                        <div class="bg-gray-100 p-4 rounded-lg border-2 border-gray-300">
                            <p class="text-sm text-gray-600">Monto Final Esperado</p>
                            <p class="text-2xl font-bold text-gray-800">S/ {{ number_format($caja->monto_final_esperado, 2) }}</p>
                        </div>
                    </div>

                    @if($caja->estado === 'cerrada')
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <p class="text-sm text-gray-600">Monto Contado (Real)</p>
                                    <p class="text-2xl font-bold text-blue-600">S/ {{ number_format($caja->monto_final_real, 2) }}</p>
                                </div>
                                <div class="p-4 rounded-lg {{ $caja->diferencia == 0 ? 'bg-green-50' : ($caja->diferencia > 0 ? 'bg-blue-50' : 'bg-red-50') }}">
                                    <p class="text-sm text-gray-600">Diferencia</p>
                                    <p class="text-2xl font-bold {{ $caja->diferencia == 0 ? 'text-green-600' : ($caja->diferencia > 0 ? 'text-blue-600' : 'text-red-600') }}">
                                        S/ {{ number_format($caja->diferencia, 2) }}
                                        @if($caja->diferencia > 0)
                                            <span class="text-sm">(Sobrante)</span>
                                        @elseif($caja->diferencia < 0)
                                            <span class="text-sm">(Faltante)</span>
                                        @else
                                            <span class="text-sm">(Cuadrado)</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Acciones Rápidas -->
            @if($caja->estado === 'abierta')
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">
                        <i class="bi bi-lightning mr-2"></i>Acciones Rápidas
                    </h3>
                    
                    <div class="space-y-3">
                        <button onclick="abrirModalMovimiento('gasto')" 
                                class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-lg transition">
                            <i class="bi bi-cash-stack mr-2"></i>Registrar Gasto
                        </button>
                        
                        <button onclick="abrirModalMovimiento('retiro')" 
                                class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-4 rounded-lg transition">
                            <i class="bi bi-arrow-down-circle mr-2"></i>Registrar Retiro
                        </button>
                        
                        <button onclick="abrirModalMovimiento('deposito')" 
                                class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 rounded-lg transition">
                            <i class="bi bi-arrow-up-circle mr-2"></i>Registrar Depósito
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Movimientos -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="bi bi-list-ul mr-2"></i>Movimientos de Caja
            </h3>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hora</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Concepto</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Método</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Monto</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuario</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($caja->movimientos as $movimiento)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $movimiento->created_at->format('H:i') }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="{{ $movimiento->color_concepto }}">
                                        <i class="bi {{ $movimiento->icono_concepto }} mr-1"></i>
                                        {{ ucfirst($movimiento->concepto) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $movimiento->descripcion ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $movimiento->metodoPago->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-right font-semibold {{ $movimiento->tipo === 'ingreso' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $movimiento->tipo === 'ingreso' ? '+' : '-' }} S/ {{ number_format($movimiento->monto, 2) }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $movimiento->usuario->name }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                    No hay movimientos registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal para registrar movimiento -->
    <div id="modalMovimiento" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <h3 class="text-xl font-bold text-gray-800 mb-4" id="modalTitle">Registrar Movimiento</h3>
            
            <form id="formMovimiento">
                @csrf
                <input type="hidden" id="tipo_movimiento" name="tipo">
                <input type="hidden" id="concepto_movimiento" name="concepto">
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Monto *</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-500">S/</span>
                        <input type="number" name="monto" step="0.01" min="0.01" required
                               class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Método de Pago</label>
                    <select name="metodo_pago_id" class="w-full p-2 border rounded-lg">
                        <option value="">Seleccionar</option>
                        @foreach($metodosPago as $metodo)
                            <option value="{{ $metodo->id }}">{{ $metodo->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Descripción *</label>
                    <textarea name="descripcion" rows="3" required
                              class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Comprobante</label>
                    <input type="text" name="comprobante" placeholder="Ej: BOL-001"
                           class="w-full p-2 border rounded-lg">
                </div>
                
                <div class="flex gap-3">
                    <button type="button" onclick="cerrarModalMovimiento()"
                            class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg">
                        Registrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function abrirModalMovimiento(concepto) {
            const modal = document.getElementById('modalMovimiento');
            const title = document.getElementById('modalTitle');
            const tipoInput = document.getElementById('tipo_movimiento');
            const conceptoInput = document.getElementById('concepto_movimiento');
            
            const config = {
                'gasto': { tipo: 'egreso', titulo: 'Registrar Gasto' },
                'retiro': { tipo: 'egreso', titulo: 'Registrar Retiro' },
                'deposito': { tipo: 'ingreso', titulo: 'Registrar Depósito' }
            };
            
            title.textContent = config[concepto].titulo;
            tipoInput.value = config[concepto].tipo;
            conceptoInput.value = concepto;
            
            modal.classList.remove('hidden');
        }
        
        function cerrarModalMovimiento() {
            document.getElementById('modalMovimiento').classList.add('hidden');
            document.getElementById('formMovimiento').reset();
        }
        
        document.getElementById('formMovimiento').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            try {
                const response = await fetch('{{ route('cajas.registrarMovimiento', $caja->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Movimiento registrado',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: result.message
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al registrar el movimiento'
                });
            }
        });
    </script>
</x-app-layout>
