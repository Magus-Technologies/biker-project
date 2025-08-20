<!-- resources\views\devoluciones\index.blade.php -->
<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">DEVOLUCIONES</h2>
            <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg">
                Exportar
            </button>
        </div>

        <!-- Filtro de fechas -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Desde</label>
                    <input type="date" id="fecha_desde" class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Hasta</label>
                    <input type="date" id="fecha_hasta" class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo Documento</label>
                    <select id="document_type_id" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="">Todos</option>
                        @foreach($documentTypes as $docType)
                            <option value="{{ $docType->id }}">{{ $docType->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button onclick="filtrarVentas()" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg w-full">
                        Filtrar
                    </button>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fechahora</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vendedor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody id="ventasTable" class="bg-white divide-y divide-gray-200">
                    @foreach($ventas as $venta)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{$venta->customer_names_surnames}}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{$venta->fecha_registro}}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{$venta->total_price}}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{$venta->userRegister->name}}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <button onclick="openDevolucionModal({{$venta->id}})" 
                                class="bg-blue-500 text-white px-3 py-1 rounded text-xs">
                                Detalle
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de Detalles y Devolución -->
    <div id="devolucionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">
        <div class="bg-white rounded-lg p-6 w-4/5 max-w-4xl max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 id="modalTitle" class="text-lg font-bold"></h3>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">✕</button>
            </div>
            
            <div id="devolucionForm" class="hidden mb-4">
                <div class="bg-blue-50 p-4 rounded-lg mb-4">
                    <h4 class="font-semibold text-blue-800 mb-2">Items seleccionados para devolución:</h4>
                    <div id="selectedItems" class="space-y-2"></div>
                    <div class="mt-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Motivo de la devolución:</label>
                        <textarea id="reason" class="w-full border border-gray-300 rounded-md px-3 py-2" rows="2" placeholder="Motivo de la devolución (opcional)"></textarea>
                    </div>
                </div>
            </div>
            
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">Producto</th>
                        <th class="border p-2">Código</th>
                        <th class="border p-2">Cantidad Vendida</th>
                        <th class="border p-2">Precio Venta</th>
                        <th class="border p-2">Total Unidad</th>
                        <th class="border p-2">Acciones</th>
                    </tr>
                </thead>
                <tbody id="productosTable">
                </tbody>
            </table>
            
            <div class="flex justify-end mt-4 space-x-2">
                <button onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cerrar</button>
                <button id="btnProcesarDevolucion" onclick="procesarDevolucion()" class="bg-green-500 text-white px-4 py-2 rounded hidden">
                    Procesar Devolución
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentSale = null;
        let devolucionItems = [];

        // Establecer fechas por defecto (último mes)
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const lastMonth = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());
            
            document.getElementById('fecha_hasta').value = today.toISOString().split('T')[0];
            document.getElementById('fecha_desde').value = lastMonth.toISOString().split('T')[0];
        });

        async function filtrarVentas() {
            const fechaDesde = document.getElementById('fecha_desde').value;
            const fechaHasta = document.getElementById('fecha_hasta').value;
            const documentTypeId = document.getElementById('document_type_id').value;
            
            if (!fechaDesde || !fechaHasta) {
                alert('Por favor selecciona ambas fechas');
                return;
            }
            
            try {
                const response = await fetch('/devoluciones/filtro-por-fecha', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        fecha_desde: fechaDesde,
                        fecha_hasta: fechaHasta,
                        document_type_id: documentTypeId
                    })
                });
                
                const ventas = await response.json();
                actualizarTablaVentas(ventas);
            } catch (error) {
                console.error('Error:', error);
                alert('Error al filtrar las ventas');
            }
        }

        function actualizarTablaVentas(ventas) {
            const tbody = document.getElementById('ventasTable');
            tbody.innerHTML = '';
            
            ventas.forEach(venta => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-6 py-4 text-sm text-gray-900">${venta.customer_names_surnames}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">${venta.fecha_registro}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">${venta.total_price}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">${venta.user_register ? venta.user_register.name : 'N/A'}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        <button onclick="openDevolucionModal(${venta.id})" 
                            class="bg-blue-500 text-white px-3 py-1 rounded text-xs">
                            Detalle
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
            });
        }

        async function openDevolucionModal(saleId) {
            try {
                const response = await fetch(`/devoluciones/sale/${saleId}`);
                const sale = await response.json();
                currentSale = sale;
                
                document.getElementById('modalTitle').textContent = `Detalles de la Venta - ${sale.customer_names_surnames} - ${sale.fecha_registro}`;
                
                const tbody = document.getElementById('productosTable');
                tbody.innerHTML = '';
                
                sale.sale_items.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="border p-2">${item.item.description || item.item.name}</td>
                        <td class="border p-2">${item.item.code_sku}</td>
                        <td class="border p-2">${item.quantity}</td>
                        <td class="border p-2">${item.unit_price}</td>
                        <td class="border p-2">${(item.quantity * item.unit_price).toFixed(2)}</td>
                        <td class="border p-2">
                            <button onclick="selectItemForReturn(${item.id}, ${item.quantity})" 
                                class="bg-red-500 text-white px-2 py-1 rounded text-xs">
                                Devolver
                            </button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
                
                // Limpiar items anteriores
                devolucionItems = [];
                document.getElementById('devolucionForm').classList.add('hidden');
                document.getElementById('btnProcesarDevolucion').classList.add('hidden');
                
                document.getElementById('devolucionModal').classList.remove('hidden');
            } catch (error) {
                console.error('Error:', error);
                alert('Error al cargar los detalles de la venta');
            }
        }

        function selectItemForReturn(saleItemId, maxQuantity) {
            const cantidad = prompt(`Ingresa la cantidad a devolver (máximo: ${maxQuantity}):`);
            
            if (cantidad && cantidad > 0 && cantidad <= maxQuantity) {
                const saleItem = currentSale.sale_items.find(item => item.id === saleItemId);
                
                // Verificar si ya está seleccionado
                const existingIndex = devolucionItems.findIndex(item => item.sale_item_id === saleItemId);
                if (existingIndex >= 0) {
                    devolucionItems[existingIndex].quantity_returned = parseInt(cantidad);
                } else {
                    devolucionItems.push({
                        sale_item_id: saleItemId,
                        quantity_returned: parseInt(cantidad),
                        unit_price: saleItem.unit_price,
                        item_name: saleItem.item.description || saleItem.item.name
                    });
                }
                
                actualizarItemsSeleccionados();
                document.getElementById('devolucionForm').classList.remove('hidden');
                document.getElementById('btnProcesarDevolucion').classList.remove('hidden');
            }
        }

        function actualizarItemsSeleccionados() {
            const container = document.getElementById('selectedItems');
            container.innerHTML = '';
            
            devolucionItems.forEach(item => {
                const div = document.createElement('div');
                div.className = 'flex justify-between items-center bg-white p-2 rounded border';
                div.innerHTML = `
                    <span>${item.item_name} - ${item.quantity_returned} unidades</span>
                    <button onclick="removeItem(${item.sale_item_id})" class="text-red-500 hover:text-red-700">✕</button>
                `;
                container.appendChild(div);
            });
        }

        function removeItem(saleItemId) {
            devolucionItems = devolucionItems.filter(item => item.sale_item_id !== saleItemId);
            actualizarItemsSeleccionados();
            
            if (devolucionItems.length === 0) {
                document.getElementById('devolucionForm').classList.add('hidden');
                document.getElementById('btnProcesarDevolucion').classList.add('hidden');
            }
        }

        async function procesarDevolucion() {
            if (devolucionItems.length === 0) {
                alert('No hay items para devolver');
                return;
            }
            
            const total = devolucionItems.reduce((sum, item) => sum + (item.quantity_returned * item.unit_price), 0);
            const reason = document.getElementById('reason').value;
            
            try {
                const response = await fetch('/devoluciones', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        sale_id: currentSale.id,
                        items: devolucionItems,
                        total_amount: total,
                        reason: reason
                    })
                });
                
                const result = await response.json();
                
                if (response.ok) {
                    alert('Devolución procesada correctamente');
                    closeModal();
                    // Recargar la tabla de ventas
                    filtrarVentas();
                } else {
                    alert('Error: ' + result.error);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al procesar la devolución');
            }
        }

        function closeModal() {
            document.getElementById('devolucionModal').classList.add('hidden');
            devolucionItems = [];
            document.getElementById('devolucionForm').classList.add('hidden');
            document.getElementById('btnProcesarDevolucion').classList.add('hidden');
            document.getElementById('reason').value = '';
        }
    </script>
</x-app-layout>
