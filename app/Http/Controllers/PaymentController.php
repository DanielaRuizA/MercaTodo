<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Services\PlaceToPayPayment;
use App\Contracts\PaymentFactoryInterface;
use App\Services\PaymentBase;

// use Inertia\Inertia;

class PaymentController extends Controller
{
    public function processPayment(Request $request, PlaceToPayPayment $paymentService)
    {
        $paymentService->pay($request);
        // return Inertia::location($paymentService->pay($request));

        // return redirect()->to($order->url);

        // Inertia::location($order->url);

        // return Inertia::location($order->url);
    }

    private function sendEmail(PaymentBase $base): void
    {
        $base->sendNotification();
    }

    public function processResponse(PlaceToPayPayment $placeToPayPayment)
    {
        dd('hola');
        // return $placeToPayPayment->getRequestInformation();
    }
}
