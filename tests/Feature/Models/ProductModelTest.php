<?php

namespace Tests\Feature\Models;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductModelTest extends TestCase
{
    use RefreshDatabase;

    public function testProductHasOrdersRelationship(): void
    {
        $product = Product::factory()->create();

        $this->assertEmpty($product->orders);

        $order = Order::factory()->create();
        $product->orders()->attach($order->id);
        $this->assertCount(0, $product->orders);
    }

public function testProductIsFillable()
{
    $data = [
        'name' => 'Test Product',
        'description' => 'This is a test product.',
        'status' => 'Active',
        'price' => 9000,
        'quantity' => 10,
        'product_photo' => 'test.jpg',
    ];

    $product = Product::create($data);

    $this->assertEquals($data['name'], $product->name);
    $this->assertEquals($data['description'], $product->description);
}
}
