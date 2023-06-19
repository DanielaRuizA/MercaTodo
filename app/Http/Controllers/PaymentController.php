<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Order;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Services\PaymentBase;
use App\Services\PlaceToPayPayment;
use Illuminate\Support\Facades\Redirect;

class PaymentController extends Controller
{
    public function processPayment(Request $request, PlaceToPayPayment $paymentService):void
    {
        $paymentService->pay($request);
    }

    public function processResponse(PlaceToPayPayment $placeToPayPayment):Response
    {
        return $placeToPayPayment->getRequestInformation();
    }

    public function retryPayment(Request $request, PlaceToPayPayment $paymentService)
    {
        return $paymentService->pay($request);
        // $request->validate([
        //     'id' => ['required', 'integer'],
        // ]);

        // $order = Order::where('order_id', $id)->first();

        // if ($order-> status == 'CANCELED') {
        //     $order->pending();
        // }
        // return $paymentService->pay(
        //     $order,
        //     $request->ip() ? $request->ip() : '',
        //     $request->userAgent() ? $request->userAgent() : ''
        // );
    }
}
