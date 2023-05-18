<?php

namespace App\Actions\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProductIndexAction
{
    public function handle(Request $request)
    {
        Product::latest()
                ->where('name', 'LIKE', "%$request->q%")
                ->OrWhere('price', 'LIKE', "%$request->q%")
                ->where('name', 'LIKE', "%$request->q%")
                ->where('name', 'LIKE', "%$request->q%")
                ->paginate(20, ['id','name', 'price', 'quantity','product_photo']);
    }
}
