<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $table = 'stocks';
    protected $primaryKey = 'id_stock';
    protected $fillable = [
        'wh_stock',
        'in_stock',
        'out_stock',
        'real_stock',
        'alert_stock',
        'id_product',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }
}
