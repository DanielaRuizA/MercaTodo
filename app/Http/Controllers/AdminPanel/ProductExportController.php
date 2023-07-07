<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Jobs\ProductExportJob;
use Illuminate\Http\Request;

class ProductExportController extends Controller
{
    public function __invoke(Request $request)
    {
        ProductExportJob::dispatch();
        
        // return redirect()->route('products.export')->with('message', 'Productos exportador a formato excel');
        return redirect()->route('products.stock.report')->with('message', 'Productos exportador a formato excel');
    }
}
