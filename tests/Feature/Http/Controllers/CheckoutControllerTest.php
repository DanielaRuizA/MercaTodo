<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Services\CartService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckoutControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;


    public function testUserCanAccessToCheckoutView(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('checkout')
            ->assertStatus(200);
    }

    public function testCanAccessToCheckoutLoggedUsers(): void
    {
        $this->get('checkout')
        ->assertRedirect('login');
    }

    public function testUserCantCheckoutWithAEmptyCart(): void
    {
        $user = User::factory()->create();

        $this
        ->actingAs($user)
        ->get('checkout')
        ->assertStatus(200)
        ->assertSee(0);
    }

    // public function testUserCantCheckoutWithACart()
    // {
        // $user = User::factory()->create();
        
        // $cartItems = Cart::instance('default')->content();
        // $total = Cart::instance('default')->subtotal();

        // $this->get(route('checkout.index'));

        // $this
        // ->actingAs($user)
        // ->get('checkout')
        // ->assertStatus(200)
        // ->assertSee($catItems);
    // }

    // public function testIndex()
// {
//     $user = User::factory()->create();

//     $this->actingAs($user);

//     $response = $this->get('/checkout');
//     $response->assertStatus(200);

//     $cartService = $this->getMockBuilder(CartService::class)
//             ->disableOriginalConstructor()
//             ->getMock();

//     $cartItems = ['item1', 'item2'];
//     $total = 100;


//     $response->assertInertia(fn (Assert $page) => $page
//     ->has('cartItems', ['item1', 'item2'])
//     ->has('total', 100));
// }
// }

// public function testIndex()
// {
//     $user = User::factory()->create();

//     $this->actingAs($user);

//     $response = $this->get('/checkout');
//     $response->assertStatus(200);

//     $cartService = $this->getMockBuilder(CartService::class)
//             ->disableOriginalConstructor()
//             ->getMock();

//     $cartItems = ['item1', 'item2'];
//     $total = 100;


//     $response->assertInertia(fn (Assert $page) => $page
//     ->has('cartItems', ['item1', 'item2'])
//     ->has('total', 100));
// }
// }




// // Make a request to the controller action
// $response = $this->get('/checkout');

// // Assert the response
// $response->assertStatus(200);
// $response->assertInertia(fn (InertiaAssert $page) => {
        //     $page->component('Checkout/Index');
        //     $page->has('cartItems', ['item1', 'item2']);
        //     $page->has('total', 100);





// // Make a request to the controller action
// $response = $this->get('/checkout');

// // Assert the response
// $response->assertStatus(200);
// $response->assertInertia(fn (InertiaAssert $page) => {
        //     $page->component('Checkout/Index');
        //     $page->has('cartItems', ['item1', 'item2']);
        //     $page->has('total', 100);
}
