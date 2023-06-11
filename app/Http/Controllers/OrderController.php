<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function index(): Response
    {
        $orders = Order::where('user_id', '=', auth()->id())->latest()->get();

        return Inertia::render('Orders/Index', [
            'orders' => $orders,
        ]);
    }
}
