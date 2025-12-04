@props([
    'tabId' => '',
    'paymentsType' => [],
    'paymentsMethod' => [],
    'documentTypes' => []
])

<!-- Detalle del Pedido / Documento -->
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-lg font-bold mb-4">Documento</h2>
    
    <!-- Tipo pago -->
    <div>
        <label class="font-bold">Tipo pago <span class="text-red-500">*</span></label>
        <select id="paymentType{{ $tabId }}" class="w-full p-2 border rounded">
            <option value="">Seleccione</option>
            @foreach ($paymentsType as $payment)
                <option value="{{ $payment->id }}">{{ $payment->name }}</option>
            @endforeach
        </select>
    </div>
    
    <!-- Campos de crédito (ocultos por defecto) -->
    <div id="creditFields{{ $tabId }}" class="mt-3 hidden">
        <label for="nro_dias{{ $tabId }}">Número de días:</label>
        <input type="number" id="nro_dias{{ $tabId }}" class="w-full p-2 border rounded" min="1">
        <label for="fecha_vencimiento{{ $tabId }}" class="mt-2">Fecha de vencimiento:</label>
        <input type="date" id="fecha_vencimiento{{ $tabId }}" class="w-full p-2 border rounded">
    </div>
    
    <!-- Método pago 1 -->
    <div class="mt-3" id="paymentMethodContainer1{{ $tabId }}">
        <label class="font-bold">Método pago <span class="text-red-500">*</span></label>
        <select id="paymentMethod1{{ $tabId }}" class="w-full p-2 border rounded">
            <option value="">Seleccione</option>
            @foreach ($paymentsMethod as $payment)
                <option value="{{ $payment->id }}">{{ $payment->name }}</option>
            @endforeach
        </select>
    </div>
    
    <!-- Checkbox para segundo método de pago -->
    <div class="mt-2" id="paymentMethodContainer2{{ $tabId }}">
        <input type="checkbox" id="togglePaymentFields{{ $tabId }}" class="mr-2">
        <label for="togglePaymentFields{{ $tabId }}">Agregar método de pago y monto</label>
    </div>
    
    <!-- Campos de segundo método de pago (ocultos por defecto) -->
    <div id="paymentFieldsContainer{{ $tabId }}" class="mt-2 hidden">
        <div>
            <label class="font-bold">Método de pago</label>
            <select id="paymentMethod2{{ $tabId }}" class="w-full p-2 border rounded">
                <option value="">Seleccione</option>
                @foreach ($paymentsMethod as $payment)
                    <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mt-2">
            <label class="font-bold">Monto a pagar</label>
            <input type="number" id="paymentAmount2{{ $tabId }}" class="w-full p-2 border rounded" placeholder="Ingrese el monto">
        </div>
    </div>
    
    <!-- Tipo de documento -->
    <div class="mt-3">
        <label class="font-bold">Tipo de documento <span class="text-red-500">*</span></label>
        <select id="documentType{{ $tabId }}" class="w-full p-2 border rounded">
            <option value="">Seleccione</option>
            @foreach ($documentTypes as $documentType)
                <option value="{{ $documentType->id }}">{{ $documentType->name }}</option>
            @endforeach
        </select>
    </div>
    
    <!-- Fecha -->
    <div class="mt-3">
        <label class="font-bold">Fecha</label>
        <input type="date" id="orderDate{{ $tabId }}" value="{{ date('Y-m-d') }}" class="w-full p-2 border rounded">
    </div>
    
    <!-- Moneda -->
    <div class="mt-3">
        <label class="font-bold">Moneda</label>
        <input type="text" id="orderCurrency{{ $tabId }}" value="SOLES" class="w-full p-2 border rounded" readonly>
    </div>
    
    <!-- Resumen de totales -->
    <div class="mt-4 space-y-2">
        <div class="bg-gray-200 text-gray-800 p-2 rounded text-center text-sm font-bold">
            Subtotal: <span id="subtotalAmount{{ $tabId }}">S/ 0.00</span>
        </div>
        <div class="bg-gray-200 text-gray-800 p-2 rounded text-center text-sm font-bold">
            IGV (18%): <span id="igvAmount{{ $tabId }}">S/ 0.00</span>
        </div>
        <div class="bg-indigo-500 text-white p-2 rounded text-center text-sm font-bold" id="totalAmount{{ $tabId }}">
            S/ 0.00
        </div>
    </div>
</div>
