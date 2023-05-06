<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Permission::create(['name'=>'dashboard']);
        Permission::create(['name'=>'users.index']);
        Permission::create(['name'=>'users.show']);
        Permission::create(['name'=>'users.edit']);
        Permission::create(['name'=>'users.update']);
        Permission::create(['name'=>'users.destroy']);
        Permission::create(['name'=>'products.index']);
        Permission::create(['name'=>'products.show']);
        Permission::create(['name'=>'products.edit']);
        Permission::create(['name'=>'products.update']);
        Permission::create(['name'=>'products.destroy']);
        Permission::create(['name'=>'stores.index']);



        $roleAdmin = Role::create([ 'name' => 'admin' ]);
        $roleAdmin->givePermissionTo(Permission::all());

        $roleUser = Role::create(['name'=>'user']);
        $roleUser->givePermissionTo('stores.index');

        
        User::factory()->create([
            'name' => 'admi1',
            'email' => 'i@admin.com',
            'password' => bcrypt('123456')
        ])->assignRole('admin');
        
        //User::factory(50)->create()->assignRole('user');
        User::factory(50)->create();

        Product::factory(100)->create();
    }
}
