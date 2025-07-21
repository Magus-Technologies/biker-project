<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota de Empresa</title>
    <style>
        body { font-family: DejaVu Sans; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid black; padding: 4px; text-align: center; }
        .header-box { border: 1px solid black; padding: 10px; width: 50%; float: left; }
        .note-box { border: 1px solid black; padding: 10px; width: 30%; float: right; text-align: center; }
        .clearfix { clear: both; }
        .quote { text-align: center; margin-top: 20px; font-style: italic; }
        .total { text-align: right; font-weight: bold; margin-top: 10px; }
    </style>
</head>
<body>

<div class="header-box">
    <p><strong>CLIENTE:</strong> {{ $sale->customer_names_surnames }}</p>
    <p><strong>VENDEDOR:</strong> {{ $sale->userRegister->name ?? 'N/A' }}</p>
    <p><strong>FECHA:</strong> {{ \Carbon\Carbon::parse($sale->fecha_registro)->format('d/m/Y') }}</p>
    <p><strong>MONTO TOTAL:</strong> {{ number_format($sale->total_price, 2) }} SOLES</p>
</div>

<div class="note-box">
    <p><strong>NOTA EMPRESA</strong></p>
    <p><strong>{{ $sale->serie }}-{{ $sale->number }}</strong></p>
</div>

<div class="clearfix"></div>

<p class="quote">"¿Ruido raro? ¿Frenos llorando? Tranquilo, tenemos tus repuestos favoritos aquí, esperándote"</p>

<table>
    <thead>
        <tr>
            <th>CODIGO</th>
            <th>DESCRIPCION</th>
            <th>MODELO</th>
            <th>CANTIDAD</th>
            <th>PRECIO MAYORISTA</th>
            <th>PRECIO PUBLICO</th>
            <th>UBICACION</th>
            <th>MONTO MAYORISTA</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($sale->saleItems) && is_iterable($sale->saleItems))
            @php
                $totalRows = 33;
                $rowCount = 0;
            @endphp
    
            @foreach ($sale->saleItems as $index => $saleItem)
                @php
                    $descripcion = $saleItem->item->description ?? ($saleItem->item->name ?? 'N/A');
                    $cantidad = str_pad($saleItem->quantity ?? 0, 4, '0', STR_PAD_LEFT); // Formato 0001
                    $precio = $saleItem->unit_price ?? 0;
                    $subtotal = $cantidad * $precio;
                    $unidad = $saleItem->item->unit->name ?? 'N/A';
                    $rowCount++;
                @endphp
                <tr>
                    <td style="padding: 2px; text-align: center; border-right: 1px solid #000">
                        {{ $index + 1 }}
                    </td>
                    <td style="padding: 2px; text-align: center; border-right: 1px solid #000">
                        {{ $descripcion }}
                    </td>
                    <td style="padding: 2px; text-align: center; border-right: 1px solid #000">
                        {{ $descripcion }}
                    </td>
                    <td style="padding: 2px; text-align: center; border-right: 1px solid #000">
                        {{ $cantidad }}
                    </td>
                    <td style="padding: 2px; text-align: center; border-right: 1px solid #000">
                        {{ number_format($precio, 2) }}
                    </td>
                    <td style="padding: 2px; text-align: center; border-right: 1px solid #000">
                        {{ $unidad }}
                    </td>
                    <td style="padding: 2px; text-align: center; border-right: 1px solid #000">
                        {{ number_format($precio, 2) }}
                    </td>
                    <td style="padding: 2px; text-align: center; border-right: 1px solid #000">
                        {{ number_format($subtotal, 2) }}
                    </td>
                </tr>
            @endforeach
        @endif
        
    </tbody>
</table>

<p class="total">MONTO TOTAL: {{ number_format($sale->total_price, 2) }}</p>

</body>
</html>
