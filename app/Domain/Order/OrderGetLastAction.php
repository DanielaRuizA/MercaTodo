<?php

namespace App\Domain\Order;

use App\Models\Order;

class OrderGetLastAction
{
    public static function execute(): object|null
    {
        return Order::query()->where('user_id', '=', auth()->id())
            ->where('status', '=', 'PENDING')
            ->orWhere('status', '=', 'CANCELED')
            ->latest()->first();
    }
}
