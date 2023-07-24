<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BranchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branch = new \App\Models\Branch();
        $branch->truncate();

        $branch->Create([
            'slug'                 => strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)),
            'organization_id'      => 1,
            'name'                 => 'Main Branch',
            'arabic_name'          => 'Main Branch',
            'identifier'           => 'cta',
            'contact_person'       => 'Harsh',
            'phone'                => '0067685242',
            'email'                => 'harsh@cta.com',
            'start_time'           => '10:00',
            'end_time'             => '19:00',
            'location'             => '345 water street, India',
            'latitude'             => 12.34,
            'longitude'            => 12.34,
            'is_active'            => 1,
            'created_by'           => 1,
            'updated_by'           => 1
        ]);
    }
}
