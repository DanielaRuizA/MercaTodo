<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function testUserCreateANewSession(): void
    {
        $user = User::factory()->create();

        $this
        ->actingAs($user);
        $order=Order::create([
            'user_id' =>  auth()->id(),
            'amount' =>  3000,
        ]);

        $mockResponse =[
            'status' => [
                'status' => 'OK',
                'reason' => 'PC',
                'message' => 'La petición se ha procesado correctamente',
                'date' => '2021-11-30T15:08:27-05:00'
            ],
            'requestId' => 1,
            "processUrl" => "https://checkout-co.placetopay.com/session/1/cc9b8690b1f7228c78b759ce27d7e80a"
        ];

        Http::fake([config('placetopay.url').'/*' => Http::response($mockResponse)]);

        $this->postJson(route('payments.processPayment'), [
            'reference' => $order->id,
            'total' => $order->amount,
        ])->assertStatus(200);
    }
}
