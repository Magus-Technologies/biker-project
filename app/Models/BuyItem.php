<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'buy_id',
        'warehouse_id', // Agregar esta línea
        'quantity',
        'user_register',
        'fecha_registro',
        'price',
        'status',
        // NUEVOS CAMPOS:
        'tienda_id',
        'custom_price',
        'scanned_codes' // JSON para códigos escaneados
    ];

    // Agregar estos casts después de los fillable:
    protected $casts = [
        'scanned_codes' => 'array'
    ];

    public function buy()
    {
        return $this->belongsTo(Buy::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Agregar esta relación después de buy():
    public function tienda()
    {
        return $this->belongsTo(Tienda::class);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_register = auth()->id();
            $model->fecha_registro = now();
        });
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
