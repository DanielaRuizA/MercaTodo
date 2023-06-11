<?php

namespace Tests\Feature\Http\Controllers\Cart;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function testUserCanAccessToCartView()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('cart')
            ->assertStatus(200);
    }


    // public function testUserAddItemsCart()
    // {
    //     $user = User::factory()->create();

    //     $product = Product::factory()->create();

    //     $data = Cart::instance('default')->add('1', 'nuevo', 55, 300, ['totalQty' => 3]);


    //     $this
    //         ->actingAs($user)
    //         ->post("cart/$product->id")
    //         ->assertRedirect('cart');
        // ->assertRedirect('product');
        // ->assertSee($product->nombre)
        // ->assertSee($product->descripcion)
        // ->assertSee($product->precio)
        // ->assertSee($product->cantidad)
        // ->assertSee($product->imagen);
    // }

    // public function testUserUpdateCart()
    // {
    //     $user = User::factory()->create();

    //     $product = Product::factory()->create();

    //     $data = [
    //         'name' => 'New Product',
    //         'description' => 'This is a product',
    //         'price' => 1000,
    //         'quantity' => 33,
    //     ];

    //     $this->actingAs($user)
    //         ->patch("cart/$product->id", $data)
    //         ->assertRedirect('cart.index');
    // }
    
    // public function testAdminDestroyProduct()
    // {
    //     $roleAdmin = Role::create(['name' => 'admin']);

    //     Permission::create(['name' => 'admin.products.destroy'])->assignRole($roleAdmin);

    //     $admin = User::factory()->create()->assignRole('admin');

    //     $product = Product::factory()->create();

    //     $this
    //         ->actingAs($admin)
    //         ->delete("products/$product->id")
    //         ->assertRedirect('products');

    //     $this->assertDatabaseMissing('products', [
    //         'id' => $product->id,
    //         'name' => $product->name,
    //         'description' => $product->description,
    //         'price' => $product->price,
    //         'quantity' => $product->quantity,
    //         'product_photo' => $product->product_photo,
    //     ]);
    }
}
