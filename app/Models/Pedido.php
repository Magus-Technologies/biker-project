<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'customer_dni',
        'customer_names_surnames',
        'customer_phone',
        'customer_address',
        'districts_id',
        'mechanics_id',
        'user_register',
        'user_update',
        'status',
        'priority',
        'observation',
        'subtotal',
        'igv',
        'total',
        'sale_id',
        'converted_at',
        'expires_at',
        'fecha_registro',
        'fecha_actualizacion',
    ];

    protected $casts = [
        'converted_at' => 'datetime',
        'expires_at' => 'date',
        'subtotal' => 'decimal:2',
        'igv' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_register = auth()->id();

            // Generar código automático
            if (empty($model->code)) {
                $lastPedido = self::orderBy('id', 'desc')->first();
                $nextNumber = $lastPedido ? $lastPedido->id + 1 : 1;
                $model->code = 'PED-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
            }
        });

        static::updating(function ($model) {
            $model->user_update = auth()->id();
        });
    }

    // Relaciones
    public function userRegister()
    {
        return $this->belongsTo(User::class, 'user_register');
    }

    public function userUpdate()
    {
        return $this->belongsTo(User::class, 'user_update');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'districts_id');
    }

    public function mechanic()
    {
        return $this->belongsTo(User::class, 'mechanics_id');
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function items()
    {
        return $this->hasMany(PedidoItem::class);
    }

    public function services()
    {
        return $this->hasMany(PedidoService::class);
    }

    // Scopes
    public function scopePendiente($query)
    {
        return $query->where('status', 'pendiente');
    }

    public function scopeConfirmado($query)
    {
        return $query->where('status', 'confirmado');
    }

    public function scopeConvertido($query)
    {
        return $query->where('status', 'convertido');
    }

    public function scopeCancelado($query)
    {
        return $query->where('status', 'cancelado');
    }

    // Métodos auxiliares
    public function isPendiente()
    {
        return $this->status === 'pendiente';
    }

    public function isConfirmado()
    {
        return $this->status === 'confirmado';
    }

    public function isConvertido()
    {
        return $this->status === 'convertido';
    }

    public function isCancelado()
    {
        return $this->status === 'cancelado';
    }

    public function canBeEdited()
    {
        return in_array($this->status, ['pendiente', 'confirmado']);
    }

    public function canBeConverted()
    {
        return $this->status === 'confirmado';
    }

    // Calcular totales
    public function calculateTotals()
    {
        $itemsTotal = $this->items->sum(function ($item) {
            return $item->quantity * $item->unit_price;
        });

        $servicesTotal = $this->services->sum('price');

        $total = $itemsTotal + $servicesTotal;
        $igv = $total * 0.18;
        $subtotal = $total - $igv;

        $this->update([
            'subtotal' => $subtotal,
            'igv' => $igv,
            'total' => $total,
        ]);

        return $this;
    }
}
