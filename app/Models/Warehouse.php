<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'tienda_id'];

    public function tienda()
    {
        return $this->belongsTo(Tienda::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}
