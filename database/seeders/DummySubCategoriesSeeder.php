<?php

namespace Database\Seeders;

use App\Models\Subcategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummySubCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $SubCategoryData = [
            [
                'id_category'=>1,
                'sub_category_name'=>'Vegetables',
            ],
            [
                'id_category'=>1,
                'sub_category_name'=>'Fruits',
            ],
            [
                'id_category'=>1,
                'sub_category_name'=>'Snack',
            ],
            [
                'id_category'=>2,
                'sub_category_name'=>'Hoodies',
            ],
            [
                'id_category'=>2,
                'sub_category_name'=>'T-shirts',
            ],
        ];

        foreach($SubCategoryData as $data){
            Subcategory::create($data);
        }
    }
}
