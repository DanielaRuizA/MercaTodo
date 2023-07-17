<?php

namespace App\QueryBuilders;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;

class OrderQueryBuilder extends Builder
{
    public function whereDateOrder(?string $date1, ?string $date2): self|Order
    {
        if ($date1 && $date2) {
            return $this->whereBetween('orders.created_at', [$date1, $date2]);
        } elseif ($date1) {
            return $this->where('orders.created_at', $date1);
        } elseif ($date2) {
            return $this->where('orders.created_at', $date2);
        } else {
            return $this;
        }
    }

    public function whereOrderStatus(?string $orderStatus): self
    {
        return $orderStatus ?
            $this->where('orders.status', $orderStatus) :
            $this;
    }

    public function whereOrderAmount(?string $minAmount, ?string $maxAmount): self|Order
    {
        if ($minAmount && $maxAmount) {
            return $this->whereBetween('orders.amount', [$minAmount, $maxAmount]);
        } elseif ($minAmount) {
            return $this->where('orders.amount', $minAmount);
        } elseif ($maxAmount) {
            return $this->where('orders.amount', $maxAmount);
        } else {
            return $this;
        }
    }
}
