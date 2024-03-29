<?php

namespace Tests\Feature\Http\Controllers\AdminPanel;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function testAdminAccessProductsIndex(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.products.index'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $this->actingAs($admin)
            ->get('products')
            ->assertStatus(200);
    }

    public function testAdminShowProduct(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.products.show'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $user = User::factory()->create();

        $product = Product::factory()->create();

        $this->actingAs($admin)
            ->get("products/$product->id")
            ->assertStatus(200)
            ->assertSee($product->nombre)
            ->assertSee($product->descripcion)
            ->assertSee($product->precio)
            ->assertSee($product->cantidad)
            ->assertSee($product->imagen);
    }

    public function testAdminCanAccessCreateFormProduct(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.products.create'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $data = [
            'name' => 'New Product',
            'description' => 'This is a product',
            'price' => 1000,
            'quantity' => 33,
            'product_photo' => 'images/icecream.jpg',
        ];

        $product = Product::factory()->create();

        Storage::fake('images');

        $this
            ->actingAs($admin)
            ->get('products/create', $data)
            ->assertStatus(200)
            ->assertSee($product->nombre)
            ->assertSee($product->descripcion)
            ->assertSee($product->precio)
            ->assertSee($product->cantidad)
            ->assertSee($product->imagen);
    }

    public function testAdminStoreProduct(): void
    {
        Storage::fake('public');

        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.products.store'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        Product::factory()->create();

        $file = File::create('icecream.jpg');

        $data = [
            'name' => 'gomas',
            'description' => 'gomas de distintos sabores y colores',
            'price' => 3000,
            'quantity' => 33,
            'product_photo' => $file,
        ];

        $this->actingAs($admin)
            ->post('products', $data)
            ->assertRedirect('products');

        $this->assertDatabaseHas('products', [
            'name' => 'gomas',
            'description' => 'gomas de distintos sabores y colores',
            'price' => 3000,
            'quantity' => 33,
        ]);

        $this->assertNotNull('product_photo');
        $this->assertFileExists($file, "filename doesn't exists");
    }

    public function testAdminCanAccessEditFormProduct(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.products.edit'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $product = Product::factory()->create();

        $this->actingAs($admin)
            ->get("products/$product->id/edit")
            ->assertStatus(200)
            ->assertSee($product->nombre)
            ->assertSee($product->descripcion)
            ->assertSee($product->precio)
            ->assertSee($product->cantidad)
            ->assertSee($product->imagen);
    }

    public function testAdminUpdateProduct(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.products.update'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $product = Product::factory()->create();

        $file = File::create('icecream.jpg');

        $data = [
            'name' => 'New Product',
            'description' => 'This is a product',
            'price' => 1000,
            'quantity' => 33,
            'product_photo' => $file,
        ];

        $this->actingAs($admin)
            ->put("products/$product->id", $data)
            ->assertRedirect('products');

        $this->assertDatabaseHas('products', [
            'name' => 'New Product',
            'description' => 'This is a product',
            'price' => 1000,
            'quantity' => 33,
        ]);

        $this->assertNotNull('product_photo');
        $this->assertFileExists($file, "filename doesn't exists");
    }

    public function testAdminDestroyProduct(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.products.destroy'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $product = Product::factory()->create();

        $this
            ->actingAs($admin)
            ->delete("products/$product->id")
            ->assertRedirect('products');

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'quantity' => $product->quantity,
            'product_photo' => $product->product_photo,
        ]);
    }

    public function testAdminChangeProductStatus(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.products.status'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $product = Product::factory()->create();

        $response = $this->actingAs($admin)
            ->json('get', 'change/product/status', [
                'product_id' => $product->id,
                'status' => 'Inactive',
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'status' => 'Inactive',
        ]);

        $response->assertJson([
            'success' => 'Status change successfully.',
        ]);
    }

    public function testUserCantAccessIndexProducts(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('products')
            ->assertStatus(403);
    }

    public function testUserCantAccessShowProducts(): void
    {
        $user = User::factory()->create();

        $product = Product::factory()->create();

        $this->actingAs($user)
            ->get("products/$product->id")
            ->assertStatus(403);
    }

    public function testUserCantAccessCreateFormProduct(): void
    {
        $user = User::factory()->create();

        Product::factory()->create();

        $data = [
            'name' => 'New Product',
            'description' => 'This is a product',
            'price' => 1000,
            'quantity' => 33,
            'product_photo' => 'images/icecream.jpg',
        ];

        $this
            ->actingAs($user)
            ->get('products/create', $data)
            ->assertStatus(403);
    }

    public function testUserCantStoreProduct(): void
    {
        $user = User::factory()->create();

        Product::factory()->create();

        $file = File::create('icecream.jpg');

        $data = [
            'name' => 'gomas',
            'description' => 'gomas de distintos sabores y colores',
            'price' => 3000,
            'quantity' => 33,
            'product_photo' => $file,
        ];

        $this->actingAs($user)
            ->post('products', $data)
            ->assertStatus(403);
    }

    public function testUserCantAccessEditFormProducts(): void
    {
        $user = User::factory()->create();

        $product = Product::factory()->create();

        $data = [
            'name' => 'New Product',
            'description' => 'This is a product',
            'price' => 1000,
            'quantity' => 33,
            'product_photo' => 'images/icecream.jpg',
        ];

        $this->actingAs($user)
            ->get("products/$product->id/edit")
            ->assertStatus(403);
    }

    public function testUserCantUpdateProducts(): void
    {
        $user = User::factory()->create();

        $product = Product::factory()->create();

        $file = File::create('icecream.jpg');

        $data = [
            'name' => 'New Product',
            'description' => 'This is a product',
            'price' => 1000,
            'quantity' => 33,
            'product_photo' => $file,
        ];

        $this->actingAs($user)
            ->put("products/$product->id", $data)
            ->assertStatus(403);
    }

    public function testUsersCantDestroyProducts(): void
    {
        $user = User::factory()->create();

        $product = Product::factory()->create();

        $this->actingAs($user)
            ->delete("products/$product->id")
            ->assertStatus(403);
    }

    public function testUserCantChangeProductStatus(): void
    {
        $user = User::factory()->create();

        $product = Product::factory()->create();

        $response = $this->actingAs($user)
            ->json('get', 'change/product/status', [
                'product_id' => $product->id,
                'status' => 'Inactive',
            ]);

        $response->assertStatus(403);
    }

    public function testImagesCanBeUploaded(): void
    {
        Storage::fake('images');

        $file = File::create('avatar.jpg');

        $this->post('products', [
            'product_photo' => $file,
        ]);
        $this->assertNotNull('product_photo');
        $this->assertFileExists($file, "filename doesn't exists");
    }
}
