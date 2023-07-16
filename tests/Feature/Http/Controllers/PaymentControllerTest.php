<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\PlaceToPayPayment;
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

        $this->postJson(route('payments.process'), [
            'reference' => $order->id,
            'total' => $order->amount,
        ])->assertStatus(200);
    }

    // public function testUserCanPay()
    // {
    //     $paymentService = new PlaceToPayPayment();
    //     $request = new Request();
    //     $order = Order::factory()->create();

    //     $response = $paymentService->pay($request, $order);

    //     $this->assertInstanceOf(HttpFoundationResponse::class, $response);
    //     $this->assertEquals(302, $response->getStatusCode());
    //     $this->assertNotNull($order->order_id);
    //     $this->assertNotNull($order->url);
    //     $this->assertStringContainsString($order->order_id, $response->headers->get('Location'));
    // }

    // public function testUserCanRedirectToPlacetopay()
    // {
    //     $user = User::factory()->create();

    //     $this->actingAs($user);

    //     $order = Order::factory()->create([
    //         'user_id' => $user->getKey(),
    //         'order_id' => 1213,
    //         'url' => 'https://checkout-co.placetopay.dev/spa/session/1213/1234',
    //         'amount' => 30000,
    //             ], );

    //     $response = $this->post(route('payments.process', $order->order_id));

    //     $response->assertRedirect()
    //         ->assertRedirectContains($order->url);
    // }
}
