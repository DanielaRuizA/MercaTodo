<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ProductRequest;
use App\Http\Resources\Api\V1\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;
use Spatie\QueryBuilder\QueryBuilder;

class ProductController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $products = QueryBuilder::for(Product::class)
            ->allowedFilters(['id', 'name', 'description', 'status', 'price', 'quantity'])
            ->paginate(20);

        return ProductResource::collection($products);
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('product_photo')) {
            $filePath = url(Storage::disk('public')->put('images', request()->file('product_photo')));
            $data['product_photo'] = $filePath;
        }

        $product = Product::create($data);

        return response()->json([
            'message' => trans('the product was created successfully', ['attribute' => 'product']),
            'data' => new ProductResource($product),
        ], 201);
    }

    public function show(int $id): ProductResource
    {
        $product = QueryBuilder::for(Product::class)
            ->findOrFail($id);

        return ProductResource::make($product);
    }

    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('product_photo')) {
            Storage::disk('public')->delete($product->product_photo);

            $filePath = url(Storage::disk('public')->put('images', request()->file('product_photo')));

            $validated['product_photo'] = $filePath;
        }

        $product->update($validated);

        return response()->json([
            'message' => trans('the product was updated successfully', ['attribute' => 'product']),
            'data' => new ProductResource($product),
        ], 200);
    }

    public function destroy(Product $product): JsonResponse
    {
        Storage::disk('public')->delete($product->product_photo);

        $product->delete();

        return response()->json([
            'message' => trans('the product was deleted successfully', ['attribute' => 'product']),
        ], 200);
    }
}
