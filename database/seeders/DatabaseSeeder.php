<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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


        $roleAdmin = Role::create([ 'name' => 'admin' ]);
        $roleAdmin->givePermissionTo(Permission::all());

        //Role::create(['name'=>'user']);

        
        User::factory()->create([
            'name' => 'admi1',
            'email' => 'i@admin.com',
            'password' => bcrypt('123456')
        ])->assignRole('admin');
        
        //User::factory(50)->create()->assignRole('user');
        User::factory(50)->create();
    }
}
