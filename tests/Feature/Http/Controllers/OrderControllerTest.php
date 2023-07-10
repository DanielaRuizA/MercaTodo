<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderControllerTest extends TestCase
{
//     use WithFaker, RefreshDatabase;
    
//     public function testUserCanAccessIndexOrders(): void
//     {
//         $user = User::factory()->create();
//         $this->actingAs($user)
//             ->get('orders')
//             ->assertStatus(200);
//     }

    // public function testUserCanSeeListOfOrders(): void
    // {
    // $user = User::factory()->create();

    // $orders = Order::factory()->count(3)->create([
    // 'user_id' => $user->id,
    // ]);
        
    // Order::factory()->create();

    // $orders = Order::factory()->create();

    // $response =$this->actingAs($user)
    // ->get(route('orders.index'));
    
    // $response->assertOk();

    // $response->assertInertia(
        //     fn (Assert $page) =>
        //     $page->component('Orders/Index')
        //         ->has('orders', function (Assert $component) use ($orders) {
        //             $component->has('data', $orders->toArray());
        //         })
    // );
    // }
}
