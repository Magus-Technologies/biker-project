<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Caja {{ $caja->codigo }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 10px;
        }
        .container {
            width: 100%;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #333;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 18px;
            color: #666;
        }
        .header p {
            margin: 3px 0;
            font-size: 11px;
            color: #888;
        }
        .info-section {
            width: 100%;
            margin-bottom: 15px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .info-table td {
            padding: 6px;
            border: 1px solid #ddd;
            font-size: 10px;
        }
        .info-table td.label {
            background-color: #f5f5f5;
            font-weight: bold;
            width: 25%;
        }
        .section-title {
            background-color: #333;
            color: white;
            padding: 8px;
            font-weight: bold;
            font-size: 12px;
            margin-top: 15px;
            margin-bottom: 10px;
        }
        .summary-grid {
            width: 100%;
            margin-bottom: 15px;
        }
        .summary-box {
            display: inline-block;
            width: 23%;
            padding: 8px;
            margin: 5px 1%;
            border: 1px solid #ddd;
            text-align: center;
            vertical-align: top;
        }
        .summary-box.efectivo { border-left: 4px solid #10b981; }
        .summary-box.tarjeta { border-left: 4px solid #8b5cf6; }
        .summary-box.transferencia { border-left: 4px solid #6366f1; }
        .summary-box.otros { border-left: 4px solid #3b82f6; }
        .summary-box.gastos { border-left: 4px solid #f97316; }
        .summary-box.retiros { border-left: 4px solid #ef4444; }
        .summary-box.depositos { border-left: 4px solid #14b8a6; }
        .summary-box .label {
            font-size: 9px;
            color: #666;
            margin-bottom: 3px;
        }
        .summary-box .amount {
            font-size: 14px;
            font-weight: bold;
        }
        .movements-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 9px;
        }
        .movements-table th {
            background-color: #f5f5f5;
            padding: 6px;
            border: 1px solid #ddd;
            font-weight: bold;
            text-align: left;
        }
        .movements-table td {
            padding: 5px;
            border: 1px solid #ddd;
        }
        .movements-table tr:nth-child(even) {
            background-color: #fafafa;
        }
        .calculation-box {
            width: 60%;
            margin: 20px auto;
            border: 2px solid #333;
            padding: 15px;
            background-color: #f9f9f9;
        }
        .calculation-row {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }
        .calculation-row .label {
            display: table-cell;
            width: 70%;
            padding: 5px;
        }
        .calculation-row .value {
            display: table-cell;
            width: 30%;
            text-align: right;
            padding: 5px;
            font-weight: bold;
        }
        .calculation-row.total {
            border-top: 2px solid #333;
            padding-top: 10px;
            margin-top: 10px;
            font-size: 12px;
        }
        .calculation-row.final {
            background-color: #e5e7eb;
            padding: 8px 5px;
            font-size: 13px;
        }
        .diferencia-box {
            text-align: center;
            padding: 15px;
            margin: 20px 0;
            border: 2px solid #333;
            font-size: 14px;
        }
        .diferencia-box.positivo { background-color: #dbeafe; border-color: #3b82f6; }
        .diferencia-box.negativo { background-color: #fee2e2; border-color: #ef4444; }
        .diferencia-box.cuadrado { background-color: #d1fae5; border-color: #10b981; }
        .signatures {
            width: 100%;
            margin-top: 40px;
        }
        .signature-box {
            display: inline-block;
            width: 45%;
            text-align: center;
            margin: 0 2%;
            vertical-align: top;
        }
        .signature-line {
            border-top: 2px solid #333;
            margin-top: 50px;
            padding-top: 8px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 9px;
            color: #888;
        }
        .text-green { color: #10b981; }
        .text-red { color: #ef4444; }
        .text-blue { color: #3b82f6; }
        .text-orange { color: #f97316; }
        .text-purple { color: #8b5cf6; }
        .text-teal { color: #14b8a6; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Encabezado -->
        <div class="header">
            <h1>REPORTE DE CAJA</h1>
            <h2>{{ $caja->codigo }}</h2>
            <p>{{ $caja->tienda->nombre ?? 'Sin tienda asignada' }}</p>
            <p>Generado el {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>

        <!-- Información General -->
        <table class="info-table">
            <tr>
                <td class="label">Usuario Apertura:</td>
                <td>{{ $caja->usuario->name }}</td>
                <td class="label">Usuario Cierre:</td>
                <td>{{ $caja->usuarioCierre->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Fecha Apertura:</td>
                <td>{{ $caja->fecha_apertura->format('d/m/Y H:i:s') }}</td>
                <td class="label">Fecha Cierre:</td>
                <td>{{ $caja->fecha_cierre ? $caja->fecha_cierre->format('d/m/Y H:i:s') : 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Monto Inicial:</td>
                <td>S/ {{ number_format($caja->monto_inicial, 2) }}</td>
                <td class="label">Estado:</td>
                <td><strong>{{ strtoupper($caja->estado) }}</strong></td>
            </tr>
        </table>

        @if($caja->observaciones_apertura)
        <table class="info-table">
            <tr>
                <td class="label">Observaciones Apertura:</td>
                <td colspan="3">{{ $caja->observaciones_apertura }}</td>
            </tr>
        </table>
        @endif

        @if($caja->observaciones_cierre)
        <table class="info-table">
            <tr>
                <td class="label">Observaciones Cierre:</td>
                <td colspan="3">{{ $caja->observaciones_cierre }}</td>
            </tr>
        </table>
        @endif

        <!-- Resumen de Ventas -->
        <div class="section-title">RESUMEN DE VENTAS POR MÉTODO DE PAGO</div>
        <div class="summary-grid">
            <div class="summary-box efectivo">
                <div class="label">Efectivo</div>
                <div class="amount text-green">S/ {{ number_format($caja->monto_ventas_efectivo, 2) }}</div>
            </div>
            <div class="summary-box tarjeta">
                <div class="label">Tarjeta</div>
                <div class="amount text-purple">S/ {{ number_format($caja->monto_ventas_tarjeta, 2) }}</div>
            </div>
            <div class="summary-box transferencia">
                <div class="label">Transferencia</div>
                <div class="amount text-blue">S/ {{ number_format($caja->monto_ventas_transferencia, 2) }}</div>
            </div>
            <div class="summary-box otros">
                <div class="label">Otros</div>
                <div class="amount text-blue">S/ {{ number_format($caja->monto_ventas_otros, 2) }}</div>
            </div>
        </div>

        <table class="info-table">
            <tr>
                <td class="label" style="text-align: right; font-size: 12px;">TOTAL VENTAS:</td>
                <td style="text-align: right; font-size: 14px; font-weight: bold;">S/ {{ number_format($caja->total_ventas, 2) }}</td>
            </tr>
        </table>

        <!-- Otros Movimientos -->
        <div class="section-title">OTROS MOVIMIENTOS</div>
        <div class="summary-grid">
            <div class="summary-box gastos">
                <div class="label">Gastos</div>
                <div class="amount text-orange">- S/ {{ number_format($caja->monto_gastos, 2) }}</div>
            </div>
            <div class="summary-box retiros">
                <div class="label">Retiros</div>
                <div class="amount text-red">- S/ {{ number_format($caja->monto_retiros, 2) }}</div>
            </div>
            <div class="summary-box depositos">
                <div class="label">Depósitos</div>
                <div class="amount text-teal">+ S/ {{ number_format($caja->monto_depositos, 2) }}</div>
            </div>
        </div>

        <!-- Cálculo Final -->
        <div class="section-title">CÁLCULO FINAL</div>
        <div class="calculation-box">
            <div class="calculation-row">
                <div class="label">Monto Inicial:</div>
                <div class="value">S/ {{ number_format($caja->monto_inicial, 2) }}</div>
            </div>
            <div class="calculation-row">
                <div class="label">+ Ventas en Efectivo:</div>
                <div class="value text-green">S/ {{ number_format($caja->monto_ventas_efectivo, 2) }}</div>
            </div>
            <div class="calculation-row">
                <div class="label">+ Depósitos:</div>
                <div class="value text-green">S/ {{ number_format($caja->monto_depositos, 2) }}</div>
            </div>
            <div class="calculation-row">
                <div class="label">- Gastos:</div>
                <div class="value text-red">S/ {{ number_format($caja->monto_gastos, 2) }}</div>
            </div>
            <div class="calculation-row">
                <div class="label">- Retiros:</div>
                <div class="value text-red">S/ {{ number_format($caja->monto_retiros, 2) }}</div>
            </div>
            <div class="calculation-row total final">
                <div class="label">MONTO FINAL ESPERADO:</div>
                <div class="value text-blue">S/ {{ number_format($caja->monto_final_esperado, 2) }}</div>
            </div>
        </div>

        @if($caja->estado === 'cerrada' && $caja->monto_final_real !== null)
        <div class="calculation-box">
            <div class="calculation-row final">
                <div class="label">MONTO CONTADO (REAL):</div>
                <div class="value text-purple">S/ {{ number_format($caja->monto_final_real, 2) }}</div>
            </div>
        </div>

        <div class="diferencia-box {{ $caja->diferencia == 0 ? 'cuadrado' : ($caja->diferencia > 0 ? 'positivo' : 'negativo') }}">
            <strong>DIFERENCIA: S/ {{ number_format($caja->diferencia, 2) }}</strong>
            @if($caja->diferencia > 0)
                <div>(SOBRANTE)</div>
            @elseif($caja->diferencia < 0)
                <div>(FALTANTE)</div>
            @else
                <div>(CUADRADO ✓)</div>
            @endif
        </div>
        @endif

        <!-- Detalle de Movimientos -->
        <div class="section-title">DETALLE DE MOVIMIENTOS</div>
        <table class="movements-table">
            <thead>
                <tr>
                    <th style="width: 8%;">Hora</th>
                    <th style="width: 10%;">Tipo</th>
                    <th style="width: 12%;">Concepto</th>
                    <th style="width: 30%;">Descripción</th>
                    <th style="width: 12%;">Método</th>
                    <th style="width: 13%;">Monto</th>
                    <th style="width: 15%;">Usuario</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalIngresos = 0;
                    $totalEgresos = 0;
                @endphp
                @forelse($caja->movimientos as $movimiento)
                    @php
                        if($movimiento->tipo === 'ingreso') {
                            $totalIngresos += $movimiento->monto;
                        } else {
                            $totalEgresos += $movimiento->monto;
                        }
                    @endphp
                    <tr>
                        <td>{{ $movimiento->created_at->format('H:i:s') }}</td>
                        <td style="text-align: center;">
                            <strong>{{ strtoupper($movimiento->tipo) }}</strong>
                        </td>
                        <td>{{ ucfirst($movimiento->concepto) }}</td>
                        <td>
                            {{ $movimiento->descripcion ?? '-' }}
                            @if($movimiento->comprobante)
                                <br><small>{{ $movimiento->comprobante }}</small>
                            @endif
                        </td>
                        <td>{{ $movimiento->metodoPago->name ?? '-' }}</td>
                        <td style="text-align: right; font-weight: bold;">
                            {{ $movimiento->tipo === 'ingreso' ? '+' : '-' }} S/ {{ number_format($movimiento->monto, 2) }}
                        </td>
                        <td>{{ $movimiento->usuario->name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px;">No hay movimientos registrados</td>
                    </tr>
                @endforelse
            </tbody>
            @if($caja->movimientos->count() > 0)
            <tfoot style="background-color: #f5f5f5; font-weight: bold;">
                <tr>
                    <td colspan="5" style="text-align: right;">Total Ingresos:</td>
                    <td style="text-align: right;" class="text-green">+ S/ {{ number_format($totalIngresos, 2) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="5" style="text-align: right;">Total Egresos:</td>
                    <td style="text-align: right;" class="text-red">- S/ {{ number_format($totalEgresos, 2) }}</td>
                    <td></td>
                </tr>
                <tr style="border-top: 2px solid #333;">
                    <td colspan="5" style="text-align: right; font-size: 11px;">BALANCE:</td>
                    <td style="text-align: right; font-size: 11px;">S/ {{ number_format($totalIngresos - $totalEgresos, 2) }}</td>
                    <td></td>
                </tr>
            </tfoot>
            @endif
        </table>

        <!-- Firmas -->
        <div class="signatures">
            <div class="signature-box">
                <div class="signature-line">
                    {{ $caja->usuario->name }}<br>
                    <small>Usuario Apertura</small>
                </div>
            </div>
            @if($caja->estado === 'cerrada')
            <div class="signature-box">
                <div class="signature-line">
                    {{ $caja->usuarioCierre->name ?? 'N/A' }}<br>
                    <small>Usuario Cierre</small>
                </div>
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Sistema de Gestión - Biker Project</p>
            <p>Este documento es un reporte generado automáticamente</p>
        </div>
    </div>
</body>
</html>
