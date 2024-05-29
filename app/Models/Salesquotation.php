<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salesquotation extends Model
{
    use HasFactory;
    protected $table = 'salesquotations';
    protected $primaryKey = 'id_sales';
    protected $fillable = [
        'transaction_date',
        'sq_numbering',

        'warehouse',
        'staff_name',

        'socmed_type',
        'socmed_username',
        'customer_name',
        'customer_phone_number',
        'customer_address',
        'address_picture',

        'delivery_company',
        'payment_receipt',
        'shipment_status',
        'shipment_resi',

        'qty_sales',
        'total_order',
        'send_date',
        'sales_note',
        'sales_status',
        'resi_number',
        'id_store',
        'id_product',
        'id_user',
        // 'id_customer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }

    public function user()
    {
        return $this->belongsTo(user::class, 'id_user', 'id_user');
    }

    public function shipment()
    {
        return $this->hasMany(Shipment::class, 'id_shipment');
    }

    public function store()
    {
        return $this->belongsTo(store::class, 'id_store', 'id_store');
    }

    // public function customer()
    // {
    //     return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    // }
}
