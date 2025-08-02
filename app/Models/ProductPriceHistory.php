<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPriceHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'buy_id',
        'price',
        'type',
        'user_register'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_register = auth()->id();
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function buy()
    {
        return $this->belongsTo(Buy::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_register');
    }
}
