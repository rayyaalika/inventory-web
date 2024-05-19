<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;
    protected $table = 'subcategories';
    protected $primaryKey = 'id_sub_category';
    protected $fillable = [
        'sub_category_name',
        'id_category',
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category', 'id_category');
    }

    public function product()
    {
        return $this->hasMany(Product::class, 'id_product');
    }
}
