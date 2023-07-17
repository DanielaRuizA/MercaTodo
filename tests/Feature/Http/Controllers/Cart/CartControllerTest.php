<?php

namespace Tests\Feature\Http\Controllers\Cart;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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

    public function testUserUpdateTheQuantityOfTheCart(): void
    {
        $cartItemId = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
        $newQuantity = 2;

        $this
            ->patch(route('cart.update', $cartItemId), ['quantity' => $newQuantity])
            ->assertRedirect();
    }
}
