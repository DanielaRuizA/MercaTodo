<?php

namespace App\Actions\Product;

use App\Models\Product;
use App\Http\Requests\Admin\ProductStoreRequest;
use Illuminate\Support\Facades\Storage;

class ProductStoreAction
{
    public function handle(ProductStoreRequest $request)
    {
        $validated = $request->validated();
        
        if ($request->hasFile('product_photo')) {
            $filePath = Storage::disk('public')->put('images', request()->file('product_photo'));

            $validated['product_photo'] = $filePath;
        }

        Product::create($validated);
    }
}
