<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipmentaddress extends Model
{
    use HasFactory;
    protected $table = 'shipmentaddress';
    protected $primaryKey = 'id_address';
    protected $fillable = [
        'address_details',
        'address_picture',
        'address_status',
        'id_customer'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }
}
