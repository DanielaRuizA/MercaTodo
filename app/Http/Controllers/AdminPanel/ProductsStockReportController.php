<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Jobs\ProductsStockReportJob;
use Illuminate\Http\Request;

class ProductsStockReportController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        ProductsStockReportJob::dispatch();

        // return redirect()->route('products.stock.report')->with('message', 'Productos exportador a formato excel');

        // return redirect()->route('products.export')->with('message', 'Productos exportador a formato excel');
    }
}
