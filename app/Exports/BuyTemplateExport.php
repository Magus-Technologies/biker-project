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
    // Busca el método sheets() en la clase BuyTemplateExport (alrededor de línea 15) y reemplázalo:
    public function sheets(): array
    {
        return [
            'Plantilla' => new BuyTemplateSheet(),
            'Métodos de Pago' => new PaymentMethodsSheet(),
            'Estados de Entrega' => new DeliveryStatusSheet(),
            // Eliminado: 'Tiendas' => new TiendasSheet(), // Ya no se necesita hoja de tiendas
        ];
    }
}

class BuyTemplateSheet implements FromArray, WithHeadings, WithStyles, WithTitle, WithColumnWidths
{
    // Busca el método array() en la clase BuyTemplateSheet (alrededor de línea 25) y reemplázalo:
    public function array(): array
    {
        return [
            [
                '2024-01-15',
                'NOTA DE VENTA',
                'SKU001',
                '10',
                '25.50',
                'Efectivo',
                'Productos Recibidos',
                'Compra de productos varios'
            ],
            [
                '2024-01-16',
                'NOTA DE VENTA',
                'SKU002',
                '5',
                '15.00',
                'Transferencia',
                'Productos Pendientes',
                'Compra urgente'
            ]
        ];
    }

    // Busca el método headings() en la clase BuyTemplateSheet (alrededor de línea 45) y reemplázalo:
    public function headings(): array
    {
        return [
            'Fecha Compra (YYYY-MM-DD)*',
            'Tipo Documento*',
            'SKU Producto*',
            'Cantidad*',
            'Precio Unitario*',
            'Método de Pago*',
            'Estado de Entrega*',
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

    // Busca el método columnWidths() en la clase BuyTemplateSheet (alrededor de línea 90) y reemplázalo:
    public function columnWidths(): array
    {
        return [
            'A' => 15,  // Fecha
            'B' => 18,  // Tipo Doc
            'C' => 12,  // SKU
            'D' => 10,  // Cantidad
            'E' => 15,  // Precio
            'F' => 18,  // Método Pago
            'G' => 20,  // Estado
            'H' => 25,  // Observación
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

