<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forecasting extends Model
{
    use HasFactory;
    protected $table = 'forecastings';
    protected $primaryKey = 'id_forecasting';
    protected $fillable = [
        'date',
        'parameter',
        'value',
        // 'id_product',
    ];

    // public function product()
    // {
    //     return $this->belongsTo(Product::class, 'id_product', 'id_product');
    // }
}
