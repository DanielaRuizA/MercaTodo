<?php

namespace Tests\Feature\Http\Controllers\Store;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Product;

class StoreControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function testAdminAccessStore()
    {
        $roleAdmin =  Role::create(["name" => "admin"]);

        Permission::create(["name" => "admin.store.index"])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole("admin");

        $product = Product::factory()->create();

        $this->actingAs($admin)
            ->get("stores")
            ->assertStatus(200)
            ->assertSee($product->nombre)
            ->assertSee($product->precio)
            ->assertSee($product->imagen);
    }

    public function testUserAccessStore()
    {
        $roleUser =  Role::create(["name" => "user"]);

        Permission::create(["name" => "admin.store.index"])->assignRole($roleUser);

        $user = User::factory()->create()->assignRole("user");

        $product = Product::factory()->create();

        $this->actingAs($user)
            ->get("stores")
            ->assertStatus(200)
            ->assertSee($product->nombre)
            ->assertSee($product->precio)
            ->assertSee($product->imagen);
    }
}
