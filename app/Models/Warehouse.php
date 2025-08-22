<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable = [
        'name',
        'code', 
        'address',
        'type',
        'status'
    ];

    public function buys()
    {
        return $this->hasMany(Buy::class);
    }

    public function buyItems()
    {
        return $this->hasMany(BuyItem::class);
    }

    public static function getCentral()
    {
        return self::where('type', 'central')->where('status', 1)->first();
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
    
}
