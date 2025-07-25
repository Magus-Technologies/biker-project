<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drive extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_doc',
        'nro_documento',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        // 'nacionalidad', // ya no se usa
        // 'nro_licencia', //  ya no se usa
        // 'categoria_licencia', // ya no se usa
        'fecha_nacimiento',
        'telefono',
        'correo',
        'foto',
        'departamento',
        'provincia',
        'distrito',
        'direccion_detalle',
        'user_register',
        'nombres_contacto',
        'telefono_contacto',
        'parentesco_contacto',
        'user_update',
        'fecha_registro',
        'fecha_actualizacion',
        'status',
        'codigo',
        'nro_motor',
        'nro_chasis', // NUEVO CAMPO
        'nro_placa',  // NUEVO CAMPO
    ];

    public $timestamps = true;

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_registro' => 'datetime',
        'fecha_actualizacion' => 'datetime',
        'status' => 'boolean',
    ];

    public function userRegistered()
    {
        return $this->belongsTo(User::class, 'user_register');
    }

    public function userUpdated()
    {
        return $this->belongsTo(User::class, 'user_update');
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
}