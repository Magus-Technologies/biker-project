<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CajaMovimiento extends Model
{
    use HasFactory;

    protected $table = 'caja_movimientos';

    protected $fillable = [
        'caja_id',
        'tipo',
        'concepto',
        'monto',
        'metodo_pago_id',
        'sale_id',
        'descripcion',
        'comprobante',
        'user_id',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
    ];

    // Relaciones
    public function caja()
    {
        return $this->belongsTo(Caja::class, 'caja_id');
    }

    public function metodoPago()
    {
        return $this->belongsTo(PaymentMethod::class, 'metodo_pago_id');
    }

    public function venta()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Scopes
    public function scopeIngresos($query)
    {
        return $query->where('tipo', 'ingreso');
    }

    public function scopeEgresos($query)
    {
        return $query->where('tipo', 'egreso');
    }

    public function scopeVentas($query)
    {
        return $query->where('concepto', 'venta');
    }

    public function scopeGastos($query)
    {
        return $query->where('concepto', 'gasto');
    }

    public function scopeHoy($query)
    {
        return $query->whereDate('created_at', today());
    }

    // Métodos auxiliares
    public function esIngreso()
    {
        return $this->tipo === 'ingreso';
    }

    public function esEgreso()
    {
        return $this->tipo === 'egreso';
    }

    public function getMontoFormateadoAttribute()
    {
        return 'S/ ' . number_format($this->monto, 2);
    }

    public function getIconoConceptoAttribute()
    {
        $iconos = [
            'venta' => 'bi-cart-check',
            'devolucion' => 'bi-arrow-return-left',
            'gasto' => 'bi-cash-stack',
            'retiro' => 'bi-arrow-down-circle',
            'deposito' => 'bi-arrow-up-circle',
            'ajuste' => 'bi-gear',
            'apertura' => 'bi-unlock',
        ];

        return $iconos[$this->concepto] ?? 'bi-circle';
    }

    public function getColorConceptoAttribute()
    {
        $colores = [
            'venta' => 'text-green-600',
            'devolucion' => 'text-red-600',
            'gasto' => 'text-orange-600',
            'retiro' => 'text-red-600',
            'deposito' => 'text-green-600',
            'ajuste' => 'text-blue-600',
            'apertura' => 'text-purple-600',
        ];

        return $colores[$this->concepto] ?? 'text-gray-600';
    }
}
