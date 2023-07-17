<?php

namespace App\Http\Controllers;

use App\Domain\Order\OrderCreateAction;
use App\Models\Order;
use App\Models\Product;
use App\Services\PlaceToPayPayment;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function processPayment(Request $request, Order $order, PlaceToPayPayment $paymentService)
    {
        $order = OrderCreateAction::execute($request->all());

        foreach (Cart::instance('default')->content() as $item) {
            $product = Product::find($item->model->id);
            if ($product->quantity < $item->qty) {
                if ($product->quantity === 0) {
                    return response([
                        'errors' => 'Sorry! '.$item->name.' is no longer available. Please remove the item from your cart.',
                    ], 400);
                }

                return response([
                    'errors' => 'Sorry! There are only '.$product->quantity.'of '.$item->name.' left. Please adjust the quantities in your cart!',
                ], 400);
            }

            $order->products()->attach($product, ['quantity' => $item->qty, 'unit_price' => $item->price]);
            $product->decrement('quantity', $item->qty);
        }

        $paymentService->pay($request, $order);

        Cart::instance('default')->destroy();
    }

    public function processResponse(PlaceToPayPayment $placeToPayPayment)
    {
        return $placeToPayPayment->getRequestInformation();
    }

    public function retryPayment(Request $request, PlaceToPayPayment $paymentService)
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
