<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'code_bar',
        'description',
        'amount',
        'model',
        'location',
        'brand_id',
        'unit_id',
        'code_sku',
        'status',
        'control_type',
        'user_register',
        'user_update',
        'fecha_registro',
        'fecha_actualizacion',
    ];

    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_register = auth()->id();
        });
        static::updating(function ($model) {
            $model->user_update = auth()->id();
        });
    }
    public static  function generateCode()
    {
        $lastCodigo = Product::max('code') ?? '0000000';
        $nextCodigo = intval($lastCodigo) + 1;
        return str_pad($nextCodigo, 7, '0', STR_PAD_LEFT);
    }
    public function stocks()  // ← PLURAL
    {
        return $this->hasMany(Stock::class, 'product_id');  // hasMany en lugar de hasOne
    }

    // Agregar esta función después de stocks():
    public function getStockByTienda($tiendaId)
    {
        return $this->stocks()->where('tienda_id', $tiendaId)->first();
    }

    public function priceHistories()
    {
        return $this->hasMany(ProductPriceHistory::class);
    }
    
}
