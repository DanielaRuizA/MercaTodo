<?php

namespace App\Http\Controllers\AdminPanel;

use App\Exports\OrdersReportExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\OrderReportRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ReportOrderController extends Controller
{
    public function ordersReportTable(Request $request): Response
    {
        $orders = Order::query()
            ->whereDateOrder($request->input('date1'), $request->input('date2'))
            ->whereOrderStatus($request->input('orderStatus'))
            ->whereOrderAmount($request->input('minAmount'), $request->input('maxAmount'))
            ->select(
                'orders.id',
                'orders.order_id',
                'orders.created_at',
                'orders.amount',
                'orders.status',
                'orders.url',
                'orders.updated_at',
                'users.name',
                'users.email',
            )
            ->orderByDesc('orders.created_at')
            ->join('users', 'orders.user_id', 'users.id')
            ->get();

        return Inertia::render('AdminPanel/Reports/Orders/Table', [
            'filters' => $request->only([
                'date1', 'date2', 'orderStatus', 'minAmount', 'maxAmount',
            ]),
            'orders' => $orders,
            'success' => session('success'),
        ]);
    }

    public function ordersReportExport(OrderReportRequest $request): RedirectResponse
    {
        $path_file = 'reports/orders/orders_'.$request->validated()['time'].'.xlsx';
        (new OrdersReportExport($request->validated()))->queue($path_file);

        return Redirect::route('orders.report.table')->with('success', 'The Report Of Orders Was Generated Successfully.');
    }
}
