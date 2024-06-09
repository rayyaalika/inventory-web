<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $primaryKey = 'id_product';
    protected $fillable = [
        'product_type',
        'product_brand',
        'product_color',
        'product_name',
        'product_chinese_name',
        'product_english_name',
        'product_code',
        'product_slug',
        'product_barcode',
        'product_cost',
        'product_price',
        'alert_quantity',
        'product_weight',
        'product_lenght',
        'product_height',
        'product_width',
        'group_unit',
        'default_inventory_unit',
        'default_sale_unit',
        'default_purchase_unit',
        'product_tax',
        'tax_method',
        'link_product',
        'link_video',
        'pre_order_type',
        'branch_owner',
        'tumbnail_image',
        'product_details',
        'id_supplier',
        'id_category',
        'id_sub_category',
        'id_user'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category', 'id_category');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'id_sub_category', 'id_sub_category');
    }

    public function Stok()
    {
        return $this->hasMany(Stock::class, 'id_product');
    }

    public function Supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id_supplier');
    }

    public function salesproduct()
    {
        return $this->hasMany(salesproduct::class, 'id_product', 'id_product');
    }

    public function forecasting()
    {
        return $this->hasMany(Forecasting::class, 'id_forecasting', 'id_forecasting');
    }

    public function user()
    {
        return $this->belongsTo(user::class, 'id_user', 'id_user');
    }
}
