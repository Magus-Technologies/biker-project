<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class StockMinExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    protected $productos;
    protected $tiendaNombre;

    public function __construct($productos, $tiendaNombre = 'Todas las Tiendas')
    {
        $this->productos = $productos;
        $this->tiendaNombre = $tiendaNombre;
    }

    public function collection()
    {
        $data = collect();
        
        foreach ($this->productos as $producto) {
            $estado = $producto->quantity == 0 ? 'AGOTADO' : 'STOCK BAJO';
            
            $data->push([
                $producto->code_sku ?? $producto->code,
                $producto->description,
                $producto->model ?? '-',
                $producto->minimum_stock,
                $producto->quantity,
                $producto->location ?? '-',
                $producto->tienda->nombre ?? 'N/A',
                $estado
            ]);
        }
        
        return $data;
    }

    public function headings(): array
    {
        return [
            'CÓDIGO',
            'DESCRIPCIÓN',
            'MODELO',
            'STOCK MÍNIMO',
            'CANTIDAD ACTUAL',
            'UBICACIÓN',
            'TIENDA/SUCURSAL',
            'ESTADO'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Aplicar estilos al header
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => Color::COLOR_WHITE],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF1e3a8a'], // Azul oscuro
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => Color::COLOR_WHITE],
                ],
            ],
        ]);

        // Aplicar bordes a toda la tabla
        $lastRow = $this->productos->count() + 1;
        $sheet->getStyle("A1:H{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Centrar columnas numéricas
        $sheet->getStyle("D2:E{$lastRow}")->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Aplicar colores según el estado
        for ($row = 2; $row <= $lastRow; $row++) {
            $estadoCell = $sheet->getCell("H{$row}");
            if ($estadoCell->getValue() === 'AGOTADO') {
                $sheet->getStyle("A{$row}:H{$row}")->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFFECACA'], // Rojo claro
                    ],
                ]);
            } else {
                $sheet->getStyle("A{$row}:H{$row}")->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFFEF3C7'], // Amarillo claro
                    ],
                ]);
            }
        }

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,  // Código
            'B' => 40,  // Descripción
            'C' => 20,  // Modelo
            'D' => 15,  // Stock Mínimo
            'E' => 18,  // Cantidad Actual
            'F' => 15,  // Ubicación
            'G' => 20,  // Tienda
            'H' => 15,  // Estado
        ];
    }

    public function title(): string
    {
        return 'Stock Mínimo - ' . $this->tiendaNombre;
    }
}
