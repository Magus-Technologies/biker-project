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
            'Código de barras',           // Código del producto
            'Descripción',      // Nombre o descripción
            'Modelo',           // Modelo del producto
            'Localización',     // Ubicación en la tienda
            'Tienda',          // Nombre de la tienda
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
        // Obtener la primera tienda como ejemplo
        $tiendaEjemplo = Tienda::first();
        $brandEjemplo = Brand::first();
        $unitEjemplo = Unit::first();

        return [
            // Fila de ejemplo con sugerencias sobre qué ingresar
            [
                'P001',
                '156001',
                'Shampoo Hidratante 500ml',
                'XYZ-123',
                'Pasillo 3, Estante 2',
                $tiendaEjemplo ? $tiendaEjemplo->nombre : 'Tienda Principal',
                $brandEjemplo ? $brandEjemplo->name : 'Marca Ejemplo',
                $unitEjemplo ? $unitEjemplo->name : 'Unidad',
                '100.00',   // Precio Compra
                '90.00',    // Precio Mayorista
                '110.00',   // Precio Sucursal A
                '115.00',   // Precio Sucursal B
                '50',       // Cantidad en Stock
                '10'        // Stock Mínimo
            ],
            // Primera fila de datos reales vacía (para que el usuario empiece a llenar aquí)
            ['', '', '', '', '', '', '', '', '', '', '', '', '', ''],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15, // Código
            'B' => 15, // Código de Barras
            'C' => 35, // Descripción
            'D' => 20, // Modelo
            'E' => 25, // Localización
            'F' => 50, // Tienda
            'G' => 40, // Marca
            'H' => 40, // Unidad
            'I' => 20, // Precio Compra
            'J' => 20, // Precio Mayorista
            'K' => 20, // Precio Sucursal A
            'L' => 20, // Precio Sucursal B
            'M' => 20, // Cantidad en Stock
            'N' => 20, // Stock Mínimo
        ];
    }
}
