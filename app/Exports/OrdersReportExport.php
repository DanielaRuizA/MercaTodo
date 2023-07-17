<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class OrdersReportExport implements FromQuery
{
    use Exportable;

    private array $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function query()
    {
        return Order::query()
            ->whereDateOrder(
                isset($this->filters['date1']) ? $this->filters['date1'] : null,
                isset($this->filters['date2']) ? $this->filters['date2'] : null,
            )
            ->whereOrderStatus(isset($this->filters['orderStatus']) ? $this->filters['orderStatus'] : null)
            ->whereOrderAmount(
                isset($this->filters['minAmount']) ? $this->filters['minAmount'] : null,
                isset($this->filters['maxAmount']) ? $this->filters['maxAmount'] : null,
            )
            ->select(
                'orders.id',
                'orders.order_id',
                'orders.created_at',
                'orders.amount',
                'orders.status',
                'orders.url',
                'orders.updated_at',
                'users.name',
                'users.email'
            )
            ->orderByDesc('orders.created_at')
            ->join('users', 'orders.user_id', 'users.id');
    }
}
