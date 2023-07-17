<?php

namespace App\Domain\Order;

class OrderCompletedAction
{
    public static function execute(string $orderId): void
    {
        OrderGetAction::execute($orderId)->completed();
    }
}
