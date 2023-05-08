<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Store/Index', [
            'products' => Product::latest()
                ->where('status', 0)
                ->where('name', 'LIKE', "%$request->q%")
                ->paginate(20, ['name', 'price', 'product_photo']),
        ]);
    }
}
