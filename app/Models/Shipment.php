<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;
    protected $table = 'shipment';
    protected $primaryKey = 'id_shipment';
    protected $fillable = [
        'delivery_company',
        'payment_receipt',
        'shipment_status',
        'shipment_resi',
        'id_sales',
        'id_user',
    ];
    
    public function salesquotation()
    {
        return $this->belongsTo(Salesquotation::class, 'id_sales', 'id_sales');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
