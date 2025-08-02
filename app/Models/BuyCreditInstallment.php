<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyCreditInstallment extends Model
{
    use HasFactory;

    protected $fillable = [
        'buy_payment_method_id',
        'installment_number',
        'amount',
        'due_date',
        'status',
        'paid_at'
    ];

    protected $casts = [
        'due_date' => 'date',
        'paid_at' => 'datetime'
    ];

    public function buyPaymentMethod()
    {
        return $this->belongsTo(BuyPaymentMethod::class);
    }
}
