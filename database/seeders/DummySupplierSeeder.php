<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummySupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $SupplierData = [
            [
            'supplier_company'=>'PT. GARUDA FOOD',
            'supplier_name'=>'GARUDA FOOD',
            'supplier_type'=>'local',
            'supplier_country'=>'Indoenesia',
            'supplier_address'=>'Sidoarjo',
            'supplier_phone_number'=>'628912783',
            'supplier_city'=>'Surabaya',
            'supplier_postal_code'=> null,
            'supplier_email'=> 'garuda@gmail.com',
            'supplier_currency'=>'NTD',
            'vat_number'=> null,
            'gst_number'=> null,
            ],
        ];

        foreach($SupplierData as $data){
            Supplier::create($data);
        }
    }
}
