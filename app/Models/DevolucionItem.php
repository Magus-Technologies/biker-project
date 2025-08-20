<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevolucionItem extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'devolucion_id', 
        'sale_item_id', 
        'quantity_returned', 
        'unit_price'
    ];
    
    public function devolucion() {
        return $this->belongsTo(Devolucion::class);
    }
    
    public function saleItem() {
        return $this->belongsTo(SalesItem::class, 'sale_item_id');
    }
}
