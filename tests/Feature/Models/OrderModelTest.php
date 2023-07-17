<?php

namespace Tests\Feature\Models;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderModelTest extends TestCase
{
    use RefreshDatabase;

    public function testOrderBelongsToUser(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $order->user);
        $this->assertEquals($user->id, $order->user->id);
    }

    public function testProductsRelationship(): void
    {
        $order = Order::factory()->create();
        $product1 = Product::factory()->create();
        $product2 = Product::factory()->create();

        $order->products()->attach([
            $product1->id => ['quantity' => 2, 'unit_price' => 10.99],
            $product2->id => ['quantity' => 1, 'unit_price' => 5.99],
        ]);

        $this->assertInstanceOf(Product::class, $order->products()->first());
        $this->assertCount(2, $order->products);
    }
}
