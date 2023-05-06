<?php

namespace Tests\Feature\Admin;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Testing\File;
use Illuminate\Http\Request;

class ProductPruebaTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function testAvatarUpload()
    {
        Storage::fake('avatars');

        $response = $this->json('POST', 'products', [
            'product_photo' => UploadedFile::fake()->image('avatar.jpg')
        ]);

        // Assert the file was stored...
        Storage::disk('avatars')->assertExists('avatar.jpg');

        // Assert a file does not exist...
        // Storage::disk('avatars')->assertMissing('missing.jpg');
    }
}
//     public function test_destroy()
//     {
//         $roleAdmin = Role::create(['name' => 'admin']);

//         Permission::create(['name' => 'admin.products.update'])->assignRole($roleAdmin);

//         $admin = User::factory()->create()->assignRole('admin');

//         $product = Product::factory()->create();

//         $this
//             ->actingAs($admin)
//             ->delete("products/$product->id")
//             ->assertRedirect("products");

//         $this->assertDatabaseMissing("products", [
//             'id' => $product->id,
//             'name' => $product->name,
//             'description' => $product->description,
//             'price' => $product->price,
//             'quantity' => $product->quantity,
//             'product_photo'=> $product->product_photo,
//         ]);
//     }
// }

    // public function test_avatars_can_be_uploaded(): void
    // {
    //     Storage::fake('images');

    //     $file = File::create('avatar.jpg');

    //     $response = $this->post('products', [
    //         'product_photo' => $file,
    //     ]);
    //     $this->assertNotNull('product_photo');
    //     $this->assertFileExists($file, "file exists");
    //     $this->assertExists($file->hashName());
    //     $this-> assertStringEqualsFile('product_photo', 'product_photo'->$file);
    //     $this->assertSame('product_photo', $file->originalName());
    //     $this-> assertStringEqualsFile('product_photo', $file);
    //     $this->assertSame('product_photo', $file->hashName()); este da info

    //     $this->assertDirectoryExists(Storage::disk('images'));
    //     $this->assertDatabaseHas($file->hashName());
    //     $this->assertDatabaseHas('products', [
    //         'product_photo' => $file
    //     ]);
    //     Storage::disk('images')->assertExists($file->hashName());
    // }

    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    // public function test_avatars_can_be_uploaded(): void
    // {
    //     Storage::fake('images');

    //     $file = File::create('avatar.jpg');

    //     $response = $this->post('products', [
    //         'product_photo' => $file,
    //     ]);
    //     $this->assertNotNull('product_photo');
    //     $this-> assertStringEqualsFile('product_photo', $file);
        //$this->assertSame('product_photo', $file->hashName()); este da info

        // $this->assertDirectoryExists(Storage::disk('images'));
        // $this->assertDatabaseHas($file->hashName());
        // $this->assertDatabaseHas('products', [
        //     'product_photo' => $file
        // ]);
        //Storage::disk('images')->assertExists($file->hashName());
    // }

    // public function testAdminStoreProduct()
    // {
    //     Storage::fake('public');

    //     $roleAdmin = Role::create(['name' => 'admin']);

    //     Permission::create(['name' => 'admin.products.store'])->assignRole($roleAdmin);

    //     $admin = User::factory()->create()->assignRole('admin');

    //     $products = Product::factory()->create();

    //     // $file = File::create('icecream.jpg', 200);
    //     // $filePath = Storage::disk('public')->put('images', request()->file('icecream.jpg'));
    //     $path = Storage::disk('public')->file('avatar');


    //     $data = [
    //         'name'            => 'gomas',
    //         'description'     => 'gomas de distintos sabores y colores',
    //         'price'           => 3000,
    //         'quantity'        => 33,
    //         'product_photo'   => $path
    //     ];

    //     $this->actingAs($admin)
    //         ->post('products', $data)
    //         ->assertRedirect('products');




    //     $this->assertDatabaseHas('products', [
    //         'name'            => 'gomas',
    //         'description'     => 'gomas de distintos sabores y colores',
    //         'price'           => 3000,
    //         'quantity'        => 33,
    //     ]);


        //$this->assertNotNull($products->product_photo);
        //$this->assertTrue(Storage::disk('public')->exists($products->product_photo));
        //hasFile('product_photo')

        // $this->post(route('products.store'), [
        //     'name'            => 'gomas',
        //     'description'     => 'gomas de distintos sabores y colores',
        //     'price'           => 3000,
        //     'quantity'        => 33,
        //     'product_photo'   => $file,
        // ]);

        // $this->assertEquals(
        //     'gomas',
        //     $products->name,
        //     'gomas de distintos sabores y colores',
        //     $products->description,
        //     3000,
        //     $products->price,
        //     33,
        //     $products->quantity,
        // );

        // Storage::disk('public')->assertExists($products->product_photo);

        // $this->assertFileEquals($file, Storage::disk('public')->url($products->product_photo));

        // $data = [
        //     'name'            => 'gomas',
        //     'description'     => 'gomas de distintos sabores y colores',
        //     'price'           => 3000,
        //     'quantity'        => 33,
        //     'product_photo'   =>'images/icecream.jpg',
        // ];


        // $product = $product->refresh();

        // $this
        //     ->actingAs($admin)
        //     ->post('products/', $data)
        //     ->assertRedirect();

        //$product = $product->refresh();

        // $this->assertDatabaseHas('products', $data);
        // $this->assertEquals(
        //     "gomas", $product->name,
        //     "gomas de distintos sabores y colores" , $product->description ,
        //     3000,   $product-> price,
        //     33, $product-> quantity,
        //     'images/icecream.jpg',  $product->product_photo,
        // );
        //->assertStatus(200);
    // }


    // public function testAdminUpdateProduct()
    // {
    //     $roleAdmin = Role::create(['name' => 'admin']);

    //     Permission::create(['name' => 'admin.products.update'])->assignRole($roleAdmin);

    //     $admin = User::factory()->create()->assignRole('admin');

    //     $product = Product::factory()->create();

    //     //$filename = Storage::disk('public')->put('/images', 'icecream.jpg');

    //     $data = [
    //         'name' => 'New Product',
    //         'description' => 'This is a product',
    //         'price' => 1000,
    //         'quantity' => 33,
    //         //'product_photo' => $filename,
    //         //'product_photo' =>'images/icecream.jpg',
    //     ];
    //     $this->actingAs($admin)
    //         ->put("products/$product->id", $data)
    //         ->assertRedirect("products");

    //     //$this->assertDatabaseHas("products", $data);

    //     $this->assertDatabaseHas("products", [
    //         'name' => 'New Product',
    //         'description' => 'This is a product',
    //         'price' => 1000,
    //         'quantity' => 33,
    //     ]);
    // }
    // public function test_upload_image()
    // {
    //     $roleAdmin = Role::create(['name' => 'admin']);

    //     Permission::create(['name' => 'admin.products.update'])->assignRole($roleAdmin);

    //     $admin = User::factory()->create()->assignRole('admin');

    //     $product = Product::factory()->create();


    //     $filename = 'test_image.jpg';


    //     // Make a POST request to the '/upload' endpoint
    //     $response = $admin('POST', '/upload', [
    //         'multipart' => [
    //             [
    //                 'product_photo' => $filename
    //             ]
    //         ]
    //     ]);

    //     // Check if the HTTP response status code is 200
    //     $this->assertEquals(200, $response->getStatusCode());

    //     // Check if the uploaded file exists in the storage directory
    //     $this->assertFileExists(storage_path('app/public/images' . $filename));

    //     // Clean up the test image file
    //     unlink($filename);
    // }

    // public function testUpdateProduct()
    // {
    //     // Create a new product
    //     $product = Product::factory()->create();

    //     // Create a new request with updated data
    //     $newData = [
    //         'name' => 'New Product Name',
    //         'description' => 'New Product Description',
    //         'price' => 9.99,
    //         'quantity' => 10,
    //         'product_photo' => UploadedFile::fake()->image('product.jpg')
    //     ];
    //     // $request = create('', 'PUT', $newData);

    //     // Call the update function
    //     $response = $this->put(route('products.update', $product));

    //     // Verify the response
    //     $response->assertRedirect(route('products.index'));
    //     $response->assertSessionHas('message', 'Producto Actualizado');

    //     // Verify the product was updated in the database
    //     $product->refresh();
    //     $this->assertEquals($newData['name'], $product->name);
    //     $this->assertEquals($newData['description'], $product->description);
    //     $this->assertEquals($newData['price'], $product->price);
    //     $this->assertEquals($newData['quantity'], $product->quantity);
    //     $this->assertNotNull($product->product_photo);
    //     $this->assertTrue(Storage::disk('public')->exists($product->product_photo));
    // }


    // public function test_original_filename_upload():void
    // {
    //     $filename = 'logo.jpg';

    //     $response = $this->post('products', [
    //         'product_photo' => UploadedFile::fake()->image($filename)
    //     ]);

    //     $response->assertStatus(200);
    //     $this->assertDatabaseHas('products', [
    //         'logo' => $filename
    //     ]);
    // }


