<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'dashboard']);
        Permission::create(['name' => 'users.index']);
        Permission::create(['name' => 'users.show']);
        Permission::create(['name' => 'users.edit']);
        Permission::create(['name' => 'users.update']);
        Permission::create(['name' => 'users.destroy']);
        Permission::create(['name' => 'users.status']);
        Permission::create(['name' => 'products.index']);
        Permission::create(['name' => 'products.show']);
        Permission::create(['name' => 'products.edit']);
        Permission::create(['name' => 'products.update']);
        Permission::create(['name' => 'products.destroy']);
        Permission::create(['name' => 'products.status']);
        Permission::create(['name' => 'stores.index']);

        $roleAdmin = Role::create(['name' => 'admin']);
        $roleAdmin->givePermissionTo(Permission::all());

        $roleUser = Role::create(['name' => 'user']);
        $roleUser->givePermissionTo('stores.index');
    }
}
