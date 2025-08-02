<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScannedCode extends Model
{
    use HasFactory;

    protected $fillable = ['stock_id', 'code'];

    protected $casts = [
        'scanned_codes' => 'array'
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
