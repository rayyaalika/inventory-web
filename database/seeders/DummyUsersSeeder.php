<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userData = [
            [
                'name'=>'Super Admin',
                'email'=>'superadmin@example.com',
                'role'=>'Super Admin',
                'password'=>bcrypt('12345678'),
            ],
            [
                'name'=>'Store Admin',
                'email'=>'storeadmin@example.com',
                'role'=>'Store Admin',
                'password'=>bcrypt('12345678'),
            ],
            [
                'name'=>'Supplier',
                'email'=>'supplier@example.com',
                'role'=>'Supplier',
                'password'=>bcrypt('12345678'),
            ],
            [
                'name'=>'Customer Service',
                'email'=>'customerservice@example.com',
                'role'=>'Customer Service',
                'password'=>bcrypt('12345678'),
            ],
            [
                'name'=>'Sales Order',
                'email'=>'salesorder@example.com',
                'role'=>'Sales Order',
                'password'=>bcrypt('12345678'),
            ]
        ];

        foreach($userData as $data){
            User::create($data);
        }
    }
}
