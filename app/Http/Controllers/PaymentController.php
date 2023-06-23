<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Order;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Services\PaymentBase;
use Illuminate\Validation\Rule;
use App\Services\PlaceToPayPayment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Domain\Order\OrderCreateAction;
use App\Domain\Order\OrderUpdateAction;
use Illuminate\Support\Facades\Redirect;
use Gloudemans\Shoppingcart\Facades\Cart;

class PaymentController extends Controller
{
    public function processPayment(Request $request, Order $order, PlaceToPayPayment $paymentService)
    {
        $order = OrderCreateAction::execute($request->all());

        $paymentService->pay($request, $order);
    }

    public function processResponse(PlaceToPayPayment $placeToPayPayment):Response
    {
        return $placeToPayPayment->getRequestInformation();
    }

    public function retryPayment(Request $request, Order $order, PlaceToPayPayment $paymentService)
    {
        $request->validate([
            'id' => ['required', Rule::exists('order', 'id')],
        ]);

        $order = Order::query()->whereUser($request->user()->id)->find($request->get('id'));


        return $paymentService->pay($request, $order);


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
