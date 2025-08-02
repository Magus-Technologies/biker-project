<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'clientes_mayoristas'; // Reutilizamos la tabla existente
    
    protected $fillable = [
        'codigo',
        'tipo_doc',
        'nro_documento',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'nombre_negocio',
        'telefono',
        'correo',
        'direccion_detalle',
        'status',
        'user_register',
        'user_update'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_register = auth()->id();
            $model->codigo = self::generateCode();
        });
        static::updating(function ($model) {
            $model->user_update = auth()->id();
        });
    }

    public static function generateCode()
    {
        $lastCode = self::max('codigo') ?? 'PROV000';
        $number = intval(substr($lastCode, 4)) + 1;
        return 'PROV' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    public function getFullNameAttribute()
    {
        return trim($this->nombres . ' ' . $this->apellido_paterno . ' ' . $this->apellido_materno);
    }
}
