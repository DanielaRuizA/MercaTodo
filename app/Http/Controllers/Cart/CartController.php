<?php

namespace App\Http\Controllers\Cart;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::instance('default')->content();
        $total  = Cart::instance('default')->subtotal(); //subtotal

        return Inertia::render('Cart/Index', [
            'cartItems' => $cartItems,
            'total' =>  $total,
        ]);
    }

    public function store(Request $request)
    {
        Cart::instance('default')->add($request->id, $request->name, $request->quantity, $request->price, ['totalQty' => $request->totalQty, 'image' => $request->image, 'description' => $request->description,])->associate('App\Models\Product');
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
