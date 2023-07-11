<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Inertia\Response;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\PlaceToPayPayment;
use App\Domain\Order\OrderCreateAction;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response as HttpResponse;

class PaymentController extends Controller
{
    public function processPayment(Request $request, Order $order, PlaceToPayPayment $paymentService): HttpResponse
    {
        $order = OrderCreateAction::execute($request->all());

        foreach (Cart::instance('default')->content() as $item) {
            $product = Product::find($item->model->id);
            if ($product->quantity < $item->qty) {
                if ($product->quantity === 0) {
                    return response([
                        'errors' => 'Sorry! '.$item->name. ' is no longer available. Please remove the item from your cart.'
                    ], 400);
                }
                return response([
                    'errors' => 'Sorry! There are only '.$product->quantity. 'of '.$item->name. ' left. Please adjust the quantities in your cart!',
                ], 400);
            }

            $order->products()->attach($product, ['quantity' => $item->qty, 'unit_price'=>$item->price]);
            $product->decrement('quantity', $item->qty);
        }

        // foreach (Cart::instance('default')->content() as $item) {
        //     $product = Product::find($item->model->id);
        //     $order->products()->attach($product, ['quantity' => $item->qty, 'unit_price'=>$item->price]);
        // }

        $paymentService->pay($request, $order);

        Cart::instance('default')->destroy();
    }

    public function processResponse(PlaceToPayPayment $placeToPayPayment): Response
    {
        // dd($placeToPayPayment->getRequestInformation());

        return $placeToPayPayment->getRequestInformation();
    }
    

    public function retryPayment(Request $request, PlaceToPayPayment $paymentService):RedirectResponse
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        $order = Order::findOrFail($request->input('id'));
        $status = $paymentService->pay($request, $order);

        if ($order->payment_status == 'CANCELED') {
            $order->pending();
        }

        if ($status === 200) {
            return redirect()->route('orders.index');
        }if ($status === 500) {
            return redirect()->route('orders.index');
        }
    }
}
