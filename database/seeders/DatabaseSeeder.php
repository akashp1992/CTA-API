<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GroupsTableSeeder::class);
        $this->call(OrganizationsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ConfigurationsTableSeeder::class);

        // $this->call(SuppliersTableSeeder::class);
        // $this->call(PagesTableSeeder::class);
        // $this->call(BannersTableSeeder::class);
        // $this->call(CustomersTableSeeder::class);

        // $this->call(ServiceTypesTableSeeder::class);
        // $this->call(CategoriesTableSeeder::class);
        // $this->call(ItemsTableSeeder::class);
    }
}
