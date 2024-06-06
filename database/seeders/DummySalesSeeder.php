<?php

namespace Database\Seeders;

use App\Models\Salesquotation;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummySalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now();
        $SalesData = [
            [
                'transaction_date' => $date,
                'sq_numbering' => 'SQ1234567',
                'warehouse' => 'WH 1',
                'staff_name' => 'Adinda',
                'socmed_type' => 'WhatsApp',
                'socmed_username' => null,
                'customer_name' => 'Karina Yu',
                'customer_phone_number' => '082134567890',
                'customer_address' => null,
                'address_picture' => null,
                'delivery_company' => 5,
                'payment_receipt' => null,
                'qty_sales' => null,
                'total_order' => null,
                'send_date' => null,
                'sales_note' => null,
                'resi_number' => '23456756',
                'id_store' => 1,
                // 'id_product' => null,
                'id_user' => 1,
            ],
            [
                'transaction_date' => $date,
                'sq_numbering' => 'SQ8753643',
                'warehouse' => 'WH 1',
                'staff_name' => 'Adinda',
                'socmed_type' => 'Instagram',
                'socmed_username' => 'aerichandesu',
                'customer_name' => 'Aeri Uchinaga',
                'customer_phone_number' => '0821567889',
                'customer_address' => null,
                'address_picture' => null,
                'delivery_company' => 5,
                'payment_receipt' => null,
                'qty_sales' => null,
                'total_order' => null,
                'send_date' => null,
                'sales_note' => null,
                'resi_number' => '68732462',
                'id_store' => 1,
                // 'id_product' => null,
                'id_user' => 1,
            ],
        ];

        foreach($SalesData as $data){
            Salesquotation::create($data);
        }
    }
}
