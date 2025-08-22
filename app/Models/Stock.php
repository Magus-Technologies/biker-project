<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'tienda_id', 'warehouse_id', 'quantity', 'minimum_stock'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function tienda()
    {
        return $this->belongsTo(Tienda::class);
    }

    public function scannedCodes()
    {
        return $this->hasMany(ScannedCode::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

}

