<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class BuysExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $compras;
    
    public function __construct($compras)
    {
        $this->compras = $compras;
    }

    public function collection()
    {
        return $this->compras;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Serie/Número',
            'Proveedor',
            'RUC/DNI Proveedor',
            'Fecha Registro',
            'Tipo Documento',
            'Subtotal',
            'IGV',
            'Total',
            'Tipo Pago',
            'Estado Productos',
            'Fecha Recepción',
            'Tienda',
            'Usuario Registro',
            'Observaciones'
        ];
    }

    public function map($compra): array
    {
        return [
            $compra->id,
            $compra->serie . '-' . $compra->number,
            $compra->supplier ? $compra->supplier->nombre_negocio : 'Sin Proveedor',
            $compra->supplier ? $compra->supplier->nro_documento : 'N/A',
            $compra->fecha_registro,
            $compra->documentType ? $compra->documentType->name : 'N/A',
            number_format($compra->total_price - $compra->igv, 2),
            number_format($compra->igv, 2),
            number_format($compra->total_price, 2),
            $compra->payment_type === 'cash' ? 'Contado' : 'Crédito',
            $compra->delivery_status === 'received' ? 'Recibidos' : 'Pendientes',
            $compra->received_date ? date('d/m/Y', strtotime($compra->received_date)) : 'N/A',
            $compra->tienda ? $compra->tienda->nombre : 'Sin Tienda',
            $compra->userRegister ? $compra->userRegister->name : 'N/A',
            $compra->observation ?? ''
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['rgb' => 'E5E7EB']
                ]
            ],
        ];
    }

    public function title(): string
    {
        return 'Reporte de Compras';
    }
}