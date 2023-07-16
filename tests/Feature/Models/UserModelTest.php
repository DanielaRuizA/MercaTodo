<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the relationship with orders.
     *
     * @return void
     */
    public function testOrdersRelationship()
    {
        $user = User::factory()->create();

        Order::factory()->count(3)->create(['user_id' => $user->id]);

        $this->assertCount(3, $user->orders);
        $this->assertInstanceOf(Order::class, $user->orders->first());
    }
}
