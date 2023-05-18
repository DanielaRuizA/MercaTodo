<?php

namespace App\Actions\Product;

use App\Http\Requests\AdminPanel\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductUpdateAction
{
    public function handle(ProductUpdateRequest $request, Product $product)
    {
        $validated = $request->validated();

        if ($request->hasFile('product_photo')) {
            Storage::disk('public')->delete($product->product_photo);

            $filePath = Storage::disk('public')->put('images', request()->file('product_photo'));

            $validated['product_photo'] = $filePath;
        }

        $product->update($validated);
    }
}
