<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $StoreData = [
            [
                'store_name'=>'TUKU',
                'store_address'=>'Gangnam, Seoul',
                'store_phone_number'=>'029839128',
            ],
            [
                'store_name'=>'HALOBALI',
                'store_address'=>'Gwangan-dong, Busan',
                'store_phone_number'=>'029634728',
            ],
        ];

        foreach($StoreData as $data){
            Store::create($data);
        }
    }
}
