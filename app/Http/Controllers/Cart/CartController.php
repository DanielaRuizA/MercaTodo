<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index(CartService $cartService)
    {
        // $cartItems = Cart::instance('default')->content();
        // $total  = Cart::instance('default')->subtotal(); //subtotal

        return Inertia::render('Cart/Index', [
            'cartItems' => $cartService->setCartValues()->get('cartItems'),
            'total' => $cartService->setCartValues()->get('total'),

        ]);
        //     'cartItems' => $cartItems,
        //     'total' =>  $total,
        // ]);
    }

    public function store(Request $request)
    {
        Cart::instance('default')->add($request->id, $request->name, $request->quantity, $request->price, ['totalQty' => $request->totalQty, 'image' => $request->image, 'description' => $request->description])->associate('App\Models\Product');

        return redirect()->route('cart.index');
    }

    public function update(Request $request, $id)
    {
        Cart::instance('default')->update($id, $request->quantity);

        return back();
    }

    public function destroy($id)
    {
        Cart::instance('default')->remove($id);

        return back();
    }
}
