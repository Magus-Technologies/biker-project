<x-app-layout>
    <x-breadcrumb title="Nueva Compra" subtitle="Crear nueva compra" />

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form id="purchaseForm">
                    @csrf
                    
                    <!-- Información del Proveedor -->
                    <div class="w-full mb-6">
                                                
                        <!-- Información de la Compra -->
                        <div class="bg-green-50 p-6 rounded-lg mb-6">
                            <h3 class="text-lg font-semibold mb-4 text-green-800">
                                <i class="bi bi-file-invoice mr-2"></i>Información de la Compra
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Documento</label>
                                    <select name="document_type_id" id="document_type_id" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                                        <option value="">Seleccionar...</option>
                                        @foreach($documentTypes as $docType)
                                            <option value="{{ $docType->id }}">{{ $docType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Pago</label>
                                    <select name="payment_type" id="payment_type" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                                        <option value="cash">Contado</option>
                                        <option value="credit">Crédito</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Estado de Productos</label>
                                    <!-- <CHANGE> Modificado: readonly y valor fijo -->
                                    <input type="text" value="En Espera de Productos" readonly 
                                        class="w-full rounded-md border-gray-300 bg-gray-100 text-gray-600 cursor-not-allowed">
                                    <input type="hidden" name="delivery_status" value="pending">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Búsqueda de Productos -->
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">
                            <i class="bi bi-search mr-2"></i>Buscar Productos
                        </h3>
                        
                        <div class="relative">
                            <input type="text" id="product_search" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 pl-10" 
                                   placeholder="Buscar por código, SKU, código de barras o nombre...">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-search text-gray-400"></i>
                            </div>
                            
                            <!-- Lista de resultados -->
                            <div id="search_results" class="absolute z-10 w-full bg-white border border-gray-300 rounded-md mt-1 hidden max-h-60 overflow-y-auto">
                                <!-- Los resultados se cargarán aquí -->
                            </div>
                        </div>
                    </div>
                    
                    <!-- Lista de Productos -->
                    <div class="bg-white border rounded-lg mb-6">
                        <div class="bg-gray-100 px-4 py-3 border-b">
                            <h3 class="text-lg font-semibold text-gray-800">
                                <i class="bi bi-shopping-basket mr-2"></i>Productos de la Compra
                            </h3>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full" id="products_table">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="products_tbody">
                                    <tr id="no_products_row">
                                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                            <i class="bi bi-box-open text-4xl mb-2"></i>
                                            <p>No hay productos agregados</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Métodos de Pago -->
                    <div class="bg-yellow-50 p-4 rounded-lg mb-6">
                        <h3 class="text-lg font-semibold mb-4 text-yellow-800">
                            <i class="bi bi-credit-card mr-2"></i>Métodos de Pago
                        </h3>
                        
                        <div id="payment_methods_container">
                            <div class="payment-method-row grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Método de Pago</label>
                                    <select name="payment_methods[0][payment_method_id]" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                                        <option value="">Seleccionar...</option>
                                        @foreach($paymentMethods as $method)
                                            <option value="{{ $method->id }}">{{ $method->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Monto</label>
                                    <input type="number" name="payment_methods[0][amount]" step="0.01" min="0" 
                                        class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 payment-amount-input" required>
                                </div>
                                
                                <div class="credit-fields hidden">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Cuotas</label>
                                    <div class="flex">
                                        <input type="number" name="payment_methods[0][installments]" min="1" 
                                            class="flex-1 rounded-l-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                        <button type="button" onclick="openInstallmentsModal(0)" 
                                                class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-2 rounded-r-md text-xs">
                                            <i class="bi bi-cog"></i>
                                        </button>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                        <button type="button" id="add_payment_method" class="text-sm text-blue-600 hover:text-blue-800">
                            <i class="bi bi-plus mr-1"></i>Agregar método de pago
                        </button>
                    </div>
                    
                    <!-- Totales -->
                    <div class="bg-gray-100 p-4 rounded-lg mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Subtotal</label>
                                <input type="number" id="subtotal" readonly class="w-full rounded-md border-gray-300 bg-gray-100" value="0.00">
                            </div>
                            
                            <div>
                                <div class="flex items-center mb-2">
                                    <input type="checkbox" id="incluir_igv" name="incluir_igv" checked class="mr-2">
                                    <label class="block text-sm font-medium text-gray-700">Incluir IGV (18%)</label>
                                </div>
                                <input type="number" name="igv" id="igv" readonly class="w-full rounded-md border-gray-300 bg-gray-100" value="0.00">
                            </div>

                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Total</label>
                                <input type="number" name="total_price" id="total_price" readonly class="w-full rounded-md border-gray-300 bg-gray-100 font-bold text-lg" value="0.00">
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones</label>
                            <textarea name="observation" rows="3" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                                      placeholder="Observaciones adicionales..."></textarea>
                        </div>
                    </div>
                    
                    <!-- Botones de Acción -->
                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="window.location.href='{{ route('buys.index') }}'"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                            <i class="bi bi-times mr-2"></i>Cancelar
                        </button>
                        
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                            <i class="bi bi-save mr-2"></i>Guardar Compra
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Escanear Códigos -->
    <div id="scanCodesModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-2/3 max-w-2xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4 bg-green-500 text-white p-3 rounded-t">
                    <h3 class="text-lg font-medium flex items-center">
                        <i class="bi bi-barcode mr-2"></i>Escanear Códigos
                    </h3>
                    <button type="button" onclick="closeScanModal()" class="text-white hover:text-gray-300">
                        <i class="bi bi-times"></i>
                    </button>
                </div>
                
                <div class="mb-4 p-3 bg-gray-50 rounded">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium" id="scan_product_name">Producto:</p>
                            <p class="text-sm text-gray-600">Cantidad esperada: <span id="scan_expected_quantity" class="font-bold">1</span></p>
                        </div>
                        <div class="text-right">
                            <p class="text-green-600 font-bold">
                                <i class="bi bi-check-circle mr-1"></i>
                                <span id="scan_current_count">1</span> de <span id="scan_total_needed">1</span> códigos escaneados
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Código escaneado:</label>
                    <div class="flex">
                        <input type="text" id="inputCodigoEscaneado" 
                            class="flex-1 rounded-l-md border-gray-300 focus:border-green-500 focus:ring-green-500" 
                                placeholder="Escanee o ingrese el código...">
                        <button type="button" id="btnAgregarCodigo" 
                                class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded-r-md">
                            <i class="bi bi-plus"></i> Agregar
                        </button>
                    </div>
                    <small class="text-gray-500">Presione Enter después de escanear o use el botón Agregar</small>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Códigos escaneados:</label>
                    <div class="bg-black text-green-400 p-4 rounded font-mono text-sm max-h-40 overflow-y-auto" id="codigosEscaneadosList">
                        <!-- Los códigos aparecerán aquí -->
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeScanModal()" 
                            class="bg-gray-500 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded">
                        Cancelar
                    </button>
                    <button type="button" id="btnConfirmarCodigos" 
                            class="bg-green-500 hover:bg-green-700 text-white font-medium py-2 px-4 rounded">
                        <i class="bi bi-check mr-2"></i>Confirmar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Configurar Cuotas -->
    <div id="configureInstallmentsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-4/5 max-w-4xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4 bg-blue-500 text-white p-3 rounded-t">
                    <h3 class="text-lg font-medium flex items-center">
                        <i class="bi bi-calendar-alt mr-2"></i>Configurar Cuotas de Pago
                    </h3>
                    <button type="button" onclick="closeInstallmentsModal()" class="text-white hover:text-gray-300">
                        <i class="bi bi-times"></i>
                    </button>
                </div>
                
                <div id="installments_configuration">
                    <!-- Las cuotas se generarán dinámicamente aquí -->
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeInstallmentsModal()" 
                            class="bg-gray-500 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded">
                        Cancelar
                    </button>
                    <button type="button" id="btnConfirmarCuotas" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                        <i class="bi bi-check mr-2"></i>Confirmar Cuotas
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let productIndex = 0;
        let paymentMethodIndex = 1;
        let currentScanProduct = null;
        let scannedCodes = [];

        $(document).ready(function() {
            initializeEventListeners();
            calculateTotals();
        });

        function initializeEventListeners() {
            // Búsqueda de productos
            $('#product_search').on('input', debounce(searchProducts, 300));
            $('#product_search').on('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    if (searchResultsProducts.length > 0) {
                        addProductToCart(searchResultsProducts[0]);
                    }
                }
            });

            // Tipo de pago
            $('#payment_type').on('change', toggleCreditFields);

            // IGV opcional
            $('#incluir_igv').on('change', calculateTotals);

            // Agregar método de pago
            $('#add_payment_method').on('click', addPaymentMethod);

            // Envío del formulario
            $('#purchaseForm').on('submit', submitPurchase);

            // Modal de escaneo
            $('#btnAgregarCodigo').on('click', addScannedCode);
            $('#inputCodigoEscaneado').on('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addScannedCode();
                }
            });
            $('#btnConfirmarCodigos').on('click', confirmScannedCodes);

            $('#btnConfirmarCuotas').on('click', confirmInstallments);

            // Ocultar resultados al hacer clic fuera
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#product_search, #search_results').length) {
                    $('#search_results').addClass('hidden');
                }
            });
        }

        // Función para buscar productos
        function searchProducts() {
            const search = $('#product_search').val().trim();
            
            if (search.length < 2) {
                $('#search_results').addClass('hidden');
                return;
            }

            $.ajax({
                url: '{{ route("buy.search-products") }}',
                method: 'GET',
                data: { search: search },
                success: function(products) {
                    displaySearchResults(products);
                },
                error: function() {
                    showAlert('Error al buscar productos', 'error');
                }
            });
        }

        // Variable global para almacenar los productos de búsqueda
        let searchResultsProducts = [];

        function displaySearchResults(products) {
            const resultsContainer = $('#search_results');
            resultsContainer.empty();
            searchResultsProducts = products;

            if (products.length === 0) {
                resultsContainer.html('<div class="p-3 text-gray-500">No se encontraron productos</div>');
            } else {
                products.forEach((product, index) => {
                    const resultHtml = `
                        <div class="search-result-item p-3 hover:bg-blue-50 cursor-pointer border-b"
                            onclick="addProductToCart(searchResultsProducts[${index}])">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-medium">${product.description}</p>
                                    <p class="text-sm text-gray-500">SKU: ${product.code_sku} | Stock: ${product.stock_total}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm">Precio: S/. ${parseFloat(product.precio_compra).toFixed(2)}</p>
                                </div>
                            </div>
                        </div>
                    `;
                    resultsContainer.append(resultHtml);
                });
            }

            resultsContainer.removeClass('hidden');
        }

        function addProductToCart(product) {
            $('#search_results').addClass('hidden');
            $('#product_search').val('');

            // Verificar si el producto ya está en el carrito
            const existingRow = $(`#product_row_${product.id}`);
            if (existingRow.length) {
                const quantityInput = existingRow.find('.quantity-input');
                quantityInput.val(parseInt(quantityInput.val()) + 1).trigger('input');
                showAlert('Cantidad del producto actualizada', 'success');
                return;
            }

            $('#no_products_row').remove();

            // Modificado: Mostrar botón de escanear solo si delivery_status no es 'pending'
            const deliveryStatus = $('input[name="delivery_status"]').val();
            const scanButtonHtml = product.control_type === 'codigo_unico' && deliveryStatus !== 'pending'
                ? `<button type="button" class="scan-codes-btn bg-green-500 hover:bg-green-700 text-white px-2 py-1 rounded text-xs ml-2" 
                          onclick="openScanModal(${product.id}, '${product.description}')">
                      <i class="bi bi-barcode mr-1"></i>Escanear
                   </button>` 
                : '';

            const rowHtml = `
                <tr id="product_row_${product.id}">
                    <td class="px-4 py-3">
                        <div>
                            <p class="font-medium">${product.description}</p>
                            <p class="text-sm text-gray-500">SKU: ${product.code_sku}</p>
                            <p class="text-xs text-gray-400">Control: ${product.control_type === 'codigo_unico' ? 'Código Único' : 'Cantidad'}</p>
                        </div>
                        <input type="hidden" name="products[${productIndex}][product_id]" value="${product.id}">
                        <input type="hidden" name="products[${productIndex}][scanned_codes]" value="" class="scanned-codes-input">
                    </td>
                    <td class="px-4 py-3">
                        <input type="number" name="products[${productIndex}][quantity]" 
                               class="quantity-input w-20 rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                               value="1" min="1" required>
                        ${scanButtonHtml}
                    </td>
                    <td class="px-4 py-3">
                        <div class="space-y-2">
                            <input type="number" name="products[${productIndex}][price]" step="0.01" min="0"
                                   class="price-input w-24 rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                                   value="${product.precio_compra}" required readonly>
                            <div class="flex items-center">
                                <input type="checkbox" name="products[${productIndex}][use_custom_price]" 
                                       class="custom-price-checkbox mr-2">
                                <label class="text-xs text-gray-600">Usar precio diferente al registrado</label>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <span class="subtotal-display font-medium">S/. ${parseFloat(product.precio_compra).toFixed(2)}</span>
                    </td>
                    <td class="px-4 py-3">
                        <button type="button" onclick="removeProduct(${product.id})" 
                                class="bg-red-500 hover:bg-red-700 text-white px-2 py-1 rounded text-xs">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `;

            $('#products_tbody').append(rowHtml);

            // Agregar event listeners para el nuevo producto
            $(`#product_row_${product.id} .quantity-input, #product_row_${product.id} .price-input`).on('input', calculateTotals);

            // Event listener para el checkbox de precio personalizado
            $(`#product_row_${product.id} .custom-price-checkbox`).on('change', function() {
                const priceInput = $(this).closest('tr').find('.price-input');
                if ($(this).is(':checked')) {
                    priceInput.prop('readonly', false);
                    priceInput.focus();
                } else {
                    priceInput.prop('readonly', true);
                    priceInput.val(product.precio_compra); // ← AQUÍ ESTÁ LA CORRECCIÓN
                    calculateTotals();
                }
            });

            productIndex++;
            calculateTotals();
            reproducirSonidoEscaner();
        }

        function removeProduct(productId) {
            $(`#product_row_${productId}`).remove();
            
            if ($('#products_tbody tr').length === 0) {
                $('#products_tbody').html(`
                    <tr id="no_products_row">
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                            <i class="bi bi-box-open text-4xl mb-2"></i>
                            <p>No hay productos agregados</p>
                        </td>
                    </tr>
                `);
            }
            
            calculateTotals();
        }

        function calculateTotals() {
            let subtotal = 0;
            
            $('#products_tbody tr:not(#no_products_row)').each(function() {
                const quantity = parseFloat($(this).find('.quantity-input').val()) || 0;
                const price = parseFloat($(this).find('.price-input').val()) || 0;
                const itemSubtotal = quantity * price;
                
                $(this).find('.subtotal-display').text(`S/. ${itemSubtotal.toFixed(2)}`);
                subtotal += itemSubtotal;
            });
            
            const incluirIgv = $('#incluir_igv').is(':checked');
            const igv = incluirIgv ? subtotal * 0.18 : 0;
            const total = subtotal + igv;
            
            $('#subtotal').val(subtotal.toFixed(2));
            $('#igv').val(igv.toFixed(2));
            $('#total_price').val(total.toFixed(2));
            updatePaymentMethodsAmounts(); // ← Cambiar el nombre de la función
        }

        // Función para distribuir el total entre todos los métodos de pago
        function updatePaymentMethodsAmounts() {
            const totalPrice = parseFloat($('#total_price').val()) || 0;
            const paymentAmountInputs = $('.payment-amount-input');
            
            if (paymentAmountInputs.length > 0 && totalPrice > 0) {
                // Si solo hay un método de pago, asignar todo el monto
                if (paymentAmountInputs.length === 1) {
                    paymentAmountInputs.first().val(totalPrice.toFixed(2));
                } else {
                    // Si hay múltiples métodos, distribuir equitativamente
                    const amountPerMethod = totalPrice / paymentAmountInputs.length;
                    paymentAmountInputs.each(function() {
                        $(this).val(amountPerMethod.toFixed(2));
                    });
                }
            }
        }

        // Modal de escaneo
        function openScanModal(productId, productName) {
            currentScanProduct = productId;
            scannedCodes = [];
            
            const row = $(`#product_row_${productId}`);
            const quantity = parseInt(row.find('.quantity-input').val());
            
            $('#scan_product_name').text(`Producto: ${productName}`);
            $('#scan_expected_quantity').text(quantity);
            $('#scan_total_needed').text(quantity);
            $('#scan_current_count').text('0');
            $('#codigosEscaneadosList').empty();
            $('#inputCodigoEscaneado').val('');
            
            $('#scanCodesModal').removeClass('hidden');
            
            setTimeout(() => {
                $('#inputCodigoEscaneado').focus();
            }, 100);
        }

        function closeScanModal() {
            $('#scanCodesModal').addClass('hidden');
            currentScanProduct = null;
            scannedCodes = [];
        }

        function addScannedCode() {
            const code = $('#inputCodigoEscaneado').val().trim();
            
            if (!code) {
                showAlert('Ingrese un código válido', 'error');
                return;
            }
            
            if (scannedCodes.includes(code)) {
                showAlert('Este código ya fue escaneado', 'error');
                $('#inputCodigoEscaneado').val('').focus();
                return;
            }
            
            scannedCodes.push(code);
            
            // Agregar a la lista visual
            const codeHtml = `<div class="flex justify-between items-center mb-1">
                <span>${scannedCodes.length}. ${code}</span>
                <button type="button" onclick="removeScannedCode('${code}')" class="text-red-400 hover:text-red-600">
                    <i class="bi bi-times"></i>
                </button>
            </div>`;
            $('#codigosEscaneadosList').append(codeHtml);
            
            // Actualizar contador
            $('#scan_current_count').text(scannedCodes.length);
            
            // Limpiar input y enfocar
            $('#inputCodigoEscaneado').val('').focus();
            
            // Reproducir sonido
            reproducirSonidoEscaner();
            
            // Auto-confirmar si se completaron todos los códigos
            const expectedQuantity = parseInt($('#scan_expected_quantity').text());
            if (scannedCodes.length === expectedQuantity) {
                setTimeout(confirmScannedCodes, 500);
            }
        }

        function removeScannedCode(code) {
            scannedCodes = scannedCodes.filter(c => c !== code);
            
            // Regenerar lista
            $('#codigosEscaneadosList').empty();
            scannedCodes.forEach((c, index) => {
                const codeHtml = `<div class="flex justify-between items-center mb-1">
                    <span>${index + 1}. ${c}</span>
                    <button type="button" onclick="removeScannedCode('${c}')" class="text-red-400 hover:text-red-600">
                        <i class="bi bi-times"></i>
                    </button>
                </div>`;
                $('#codigosEscaneadosList').append(codeHtml);
            });
            
            $('#scan_current_count').text(scannedCodes.length);
        }

        function confirmScannedCodes() {
            const expectedQuantity = parseInt($('#scan_expected_quantity').text());
            
            if (scannedCodes.length !== expectedQuantity) {
                showAlert(`Se requieren ${expectedQuantity} códigos, solo se escanearon ${scannedCodes.length}`, 'error');
                return;
            }
            
            // Guardar códigos en el input hidden
            const row = $(`#product_row_${currentScanProduct}`);
            row.find('.scanned-codes-input').val(JSON.stringify(scannedCodes));
            
            // Debug temporal
            console.log('Códigos guardados en input hidden:', JSON.stringify(scannedCodes));
            console.log('Valor del input:', row.find('.scanned-codes-input').val());

            // Actualizar botón
            const scanBtn = row.find('.scan-codes-btn');
            scanBtn.removeClass('bg-green-500 hover:bg-green-700').addClass('bg-blue-500 hover:bg-blue-700');
            scanBtn.html(`<i class="bi bi-check mr-1"></i>Escaneado (${scannedCodes.length})`);
            
            closeScanModal();
            showAlert('Códigos confirmados correctamente', 'success');
        }

        // Métodos de pago
        function toggleCreditFields() {
            const paymentType = $('#payment_type').val();
            $('.credit-fields').toggleClass('hidden', paymentType !== 'credit');
        }

        function addPaymentMethod() {
            const newMethodHtml = `
                <div class="payment-method-row grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                    <div>
                        <select name="payment_methods[${paymentMethodIndex}][payment_method_id]" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="">Seleccionar...</option>
                            @foreach($paymentMethods as $method)
                                <option value="{{ $method->id }}">{{ $method->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <input type="number" name="payment_methods[${paymentMethodIndex}][amount]" step="0.01" min="0" 
                            class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 payment-amount-input" required>
                    </div>
                    
                    <div class="credit-fields ${$('#payment_type').val() !== 'credit' ? 'hidden' : ''}">
                        <div class="flex">
                            <input type="number" name="payment_methods[${paymentMethodIndex}][installments]" min="1" 
                                   class="flex-1 rounded-l-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <button type="button" onclick="openInstallmentsModal(${paymentMethodIndex})" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-2 rounded-r-md text-xs">
                                <i class="bi bi-cog"></i>
                            </button>
                        </div>
                    </div>

                    
                    <div class="credit-fields ${$('#payment_type').val() !== 'credit' ? 'hidden' : ''}">
                        <input type="date" name="payment_methods[${paymentMethodIndex}][due_date]" 
                               class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    
                    <div class="md:col-span-4 text-right">
                        <button type="button" onclick="$(this).closest('.payment-method-row').remove(); updatePaymentMethodsAmounts();" 
                                class="text-red-600 hover:text-red-800 text-sm">
                            <i class="bi bi-trash mr-1"></i>Eliminar
                        </button>
                    </div>
                </div>
            `;
            
            $('#payment_methods_container').append(newMethodHtml);
            paymentMethodIndex++;
            updatePaymentMethodsAmounts();
        }

        // Envío del formulario
        function submitPurchase(e) {
            e.preventDefault();
            
            // Validar que hay productos
            if ($('#products_tbody tr:not(#no_products_row)').length === 0) {
                showAlert('Debe agregar al menos un producto', 'error');
                return;
            }
                        
            // Validar configuración de cuotas para pagos a crédito
            const paymentType = $('#payment_type').val();
            if (paymentType === 'credit') {
                let missingInstallmentsConfig = false;
                $('.payment-method-row').each(function() {
                    const installmentsInput = $(this).find('input[name*="[installments]"]');
                    const installments = parseInt(installmentsInput.val()) || 0;
                    const paymentIndex = $(this).index();
                    
                    // Validar que se haya ingresado número de cuotas
                    if (installments <= 0) {
                        missingInstallmentsConfig = true;
                        showAlert(`Debe ingresar el número de cuotas para el método de pago #${paymentIndex + 1}`, 'error');
                        installmentsInput.focus();
                        return false;
                    }
                    
                    // Si hay más de 1 cuota, validar que esté configurada
                    if (installments > 1) {
                        const installmentsConfig = $(`#payment_methods_container`).attr(`data-installments-${paymentIndex}`);
                        if (!installmentsConfig) {
                            missingInstallmentsConfig = true;
                            showAlert(`Debe configurar las cuotas para el método de pago #${paymentIndex + 1}`, 'error');
                            return false;
                        }
                    }
                });
                
                if (missingInstallmentsConfig) return;
            }

            const formData = new FormData(this);
            
            // Agregar códigos escaneados
            let productIndex = 0;
            $('#products_tbody tr:not(#no_products_row)').each(function() {
                const scannedCodesInput = $(this).find('.scanned-codes-input');
                const productId = $(this).find('input[name*="[product_id]"]').val();
                
                if (scannedCodesInput.val()) {
                    console.log(`Enviando códigos para producto ${productId}:`, scannedCodesInput.val());
                    formData.append(`products[${productIndex}][scanned_codes]`, scannedCodesInput.val());
                }
                productIndex++;
            });

            // Agregar configuraciones de cuotas si existen
            $('.payment-method-row').each(function(index) {
                const installmentsConfig = $(`#payment_methods_container`).attr(`data-installments-${index}`);
                if (installmentsConfig) {
                    formData.append(`installments_config[${index}]`, installmentsConfig);
                }
            });
            
            $.ajax({
                url: '{{ route("buy.store-purchase") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('button[type="submit"]').prop('disabled', true).html('<i class="bi bi-spinner fa-spin mr-2"></i>Guardando...');
                },
                success: function(response) {
                    if (response.success) {
                        showAlert(response.message, 'success');
                        setTimeout(() => {
                             window.location.href = '{{ route("buys.index") }}';
                        }, 2000);
                    }
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    showAlert(response?.message || 'Error al guardar la compra', 'error');
                },
                complete: function() {
                    $('button[type="submit"]').prop('disabled', false).html('<i class="bi bi-save mr-2"></i>Guardar Compra');
                }
            });
        }

        // Funciones auxiliares
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

                // Funciones para modal de cuotas
        function openInstallmentsModal(paymentMethodIndex) {
            const installments = parseInt($(`input[name="payment_methods[${paymentMethodIndex}][installments]"]`).val()) || 1;
            const amount = parseFloat($(`input[name="payment_methods[${paymentMethodIndex}][amount]"]`).val()) || 0;
            
            if (installments <= 1) {
                showAlert('Configure más de 1 cuota para usar esta función', 'warning');
                return;
            }
            
            generateInstallmentsConfiguration(installments, amount, paymentMethodIndex);
            $('#configureInstallmentsModal').removeClass('hidden');
        }

        function closeInstallmentsModal() {
            $('#configureInstallmentsModal').addClass('hidden');
        }

        function generateInstallmentsConfiguration(installments, totalAmount, paymentMethodIndex) {
            const installmentAmount = parseFloat((totalAmount / installments).toFixed(2)); // Redondear a 2 decimales
            const baseDate = new Date();
            
            let html = `
                <div class="mb-4 p-3 bg-blue-50 rounded">
                    <p class="font-medium">Monto total: S/. ${totalAmount.toFixed(2)}</p>
                    <p class="text-sm text-gray-600">Número de cuotas: ${installments}</p>
                    <p class="text-sm text-gray-600">Monto sugerido por cuota: S/. ${installmentAmount.toFixed(2)}</p>
                </div>
                
                <div class="mb-4 p-3 bg-green-50 rounded">
                    <p class="font-medium text-green-800">Suma actual: <span id="current-sum" class="font-bold">S/. 0.00</span></p>
                    <p class="text-sm text-green-600">Diferencia: <span id="difference" class="font-bold">S/. 0.00</span></p>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2">Cuota</th>
                                <th class="border border-gray-300 px-4 py-2">Monto</th>
                                <th class="border border-gray-300 px-4 py-2">Fecha Vencimiento</th>
                            </tr>
                        </thead>
                        <tbody>
                `;
            
            // Calcular montos para evitar problemas de redondeo
            let remainingAmount = totalAmount;
            let calculatedAmounts = [];
            
            for (let i = 1; i <= installments; i++) {
                let amount;
                if (i === installments) {
                    // La última cuota lleva el resto para evitar diferencias por redondeo
                    amount = remainingAmount;
                } else {
                    amount = installmentAmount;
                    remainingAmount -= amount;
                }
                calculatedAmounts.push(amount);
            }
            
            for (let i = 1; i <= installments; i++) {
                const dueDate = new Date(baseDate);
                dueDate.setMonth(dueDate.getMonth() + i);
                const dueDateString = dueDate.toISOString().split('T')[0];
                
                html += `
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center font-medium">${i}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <input type="number" step="0.01" min="0" 
                                class="installment-amount w-full rounded border-gray-300" 
                                value="${calculatedAmounts[i-1].toFixed(2)}" data-installment="${i}">
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            <input type="date" 
                                class="installment-date w-full rounded border-gray-300" 
                                value="${dueDateString}" data-installment="${i}">
                        </td>
                    </tr>
                `;
            }
            
            html += `
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4 p-3 bg-yellow-50 rounded">
                    <p class="text-sm text-yellow-800">
                        <i class="bi bi-info-circle mr-1"></i>
                        Puede modificar los montos y fechas según sus necesidades. 
                        La suma total debe coincidir con el monto del método de pago.
                    </p>
                </div>
            `;
            
            $('#installments_configuration').html(html);
            $('#installments_configuration').attr('data-payment-index', paymentMethodIndex);
            $('#installments_configuration').attr('data-expected-total', totalAmount.toFixed(2));
            
            // Agregar event listeners para actualizar la suma automáticamente
            $('.installment-amount').on('input', updateInstallmentsSum);
            
            // Calcular suma inicial
            updateInstallmentsSum();
        }

        // Función para actualizar la suma de las cuotas en tiempo real
        function updateInstallmentsSum() {
            const expectedTotal = parseFloat($('#installments_configuration').attr('data-expected-total')) || 0;
            let currentSum = 0;
            
            $('.installment-amount').each(function() {
                currentSum += parseFloat($(this).val()) || 0;
            });
            
            const difference = currentSum - expectedTotal;
            
            $('#current-sum').text(`S/. ${currentSum.toFixed(2)}`);
            $('#difference').text(`S/. ${difference.toFixed(2)}`);
            
            // Cambiar color según la diferencia
            if (Math.abs(difference) < 0.01) { // Considerando diferencias mínimas por redondeo
                $('#current-sum').parent().removeClass('bg-red-50 bg-yellow-50').addClass('bg-green-50');
                $('#current-sum').removeClass('text-red-800 text-yellow-800').addClass('text-green-800');
                $('#difference').removeClass('text-red-800 text-yellow-800').addClass('text-green-800');
            } else {
                $('#current-sum').parent().removeClass('bg-green-50 bg-yellow-50').addClass('bg-red-50');
                $('#current-sum').removeClass('text-green-800 text-yellow-800').addClass('text-red-800');
                $('#difference').removeClass('text-green-800 text-yellow-800').addClass('text-red-800');
            }
        }

        function confirmInstallments() {
            const paymentIndex = $('#installments_configuration').attr('data-payment-index');
            const installmentsData = [];
            let totalAmount = 0;
            
            $('.installment-amount').each(function() {
                const installmentNumber = $(this).data('installment');
                const amount = parseFloat($(this).val()) || 0;
                const date = $(`.installment-date[data-installment="${installmentNumber}"]`).val();
                
                installmentsData.push({
                    installment_number: installmentNumber,
                    amount: amount,
                    due_date: date
                });
                
                totalAmount += amount;
            });
            
            // Validar que la suma coincida (con tolerancia de 0.01 por redondeo)
            const expectedAmount = parseFloat($(`input[name="payment_methods[${paymentIndex}][amount]"]`).val()) || 0;
            if (Math.abs(totalAmount - expectedAmount) > 0.01) {
                showAlert(`La suma de las cuotas (S/. ${totalAmount.toFixed(2)}) no coincide con el monto del método de pago (S/. ${expectedAmount.toFixed(2)})`, 'error');
                return;
            }
            
            // Guardar configuración
            $(`#payment_methods_container`).attr(`data-installments-${paymentIndex}`, JSON.stringify(installmentsData));
            
            closeInstallmentsModal();
            showAlert('Configuración de cuotas guardada correctamente', 'success');
        }

        function showAlert(message, type = 'info') {
            const alertClass = {
                success: 'bg-green-100 border-green-400 text-green-700',
                error: 'bg-red-100 border-red-400 text-red-700',
                warning: 'bg-yellow-100 border-yellow-400 text-yellow-700',
                info: 'bg-blue-100 border-blue-400 text-blue-700'
            };
            
            const alert = $(`
                <div class="fixed top-4 right-4 z-50 ${alertClass[type]} px-4 py-3 rounded border" role="alert">
                    <span class="block sm:inline">${message}</span>
                </div>
            `);
            
            $('body').append(alert);
            
            setTimeout(() => {
                alert.fadeOut(() => alert.remove());
            }, 5000);
        }

        // Reproducir sonido de escáner
        function reproducirSonidoEscaner() {
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            
            setTimeout(() => {
                const inputEdit = $('#inputCodigoEscaneado');
                if (inputEdit.length) {
                    inputEdit.prop('readonly', false);
                    inputEdit.prop('disabled', false);
                    inputEdit.removeAttr('readonly');
                    inputEdit.removeAttr('disabled');
                    inputEdit.focus();
                }
            }, 100);
            
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);

            oscillator.frequency.value = 800;
            oscillator.type = "square";

            gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.1);

            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.1);
        }
    </script>

    <style>
        /* Estilos adicionales para el módulo de compras */
        .search-result-item:hover {
            background-color: #eff6ff;
            border-left: 4px solid #3b82f6;
        }

        .scan-codes-btn {
            transition: all 0.3s ease;
        }

        .scan-codes-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .custom-price-checkbox:checked + label {
            color: #059669;
            font-weight: 600;
        }

        .payment-method-row {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            background-color: #f9fafb;
        }

        .payment-method-row:hover {
            background-color: #f3f4f6;
        }

        /* Animación para las alertas */
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .fixed.top-4.right-4 {
            animation: slideInRight 0.3s ease-out;
        }

        /* Efecto de código escaneado */
        #codigosEscaneadosList {
            background: linear-gradient(45deg, #000000, #1a1a1a);
            border: 1px solid #22c55e;
            box-shadow: 0 0 10px rgba(34, 197, 94, 0.3);
        }

        #codigosEscaneadosList div {
            border-bottom: 1px solid #22c55e;
            padding: 0.25rem 0;
        }

        #codigosEscaneadosList div:last-child {
            border-bottom: none;
        }

        /* Estilo para input de búsqueda activo */
        #product_search:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            border-color: #3b82f6;
        }

        /* Estilo para productos con códigos únicos */
        .codigo-unico-badge {
            background-color: #fef3c7;
            color: #92400e;
            padding: 0.125rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* Transición suave para los modales */
        .modal-transition {
            transition: opacity 0.3s ease-in-out;
        }

        /* Estilo para el contador de códigos escaneados */
        .scan-counter {
            background: linear-gradient(45deg, #10b981, #059669);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: bold;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        /* Efecto hover para botones de acción */
        .action-button {
            transition: all 0.2s ease;
        }

        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Estilo para filas de productos */
        #products_tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Indicador visual para campos obligatorios */
        .required-field label::after {
            content: " *";
            color: #ef4444;
        }

        /* Estilo para inputs con error */
        .input-error {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
        }

        /* Loader personalizado */
        .custom-loader {
            border: 2px solid #f3f3f3;
            border-top: 2px solid #3b82f6;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            display: inline-block;
            margin-right: 0.5rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsividad mejorada */
        @media (max-width: 768px) {
            .grid.grid-cols-1.md\\:grid-cols-2,
            .grid.grid-cols-1.md\\:grid-cols-4 {
                grid-template-columns: 1fr;
            }
            
            .scan-codes-btn {
                margin-top: 0.5rem;
                margin-left: 0;
                display: block;
                width: 100%;
            }
            
            #scanCodesModal .relative {
                width: 95%;
                margin: 1rem auto;
            }
        }

        /* Estilo para el badge de estado de entrega */
        .delivery-status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .delivery-received {
            background-color: #d1fae5;
            color: #065f46;
        }

        .delivery-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        /* Animación para el sonido del escáner */
        @keyframes pulse-green {
            0% {
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(34, 197, 94, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0);
            }
        }

        .scanner-pulse {
            animation: pulse-green 0.6s ease-out;
        }

        /* === MEJORAS VISUALES PARA EL MÓDULO DE COMPRAS === */

        /* Mejoras para las cards principales */
        .bg-blue-50 {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border: 1px solid #bfdbfe;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.1);
        }

        .bg-green-50 {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border: 1px solid #bbf7d0;
            box-shadow: 0 4px 6px -1px rgba(34, 197, 94, 0.1);
        }

        .bg-gray-50 {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px -1px rgba(107, 114, 128, 0.1);
        }

        .bg-yellow-50 {
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            border: 1px solid #fde68a;
            box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.1);
        }

        /* Efectos hover para las cards */
        .bg-blue-50:hover, .bg-green-50:hover, .bg-gray-50:hover, .bg-yellow-50:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        /* Mejoras para los títulos de sección */
        .text-blue-800, .text-green-800, .text-gray-800, .text-yellow-800 {
            font-weight: 700;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .text-blue-800 {
            background: linear-gradient(45deg, #1e40af, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .text-green-800 {
            background: linear-gradient(45deg, #166534, #16a34a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .text-yellow-800 {
            background: linear-gradient(45deg, #92400e, #d97706);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Mejoras para inputs y selects */
        .rounded-md.border-gray-300 {
            border: 2px solid #e5e7eb;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }

        /* NUEVO: Padding específico solo para inputs de cantidad y precio en la tabla de productos */
        #products_tbody .quantity-input, 
        #products_tbody .price-input {
            padding-left: 12px !important;
            padding-right: 8px !important;
            text-align: left;
        }

        /* NUEVO: Padding solo para los campos de totales en la sección de totales */
        .bg-gray-100.p-4.rounded-lg #subtotal,
        .bg-gray-100.p-4.rounded-lg #igv,
        .bg-gray-100.p-4.rounded-lg #total_price {
            padding-left: 16px !important;
            padding-right: 12px !important;
            text-align: left;
        }

        /* NUEVO: Padding solo para campos de monto en la sección de métodos de pago */
        #payment_methods_container input[name*="[amount]"] {
            padding-left: 12px !important;
            padding-right: 8px !important;
            text-align: left;
        }

        .rounded-md.border-gray-300:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-1px);
        }

        /* Mejoras para botones */
        .bg-blue-500 {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            box-shadow: 0 4px 14px 0 rgba(59, 130, 246, 0.39);
            transition: all 0.3s ease;
        }

        .bg-blue-500:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
            transform: translateY(-2px);
        }

        .bg-green-500 {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 4px 14px 0 rgba(16, 185, 129, 0.39);
        }

        .bg-green-500:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
            transform: translateY(-2px);
        }

        /* Mejoras para la tabla de productos */
        .bg-white.border.rounded-lg {
            border: 2px solid #f1f5f9;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-radius: 16px;
            overflow: hidden;
        }

        .bg-gray-100 {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-bottom: 2px solid #e2e8f0;
        }

        .bg-gray-50 thead th {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 16px;
        }

        /* Mejoras para el campo de búsqueda */
        .relative input[type="text"] {
            padding-left: 48px;
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .relative input[type="text"]:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            background: rgba(255, 255, 255, 1);
        }


        .relative input[type="text"]:focus + .absolute .fa-search {
            color: #3b82f6;
        }

        /* Mejoras para resultados de búsqueda */
        #search_results {
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.95);
        }

        .search-result-item {
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
        }

        .search-result-item:hover {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border-left-color: #3b82f6;
            transform: translateX(4px);
        }

        /* Mejoras para botones de acción */
        .bg-red-500 {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            box-shadow: 0 4px 14px 0 rgba(239, 68, 68, 0.39);
        }

        .bg-red-500:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
            transform: translateY(-2px);
        }

        /* Mejoras para el área de totales */
        .bg-gray-100.p-4.rounded-lg {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);
        }

        /* Mejoras para inputs readonly */
        input[readonly] {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 2px solid #e2e8f0;
            color: #374151;
            font-weight: 600;
        }

        /* Padding mínimo para el input del modal de escaneo */
        #inputCodigoEscaneado {
            padding-left: 8px !important;
        }

        /* Mejoras para modales */
        .fixed.inset-0.bg-gray-600 {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
        }

        .relative.top-20.mx-auto.p-5.border.shadow-lg.rounded-md.bg-white,
        .relative.top-10.mx-auto.p-5.border.shadow-lg.rounded-md.bg-white {
            border-radius: 20px;
            border: 2px solid #e5e7eb;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
        }

        /* Animaciones mejoradas */
        .bg-blue-50, .bg-green-50, .bg-gray-50, .bg-yellow-50,
        .rounded-md.border-gray-300, button, .search-result-item {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Mejoras para el estado hover de filas de tabla */
        #products_tbody tr:hover {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            transform: scale(1.01);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        /* Efectos de profundidad para elementos interactivos */
        .scan-codes-btn, .action-button {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .scan-codes-btn:hover, .action-button:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            transform: translateY(-3px);
        }

        /* Mejoras para el texto de ayuda */
        small.text-gray-500 {
            color: #6b7280;
            font-style: italic;
            font-weight: 500;
        }
        </style>
</x-app-layout>