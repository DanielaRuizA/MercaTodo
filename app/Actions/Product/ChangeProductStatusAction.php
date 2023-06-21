<?php

namespace App\Actions\Product;

use App\Models\Product;
use Illuminate\Http\Request;

class ChangeProductStatusAction
{
    public function handle(Request $request): void
    {
        $product = Product::find($request->product_id);

        $product->status = $request->status;

        $product->save();
    }
}
