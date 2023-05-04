<?php

namespace App\Http\Controllers\Store;

use Inertia\Inertia;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        //dd(DB::table('products')->where('status', 0)->first());

        // $products = Product::latest()
        // ->where('status', 0)
        // ->where('name', 'LIKE', "%$request->q%")
        // ->paginate(20, ['name','price','product_photo']);

        // return Inertia::render('Store/Index', [
        //     'products' => $products
        // ]);

        return Inertia::render('Store/Index', [
            'products'=> Product::latest()
            ->where('status', 0)
            ->where('name', 'LIKE', "%$request->q%")
            ->paginate(20, ['name','price','product_photo'])
        ]);
    }
}
