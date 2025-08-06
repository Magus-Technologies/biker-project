<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lista de Precios {{ $year }}</title>
    <style>
        @page {
            margin: 15mm;
            size: A4 landscape; /* Orientación horizontal */
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            margin: 0;
            padding: 0;
            line-height: 1.2;
        }
        
        /* Header con logo */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 15px;
        }
        
        .header-left {
            display: table-cell;
            width: 200px;
            vertical-align: top;
        }
        
        .logo {
            width: auto;
            height: 100px;
            max-width: 200px;
            object-fit: contain;
        }
        
        .header-center {
            display: table-cell;
            text-align: center;
            vertical-align: middle;
            padding: 0 20px;
        }
        
        .header-right {
            display: table-cell;
            width: 200px;
            text-align: right;
            vertical-align: top;
        }
        
        .company-info {
            font-size: 10px;
            color: #333;
            margin-top: 5px;
        }
        
        .title {
            color: #1e3a8a;
            font-size: 20px;
            font-weight: bold;
            margin: 0;
        }
        
        .subtitle {
            color: #666;
            font-size: 11px;
            margin: 5px 0;
        }
        
        .info-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 8px;
            font-size: 9px;
        }
        
        /* Leyenda mejorada */
        .legend {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        
        .legend-title {
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }
        
        .legend-items {
            display: table;
            width: 100%;
        }
        
        .legend-item {
            display: table-cell;
            text-align: center;
            padding: 4px 8px;
            border-radius: 3px;
            color: white;
            font-weight: bold;
            font-size: 8px;
            margin-right: 10px;
            width: 20%;
        }
        
        .legend-estable { background-color: #28a745; }
        .legend-alto { background-color: #007bff; }
        .legend-bajo { background-color: #dc3545; }
        .legend-normal { background-color: #ffc107; color: #000; }
        
        /* Tabla optimizada para horizontal */
        .table-container {
            width: 100%;
            overflow: visible;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
            margin-top: 10px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 4px 3px;
            text-align: center;
            vertical-align: middle;
        }
        
        th {
            background-color: #1e3a8a;
            color: white;
            font-weight: bold;
            font-size: 7px;
        }
        
        .header-main {
            background-color: #2563eb;
        }
        
        .codigo-col {
            width: 60px;
            font-family: 'Courier New', monospace;
            font-weight: bold;
        }
        
        .descripcion-col {
            width: 120px;
            text-align: left;
            font-size: 7px;
        }
        
        .mes-col {
            width: 45px;
            font-size: 7px;
        }
        
        .precio-valor {
            padding: 2px 4px;
            border-radius: 2px;
            font-weight: bold;
            color: white;
            font-size: 7px;
            display: inline-block;
            min-width: 35px;
        }
        
        .precio-estable { background-color: #28a745; }
        .precio-alto { background-color: #007bff; }
        .precio-bajo { background-color: #dc3545; }
        .precio-normal { background-color: #ffc107; color: #000; }
        
        /* Footer mejorado */
        .footer {
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            display: table;
            width: 100%;
        }
        
        .footer-left {
            display: table-cell;
            width: 50%;
            font-size: 8px;
            color: #666;
        }
        
        .footer-right {
            display: table-cell;
            width: 50%;
            text-align: right;
            font-size: 8px;
            color: #666;
        }
        
        .stats {
            background-color: #f8f9fa;
            padding: 8px;
            border-radius: 3px;
            margin-top: 5px;
        }
        
        .no-data {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 30px;
            font-size: 12px;
        }
        
        /* Responsive para PDF */
        @media print {
            .header {
                page-break-inside: avoid;
            }
            
            table {
                page-break-inside: auto;
            }
            
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
    </style>
</head>
<body>
    <!-- Header con logo -->
    <div class="header">
        <div class="header-left">
            @if(file_exists(public_path('img/logo.png')))
                <img src="{{ public_path('img/logo.png') }}" alt="Logo" class="logo">
            @else
                <div style="width: 200px; height: 100px; background-color: #f0f0f0; border: 2px dashed #ccc; display: flex; align-items: center; justify-content: center; color: #666;">
                    <span>LOGO</span>
                </div>
            @endif
            <div class="company-info">
                <strong>{{ config('app.name', 'Sistema de Gestión') }}</strong><br>
                Sistema de Control de Precios
            </div>
        </div>
        
        <div class="header-center">
            <h1 class="title">Lista de Precios - Año {{ $year }}</h1>
            <p class="subtitle">Generado el {{ now()->format('d/m/Y H:i:s') }}</p>
            <div class="info-box">
                <strong>LA LISTA DE PRECIOS SE SACARÁ EN BASE A LAS COMPRAS</strong>
            </div>
        </div>
        
        <div class="header-right">
            <div class="info-box">
                <strong>Año:</strong> {{ $year }}<br>
                <strong>Productos:</strong> {{ count($preciosProductos) }}<br>
                <strong>Fecha:</strong> {{ now()->format('d/m/Y') }}<br>
                <strong>Hora:</strong> {{ now()->format('H:i:s') }}
            </div>
        </div>
    </div>
    
    <!-- Leyenda mejorada -->
    <div class="legend">
        <div class="legend-title">Leyenda de Colores de Precios:</div>
        <div class="legend-items">
            <div class="legend-item legend-estable">ESTABLES<br><small>(≤5% variación)</small></div>
            <div class="legend-item legend-alto">ALTOS<br><small>(>10% aumento)</small></div>
            <div class="legend-item legend-bajo">BAJOS<br><small>(>10% reducción)</small></div>
            <div class="legend-item legend-normal">NORMALES<br><small>(5-10% variación)</small></div>
        </div>
    </div>
    
    <!-- Tabla horizontal optimizada -->
    @if(count($preciosProductos) > 0)
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th rowspan="2" class="codigo-col">CÓDIGO</th>
                    <th rowspan="2" class="descripcion-col">DESCRIPCIÓN</th>
                    <th colspan="12" class="header-main">AÑO {{ $year }} - MESES</th>
                </tr>
                <tr>
                    <th class="mes-col">ENE</th>
                    <th class="mes-col">FEB</th>
                    <th class="mes-col">MAR</th>
                    <th class="mes-col">ABR</th>
                    <th class="mes-col">MAY</th>
                    <th class="mes-col">JUN</th>
                    <th class="mes-col">JUL</th>
                    <th class="mes-col">AGO</th>
                    <th class="mes-col">SEP</th>
                    <th class="mes-col">OCT</th>
                    <th class="mes-col">NOV</th>
                    <th class="mes-col">DIC</th>
                </tr>
            </thead>
            <tbody>
                @foreach($preciosProductos as $item)
                <tr>
                    <td class="codigo-col">{{ $item['producto']->code_sku ?? $item['producto']->code }}</td>
                    <td class="descripcion-col">
                        <strong>{{ $item['producto']->description }}</strong>
                        @if($item['producto']->brand)
                            <br><small>{{ $item['producto']->brand->name }}</small>
                        @endif
                    </td>
                    
                    @for($mes = 1; $mes <= 12; $mes++)
                        <td class="mes-col">
                            @if($item['precios'][$mes])
                                <span class="precio-valor {{ getPrecioClass($item['precios'], $mes) }}">
                                    {{ number_format($item['precios'][$mes], 2) }}
                                </span>
                            @else
                                <span style="color: #999;">-</span>
                            @endif
                        </td>
                    @endfor
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="no-data">
        <strong>No hay datos de precios para el año {{ $year }}</strong><br>
        <small>No se encontraron compras registradas en este período</small>
    </div>
    @endif
    
    <!-- Footer con estadísticas -->
    <div class="footer">
        <div class="footer-left">
            <div class="stats">
                <strong>Estadísticas del Reporte:</strong><br>
                • Total de productos: {{ count($preciosProductos) }}<br>
                • Año analizado: {{ $year }}<br>
                • Período: Enero - Diciembre {{ $year }}
            </div>
        </div>
        
        <div class="footer-right">
            <div class="stats">
                <strong>Información del Sistema:</strong><br>
                • Reporte generado automáticamente<br>
                • Basado en compras registradas<br>
                • {{ now()->format('d/m/Y H:i:s') }}
            </div>
        </div>
    </div>
</body>
</html>