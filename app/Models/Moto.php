<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moto extends Model
{
    use HasFactory;

    protected $table = 'motos';

    protected $fillable = [
        'codigo',
        'nro_motor',
        'nro_chasis',
        'marca',
        'modelo',
        'anio',
        'color',
        'lugar_provisional',
        'user_register',
        'user_update',
        'status',
        'fecha_registro',
        'fecha_actualizacion',
    ];

    protected $casts = [
        'fecha_registro' => 'datetime',
        'fecha_actualizacion' => 'datetime',
        'status' => 'boolean',
    ];

    // Relación con garantía
    public function garantia()
    {
        return $this->hasOne(Garantine::class, 'nro_motor', 'nro_motor')
            ->where('status', 1)
            ->latest();
    }

    // Relación con usuario que registró
    public function userRegistered()
    {
        return $this->belongsTo(User::class, 'user_register');
    }

    // Relación con usuario que actualizó
    public function userUpdated()
    {
        return $this->belongsTo(User::class, 'user_update');
    }

    // Auto-asignar usuario al crear/actualizar
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_register = auth()->id();
        });
        
        static::updating(function ($model) {
            $model->user_update = auth()->id();
        });
    }
}
