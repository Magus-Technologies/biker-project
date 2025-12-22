<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaPendiente extends Model
{
    use HasFactory;

    protected $table = 'ventas_pendientes';

    protected $fillable = [
        'user_id',
        'tipo',
        'datos',
        'fecha_guardado',
    ];

    protected $casts = [
        'datos' => 'array', // Automáticamente convierte JSON a array
        'fecha_guardado' => 'datetime',
    ];

    /**
     * Relación con el usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener venta pendiente por usuario y tipo
     */
    public static function obtenerPorUsuarioYTipo($userId, $tipo)
    {
        return self::where('user_id', $userId)
            ->where('tipo', $tipo)
            ->first();
    }

    /**
     * Guardar o actualizar venta pendiente
     */
    public static function guardarVentaPendiente($userId, $tipo, $datos)
    {
        return self::updateOrCreate(
            [
                'user_id' => $userId,
                'tipo' => $tipo,
            ],
            [
                'datos' => $datos,
                'fecha_guardado' => now(),
            ]
        );
    }

    /**
     * Limpiar venta pendiente
     */
    public static function limpiarVentaPendiente($userId, $tipo)
    {
        return self::where('user_id', $userId)
            ->where('tipo', $tipo)
            ->delete();
    }

    /**
     * Limpiar ventas pendientes antiguas (más de 7 días)
     */
    public static function limpiarVentasAntiguas()
    {
        return self::where('fecha_guardado', '<', now()->subDays(7))->delete();
    }
}
