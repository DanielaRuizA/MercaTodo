<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as InertiaAssert;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testUserCanSeeTheOrders(): void
    {
        Role::create(['name' => 'user']);

        $user = User::factory()->create()->assignRole('user');

        Order::factory()->count(5)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->get(route('orders.index'));

        $response->assertStatus(200);

        $response->assertInertia(
            fn (InertiaAssert $page) => $page->component('Orders/Index')
        );
    }
}
