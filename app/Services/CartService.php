<?php

namespace App\Services;

use Gloudemans\Shoppingcart\Facades\Cart;

class CartService
{
    public function setCartValues()
    {
        $cartItems = Cart::instance('default')->content();
        $total = Cart::instance('default')->subtotal();

        return collect([
            'cartItems' => $cartItems,
            'total' =>  $total,
        ]);
    }
}
