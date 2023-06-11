<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\PlaceToPayPayment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CartService $cartService)
    {
        $contents = [
            'cartItems' => $cartService->setCartValues()->get('cartItems'),
            'total' => $cartService->setCartValues()->get('total'),
        ];

        return Inertia::render('Checkout/Index', $contents);
    }

    public function store(Request $request, PlaceToPayPayment $paymentService)
    {
        return $paymentService->pay($request);
    }
}
