<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ProductData = [
            [
                'product_type' => 1,
                'product_brand' => 'KOBE',
                'product_color' => 'GREEN',
                'product_name' => 'POTABEE GRILLED SEAWEED',
                'product_chinese_name'  => null,
                'product_english_name'  => null,
                'product_slug'  => null,
                'product_barcode' => 'PGS1234',
                'product_cost' => '8',
                'product_price' => '12',
                'alert_quantity' => null,
                'product_weight' => null ,
                'product_lenght' => null,
                'product_height' => null,
                'product_width' => null,
                'group_unit' => 'PIECES',
                'default_inventory_unit' => 'PIECES',
                'default_sale_unit' => 'PIECES',
                'default_purchase_unit' => 'PIECES',
                'product_tax' => null,
                'tax_method' => null,
                'link_product' => null,
                'link_video' => null,
                'pre_order_type' => null,
                'branch_owner' => null,
                'tumbnail_image' => null,
                'product_details' => null, 
                'id_supplier' => 1,
                'id_category' => 1,
                'id_sub_category' => 3,
                'id_user' => 1,
            ],
            [
                'product_type' => 2,
                'product_brand' => 'UNIQLO',
                'product_color' => 'RED',
                'product_name' => 'DISNEY SHORT SLEVE UT',
                'product_chinese_name'  => null,
                'product_english_name'  => null,
                'product_slug'  => null,
                'product_barcode' => 'PGS1234',
                'product_cost' => '120',
                'product_price' => '180',
                'alert_quantity' => null,
                'product_weight' => null ,
                'product_lenght' => null,
                'product_height' => null,
                'product_width' => null,
                'group_unit' => 'PIECES',
                'default_inventory_unit' => 'PIECES',
                'default_sale_unit' => 'PIECES',
                'default_purchase_unit' => 'PIECES',
                'product_tax' => null,
                'tax_method' => null,
                'link_product' => null,
                'link_video' => null,
                'pre_order_type' => null,
                'branch_owner' => null,
                'tumbnail_image' => null,
                'product_details' => null, 
                'id_supplier' => 1,
                'id_category' => 2,
                'id_sub_category' => 5,
                'id_user' => 1,
            ],
        ];

        foreach($ProductData as $data){
            Product::create($data);
        }
    }
}
