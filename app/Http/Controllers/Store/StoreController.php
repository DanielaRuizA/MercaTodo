<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StoreController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Product::latest()->where('status', 0);

        if ($request->q) {
            $query->where(function ($query) use ($request) {
                $query->where('name', 'LIKE', "%$request->q%")
                    ->orWhere('price', 'LIKE', "%$request->q%");
            });
        }

        $products = $query->paginate(20, ['id', 'name', 'price', 'product_photo']);

        // dd($products);

        return Inertia::render('Store/Index', [
            'products' => $products,
        ]);
    }

    public function show(Product $product): Response
    {
        // dd($product);

        return Inertia::render('Store/Show', compact('product'));
    }

    public function edit(Product $product): Response
    {
        return Inertia::render('Store/Edit', compact('product'));
    }
}
