<?php

namespace App\Domain\Order;

class OrderCanceledAction
{
    public static function execute(string $orderId): void
    {
        OrderGetAction::execute($orderId)->canceled();
    }
}
