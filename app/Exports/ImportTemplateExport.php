<?php

namespace App\Exports;

use App\Models\Tienda;
use App\Models\Brand;
use App\Models\Unit;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class ImportTemplateExport implements FromArray, WithHeadings, WithColumnWidths
{
    public function headings(): array
    {
        return [
            'Código',           // Código del producto
            'Código de barras', // Código de barras del producto
            'Descripción',      // Nombre o descripción
            'Modelo',           // Modelo del producto
            'Localización',     // Ubicación física en almacén (Ej: E-5, E-29)
            'Marca',            // Marca del producto
            'Unidad',           // Unidad de medida
            'Precio Compra',    // Precio de compra
            'Precio Mayorista', // Precio mayorista
            'Precio Sucursal A', // Precio para sucursal A
            'Precio Sucursal B', // Precio para sucursal B
            'Cantidad en Stock', // Cantidad en stock
            'Stock Mínimo'      // Stock mínimo
        ];
    }

    public function array(): array
    {
        $brandEjemplo = Brand::first();
        $unitEjemplo = Unit::first();

        return [
            // Fila de ejemplo con sugerencias sobre qué ingresar
            [
                'P001',                                    // Código
                '7501234567890',                          // Código de barras
                'Aceite Mobil 20W-50 1L',                 // Descripción
                'MOBIL-20W50',                            // Modelo
                'E-29',                                    // Localización (Estante E, posición 29)
                $brandEjemplo ? $brandEjemplo->name : 'Mobil', // Marca
                $unitEjemplo ? $unitEjemplo->name : 'Litro',   // Unidad
                '45.00',   // Precio Compra
                '55.00',   // Precio Mayorista
                '65.00',   // Precio Sucursal A
                '70.00',   // Precio Sucursal B
                '50',      // Cantidad en Stock
                '10'       // Stock Mínimo
            ],
            // Primera fila de datos reales vacía (para que el usuario empiece a llenar aquí)
            ['', '', '', '', '', '', '', '', '', '', '', '', ''],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15, // Código
            'B' => 18, // Código de Barras
            'C' => 35, // Descripción
            'D' => 20, // Modelo
            'E' => 15, // Localización
            'F' => 20, // Marca
            'G' => 15, // Unidad
            'H' => 18, // Precio Compra
            'I' => 18, // Precio Mayorista
            'J' => 18, // Precio Sucursal A
            'K' => 18, // Precio Sucursal B
            'L' => 18, // Cantidad en Stock
            'M' => 18, // Stock Mínimo
        ];
    }
}
