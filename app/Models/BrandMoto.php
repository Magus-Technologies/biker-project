<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandMoto extends Model
{
    use HasFactory;

    protected $table = 'brands_motos';

    protected $fillable = [
        'name',
        'slug',
        'color_from',
        'color_to',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    // Relación con cars
    public function cars()
    {
        return $this->hasMany(Car::class, 'marca', 'name');
    }
}
