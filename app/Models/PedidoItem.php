<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedido_id',
        'product_id',
        'product_price_id',
        'quantity',
        'unit_price',
        'total',
        'notes',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::saving(function ($model) {
            // Calcular total automáticamente
            $model->total = $model->quantity * $model->unit_price;
        });

        static::saved(function ($model) {
            // Recalcular totales del pedido
            $model->pedido->calculateTotals();
        });

        static::deleted(function ($model) {
            // Recalcular totales del pedido
            $model->pedido->calculateTotals();
        });
    }

    // Relaciones
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productPrice()
    {
        return $this->belongsTo(ProductPrice::class, 'product_price_id');
    }
}
