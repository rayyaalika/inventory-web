<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $primaryKey = 'id_category';
    protected $fillable = [
        'category_name',
    ];

    public function product()
    {
        return $this->hasMany(Product::class, 'id_product');
    }

    public function subcategory()
    {
        return $this->hasMany(Subcategory::class, 'id_subcategory');
    }
}
