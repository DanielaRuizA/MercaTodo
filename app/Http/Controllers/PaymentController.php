<?php


namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Order;
use Inertia\Response;
use App\Models\Product;
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

        $paymentService->pay($request, $order);

        Cart::instance('default')->destroy();
    }

    public function processResponse(PlaceToPayPayment $placeToPayPayment)
    {
        // dd($placeToPayPayment->getRequestInformation());

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
