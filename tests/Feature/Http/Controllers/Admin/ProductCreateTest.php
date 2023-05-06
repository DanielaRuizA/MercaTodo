<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Testing\File;


class ProductCreateTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function testAdminCanAccessCreateProduct()
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.products.create'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $this->actingAs($admin)
            ->get('products/create')
            ->assertStatus(200);
    }

    public function testAdminCreateProduct()
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

    public function testAdminStoreProduct()
    {
        Storage::fake('public');

        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.products.store'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        Product::factory()->create();

        $file = File::create('icecream.jpg');

        $data = [
            'name'            => 'gomas',
            'description'     => 'gomas de distintos sabores y colores',
            'price'           => 3000,
            'quantity'        => 33,
            'product_photo'   => $file
        ];

        $this->actingAs($admin)
            ->post('products', $data)
            ->assertRedirect('products');

        $this->assertDatabaseHas('products', [
            'name'            => 'gomas',
            'description'     => 'gomas de distintos sabores y colores',
            'price'           => 3000,
            'quantity'        => 33,
        ]);

        $this->assertNotNull('product_photo');
        $this->assertFileExists($file, "filename doesn't exists");
    }

    public function testAdminEditProduct()
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.products.create'])->assignRole($roleAdmin);

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

    public function testAdminUpdateProduct()
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
            ->assertRedirect("products");

        $this->assertDatabaseHas("products", [
            'name' => 'New Product',
            'description' => 'This is a product',
            'price' => 1000,
            'quantity' => 33,
        ]);

        $this->assertNotNull('product_photo');
        $this->assertFileExists($file, "filename doesn't exists");
    }

    public function testAdminDestroyProduct()
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.products.update'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $product = Product::factory()->create();

        $this
            ->actingAs($admin)
            ->delete("products/$product->id")
            ->assertRedirect("products");

        $this->assertDatabaseMissing("products", [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'quantity' => $product->quantity,
            'product_photo'=> $product->product_photo,
        ]);
    }

    public function test_avatars_can_be_uploaded(): void
    {
        Storage::fake('images');

        $file = File::create('avatar.jpg');

        $response = $this->post('products', [
            'product_photo' => $file,
        ]);
        $this->assertNotNull('product_photo'); //funciona
        $this->assertFileExists($file, "filename doesn't exists");
        //$this->assertFileExists($file); //funciona
        //$this->assertSame('product_photo', $file->hashName()); este da info
    }
    public function testChangeProductStatus()
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.products.create'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $product = Product::factory()->create();

        // $this->actingAs($admin)
        //     ->get("changeProductStatus")
        //     ->assertStatus(200);
        // //     ->assertJson([
        // //     'success' => 'Status change successfully.',
        // // ]);


    
    
        // $this->assertEquals('out_of_stock', $product->fresh()->status);

        //crear un product llamaro a la ruta change pasandole la variable
        // $response = $this->actingAs($admin)->json('GET', '/change-product-status', [
        //     'product_id' => $product->id,
        //     'status' => 1,
        // ]);

        
        //assertStatus(200)
            

        //$this->assertEquals(1, $product->fresh()->status);
        // GET|HEAD        changeProductStatus ................................................... changeProductStatus 
    }
}
