<?php

namespace App\Http\Controllers\AdminPanel;

use Inertia\Inertia;
use App\Models\Order;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Exports\OrdersReportExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\AdminPanel\OrderReportRequest;

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
        $filePath = 'reports/orders/orders_'.$request->validated()['time'].'.xlsx';
        (new OrdersReportExport($request->validated()))->queue($filePath);

        return Redirect::route('orders.report.table')->with('success', 'The Report Of Orders Was Generated Successfully.');
    }
}
