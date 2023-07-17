<?php

namespace App\Contracts;

use App\Models\Order;
use Illuminate\Http\Request;

interface PaymentInterface
{
    public function pay(Request $request, Order $order);
}
