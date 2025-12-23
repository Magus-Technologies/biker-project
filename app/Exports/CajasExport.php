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

class CajasExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    protected $cajas;

    public function __construct($cajas)
    {
        $this->cajas = $cajas;
    }

    public function collection()
    {
        $data = collect();
        
        foreach ($this->cajas as $caja) {
            $data->push([
                $caja->codigo,
                $caja->usuario->name,
                $caja->tienda->nombre ?? 'Sin tienda',
                $caja->fecha_apertura->format('d/m/Y H:i:s'),
                $caja->fecha_cierre ? $caja->fecha_cierre->format('d/m/Y H:i:s') : 'N/A',
                'S/ ' . number_format($caja->monto_inicial, 2),
                'S/ ' . number_format($caja->monto_ventas_efectivo, 2),
                'S/ ' . number_format($caja->monto_ventas_tarjeta, 2),
                'S/ ' . number_format($caja->monto_ventas_transferencia, 2),
                'S/ ' . number_format($caja->monto_ventas_otros, 2),
                'S/ ' . number_format($caja->total_ventas, 2),
                'S/ ' . number_format($caja->monto_gastos, 2),
                'S/ ' . number_format($caja->monto_retiros, 2),
                'S/ ' . number_format($caja->monto_depositos, 2),
                'S/ ' . number_format($caja->monto_final_esperado, 2),
                $caja->monto_final_real ? 'S/ ' . number_format($caja->monto_final_real, 2) : 'N/A',
                $caja->diferencia !== null ? 'S/ ' . number_format($caja->diferencia, 2) : 'N/A',
                strtoupper($caja->estado),
                $caja->usuarioCierre->name ?? 'N/A',
            ]);
        }
        
        return $data;
    }

    public function headings(): array
    {
        return [
            'CÓDIGO',
            'USUARIO APERTURA',
            'TIENDA',
            'FECHA APERTURA',
            'FECHA CIERRE',
            'MONTO INICIAL',
            'VENTAS EFECTIVO',
            'VENTAS TARJETA',
            'VENTAS TRANSFERENCIA',
            'VENTAS OTROS',
            'TOTAL VENTAS',
            'GASTOS',
            'RETIROS',
            'DEPÓSITOS',
            'MONTO FINAL ESPERADO',
            'MONTO FINAL REAL',
            'DIFERENCIA',
            'ESTADO',
            'USUARIO CIERRE',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Aplicar estilos al header
        $sheet->getStyle('A1:S1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => Color::COLOR_WHITE],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF1F2937'], // Gris oscuro
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
        $lastRow = $this->cajas->count() + 1;
        $sheet->getStyle("A1:S{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Centrar columnas
        $sheet->getStyle("A2:S{$lastRow}")->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Aplicar colores alternados a las filas
        for ($row = 2; $row <= $lastRow; $row++) {
            $color = ($row % 2 == 0) ? 'FFF3F4F6' : 'FFFFFFFF'; // Gris claro alternado
            $sheet->getStyle("A{$row}:S{$row}")->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => $color],
                ],
            ]);
        }

        // Colorear columna de estado
        for ($row = 2; $row <= $lastRow; $row++) {
            $estado = $sheet->getCell("R{$row}")->getValue();
            if ($estado === 'ABIERTA') {
                $sheet->getStyle("R{$row}")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FF10B981'], // Verde
                    ],
                ]);
            } elseif ($estado === 'CERRADA') {
                $sheet->getStyle("R{$row}")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FF6B7280'], // Gris
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
            'B' => 25,  // Usuario Apertura
            'C' => 20,  // Tienda
            'D' => 20,  // Fecha Apertura
            'E' => 20,  // Fecha Cierre
            'F' => 18,  // Monto Inicial
            'G' => 18,  // Ventas Efectivo
            'H' => 18,  // Ventas Tarjeta
            'I' => 20,  // Ventas Transferencia
            'J' => 15,  // Ventas Otros
            'K' => 18,  // Total Ventas
            'L' => 15,  // Gastos
            'M' => 15,  // Retiros
            'N' => 15,  // Depósitos
            'O' => 22,  // Monto Final Esperado
            'P' => 20,  // Monto Final Real
            'Q' => 15,  // Diferencia
            'R' => 12,  // Estado
            'S' => 25,  // Usuario Cierre
        ];
    }

    public function title(): string
    {
        return 'Listado de Cajas';
    }
}
