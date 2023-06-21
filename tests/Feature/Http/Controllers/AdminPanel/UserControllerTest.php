<?php

namespace Tests\Feature\Http\Controllers\AdminPanel;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function testAdminAccessDashboard()
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.dashboard'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $response = $this->actingAs($admin)
            ->get('dashboard')
            ->assertStatus(200);

        $response->assertSeeText('dashboard');
    }

    public function testAdminAccessUsersIndex()
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.users.index'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $this->actingAs($admin)
            ->get('users')
            ->assertStatus(200);
    }

    public function testAdminShowUser()
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.users.show'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $user = User::factory()->create();

        $this->actingAs($admin)
            ->get("users/$user->id")
            ->assertStatus(200);
    }

    public function testAdminCanAccessEditFormUser()
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.users.edit'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $user = User::factory()->create();

        $this->actingAs($admin)
            ->get("users/$user->id/edit")
            ->assertStatus(200)
            ->assertSee($user->name)
            ->assertSee($user->email);
    }

    public function testAdminUpdateUser()
    {
        $roleAdmin = Role::create(['name' => 'admin']);
        Permission::create(['name' => 'admin.users.update'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');
        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
        ];

        $this
            ->actingAs($admin)
            ->put("users/$user->id", $data)
            ->assertRedirect('users');

        $this->assertDatabaseHas('users', $data);
    }

    public function testAdminDestroyUser()
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.users.destroy'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $user = User::factory()->create();

        $this
            ->actingAs($admin)
            ->delete("users/$user->id")
            ->assertRedirect('users');

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function testAdminChangeUserStatus()
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.users.status'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $user = User::factory()->create();

        $data = [
            'status' => 'Inactive',
        ];

        $this->actingAs($admin)
            ->get("change/status/$user->id", $data);

        $this->assertDatabaseHas('users', [
            'status' => 'Active',
        ]);
    }

    public function testUserAccessDashboard()
    {
        $roleAdmin = Role::create(['name' => 'dashboard']);

        Permission::create(['name' => 'dashboard'])->assignRole($roleAdmin);

        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('dashboard')
            ->assertStatus(200);
    }

    public function testUserCantAccessIndexUsers()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('users')
            ->assertStatus(403);
    }

    public function testUserCantAccessShowUsers()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get("users/$user->id")
            ->assertStatus(403);
    }

    public function testUserCantAccessEditFormUsers()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get("users/$user->id/edit")
            ->assertStatus(403);
    }

    public function testUserCantUpdateUsers()
    {
        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
        ];

        $this
            ->actingAs($user)
            ->put("users/$user->id", $data)
            ->assertStatus(403);
    }

    public function testUsersCantDestroyUsers()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->delete("users/$user->id")
            ->assertStatus(403);
    }

    public function testUserCantChangeUserStatus()
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.products.status'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $user = User::factory()->create();

        $data = [
            'status' => 'Inactive',
        ];

        $this->actingAs($admin)
            ->get("change/status/$user->id", $data)
            ->assertStatus(404);
    }
}
