<?php

namespace Tests\Feature\Http\Controllers\Cart;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;

class CartControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function testUserCanAccessToCartView(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('cart')
            ->assertStatus(200);
    }

    public function testCanAccessToCartOnlyLoggedUsers(): void
    {
        $this->get('cart')
        ->assertRedirect('login');
    }

    public function testUserCanAccessToEmptyItemsCart(): void
    {
        $user = User::factory()->create();
        
        Product::factory()->create();

        $this
            ->actingAs($user)
            ->get('cart')
            ->assertStatus(200)
            ->assertSee(0);
    }


    public function testUserCanAddItemsToCart(): void
    {
        $user = User::factory()->create();

        $product = Product::factory()->create();

        $data = [
            'id' => 1,
            'name' => 'Sample Product',
            'quantity' => 2,
            'price' => 9.99,
            'totalQty' => 5,
            'image' => 'sample_image.jpg',
            'description' => 'Sample description',
        ];

        $this
            ->actingAs($user)
            ->post("cart/$product->id", $data)
            ->assertRedirect(route('cart.index'));
    }

    // public function testUserCanUpdatesCartItemQuantity()
    // {
    //     User::factory()->create();

    //     $product = Product::factory()->create();

    //     $cartItem = Cart::instance('default')->add([
    //         'id' => $product->id,
    //         'name' => $product->name,
    //         'qty' => 1,
    //         'price' => $product->price,
    //         'totalQty' => 5,
    //         'image' => $product->image,
    //         'description' => $product->description,
    //     ]);
        
    //     $this->put(route('cart.update', $cartItem->id), [
    //         'quantity' => 2,
    //     ]);
        
        // $response = $this->assertEquals(2, $cartItem->content());
        // $response = $this->assertRedirect();
    // }

    public function testUserUpdateTheQuantityOfTheCart(): void
    {
        $cartItemId = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
        $newQuantity = 2;

        $this
        ->patch(route('cart.update', $cartItemId), ['quantity' => $newQuantity])
        ->assertRedirect();
    }
    
    // public function testUserRemoveItemsOfTheCart()
    // {
    //     // Crea un usuario y un producto de prueba
    //     $user = User::factory()->create();
    //     $product = Product::factory()->create();

    //     // Agrega un elemento al carrito
    //     $item = Cart::instance('default')->add([
    //         'id' => $product->id,
    //         'name' => $product->name,
    //         'qty' => 2,
    //         'price' => $product->price,
    //         'totalQty' => 5,
    //         'image' => $product->image,
    //         'description' => $product->description,
    //     ]);


    //     $response = $this->post(route('cart.destroy', ['product' => $product->id]));

    //     $this->assertEmpty(Cart::instance('default')->content()->has($item->rowId));

        
    //     $response->assertRedirect();


        // $this->assertFileEquals(Cart::instance('default')->content()->has($item->rowId));
        // $this->assertFalse(Cart::instance('default')->content()->has($item->rowId));

        // Verifica que la respuesta redirija a la página anterior

        // $this->assertFalse(Cart::instance('default')->content()->has($item->rowId));

        // $response->assertRedirect();
    // }
}
// User::factory()->create();

// Product::factory()->create();

// $item = [
        //     'id' => 1,
        //     'name' => 'Sample Product',
        //     'quantity' => 2,
        //     'price' => 9.99,
        //     'totalQty' => 5,
        //     'image' => 'sample_image.jpg',
        //     'description' => 'Sample description',
// ];

// $this->post(route('cart.destroy', ['id' => $item->rowId]));

// $this->assertCount(0, Cart::instance('default')->content());

// $this->assertRedirect();
// }


// Cart::instance('default')->add(['id' => '293ad', 'name' => 'Product 1', 'qty' => 1, 'price' => 10.00]);

// $this->post(route('cart.destroy', ['id' => '293ad']))
// ->assertFalse(Cart::instance('default')->has(['id' => '293ad']))
// ->assertRedirect();

// // Assert that the response redirects back to the previous page
// $response->assertSessionHas('url.intended', url()->previous());
// }


//  public function testDestroyRemovesItemFromCart()
// {
    //     // Crea un elemento de prueba en el carrito
    //     $item = Cart::instance('default')->add([
    //         'id' => 1,
    //         'name' => 'Product 1',
    //         'price' => 10,
    //         'quantity' => 1,
    //     ]);

    //     // Llama a la función destroy con el ID del elemento creado
    //     $response = $this->post(route('cart.destroy', ['id' => $item->rowId]));

    //     // Verifica que el elemento haya sido eliminado del carrito
    //     $this->assertCount(0, Cart::instance('default')->content());

    //     // Verifica que la respuesta redirija a la página anterior
    //     $response->assertRedirect();
// }
// }
