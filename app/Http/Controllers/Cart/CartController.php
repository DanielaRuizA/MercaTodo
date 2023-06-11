<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CartController extends Controller
{
    public function index(CartService $cartService): Response
    {
        return Inertia::render('Cart/Index', [
            'cartItems' => $cartService->setCartValues()->get('cartItems'),
            'total' => $cartService->setCartValues()->get('total'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Cart::instance('default')->add($request->id, $request->name, $request->quantity, $request->price, ['totalQty' => $request->totalQty, 'image' => $request->image, 'description' => $request->description])->associate('App\Models\Product');

        return redirect()->route('cart.index');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        Cart::instance('default')->update($id, $request->quantity);

        return back();
    }

    public function destroy($id): RedirectResponse
    {
        Cart::instance('default')->remove($id);

        return back();
    }
}