// public function testAdminUpdateProduct()
// {
//     $roleAdmin = Role::create(['name' => 'admin']);

//     Permission::create(['name' => 'admin.products.update'])->assignRole($roleAdmin);

//     $admin = User::factory()->create()->assignRole('admin');

//     $product = Product::factory()->create();

//     $filename = Storage::disk('public')->put('/images', 'icecream.jpg');

//     $data = [
//         'name' => 'New Product',
//         'description' => 'This is a product',
//         'price' => 1000,
//         'quantity' => 33,
//         'product_photo' => $filename,
//         //'product_photo' =>'images/icecream.jpg',
//     ];
//UploadedFile::fake()->image('avatar.jpg', $width, $height)->size(100);
// $filePath = Storage::disk('public')->put('images', request()->file('product_photo'));
// 'product_photo'=> $filePath = UploadedFile::disk('public')->put('images',image('icecream.jpg'),);
//'image' => $file = UploadedFile::fake()->image('post.jpg'),

// Storage::fake('avatars');
// $file = UploadedFile::fake()->image('avatar.jpg');
// $response = $this->post('/avatar', [
    //     'avatar' => $file,
// ]);
// Storage::disk('avatars')->assertExists($file->hashName());

//Storage::fake('public');

// $this->actingAs($admin)
    //     ->put("products/$product->id", $data)
    //     ->assertRedirect("products");

    //     $this->assertDatabaseHas("products", $data);
//Storage::disk('public')->$filename->hashName('icecream.jpg');

// $this->assertDatabaseHas("products", [
    //     'name' => 'New Product',
    //     'description' => 'This is a product',
    //     'price' => 1000,
    //     'quantity' => 33,
//'product_photo' => $filename,
//'product_photo'=> $filePath = Storage::disk('public')->put('images', fake()->image('post.jpg'))
//'product_photo' =>'images/icecream.jpg',
// ]);
    
    

// ->assertEquals('images/icecream.jpg', $product->product_photo);
// }
