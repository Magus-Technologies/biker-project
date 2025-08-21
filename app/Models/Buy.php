<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_dni',
        'customer_names_surnames',
        'customer_address',
        'total_price',
        'igv',
        'observation',
        'serie',
        'number',
        'status',
        'status_buy',
        'document_type_id',
        'user_register',
        'user_update',
        'fecha_registro',
        'fecha_vencimiento',
        'fecha_actualizacion',
        // NUEVOS CAMPOS:
        'supplier_id',
        'warehouse_id', 
        'payment_type', // 'cash' o 'credit'
        'delivery_status', // 'received' o 'pending'
        'received_date',
        'tienda_id'
    ];

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function userRegister()
    {
        return $this->belongsTo(User::class, 'user_register');
    }

    public function buyItems()
    {
        return $this->hasMany(BuyItem::class);
    }

    // Agregar estas relaciones después de la función documentType():
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function tienda()
    {
        return $this->belongsTo(Tienda::class);
    }

    public function paymentMethods()
    {
        return $this->hasMany(BuyPaymentMethod::class);
    }

    public function priceHistories()
    {
        return $this->hasMany(ProductPriceHistory::class);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_register = auth()->id();
            $model->fecha_registro = now();
        });

        static::updating(function ($model) {
            $model->user_update = auth()->id();
            $model->fecha_actualizacion = now();
        });
    }

    // En app/Models/Buy.php - agregar relación
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

}
