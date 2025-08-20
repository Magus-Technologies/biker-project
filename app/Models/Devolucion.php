<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
    use HasFactory;
    
    protected $table = 'devoluciones';
    
    protected $fillable = [
        'code', 
        'sale_id', 
        'total_amount', 
        'reason', 
        'user_register'
    ];
    
    public function sale() {
        return $this->belongsTo(Sale::class);
    }
    
    public function items() {
        return $this->hasMany(DevolucionItem::class);
    }
    
    public function userRegister() {
        return $this->belongsTo(User::class, 'user_register');
    }
}
