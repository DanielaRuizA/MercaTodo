<?php

namespace App\Actions\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductDestroyAction
{
    public function handle(Product $product): void
    {
        Storage::disk('public')->delete($product->product_photo);

        $product->delete();
    }
}
