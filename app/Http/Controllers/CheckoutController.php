<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Inertia\Inertia;
use Inertia\Response;

class CheckoutController extends Controller
{
    public function index(CartService $cartService): Response
    {
        $contents = [
            'cartItems' => $cartService->setCartValues()->get('cartItems'),
            'total' => $cartService->setCartValues()->get('total'),
        ];

        return Inertia::render('Checkout/Index', $contents);
    }

    public function store(Request $request, PlaceToPayPayment $paymentService): HttpFoundationResponse
    {
        return $paymentService->pay($request);
    }
}
