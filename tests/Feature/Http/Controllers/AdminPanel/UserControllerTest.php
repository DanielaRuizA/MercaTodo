<?php

namespace Tests\Feature\Http\Controllers\AdminPanel;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as InertiaAssert;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function testAdminAccessDashboard(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.dashboard'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $response = $this->actingAs($admin)
            ->get('dashboard')
            ->assertStatus(200);

        $response->assertSeeText('dashboard');
    }

    public function testAdminAccessUsersIndex(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.users.index'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $this->actingAs($admin)
            ->get('users')
            ->assertStatus(200);
    }

    public function testAdminShowUser(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.users.show'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $user = User::factory()->create();

        $this->actingAs($admin)
            ->get("users/$user->id")
            ->assertStatus(200);
    }

    public function testAdminCanAccessEditFormUser(): void
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

    public function testAdminUpdateUser(): void
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

    public function testAdminDestroyUser(): void
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

    public function testAdminChangeUserStatus(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.users.status'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $user = User::factory()->create();

        $response = $this->actingAs($admin)
            ->json('get', 'change/user/status', [
                'user_id' => $user->id,
                'status' => 'Inactive',
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'status' => 'Inactive',
        ]);

        $response->assertJson([
            'success' => 'Status change successfully.',
        ]);
    }

    public function testUserAccessDashboard(): void
    {
        $roleAdmin = Role::create(['name' => 'dashboard']);

        Permission::create(['name' => 'dashboard'])->assignRole($roleAdmin);

        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('dashboard')
            ->assertStatus(200);
    }

    public function testUserCantAccessIndexUsers(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('users')
            ->assertStatus(403);
    }

    public function testUserCantAccessShowUsers(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get("users/$user->id")
            ->assertStatus(403);
    }

    public function testUserCantAccessEditFormUsers(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get("users/$user->id/edit")
            ->assertStatus(403);
    }

    public function testUserCantUpdateUsers(): void
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

    public function testUsersCantDestroyUsers(): void
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->delete("users/$user->id")
            ->assertStatus(403);
    }

    public function testUserCantChangeUserStatus(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.products.status'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->json('get', 'change/user/status', [
                'user_id' => $user->id,
                'status' => 'Inactive',
            ]);

        $response->assertStatus(403);
    }

    public function testAdminCanSearch(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.users.index'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        User::factory()->count(10)->create();

        $response = $this->actingAs($admin)
            ->get(route('users.index', ['search' => 'example']));

        $response->assertStatus(200);
        $response->assertInertia(
            fn (InertiaAssert $page) => $page->component('AdminPanel/Users/Index')
                ->has('users', 13)
        );

        $response = $this->actingAs($admin)
            ->get(route('users.index'));

        $response->assertStatus(200);
        $response->assertInertia(
            fn (InertiaAssert $page) => $page->component('AdminPanel/Users/Index')
        );
    }
}
