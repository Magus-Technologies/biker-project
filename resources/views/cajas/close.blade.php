<x-app-layout>
    <x-breadcrumb 
        title="Cerrar Caja {{ $caja->codigo }}" 
        parent="Cajas" 
        parentUrl="{{ route('cajas.index') }}" 
        subtitle="Cerrar" 
    />

    <div class="px-3 py-4 max-w-4xl mx-auto">

        <!-- Resumen de la caja -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="bi bi-calculator mr-2"></i>Resumen del Día
            </h3>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-blue-50 p-4 rounded-lg text-center">
                    <p class="text-sm text-gray-600">Monto Inicial</p>
                    <p class="text-xl font-bold text-blue-600">S/ {{ number_format($caja->monto_inicial, 2) }}</p>
                </div>
                
                <div class="bg-green-50 p-4 rounded-lg text-center">
                    <p class="text-sm text-gray-600">Total Ventas</p>
                    <p class="text-xl font-bold text-green-600">S/ {{ number_format($caja->total_ventas, 2) }}</p>
                </div>
                
                <div class="bg-red-50 p-4 rounded-lg text-center">
                    <p class="text-sm text-gray-600">Total Egresos</p>
                    <p class="text-xl font-bold text-red-600">S/ {{ number_format($caja->total_egresos, 2) }}</p>
                </div>
                
                <div class="bg-gray-100 p-4 rounded-lg text-center border-2 border-gray-300">
                    <p class="text-sm text-gray-600">Esperado</p>
                    <p class="text-xl font-bold text-gray-800">S/ {{ number_format($caja->monto_final_esperado, 2) }}</p>
                </div>
            </div>

            <!-- Desglose por método de pago -->
            <div class="border-t pt-4">
                <h4 class="font-semibold text-gray-700 mb-3">Desglose de Ventas por Método de Pago:</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <span class="text-sm text-gray-600">Efectivo:</span>
                        <span class="font-semibold text-green-600">S/ {{ number_format($caja->monto_ventas_efectivo, 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <span class="text-sm text-gray-600">Tarjeta:</span>
                        <span class="font-semibold text-purple-600">S/ {{ number_format($caja->monto_ventas_tarjeta, 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <span class="text-sm text-gray-600">Transferencia:</span>
                        <span class="font-semibold text-indigo-600">S/ {{ number_format($caja->monto_ventas_transferencia, 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <span class="text-sm text-gray-600">Otros:</span>
                        <span class="font-semibold text-blue-600">S/ {{ number_format($caja->monto_ventas_otros, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario de cierre -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="bi bi-cash-stack mr-2"></i>Conteo de Efectivo
            </h3>
            
            <form id="formCerrarCaja">
                @csrf
                
                <!-- Monto contado -->
                <div class="mb-6">
                    <label for="monto_final_real" class="block text-sm font-medium text-gray-700 mb-2">
                        Monto Contado (Efectivo Real en Caja) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-500 font-semibold text-lg">S/</span>
                        <input type="number" 
                               id="monto_final_real" 
                               name="monto_final_real" 
                               step="0.01" 
                               min="0"
                               required
                               class="w-full pl-10 pr-4 py-3 border-2 border-gray-300 rounded-lg text-lg font-semibold focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <p class="text-gray-500 text-sm mt-2">
                        <i class="bi bi-info-circle mr-1"></i>
                        Cuenta todo el efectivo físico que tienes en la caja
                    </p>
                </div>

                <!-- Calculadora de billetes y monedas -->
                <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-gray-700 mb-3">
                        <i class="bi bi-calculator mr-2"></i>Calculadora de Billetes y Monedas
                    </h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <div>
                            <label class="text-xs text-gray-600">Billetes S/ 200</label>
                            <input type="number" min="0" class="w-full p-2 border rounded text-sm" onchange="calcularTotal()">
                        </div>
                        <div>
                            <label class="text-xs text-gray-600">Billetes S/ 100</label>
                            <input type="number" min="0" class="w-full p-2 border rounded text-sm" onchange="calcularTotal()">
                        </div>
                        <div>
                            <label class="text-xs text-gray-600">Billetes S/ 50</label>
                            <input type="number" min="0" class="w-full p-2 border rounded text-sm" onchange="calcularTotal()">
                        </div>
                        <div>
                            <label class="text-xs text-gray-600">Billetes S/ 20</label>
                            <input type="number" min="0" class="w-full p-2 border rounded text-sm" onchange="calcularTotal()">
                        </div>
                        <div>
                            <label class="text-xs text-gray-600">Billetes S/ 10</label>
                            <input type="number" min="0" class="w-full p-2 border rounded text-sm" onchange="calcularTotal()">
                        </div>
                        <div>
                            <label class="text-xs text-gray-600">Monedas S/ 5</label>
                            <input type="number" min="0" class="w-full p-2 border rounded text-sm" onchange="calcularTotal()">
                        </div>
                        <div>
                            <label class="text-xs text-gray-600">Monedas S/ 2</label>
                            <input type="number" min="0" class="w-full p-2 border rounded text-sm" onchange="calcularTotal()">
                        </div>
                        <div>
                            <label class="text-xs text-gray-600">Monedas S/ 1</label>
                            <input type="number" min="0" class="w-full p-2 border rounded text-sm" onchange="calcularTotal()">
                        </div>
                    </div>
                    <div class="mt-3 p-3 bg-blue-50 rounded">
                        <p class="text-sm text-gray-600">Total Calculado:</p>
                        <p class="text-2xl font-bold text-blue-600" id="totalCalculado">S/ 0.00</p>
                        <button type="button" onclick="usarCalculado()" class="mt-2 text-sm text-blue-600 hover:text-blue-800">
                            <i class="bi bi-arrow-down mr-1"></i>Usar este monto
                        </button>
                    </div>
                </div>

                <!-- Vista previa de diferencia -->
                <div id="diferencia-preview" class="mb-6 p-4 rounded-lg hidden">
                    <h4 class="font-semibold mb-2">Diferencia Detectada:</h4>
                    <p class="text-2xl font-bold" id="diferencia-monto"></p>
                    <p class="text-sm mt-1" id="diferencia-texto"></p>
                </div>

                <!-- Observaciones -->
                <div class="mb-6">
                    <label for="observaciones_cierre" class="block text-sm font-medium text-gray-700 mb-2">
                        Observaciones de Cierre <span class="text-gray-400">(Opcional)</span>
                    </label>
                    <textarea id="observaciones_cierre" 
                              name="observaciones_cierre" 
                              rows="3"
                              maxlength="500"
                              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                              placeholder="Ej: Todo en orden, sin novedades"></textarea>
                </div>

                <!-- Botones -->
                <div class="flex gap-3">
                    <a href="{{ route('cajas.show', $caja->id) }}" 
                       class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition text-center">
                        <i class="bi bi-x-lg mr-2"></i>Cancelar
                    </a>
                    <button type="submit" 
                            class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg transition">
                        <i class="bi bi-lock mr-2"></i>Cerrar Caja
                    </button>
                </div>
            </form>
        </div>

        <!-- Advertencia -->
        <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
            <p class="text-sm text-yellow-800">
                <i class="bi bi-exclamation-triangle mr-2"></i>
                <strong>Importante:</strong> Una vez cerrada la caja, no podrás realizar más movimientos. Asegúrate de contar bien el efectivo.
            </p>
        </div>
    </div>

    <script>
        const montoEsperado = {{ $caja->monto_final_esperado }};
        const denominaciones = [200, 100, 50, 20, 10, 5, 2, 1];
        
        function calcularTotal() {
            const inputs = document.querySelectorAll('.grid input[type="number"]');
            let total = 0;
            
            inputs.forEach((input, index) => {
                const cantidad = parseFloat(input.value) || 0;
                total += cantidad * denominaciones[index];
            });
            
            document.getElementById('totalCalculado').textContent = 'S/ ' + total.toFixed(2);
        }
        
        function usarCalculado() {
            const total = document.getElementById('totalCalculado').textContent.replace('S/ ', '');
            document.getElementById('monto_final_real').value = total;
            calcularDiferencia();
        }
        
        document.getElementById('monto_final_real').addEventListener('input', calcularDiferencia);
        
        function calcularDiferencia() {
            const montoReal = parseFloat(document.getElementById('monto_final_real').value) || 0;
            const diferencia = montoReal - montoEsperado;
            const preview = document.getElementById('diferencia-preview');
            const montoEl = document.getElementById('diferencia-monto');
            const textoEl = document.getElementById('diferencia-texto');
            
            if (montoReal > 0) {
                preview.classList.remove('hidden');
                
                if (diferencia === 0) {
                    preview.className = 'mb-6 p-4 rounded-lg bg-green-50 border-l-4 border-green-500';
                    montoEl.className = 'text-2xl font-bold text-green-600';
                    montoEl.textContent = 'S/ 0.00';
                    textoEl.textContent = '✓ La caja está cuadrada';
                } else if (diferencia > 0) {
                    preview.className = 'mb-6 p-4 rounded-lg bg-blue-50 border-l-4 border-blue-500';
                    montoEl.className = 'text-2xl font-bold text-blue-600';
                    montoEl.textContent = '+ S/ ' + Math.abs(diferencia).toFixed(2);
                    textoEl.textContent = 'Hay un sobrante de dinero';
                } else {
                    preview.className = 'mb-6 p-4 rounded-lg bg-red-50 border-l-4 border-red-500';
                    montoEl.className = 'text-2xl font-bold text-red-600';
                    montoEl.textContent = '- S/ ' + Math.abs(diferencia).toFixed(2);
                    textoEl.textContent = 'Hay un faltante de dinero';
                }
            } else {
                preview.classList.add('hidden');
            }
        }
        
        document.getElementById('formCerrarCaja').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            // Confirmación
            const result = await Swal.fire({
                title: '¿Cerrar caja?',
                html: `Estás a punto de cerrar la caja con:<br><strong>S/ ${data.monto_final_real}</strong>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, cerrar caja',
                cancelButtonText: 'Cancelar'
            });
            
            if (!result.isConfirmed) return;
            
            try {
                const response = await fetch('{{ route('cajas.cerrar', $caja->id) }}', {
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
                        title: 'Caja cerrada',
                        text: 'La caja se ha cerrado exitosamente',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.href = result.redirect;
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
                    text: 'Ocurrió un error al cerrar la caja'
                });
            }
        });
    </script>
</x-app-layout>
