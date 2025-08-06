<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PreciosProductosExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    protected $preciosProductos;
    protected $year;

    public function __construct($preciosProductos, $year)
    {
        $this->preciosProductos = $preciosProductos;
        $this->year = $year;
    }

    public function collection()
    {
        $data = collect();
        
        foreach ($this->preciosProductos as $item) {
            $row = [
                $item['producto']->code_sku ?? $item['producto']->code,
                $item['producto']->description,
            ];
            
            // Agregar precios de cada mes
            for ($mes = 1; $mes <= 12; $mes++) {
                $row[] = $item['precios'][$mes] ? number_format($item['precios'][$mes], 2) : '-';
            }
            
            $data->push($row);
        }
        
        return $data;
    }

    public function headings(): array
    {
        return [
            'CÓDIGO',
            'DESCRIPCIÓN',
            'ENERO',
            'FEBRERO',
            'MARZO',
            'ABRIL',
            'MAYO',
            'JUNIO',
            'JULIO',
            'AGOSTO',
            'SEPTIEMBRE',
            'OCTUBRE',
            'NOVIEMBRE',
            'DICIEMBRE'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Estilo para el header
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => Color::COLOR_WHITE],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => '1e3a8a'],
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 40,
            'C' => 12,
            'D' => 12,
            'E' => 12,
            'F' => 12,
            'G' => 12,
            'H' => 12,
            'I' => 12,
            'J' => 12,
            'K' => 12,
            'L' => 12,
            'M' => 12,
            'N' => 12,
        ];
    }
}