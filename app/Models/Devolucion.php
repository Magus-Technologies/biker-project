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
    
    protected $casts = [
        'total_amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
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
    
    // Método para obtener el total de items devueltos
    public function getTotalItemsAttribute() {
        return $this->items->sum('quantity_returned');
    }
    
    // Método para verificar si la devolución tiene items
    public function hasItems() {
        return $this->items->count() > 0;
    }
    
    // Método para obtener el estado de la devolución
    public function getStatusAttribute() {
        if ($this->items->count() == 0) {
            return 'Sin items';
        }
        return 'Procesada';
    }
    
    // Scope para filtrar por fechas
    public function scopeFilterByDate($query, $fechaDesde, $fechaHasta) {
        return $query->whereDate('created_at', '>=', $fechaDesde)
                     ->whereDate('created_at', '<=', $fechaHasta);
    }
    
    // Scope para filtrar por usuario
    public function scopeFilterByUser($query, $userId) {
        return $query->where('user_register', $userId);
    }
    
    // Scope para filtrar por venta
    public function scopeFilterBySale($query, $saleId) {
        return $query->where('sale_id', $saleId);
    }
}
