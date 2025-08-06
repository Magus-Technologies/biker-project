<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Detallado de Compras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 15px;
            line-height: 1.2;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        .report-title {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
        }
        .report-date {
            font-size: 9px;
            color: #999;
        }
        
        /* Sección de resumen */
        .summary-section {
            margin-bottom: 20px;
            background-color: #f8f9fa;
            padding: 12px;
            border-radius: 4px;
        }
        .summary-title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
            text-align: center;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 10px;
            margin-bottom: 10px;
        }
        .summary-item {
            text-align: center;
            padding: 8px;
            background: white;
            border-radius: 3px;
        }
        .summary-value {
            font-size: 14px;
            font-weight: bold;
            color: #2563eb;
        }
        .summary-label {
            font-size: 8px;
            color: #666;
            margin-top: 2px;
        }
        
        /* Tablas */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 20px;
        }
        .table th {
            background-color: #e5e7eb;
            border: 1px solid #d1d5db;
            padding: 6px 4px;
            text-align: left;
            font-weight: bold;
            font-size: 9px;
        }
        .table td {
            border: 1px solid #d1d5db;
            padding: 4px;
            font-size: 8px;
            vertical-align: top;
        }
        .table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .table tr:nth-child(odd) {
            background-color: white;
        }
        
        /* Estados */
        .status-received {
            background-color: #dcfce7;
            color: #166534;
            padding: 1px 4px;
            border-radius: 3px;
            font-size: 7px;
            font-weight: bold;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
            padding: 1px 4px;
            border-radius: 3px;
            font-size: 7px;
            font-weight: bold;
        }
        .payment-cash {
            background-color: #d1fae5;
            color: #065f46;
            padding: 1px 4px;
            border-radius: 3px;
            font-size: 7px;
        }
        .payment-credit {
            background-color: #dbeafe;
            color: #1e40af;
            padding: 1px 4px;
            border-radius: 3px;
            font-size: 7px;
        }
        
        /* Utilidades */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-small { font-size: 7px; }
        .font-bold { font-weight: bold; }
        .page-break { page-break-before: always; }
        
        /* Secciones */
        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #333;
            margin: 20px 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
        }
        
        /* Footer */
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #d1d5db;
            text-align: center;
            font-size: 8px;
            color: #666;
        }
        
        /* Estadísticas específicas */
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }
        .stats-table {
            width: 100%;
            border-collapse: collapse;
        }
        .stats-table th {
            background-color: #374151;
            color: white;
            padding: 6px;
            font-size: 9px;
            text-align: left;
        }
        .stats-table td {
            padding: 4px 6px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 8px;
        }
        .stats-table tr:nth-child(even) {
            background-color: #f9fafb;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="company-name">SISTEMA DE COMPRAS - REPORTE DETALLADO</div>
        <div class="report-title">Análisis Completo de Compras por Período</div>
        <div class="report-date">Generado el: {{ date('d/m/Y H:i:s') }}</div>
    </div>

    <!-- Resumen General -->
    <div class="summary-section">
        <div class="summary-title"> RESUMEN EJECUTIVO</div>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-value">{{ $totalCompras }}</div>
                <div class="summary-label">Total de Compras</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">S/ {{ number_format($montoTotal, 2) }}</div>
                <div class="summary-label">Monto Total</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">S/ {{ number_format($igvTotal, 2) }}</div>
                <div class="summary-label">IGV Total</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ $comprasRecibidas }}</div>
                <div class="summary-label">Productos Recibidos</div>
            </div>
        </div>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-value">{{ $comprasPendientes }}</div>
                <div class="summary-label">Productos Pendientes</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ count($estadisticasProveedores) }}</div>
                <div class="summary-label">Proveedores Activos</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ count($estadisticasTiendas) }}</div>
                <div class="summary-label">Tiendas Involucradas</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">S/ {{ $montoTotal > 0 ? number_format($montoTotal / $totalCompras, 2) : '0.00' }}</div>
                <div class="summary-label">Promedio por Compra</div>
            </div>
        </div>
    </div>

    <!-- Estadísticas por Proveedor y Tienda -->
    <div class="stats-grid">
        <div>
            <div class="section-title">TOP PROVEEDORES</div>
            <table class="stats-table">
                <thead>
                    <tr>
                        <th>Proveedor</th>
                        <th class="text-center">Compras</th>
                        <th class="text-right">Monto Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(array_slice($estadisticasProveedores, 0, 8) as $stat)
                    <tr>
                        <td>{{ Str::limit($stat['proveedor'], 25) }}</td>
                        <td class="text-center">{{ $stat['total_compras'] }}</td>
                        <td class="text-right">S/ {{ number_format($stat['monto_total'], 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div>
            <div class="section-title">COMPRAS POR TIENDA</div>
            <table class="stats-table">
                <thead>
                    <tr>
                        <th>Tienda</th>
                        <th class="text-center">Compras</th>
                        <th class="text-right">Monto Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($estadisticasTiendas as $stat)
                    <tr>
                        <td>{{ $stat['tienda'] }}</td>
                        <td class="text-center">{{ $stat['total_compras'] }}</td>
                        <td class="text-right">S/ {{ number_format($stat['monto_total'], 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Productos Más Comprados -->
    <div class="section-title">TOP 15 PRODUCTOS MÁS COMPRADOS</div>
    <table class="table">
        <thead>
            <tr>
                <th style="width: 8%">#</th>
                <th style="width: 15%">SKU</th>
                <th style="width: 40%">Producto</th>
                <th style="width: 12%" class="text-center">Cant. Total</th>
                <th style="width: 12%" class="text-right">Monto Total</th>
                <th style="width: 13%" class="text-center">Compras</th>
            </tr>
        </thead>
        <tbody>
            @foreach(array_slice($productosComprados, 0, 15, true) as $index => $producto)
            <tr>
                <td class="text-center font-bold">{{ $index + 1 }}</td>
                <td>{{ $producto['sku'] }}</td>
                <td>{{ Str::limit($producto['producto'], 45) }}</td>
                <td class="text-center font-bold">{{ number_format($producto['cantidad_total']) }}</td>
                <td class="text-right font-bold">S/ {{ number_format($producto['monto_total'], 2) }}</td>
                <td class="text-center">{{ $producto['compras_count'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="page-break"></div>

    <!-- Detalle de Compras -->
    <div class="section-title">DETALLE COMPLETO DE COMPRAS</div>
    <table class="table">
        <thead>
            <tr>
                <th style="width: 8%">Serie/Núm.</th>
                <th style="width: 20%">Proveedor</th>
                <th style="width: 10%">Fecha</th>
                <th style="width: 8%">Doc.</th>
                <th style="width: 10%" class="text-right">Total</th>
                <th style="width: 8%">Pago</th>
                <th style="width: 10%">Estado</th>
                <th style="width: 12%">Tienda</th>
                <th style="width: 12%">Usuario</th>
                <th style="width: 2%">Items</th>
            </tr>
        </thead>
        <tbody>
            @foreach($compras as $compra)
            <tr>
                <td class="font-bold">{{ $compra->serie }}-{{ $compra->number }}</td>
                <td>{{ $compra->supplier ? Str::limit($compra->supplier->nombre_negocio, 20) : 'Sin Proveedor' }}</td>
                <td>{{ date('d/m/Y', strtotime($compra->fecha_registro)) }}</td>
                <td class="text-small">{{ $compra->documentType ? Str::limit($compra->documentType->name, 8) : 'N/A' }}</td>
                <td class="text-right font-bold">S/ {{ number_format($compra->total_price, 2) }}</td>
                <td>
                    <span class="{{ $compra->payment_type === 'cash' ? 'payment-cash' : 'payment-credit' }}">
                        {{ $compra->payment_type === 'cash' ? 'Contado' : 'Crédito' }}
                    </span>
                </td>
                <td>
                    <span class="{{ $compra->delivery_status === 'received' ? 'status-received' : 'status-pending' }}">
                        {{ $compra->delivery_status === 'received' ? 'Recibidos' : 'Pendientes' }}
                    </span>
                </td>
                <td>{{ $compra->tienda ? Str::limit($compra->tienda->nombre, 12) : 'N/A' }}</td>
                <td>{{ $compra->userRegister ? Str::limit($compra->userRegister->name, 12) : 'N/A' }}</td>
                <td class="text-center font-bold">{{ $compra->buyItems->count() }}</td>
            </tr>
            
            <!-- Detalle de productos para cada compra -->
            @if($compra->buyItems->count() > 0)
            <tr>
                <td colspan="10" style="padding: 0; border: none;">
                    <table style="width: 100%; margin: 5px 0; background-color: #f8f9fa;">
                        <thead>
                            <tr style="background-color: #e5e7eb;">
                                <th style="padding: 3px 6px; font-size: 7px; width: 15%;">SKU</th>
                                <th style="padding: 3px 6px; font-size: 7px; width: 35%;">Producto</th>
                                <th style="padding: 3px 6px; font-size: 7px; width: 8%; text-align: center;">Cant.</th>
                                <th style="padding: 3px 6px; font-size: 7px; width: 12%; text-align: right;">P. Unit.</th>
                                <th style="padding: 3px 6px; font-size: 7px; width: 12%; text-align: right;">Subtotal</th>
                                <th style="padding: 3px 6px; font-size: 7px; width: 18%;">Códigos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($compra->buyItems as $item)
                            <tr>
                                <td style="padding: 2px 6px; font-size: 7px;">{{ $item->product ? $item->product->code_sku : 'N/A' }}</td>
                                <td style="padding: 2px 6px; font-size: 7px;">{{ $item->product ? Str::limit($item->product->description, 35) : 'N/A' }}</td>
                                <td style="padding: 2px 6px; font-size: 7px; text-align: center;">{{ number_format($item->quantity) }}</td>
                                <td style="padding: 2px 6px; font-size: 7px; text-align: right;">S/ {{ number_format($item->price, 2) }}</td>
                                <td style="padding: 2px 6px; font-size: 7px; text-align: right; font-weight: bold;">S/ {{ number_format($item->quantity * $item->price, 2) }}</td>
                                <td style="padding: 2px 6px; font-size: 6px;">
                                    @if($item->scanned_codes && is_array($item->scanned_codes) && count($item->scanned_codes) > 0)
                                        {{ count($item->scanned_codes) }} códigos
                                    @else
                                        Sin códigos
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
            @endif
            
            <!-- Métodos de pago para cada compra -->
            @if($compra->paymentMethods->count() > 0)
            <tr>
                <td colspan="10" style="padding: 0; border: none;">
                    <table style="width: 100%; margin: 2px 0; background-color: #fef3c7;">
                        <thead>
                            <tr style="background-color: #f59e0b; color: white;">
                                <th style="padding: 2px 6px; font-size: 7px; width: 25%;">Método de Pago</th>
                                <th style="padding: 2px 6px; font-size: 7px; width: 15%; text-align: right;">Monto</th>
                                <th style="padding: 2px 6px; font-size: 7px; width: 10%; text-align: center;">Cuotas</th>
                                <th style="padding: 2px 6px; font-size: 7px; width: 15%;">Vencimiento</th>
                                <th style="padding: 2px 6px; font-size: 7px; width: 35%;">Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($compra->paymentMethods as $payment)
                            <tr>
                                <td style="padding: 2px 6px; font-size: 7px;">{{ $payment->paymentMethod ? $payment->paymentMethod->name : 'N/A' }}</td>
                                <td style="padding: 2px 6px; font-size: 7px; text-align: right;">S/ {{ number_format($payment->amount, 2) }}</td>
                                <td style="padding: 2px 6px; font-size: 7px; text-align: center;">{{ $payment->installments }}</td>
                                <td style="padding: 2px 6px; font-size: 7px;">{{ $payment->due_date ? date('d/m/Y', strtotime($payment->due_date)) : 'N/A' }}</td>
                                <td style="padding: 2px 6px; font-size: 7px;">{{ $compra->observation ?? 'Sin observaciones' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
            @endif
            
            <!-- Espaciador entre compras -->
            <tr style="height: 8px;">
                <td colspan="10" style="border: none; padding: 0; background-color: white;"></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer del reporte -->
    <div class="footer">
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-top: 20px;">
            <div style="text-align: left;">
                <strong>Filtros Aplicados:</strong><br>
                @if(request('fecha_desde'))
                    Desde: {{ date('d/m/Y', strtotime(request('fecha_desde'))) }}<br>
                @endif
                @if(request('fecha_hasta'))
                    Hasta: {{ date('d/m/Y', strtotime(request('fecha_hasta'))) }}<br>
                @endif
                @if(request('supplier_id'))
                    Proveedor filtrado<br>
                @endif
                @if(request('products_status'))
                    Estado: {{ request('products_status') }}<br>
                @endif
            </div>
            
            <div style="text-align: center;">
                <strong>Resumen Final:</strong><br>
                Total Facturado: S/ {{ number_format($montoTotal, 2) }}<br>
                Compras Procesadas: {{ $totalCompras }}<br>
                Efectividad de Recepción: {{ $totalCompras > 0 ? number_format(($comprasRecibidas / $totalCompras) * 100, 1) : 0 }}%
            </div>
            
            <div style="text-align: right;">
                <strong>Sistema de Compras</strong><br>
                Reporte generado automáticamente<br>
                {{ date('d/m/Y H:i:s') }}<br>
                Usuario: {{ auth()->user()->name ?? 'Sistema' }}
            </div>
        </div>
        
        <div style="margin-top: 15px; padding-top: 10px; border-top: 1px solid #ddd; text-align: center;">
            <em>Este reporte contiene información confidencial de la empresa. Distribución restringida.</em>
        </div>
    </div>

</body>
</html>