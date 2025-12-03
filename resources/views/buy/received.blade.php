<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="bi bi-truck-loading mr-2"></i>{{ __('Recepción de Productos') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <!-- Información de la Compra -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <h4 class="font-semibold text-blue-800 mb-2">
                                    <i class="bi bi-file-invoice mr-2"></i>Información de Compra
                                </h4>
                                <p><strong>Número:</strong> <span id="buyNumber"></span></p>
                                <p><strong>Fecha:</strong> <span id="buyDate"></span></p>
                                <p><strong>Total:</strong> <span id="buyTotal"></span></p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-blue-800 mb-2">
                                    <i class="bi bi-truck mr-2"></i>Proveedor
                                </h4>
                                <p><strong>Nombre:</strong> <span id="supplierName"></span></p>
                                <p><strong>Documento:</strong> <span id="supplierDocument"></span></p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-blue-800 mb-2">
                                    <i class="bi bi-store mr-2"></i>Tienda Destino
                                </h4>
                                <p><strong>Tienda:</strong> <span id="tiendaName"></span></p>
                                <div class="mt-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Cambiar tienda (opcional)
                                    </label>
                                    <select id="newTiendaId" class="w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="">Mantener tienda original</option>
                                        @foreach($tiendas as $tienda)
                                        <option value="{{ $tienda->id }}">{{ $tienda->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Scanner de Códigos -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <h4 class="font-semibold text-yellow-800 mb-3">
                            <i class="bi bi-barcode mr-2"></i>Scanner de Códigos de Barra
                        </h4>
                        <div class="flex gap-4 items-end">
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Escanear código de barra
                                </label>
                                <input type="text" 
                                       id="barcodeInput" 
                                       placeholder="Escanee o digite el código de barra"
                                       class="w-full rounded-md border-gray-300 shadow-sm"
                                       onkeypress="handleBarcodeInput(event)">
                            </div>
                            <button onclick="processBarcodeManually()" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="bi bi-plus mr-2"></i>Agregar
                            </button>
                            <button onclick="clearBarcode()" 
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                <i class="bi bi-trash mr-2"></i>Limpiar
                            </button>
                        </div>
                        
                        <!-- Códigos Escaneados -->
                        <div id="scannedCodesContainer" class="mt-4 hidden">
                            <h5 class="font-medium text-gray-700 mb-2">Códigos Escaneados:</h5>
                            <div id="scannedCodesList" class="flex flex-wrap gap-2"></div>
                        </div>
                    </div>

                    <!-- Tabla de Productos -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Producto
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Cantidad Pedida
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Cantidad Recibida
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Precio Unitario
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Códigos Únicos
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Estado
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="productsTable" class="bg-white divide-y divide-gray-200">
                                <!-- Los productos se cargarán dinámicamente -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="mt-6 flex justify-end space-x-4">
                        <button onclick="window.history.back()" 
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            <i class="bi bi-arrow-left mr-2"></i>Volver
                        </button>
                        <button onclick="saveReception()" 
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            <i class="bi bi-check mr-2"></i>Confirmar Recepción
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let buyData = {};
        let productsData = [];
        let scannedCodes = [];
        let currentProductId = null;

        // Inicializar página
        document.addEventListener('DOMContentLoaded', function() {
            const buyId = new URLSearchParams(window.location.search).get('buy_id');
            if (buyId) {
                loadBuyData(buyId);
            }
        });

        // Cargar datos de la compra
        async function loadBuyData(buyId) {
            try {
                const response = await fetch(`/buy/detalles/${buyId}`);
                const data = await response.json();
                
                buyData = data.buy;
                productsData = buyData.buy_items || [];
                
                displayBuyInfo();
                displayProducts();
            } catch (error) {
                console.error('Error al cargar datos de la compra:', error);
                alert('Error al cargar los datos de la compra');
            }
        }

        // Mostrar información de la compra
        function displayBuyInfo() {
            document.getElementById('buyNumber').textContent = `${buyData.serie}-${buyData.number}`;
            document.getElementById('buyDate').textContent = new Date(buyData.fecha_registro).toLocaleDateString();
            document.getElementById('buyTotal').textContent = `S/ ${parseFloat(buyData.total_price).toFixed(2)}`;
            
            if (buyData.supplier) {
                document.getElementById('supplierName').textContent = buyData.supplier.full_name || buyData.supplier.nombre_negocio;
                document.getElementById('supplierDocument').textContent = buyData.supplier.nro_documento;
            }
            
            if (buyData.tienda) {
                document.getElementById('tiendaName').textContent = buyData.tienda.name;
            }
        }

        // Mostrar productos
        function displayProducts() {
            const tbody = document.getElementById('productsTable');
            tbody.innerHTML = '';

            productsData.forEach((item, index) => {
                const product = item.product;
                const isUniqueCode = product.control_type === 'codigo_unico';
                const receivedQuantity = item.received_quantity || 0;
                const requiredCodes = isUniqueCode ? item.quantity : 0;
                const scannedCodesForProduct = item.scanned_codes || [];

                const row = `
                    <tr data-product-id="${product.id}" data-item-index="${index}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">${product.description}</div>
                                    <div class="text-sm text-gray-500">SKU: ${product.code_sku}</div>
                                    <div class="text-sm text-gray-500">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${isUniqueCode ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800'}">
                                            ${isUniqueCode ? 'Código Único' : 'Por Cantidad'}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ${item.quantity}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="number" 
                                   id="received_qty_${index}"
                                   value="${receivedQuantity}" 
                                   min="0" 
                                   max="${item.quantity}"
                                   class="w-20 rounded-md border-gray-300 shadow-sm text-sm"
                                   onchange="updateReceivedQuantity(${index}, this.value)"
                                   ${isUniqueCode ? 'readonly' : ''}>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="number" 
                                   id="price_${index}"
                                   value="${item.price}" 
                                   step="0.01"
                                   min="0"
                                   class="w-24 rounded-md border-gray-300 shadow-sm text-sm"
                                   onchange="updatePrice(${index}, this.value)">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            ${isUniqueCode ? `
                                <div class="space-y-2">
                                    <button onclick="startScanning(${product.id}, ${index})" 
                                            class="text-blue-600 hover:text-blue-900 text-sm">
                                        <i class="bi bi-barcode mr-1"></i>
                                        Escanear (${scannedCodesForProduct.length}/${requiredCodes})
                                    </button>
                                    <div id="codes_display_${index}" class="text-xs text-gray-600">
                                        ${scannedCodesForProduct.map(code => 
                                            `<span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-green-100 text-green-800 mr-1 mb-1">
                                                ${code}
                                                <button onclick="removeScannedCode(${index}, '${code}')" class="ml-1 text-green-600 hover:text-green-900">
                                                    <i class="bi bi-times"></i>
                                                </button>
                                            </span>`
                                        ).join('')}
                                    </div>
                                </div>
                            ` : `
                                <span class="text-sm text-gray-500">No requiere</span>
                            `}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span id="status_${index}" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${getStatusClass(item, isUniqueCode)}">
                                ${getStatusText(item, isUniqueCode)}
                            </span>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        }

        // Obtener clase CSS para el estado
        function getStatusClass(item, isUniqueCode) {
            if (isUniqueCode) {
                const scannedCount = (item.scanned_codes || []).length;
                const required = item.quantity;
                
                if (scannedCount === 0) return 'bg-gray-100 text-gray-800';
                if (scannedCount < required) return 'bg-yellow-100 text-yellow-800';
                if (scannedCount === required) return 'bg-green-100 text-green-800';
            } else {
                const received = item.received_quantity || 0;
                if (received === 0) return 'bg-gray-100 text-gray-800';
                if (received < item.quantity) return 'bg-yellow-100 text-yellow-800';
                if (received === item.quantity) return 'bg-green-100 text-green-800';
            }
            return 'bg-gray-100 text-gray-800';
        }

        // Obtener texto del estado
        function getStatusText(item, isUniqueCode) {
            if (isUniqueCode) {
                const scannedCount = (item.scanned_codes || []).length;
                const required = item.quantity;
                
                if (scannedCount === 0) return 'Pendiente';
                if (scannedCount < required) return 'Parcial';
                if (scannedCount === required) return 'Completo';
            } else {
                const received = item.received_quantity || 0;
                if (received === 0) return 'Pendiente';
                if (received < item.quantity) return 'Parcial';
                if (received === item.quantity) return 'Completo';
            }
            return 'Pendiente';
        }

        // Iniciar escaneo para un producto específico
        function startScanning(productId, itemIndex) {
            currentProductId = productId;
            const product = productsData[itemIndex].product;
            
            if (product.control_type === 'codigo_unico') {
                document.getElementById('barcodeInput').focus();
                document.getElementById('barcodeInput').placeholder = `Escaneando para: ${product.description}`;
                
                // Mostrar información del producto actual
                alert(`Iniciando escaneo para: ${product.description}\nCódigos requeridos: ${productsData[itemIndex].quantity}`);
            }
        }

        // Manejar entrada de código de barras
        function handleBarcodeInput(event) {
            if (event.key === 'Enter') {
                processBarcodeManually();
            }
        }

        // Procesar código de barras manualmente
        function processBarcodeManually() {
            const barcodeInput = document.getElementById('barcodeInput');
            const code = barcodeInput.value.trim();
            
            if (!code) {
                alert('Por favor, ingrese un código de barras');
                return;
            }

            if (!currentProductId) {
                alert('Primero seleccione un producto para escanear');
                return;
            }

            // Encontrar el índice del producto actual
            const itemIndex = productsData.findIndex(item => item.product.id === currentProductId);
            if (itemIndex === -1) {
                alert('Producto no encontrado');
                return;
            }

            const item = productsData[itemIndex];
            const product = item.product;

            // Verificar si el producto requiere códigos únicos
            if (product.control_type !== 'codigo_unico') {
                alert('Este producto no requiere escaneo de códigos únicos');
                return;
            }

            // Inicializar array de códigos escaneados si no existe
            if (!item.scanned_codes) {
                item.scanned_codes = [];
            }

            // Verificar si el código ya fue escaneado
            if (item.scanned_codes.includes(code)) {
                alert('Este código ya fue escaneado para este producto');
                barcodeInput.value = '';
                return;
            }

            // Verificar si ya se alcanzó la cantidad requerida
            if (item.scanned_codes.length >= item.quantity) {
                alert('Ya se escanearon todos los códigos requeridos para este producto');
                barcodeInput.value = '';
                return;
            }

            // Agregar código escaneado
            item.scanned_codes.push(code);
            
            // Actualizar cantidad recibida para productos con código único
            item.received_quantity = item.scanned_codes.length;
            
            // Actualizar interfaz
            displayProducts();
            
            // Limpiar input
            barcodeInput.value = '';
            
            // Verificar si se completó el escaneo
            if (item.scanned_codes.length === item.quantity) {
                alert(`¡Escaneo completo para ${product.description}!`);
                currentProductId = null;
                barcodeInput.placeholder = 'Escanee o digite el código de barra';
            }
        }

        // Limpiar código de barras
        function clearBarcode() {
            document.getElementById('barcodeInput').value = '';
        }

        // Actualizar cantidad recibida
        function updateReceivedQuantity(itemIndex, quantity) {
            const item = productsData[itemIndex];
            item.received_quantity = parseInt(quantity) || 0;
            displayProducts();
        }

        // Actualizar precio
        function updatePrice(itemIndex, price) {
            const item = productsData[itemIndex];
            item.price = parseFloat(price) || 0;
        }

        // Remover código escaneado
        function removeScannedCode(itemIndex, code) {
            const item = productsData[itemIndex];
            if (item.scanned_codes) {
                item.scanned_codes = item.scanned_codes.filter(c => c !== code);
                item.received_quantity = item.scanned_codes.length;
                displayProducts();
            }
        }

        // Guardar recepción
        async function saveReception() {
            // Validar que todos los productos tengan cantidad recibida o códigos escaneados
            const invalidItems = productsData.filter(item => {
                const product = item.product;
                if (product.control_type === 'codigo_unico') {
                    return !item.scanned_codes || item.scanned_codes.length === 0;
                } else {
                    return !item.received_quantity || item.received_quantity === 0;
                }
            });

            if (invalidItems.length > 0) {
                const itemNames = invalidItems.map(item => item.product.description).join(', ');
                if (!confirm(`Los siguientes productos no tienen cantidad recibida: ${itemNames}\n¿Desea continuar?`)) {
                    return;
                }
            }

            // Preparar datos para envío
            const receptionData = {
                items: productsData.map((item, index) => ({
                    buy_item_id: item.id,
                    tienda_id: document.getElementById('newTiendaId').value || buyData.tienda_id,
                    quantity: item.received_quantity || 0,
                    price: item.price,
                    scanned_codes: item.scanned_codes || []
                })).filter(item => item.quantity > 0 || item.scanned_codes.length > 0)
            };

            if (receptionData.items.length === 0) {
                alert('No hay productos para recepcionar');
                return;
            }

            try {
                const response = await fetch(`/buy/receive-products/${buyData.id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(receptionData)
                });

                const result = await response.json();

                if (response.ok) {
                    alert('Productos recepcionados correctamente');
                    window.location.href = '/buys';
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                console.error('Error al guardar recepción:', error);
                alert('Error al guardar la recepción');
            }
        }

        // Auto-enfocar el input de código de barras cuando se carga la página
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('barcodeInput').focus();
        });

        // Mantener el foco en el input de código de barras
        setInterval(function() {
            if (currentProductId && document.activeElement !== document.getElementById('barcodeInput')) {
                document.getElementById('barcodeInput').focus();
            }
        }, 1000);
    </script>

    <style>
        /* Estilos para resaltar el input activo */
        #barcodeInput:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Animación para códigos escaneados */
        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Estilos para el estado de productos */
        .status-pending { background-color: #f3f4f6; color: #374151; }
        .status-partial { background-color: #fef3c7; color: #92400e; }
        .status-complete { background-color: #d1fae5; color: #065f46; }
    </style>
</x-app-layout>