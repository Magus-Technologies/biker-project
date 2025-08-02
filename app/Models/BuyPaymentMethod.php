<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyPaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'buy_payment_methods';
    
    protected $fillable = [
        'buy_id',
        'payment_method_id', 
        'amount',
        'installments',
        'due_date'
    ];

    public function buy()
    {
        return $this->belongsTo(Buy::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

        public function creditInstallments()
    {
        return $this->hasMany(BuyCreditInstallment::class);
    }

}
