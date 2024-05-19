<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'suppliers';
    protected $primaryKey = 'id_supplier';
    protected $fillable = [
        'supplier_company',
        'supplier_name',
        'supplier_type',
        'supplier_country',
        'supplier_address',
        'supplier_phone_number',
        'supplier_city',
        'supplier_postal_code',
        'supplier_email',
        'supplier_currency',
        'vat_number',
        'gst_number',
    ];

    public function product()
    {
        return $this->hasMany(Product::class, 'id_product');
    }
}
