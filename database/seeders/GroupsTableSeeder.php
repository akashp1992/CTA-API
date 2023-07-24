<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $group = new \App\Models\Group();
        $group->truncate();

        $groups = [
            'Super Admins',
            'Organization Admins',
            'Cashiers'
        ];

        foreach ($groups as $group_individual) {
            $group
                ->create([
                    'slug'          => strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)),
                    'name'          => $group_individual,
                    'description'   => $group_individual,
                    'is_active'     => 1,
                    'is_restricted' => 1
                ]);
        }

        $group_has_access = new \App\Models\GroupHasAccess();

        $super_admin_accesses = [
            'users.index', 'users.edit', 'users.create', 'users.show',
            'customers.index', 'customers.create', 'customers.show', 'customers.edit', 'customers.delete',
            'companies.index', 'companies.create', 'companies.show', 'companies.edit', 'companies.delete',
            'pages.index', 'pages.create', 'pages.show', 'pages.edit', 'pages.delete',
            'organizations.index', 'organizations.create', 'organizations.show', 'organizations.edit', 'organizations.delete',
            'groups.index', 'groups.create', 'groups.show', 'groups.edit', 'groups.delete',
            'configurations.index',
        ];
        foreach ($super_admin_accesses as $super_admin_access) {
            $group_has_access->create([
                'group_id' => 1,
                'module'   => $super_admin_access,
                'access'   => 1
            ]);
        }

        $organization_admin_accesses = [
            'users.index', 'users.edit', 'users.create', 'users.show',
            'customers.index', 'customers.create', 'customers.show', 'customers.edit', 'customers.delete',
            'companies.index', 'companies.create', 'companies.show', 'companies.edit', 'companies.delete',
            'pages.index', 'pages.create', 'pages.show', 'pages.edit', 'pages.delete',
            'configurations.index',
        ];
        foreach ($organization_admin_accesses as $organization_admin_access) {
            $group_has_access->create([
                'group_id' => 2,
                'module'   => $organization_admin_access,
                'access'   => 1
            ]);
        }
    }
}
