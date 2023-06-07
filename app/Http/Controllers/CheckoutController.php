<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Services\PlaceToPayPayment;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CartService $cartService)
    {
        $contents =[
            'cartItems' => $cartService->setCartValues()->get('cartItems'),
            'total' => $cartService->setCartValues()->get('total'),
        ];
        return Inertia::render('Checkout/Index', $contents);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, PlaceToPayPayment $paymentservice)
    {
        return $paymentservice->pay($request);
    }

    /**
         * Display the specified resource.
         */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
