<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $table = 'cajas';

    protected $fillable = [
        'codigo',
        'user_id',
        'tienda_id',
        'fecha_apertura',
        'fecha_cierre',
        'monto_inicial',
        'monto_ventas_efectivo',
        'monto_ventas_tarjeta',
        'monto_ventas_transferencia',
        'monto_ventas_otros',
        'monto_gastos',
        'monto_retiros',
        'monto_depositos',
        'monto_final_esperado',
        'monto_final_real',
        'diferencia',
        'estado',
        'observaciones_apertura',
        'observaciones_cierre',
        'user_cierre',
    ];

    protected $casts = [
        'fecha_apertura' => 'datetime',
        'fecha_cierre' => 'datetime',
        'monto_inicial' => 'decimal:2',
        'monto_ventas_efectivo' => 'decimal:2',
        'monto_ventas_tarjeta' => 'decimal:2',
        'monto_ventas_transferencia' => 'decimal:2',
        'monto_ventas_otros' => 'decimal:2',
        'monto_gastos' => 'decimal:2',
        'monto_retiros' => 'decimal:2',
        'monto_depositos' => 'decimal:2',
        'monto_final_esperado' => 'decimal:2',
        'monto_final_real' => 'decimal:2',
        'diferencia' => 'decimal:2',
    ];

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function usuarioCierre()
    {
        return $this->belongsTo(User::class, 'user_cierre');
    }

    public function tienda()
    {
        return $this->belongsTo(Tienda::class, 'tienda_id');
    }

    public function movimientos()
    {
        return $this->hasMany(CajaMovimiento::class, 'caja_id');
    }

    public function ventas()
    {
        return $this->hasMany(Sale::class, 'caja_id');
    }

    // Scopes
    public function scopeAbierta($query)
    {
        return $query->where('estado', 'abierta');
    }

    public function scopeCerrada($query)
    {
        return $query->where('estado', 'cerrada');
    }

    public function scopeDelUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeHoy($query)
    {
        return $query->whereDate('fecha_apertura', today());
    }

    // Métodos auxiliares
    public function estaAbierta()
    {
        return $this->estado === 'abierta';
    }

    public function estaCerrada()
    {
        return $this->estado === 'cerrada';
    }

    public function calcularMontoFinalEsperado()
    {
        return $this->monto_inicial 
            + $this->monto_ventas_efectivo 
            + $this->monto_depositos 
            - $this->monto_gastos 
            - $this->monto_retiros;
    }

    public function calcularDiferencia()
    {
        if ($this->monto_final_real === null) {
            return null;
        }
        return $this->monto_final_real - $this->monto_final_esperado;
    }

    public function getTotalVentasAttribute()
    {
        return $this->monto_ventas_efectivo 
            + $this->monto_ventas_tarjeta 
            + $this->monto_ventas_transferencia 
            + $this->monto_ventas_otros;
    }

    public function getTotalEgresosAttribute()
    {
        return $this->monto_gastos + $this->monto_retiros;
    }

    public function getTotalIngresosAttribute()
    {
        return $this->total_ventas + $this->monto_depositos;
    }

    // Generar código único
    public static function generarCodigo()
    {
        $ultimoCodigo = self::max('codigo') ?? 'CAJ-0000';
        $numero = intval(substr($ultimoCodigo, 4)) + 1;
        return 'CAJ-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }

    // Verificar si el usuario tiene una caja abierta
    public static function usuarioTieneCajaAbierta($userId)
    {
        return self::where('user_id', $userId)
            ->where('estado', 'abierta')
            ->exists();
    }

    // Obtener caja abierta del usuario
    public static function cajaAbiertaDelUsuario($userId)
    {
        return self::where('user_id', $userId)
            ->where('estado', 'abierta')
            ->first();
    }
}
