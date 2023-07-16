<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as InertiaAssert;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    public function testUserCanSeeTheOrders()
    {
        Role::create(['name' => 'user']);

        $user = User::factory()->create()->assignRole('user');

        Order::factory()->count(5)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->get(route('orders.index'));

        $response->assertStatus(200);

        $response->assertInertia(
            fn (InertiaAssert $page) =>
                    $page->component('Orders/Index')
        );
    }
}
