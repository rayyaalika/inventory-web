<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salesproduct extends Model
{
    use HasFactory;

    protected $table = 'salesproducts';
    protected $primaryKey = 'id_salesproduct';
    protected $fillable = [
        'salesproduct_name',
        'salesproduct_price',
        'quantity',
        'id_product',
        'id_sales',
        'id_stock',
    ];

    public function salesquotation()
    {
        return $this->belongsTo(Salesquotation::class, 'id_sales', 'id_sales');
    }

    public function product()
    {
        return $this->belongsTo(product::class, 'id_product', 'id_product');
    }
}
