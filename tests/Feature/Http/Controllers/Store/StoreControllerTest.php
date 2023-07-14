<?php

namespace Tests\Feature\Http\Controllers\Store;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class StoreControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function testAdminAccessStore(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.store.index'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $product = Product::factory()->create();

        $this->actingAs($admin)
            ->get('stores')
            ->assertStatus(200)
            ->assertSee($product->nombre)
            ->assertSee($product->precio)
            ->assertSee($product->imagen);
    }

    public function testUserAccessStore(): void
    {
        $roleUser = Role::create(['name' => 'user']);

        Permission::create(['name' => 'admin.store.index'])->assignRole($roleUser);

        $user = User::factory()->create()->assignRole('user');

        $product = Product::factory()->create();

        $this->actingAs($user)
            ->get('stores')
            ->assertStatus(200)
            ->assertSee($product->nombre)
            ->assertSee($product->precio)
            ->assertSee($product->imagen);
    }

    public function testAdminAccessStoreShowProductView(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.store.index'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $product = Product::factory()->create();

        $this->actingAs($admin)
            ->get("stores/$product->id")
            ->assertStatus(200)
            ->assertSee($product->nombre)
            ->assertSee($product->precio)
            ->assertSee($product->imagen);
    }

    public function testUserAccessStoreShowProductView(): void
    {
        $roleUser = Role::create(['name' => 'user']);

        Permission::create(['name' => 'admin.store.index'])->assignRole($roleUser);

        $user = User::factory()->create()->assignRole('user');

        $product = Product::factory()->create();

        $this->actingAs($user)
            ->get("stores/$product->id")
            ->assertStatus(200)
            ->assertSee($product->nombre)
            ->assertSee($product->precio)
            ->assertSee($product->imagen);
    }
}
