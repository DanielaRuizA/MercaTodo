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


    public function testUserCanAccessToCheckoutView()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('checkout')
            ->assertStatus(200);
    }

    public function testCanAccessToCheckoutLoggedUsers()
    {
        $this->get('checkout')
        ->assertRedirect('login');
    }

    public function testUserCantCheckoutWithAEmptyCart()
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
}
