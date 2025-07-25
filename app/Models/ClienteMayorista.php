<?php
// app/Models/ClienteMayorista.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ClienteMayorista extends Model
{
    use HasFactory;

    protected $table = 'clientes_mayoristas';

    protected $fillable = [
        'codigo',
        'tipo_doc',
        'nro_documento',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'nombre_negocio',
        'tienda',
        'telefono',
        'correo',
        'departamento',
        'provincia',
        'distrito',
        'direccion_detalle',
        'nombres_contacto',
        'telefono_contacto',
        'parentesco_contacto',
        'foto',
        'status',
        'user_register',
        'user_update',
        'fecha_registro',
        'fecha_actualizacion'
    ];

    protected $casts = [
        'fecha_registro' => 'datetime',
        'fecha_actualizacion' => 'datetime',
        'status' => 'boolean'
    ];

    // Relaciones
    public function usuarioRegistro()
    {
        return $this->belongsTo(User::class, 'user_register');
    }

    public function usuarioActualizacion()
    {
        return $this->belongsTo(User::class, 'user_update');
    }

    // Accessor para nombre completo
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombres} {$this->apellido_paterno} {$this->apellido_materno}";
    }

    // Accessor para dirección completa
    public function getDireccionCompletaAttribute()
    {
        return "{$this->direccion_detalle}, {$this->distrito}, {$this->provincia}, {$this->departamento}";
    }
}