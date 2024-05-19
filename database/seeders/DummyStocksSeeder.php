<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyStocksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $StocksData = [
            [
                'id_product'=>1,
                'wh_stock' => 0,
                'in_stock' => 0,
                'out_stock' => 0,
                'real_stock' => 0,
                'alert_stock' => 0,
            ],
            [
                'id_product'=>2,
                'wh_stock' => 0,
                'in_stock' => 0,
                'out_stock' => 0,
                'real_stock' => 0,
                'alert_stock' => 0,
            ],
        ];

        foreach($StocksData as $data){
            Stock::create($data);
        }
    }
}
