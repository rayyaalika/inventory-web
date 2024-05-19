<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $table = 'stores';
    protected $primaryKey = 'id_store';
    protected $fillable = [
        'store_name',
        'store_address',
        'store_phone_number',
    ];

    public function salesquotation()
    {
        return $this->hasMany(Salesquotation::class, 'id_sales');
    }
}
