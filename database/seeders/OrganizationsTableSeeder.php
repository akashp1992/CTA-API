<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $organization = new \App\Models\Organization();
        $organization->truncate();

        $organization->Create([
            'slug'                 => strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)),
            'name'                 => 'Cta ( Root )',
            'identifier'           => 'cta',
            'start_date'           => '2023-01-01',
            'end_date'             => '2023-12-31',
            'business_type'        => 'Gaming Zone',
            'business_email'       => 'harsh@cta.com',
            'civil_id_number'      => '1234567890',
            'contact_person'       => 'harsh',
            'email'                => 'harsh@cta.com',
            'phone'                => '8320058628',
            'users_count'          => 5,
            'currency_code'        => 'KD',
            'payment_gateway'      => 'fatoorah',
            'is_root_organization' => 1,
            'is_active'            => 1,
            'is_RTL_enabled'       => 1,
            'created_by'           => 1,
            'updated_by'           => 1
        ]);
    }
}
