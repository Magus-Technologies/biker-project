<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Devolucion;
use App\Models\DevolucionItem;
use App\Models\Sale;
use App\Models\SalesItem;
use App\Models\Product;
use App\Models\User;

class DevolucionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener algunas ventas existentes
        $sales = Sale::with('saleItems')->take(5)->get();
        
        if ($sales->count() == 0) {
            $this->command->info('No hay ventas disponibles para crear devoluciones.');
            return;
        }
        
        // Obtener usuario para registrar las devoluciones
        $user = User::first();
        
        foreach ($sales as $sale) {
            if ($sale->saleItems->count() > 0) {
                // Crear devolución
                $devolucion = Devolucion::create([
                    'code' => $this->generateCode(),
                    'sale_id' => $sale->id,
                    'total_amount' => $sale->saleItems->take(2)->sum(function($item) {
                        return $item->quantity * $item->unit_price;
                    }),
                    'reason' => $this->getRandomReason(),
                    'user_register' => $user->id
                ]);
                
                // Crear items de devolución (solo los primeros 2 items de la venta)
                foreach ($sale->saleItems->take(2) as $saleItem) {
                    $quantityReturned = rand(1, $saleItem->quantity);
                    
                    DevolucionItem::create([
                        'devolucion_id' => $devolucion->id,
                        'sale_item_id' => $saleItem->id,
                        'quantity_returned' => $quantityReturned,
                        'unit_price' => $saleItem->unit_price
                    ]);
                    
                    // Actualizar stock (devolver al inventario)
                    if ($saleItem->item_type === Product::class) {
                        $product = Product::find($saleItem->item_id);
                        if ($product) {
                            $stock = $product->stocks()->first();
                            if ($stock) {
                                $stock->quantity += $quantityReturned;
                                $stock->save();
                            }
                        }
                    }
                }
            }
        }
        
        $this->command->info('Devoluciones creadas exitosamente.');
    }
    
    private function generateCode(): string
    {
        $lastCode = Devolucion::max('code') ?? '0000000';
        return str_pad(intval($lastCode) + 1, 7, '0', STR_PAD_LEFT);
    }
    
    private function getRandomReason(): string
    {
        $reasons = [
            'Producto defectuoso',
            'No es lo que esperaba',
            'Cambio de talla',
            'Error en el pedido',
            'Producto dañado en transporte',
            'Arrepentimiento de compra',
            'Problema de calidad',
            'Incompatibilidad con el vehículo'
        ];
        
        return $reasons[array_rand($reasons)];
    }
}
