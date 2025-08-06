<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Models\PaymentMethod;
use App\Models\Tienda;

class BuyTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Plantilla' => new BuyTemplateSheet(),
            'Métodos de Pago' => new PaymentMethodsSheet(),
            'Estados de Entrega' => new DeliveryStatusSheet(),
            'Tiendas' => new TiendasSheet(),
        ];
    }
}

class BuyTemplateSheet implements FromArray, WithHeadings, WithStyles, WithTitle, WithColumnWidths
{
    public function array(): array
    {
        return [
            [
                '20123456789',
                'Proveedor Ejemplo SAC',
                '2024-01-15',
                'NOTA DE VENTA',
                'SKU001',
                '10',
                '25.50',
                'Efectivo',
                'Productos Recibidos',
                '1',
                'Compra de productos varios'
            ],
            [
                '12345678',
                'Juan Pérez López',
                '2024-01-16',
                'NOTA DE VENTA',
                'SKU002',
                '5',
                '15.00',
                'Transferencia',
                'Productos Pendientes',
                '1',
                'Compra urgente'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'RUC/DNI Proveedor*',
            'Nombre/Razón Social*',
            'Fecha Compra (YYYY-MM-DD)*',
            'Tipo Documento*',
            'SKU Producto*',
            'Cantidad*',
            'Precio Unitario*',
            'Método de Pago*',
            'Estado de Entrega*',
            'ID Tienda*',
            'Observación'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['rgb' => '4F81BD']
                ],
                'font' => ['color' => ['rgb' => 'FFFFFF'], 'bold' => true],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
            'A2:K100' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'CCCCCC'],
                    ],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 18,  // RUC/DNI
            'B' => 30,  // Nombre
            'C' => 15,  // Fecha
            'D' => 18,  // Tipo Doc
            'E' => 12,  // SKU
            'F' => 10,  // Cantidad
            'G' => 15,  // Precio
            'H' => 18,  // Método Pago
            'I' => 20,  // Estado
            'J' => 10,  // Tienda
            'K' => 25,  // Observación
        ];
    }

    public function title(): string
    {
        return 'Plantilla Importación';
    }
}

class PaymentMethodsSheet implements FromArray, WithHeadings, WithStyles, WithTitle
{
    public function array(): array
    {
        $paymentMethods = PaymentMethod::where('status', 1)->get();
        $data = [];
        
        foreach ($paymentMethods as $method) {
            $data[] = [$method->name, $method->type];
        }
        
        return $data;
    }

    public function headings(): array
    {
        return ['Método de Pago', 'Tipo'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['rgb' => '92D050']
                ]
            ]
        ];
    }

    public function title(): string
    {
        return 'Métodos de Pago';
    }
}

class DeliveryStatusSheet implements FromArray, WithHeadings, WithStyles, WithTitle
{
    public function array(): array
    {
        return [
            ['Productos Recibidos', 'received'],
            ['Productos Pendientes', 'pending']
        ];
    }

    public function headings(): array
    {
        return ['Estado Mostrado', 'Valor Sistema'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['rgb' => 'FFC000']
                ]
            ]
        ];
    }

    public function title(): string
    {
        return 'Estados de Entrega';
    }
}

class TiendasSheet implements FromArray, WithHeadings, WithStyles, WithTitle
{
    public function array(): array
    {
        $tiendas = Tienda::where('status', 1)->get();
        $data = [];
        
        foreach ($tiendas as $tienda) {
            $data[] = [$tienda->id, $tienda->nombre];
        }
        
        return $data;
    }

    public function headings(): array
    {
        return ['ID', 'Nombre Tienda'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['rgb' => 'FF6600']
                ]
            ]
        ];
    }

    public function title(): string
    {
        return 'Tiendas';
    }
}