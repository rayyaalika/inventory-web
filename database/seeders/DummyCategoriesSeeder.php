<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $CategoryData = [
            [
                'id_category'=>1,
                'category_name'=>'Food',
            ],
            [
                'id_category'=>2,
                'category_name'=>'Clothing',
            ],
        ];

        foreach($CategoryData as $data){
            Category::create($data);
        }
    }
}
