<?php

namespace App\Domain\Order;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class OrderGetLastAction
{
    public static function execute()
    {
        return Order::query()->where('user_id', '=', auth()->id())
            ->where('status', '=', 'PENDING')
            ->orWhere('status', '=', 'CANCELED')
            ->latest()->first();
    }
}
