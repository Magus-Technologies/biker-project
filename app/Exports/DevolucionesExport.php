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

class DevolucionesExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    protected $devoluciones;
    protected $fechaDesde;
    protected $fechaHasta;

    public function __construct($devoluciones, $fechaDesde = null, $fechaHasta = null)
    {
        $this->devoluciones = $devoluciones;
        $this->fechaDesde = $fechaDesde;
        $this->fechaHasta = $fechaHasta;
    }

    public function collection()
    {
        $data = collect();
        
        foreach ($this->devoluciones as $devolucion) {
            $data->push([
                $devolucion->code,
                $devolucion->sale->customer_names_surnames ?? 'N/A',
                $devolucion->sale->customer_dni ?? 'N/A',
                $devolucion->sale->fecha_registro ?? 'N/A',
                $devolucion->total_amount,
                $devolucion->reason ?? 'Sin motivo',
                $devolucion->userRegister->name ?? 'N/A',
                $devolucion->created_at->format('d/m/Y H:i'),
                $devolucion->items->count(),
                $devolucion->items->sum('quantity_returned')
            ]);
        }
        
        return $data;
    }

    public function headings(): array
    {
        return [
            'CÓDIGO DEVOLUCIÓN',
            'CLIENTE',
            'DNI CLIENTE',
            'FECHA VENTA',
            'MONTO TOTAL',
            'MOTIVO',
            'USUARIO REGISTRÓ',
            'FECHA DEVOLUCIÓN',
            'ITEMS DEVUELTOS',
            'CANTIDAD TOTAL DEVUELTA'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Aplicar estilos al header
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => Color::COLOR_WHITE],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFDC2626'], // Rojo para devoluciones
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
        $lastRow = $this->devoluciones->count() + 1;
        $sheet->getStyle("A1:J{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Centrar columnas numéricas
        $sheet->getStyle("E2:I{$lastRow}")->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Aplicar colores alternados a las filas
        for ($row = 2; $row <= $lastRow; $row++) {
            $color = ($row % 2 == 0) ? 'FFFEF2F2' : 'FFFFF5F5'; // Rojo muy claro alternado
            $sheet->getStyle("A{$row}:J{$row}")->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => $color],
                ],
            ]);
        }

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,  // Código Devolución
            'B' => 30,  // Cliente
            'C' => 15,  // DNI Cliente
            'D' => 20,  // Fecha Venta
            'E' => 15,  // Monto Total
            'F' => 25,  // Motivo
            'G' => 25,  // Usuario Registró
            'H' => 20,  // Fecha Devolución
            'I' => 18,  // Items Devueltos
            'J' => 25,  // Cantidad Total Devuelta
        ];
    }

    public function title(): string
    {
        $title = 'Devoluciones';
        if ($this->fechaDesde && $this->fechaHasta) {
            $title .= " - {$this->fechaDesde} a {$this->fechaHasta}";
        }
        return $title;
    }
}
