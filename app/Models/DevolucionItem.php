<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevolucionItem extends Model
{
    use HasFactory;
    
    protected $table = 'devolucion_items';
    
    protected $fillable = [
        'devolucion_id', 
        'sale_item_id', 
        'quantity_returned', 
        'unit_price'
    ];
    
    protected $casts = [
        'quantity_returned' => 'integer',
        'unit_price' => 'decimal:2'
    ];
    
    public function devolucion() {
        return $this->belongsTo(Devolucion::class);
    }
    
    public function saleItem() {
        return $this->belongsTo(SalesItem::class, 'sale_item_id');
    }
    
    // Método para obtener el producto relacionado
    public function getProductAttribute() {
        if ($this->saleItem && $this->saleItem->item_type === Product::class) {
            return Product::find($this->saleItem->item_id);
        }
        return null;
    }
    
    // Método para obtener el nombre del producto
    public function getProductNameAttribute() {
        $product = $this->product;
        return $product ? $product->description : 'Producto no encontrado';
    }
    
    // Método para obtener el código del producto
    public function getProductCodeAttribute() {
        $product = $this->product;
        return $product ? $product->code_sku : 'N/A';
    }
    
    // Método para calcular el subtotal
    public function getSubtotalAttribute() {
        return $this->quantity_returned * $this->unit_price;
    }
    
    // Método para verificar si el item es válido
    public function isValid() {
        return $this->quantity_returned > 0 && $this->unit_price > 0;
    }
}
