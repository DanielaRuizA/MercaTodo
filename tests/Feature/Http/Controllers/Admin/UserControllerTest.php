<?php

namespace Tests\Feature\Http\Controllers\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserControllerTest extends TestCase
{
    use WithFaker,RefreshDatabase;
    
    //Admin test
    public function test_admin_access_dashboard()
    {
        $role_admin =  Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.dashboard'])->assignRole($role_admin);
        
        $admin = User::factory()->create()->assignRole('admin');
        
        $this->actingAs($admin)
            ->get('dashboard')
            ->assertStatus(200);
        //->assertSee
    }

    public function test_admin_access_users_index()
    {
        $role_admin =  Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.users.index'])->assignRole($role_admin);
        
        $admin = User::factory()->create()->assignRole('admin');
        
        $this->actingAs($admin)
            ->get('users')
            ->assertStatus(200);
        //->assertSee('No hay Usuarios registrados');
    }

    
    public function test_admin_show_user()
    {
        $role_admin =  Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.users.show'])->assignRole($role_admin);
        
        $admin = User::factory()->create()->assignRole('admin');

        $user = User::factory()->create();
        
        $this->actingAs($admin)
            ->get("users/$user->id")
            ->assertStatus(200);
        //->assertSee();
    }

    public function test_admin_edit_user()
    {
        $role_admin =  Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.users.edit'])->assignRole($role_admin);
        
        $admin = User::factory()->create()->assignRole('admin');

        $user = User::factory()->create();
        
        $this->actingAs($admin)
            ->get("users/$user->id/edit")
            ->assertStatus(200)
            ->assertSee($user->name)
            ->assertSee($user->email);
        //->assertSee();
    }

    public function test_admin_update_user()
    {
        $role_admin = Role::create(['name' => 'admin']);
        Permission::create(['name' => 'admin.users.update'])->assignRole($role_admin);
        
        $admin = User::factory()->create()->assignRole('admin');
        $user = User::factory()->create();

        $data = [
            /*'name'  => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),*/
            'name'  => $this->faker->name,
            'email' => $this->faker->email,
        ];
        
        $this
            ->actingAs($admin)
            ->put("users/$user->id", $data)
            ->assertRedirect("users");

        $this->assertDatabaseHas('users', $data);
    }

    public function test_admin_destroy_user()
    {
        $role_admin =  Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.users.update'])->assignRole($role_admin);
        
        $admin = User::factory()->create()->assignRole('admin');

        $user = User::factory()->create();

        $this
            ->actingAs($admin)
            ->delete("users/$user->id")
            ->assertRedirect("users");

        $this->assertDatabaseMissing('users', [
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
        ]);
    }

    //User test
    public function test_user_access_dashboard()
    {
        $role_admin =  Role::create(['name' => 'dashboard']);

        Permission::create(['name' => 'dashboard'])->assignRole($role_admin);
        
        $user = User::factory()->create();
        
        $this->actingAs($user)
            ->get('dashboard')
            ->assertStatus(200);
        //fail received 403.
    }

    public function test_user_access_index_users()
    {
        $user = User::factory()->create();
        
        $this->actingAs($user)
            ->get("users")
            ->assertStatus(403);
        //->assertSee();
    }

    public function test_user_show_users()
    {
        $user = User::factory()->create();
        
        $this->actingAs($user)
            ->get("users/$user->id")
            ->assertStatus(403);
        //->assertSee();
    }

    public function test_user_edit_users()
    {
        $user = User::factory()->create();
        
        $this->actingAs($user)
            ->get("users/$user->id/edit")
            ->assertStatus(403);
        //->assertSee();
    }

    public function test_user_update_users()
    {
        $user = User::factory()->create();

        $data = [
            'name'  => $this->faker->name,
            'email' => $this->faker->email,
        ];
        
        $this
            ->actingAs($user)
            ->put("users/$user->id", $data)
            ->assertStatus(403);
    }

    public function test_admin_destroy_users()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->delete("users/$user->id")
            ->assertStatus(403);
    }
}
