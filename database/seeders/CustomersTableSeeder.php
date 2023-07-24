<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer = new \App\Models\Customer();

        $customer->truncate();
        $customer->create([
            'organization_id' => 1,
            'slug'            => strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)),
            'code'            => 'CUS-' . mt_rand(100000, 999999),
            'first_name'        => 'Vidhya',
            'last_name'         => 'Cta',
            'email'           => 'vidhya@gmail.com',
            'phone'           => '9999999991',
            'gender'          => 'female',
            'birth_date'      => '31-08-1993',
            'password'        => bcrypt(123456),
            'is_active'       => 1,
        ]);

        $customer->create([
            'organization_id' => 1,
            'slug'            => strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)),
            'code'            => 'CUS-' . mt_rand(100000, 999999),
            'first_name'      => 'Harsh',
            'last_name'       => 'Cta',
            'email'           => 'steve.jobs@gmail.com',
            'phone'           => '9999999992',
            'gender'          => 'male',
            'birth_date'      => '31-08-1993',
            'password'        => bcrypt(123456),
            'is_active'       => 1,
        ]);
    }
}
