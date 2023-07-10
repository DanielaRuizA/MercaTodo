<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Jobs\ProductExportJob;
use Illuminate\Http\Request;

class ProductExportController extends Controller
{
    public function __invoke(Request $request)
    {
        dispatch(new ProductExportJob($request->user()));

        return redirect()->route('products.index')->with('message', 'Productos export a excel format');
    }
}
