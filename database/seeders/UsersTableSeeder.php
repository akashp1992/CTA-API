<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\Models\User();
        $user->truncate();

        $user->create([
            'organization_id'   => 1,
            'group_id'          => 1,
            'slug'              => strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)),
            'first_name'        => 'Vidhya Modi',
            'last_name'         => 'Cta',
            'email'             => 'vidhya@cta.com',
            'phone'             => '8320058628',
            'password'          => bcrypt(123456789),
            'is_root_user'      => 1,
            'email_verified_at' => \Carbon\Carbon::now()
        ]);

        $user->create([
            'organization_id'   => 1,
            'group_id'          => 1,
            'slug'              => strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)),
            'first_name'        => 'Harsh',
            'last_name'         => 'Cta',
            'email'             => 'harsh@cta.com',
            'phone'             => '8320058628',
            'password'          => bcrypt(123456789),
            'email_verified_at' => \Carbon\Carbon::now()
        ]);
    }
}
