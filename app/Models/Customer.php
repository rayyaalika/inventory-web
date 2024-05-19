<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customer';
    protected $primaryKey = 'id_customer';
    protected $fillable = [
        'socmed_type',
        'socmed_username',
        'customer_name',
        'customer_phone_number',
    ];

    public function shipmentsaddress()
    {
        return $this->hasMany(Shipmentaddress::class, 'id_address');
    }

    public function salesquotation()
    {
        return $this->hasMany(Salesquotation::class, 'id_sales');
    }
}
