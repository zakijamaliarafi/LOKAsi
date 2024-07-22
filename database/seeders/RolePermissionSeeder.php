<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'create-user']);
        Permission::create(['name' => 'update-user']);
        Permission::create(['name' => 'delete-user']);
        Permission::create(['name' => 'show-user']);

        Permission::create(['name' => 'create-location']);
        Permission::create(['name' => 'update-location']);
        Permission::create(['name' => 'delete-location']);
        Permission::create(['name' => 'show-location']);

        Permission::create(['name' => 'verify-report']);
        Permission::create(['name' => 'create-report']);

        Permission::create(['name' => 'login']);

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'coordinator']);
        Role::create(['name' => 'contributor']);
        Role::create(['name' => 'user']);
        Role::create(['name' => 'none']);

        $roleAdmin = Role::findByName('admin');
        $roleAdmin->givePermissionTo([
            'create-user',
            'update-user',
            'delete-user',
            'show-user',
            'create-location',
            'update-location',
            'delete-location',
            'show-location',
            'verify-report',
            'login'
        ]);

        $roleCoordinator = Role::findByName('coordinator');
        $roleCoordinator->givePermissionTo([
            'create-location',
            'update-location',
            'delete-location',
            'show-location',
            'verify-report',
            'login'
        ]);

        $roleContributor = Role::findByName('contributor');
        $roleContributor->givePermissionTo([
            'create-report',
            'show-location',
            'login'
        ]);

        $roleUser = Role::findByName('user');
        $roleUser->givePermissionTo([
            'show-location',
            'login'
        ]);
    }
}