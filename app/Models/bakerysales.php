<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bakerysales extends Model
{
    use HasFactory;
    protected $table = 'bakery_sale';
    protected $primaryKey = 'id_bakerysale';
    protected $fillable = [
        'date',
        'item_name',
        'quantity'
    ];
}
