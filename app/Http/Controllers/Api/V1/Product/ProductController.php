<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use App\Domain\Product\ProductSaveAction;
use App\Domain\Product\ProductUpdateAction;
use App\Domain\Product\ProductDestroyAction;
use App\Http\Requests\Api\V1\ProductRequest;
use App\Http\Resources\Api\V1\ProductResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index():AnonymousResourceCollection
    {
        $products = QueryBuilder::for(Product::class)
            ->allowedFilters(['id', 'name', 'description','status', 'price', 'quantity' ])
            ->paginate(20);

        return ProductResource::collection($products);
    }

    public function store(ProductRequest $request):JsonResponse
    {
        $data = $request->all();

        $product = ProductSaveAction::execute($data);

        return response()->json([
            'message' => trans('product was created successfully', ['attribute' => 'product']),
            'data' => new ProductResource($product),
        ], 201);
    }

    public function show(int $id):ProductResource
    {
        $product = QueryBuilder::for(Product::class)
            ->findOrFail($id);

        return ProductResource::make($product);
    }

    public function update(Request $request, string $id):JsonResponse
    {
        $product = Product::query()->findOrFail($id);

        // $this->authorize('update', $product);

        ProductUpdateAction::execute($request->all(), $product->getKey());

        return response()->json([
            'message' => trans('message.updated', ['attribute' => 'product']),
        ], 200);
    }

    public function destroy(string $id):JsonResponse
    {
        $product = Product::query()->findOrFail($id);

        // $this->authorize('delete', $product);

        ProductDestroyAction::execute([], $product->getKey());

        return response()->json([
            'message' => trans('message.deleted', ['attribute' => 'product']),
        ], 200);
    }
}
