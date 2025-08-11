<?php
// app/Models/Tienda.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tienda extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'status',
        'user_register',
        'user_update'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    // Relación con el usuario que registró
    public function usuarioRegistro()
    {
        return $this->belongsTo(User::class, 'user_register');
    }

    // Relación con el usuario que actualizó
    public function usuarioActualizacion()
    {
        return $this->belongsTo(User::class, 'user_update');
    }

    // Relación con usuarios de esta tienda
    public function usuarios()
    {
        return $this->hasMany(User::class, 'tienda_id');
    }

    // NUEVA RELACIÓN: Relación con warehouses (almacenes) - OBSOLETA
    /*
    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }
    */

    // Scope para tiendas activas
    public function scopeActivas($query)
    {
        return $query->where('status', 1);
    }
}