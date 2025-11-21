<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoService extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedido_id',
        'service_name',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    protected static function booted()
    {
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
}
