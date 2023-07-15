<?php

namespace App\Http\Controllers\AdminPanel;

use Inertia\Inertia;
use App\Models\Order;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Exports\OrdersReportExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\AdminPanel\OrderReportRequest;
use App\Http\Requests\AdminPanel\ProductStoreRequest;

class ReportOrderController extends Controller
{
    public function ordersReportTable(Request $request): Response
    {
        $orders = Order::query()
            -> whereDateOrder($request->input('date1'), $request->input('date2'))
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
                'date1', 'date2', 'orderStatus', 'minAmount', 'maxAmount'
            ]),
            'orders' => $orders,
            'success' => session('success'),
        ]);
    }


    // public function ordersReportExport(OrderReportRequest $request)
    // {
    //     $filters = $request->validated(); // Assuming OrderReportRequest has validation rules defined

    //     $export = new OrdersReportExport($filters);

    //     return $export->download('invoices.xlsx');
    // }
    public function ordersReportExport(ProductStoreRequest $request)
    {
        $path_file = 'reports/orders/orders_'.$request->validated()['time'].'.xlsx';
        (new OrdersReportExport($request->validated()))->queue($path_file);

        return Redirect::route('orders.report.export')->with('success', 'Orders report generated.');

        // $filters = [
        //     'date1' => // Provide the start date,
        //     'date2' => // Provide the end date,
        //     'orderStatus' => // Provide the order status,
        //     'minAmount' => // Provide the minimum order amount,
        //     'maxAmount' => // Provide the maximum order amount,
        // ];
        // $filters = $request;
        // $export = new OrdersReportExport($filters);

        // return $export->download('invoices.xlsx');
    }
}
