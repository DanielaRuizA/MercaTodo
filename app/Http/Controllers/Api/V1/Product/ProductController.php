<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Storage;
use App\Domain\Product\ProductSaveAction;
use App\Domain\Product\ProductUpdateAction;
use App\Domain\Product\ProductDestroyAction;
use App\Http\Requests\Api\V1\ProductRequest;
use App\Http\Resources\Api\V1\ProductResource;
use App\Http\Requests\AdminPanel\ProductStoreRequest;
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
        // $data = $request->all();

        // $product = ProductSaveAction::execute($data);

        $data = $request->validated();

        if ($request->hasFile('product_photo')) {
            $filePath = url(Storage::disk('public')->put('images', request()->file('product_photo')));

            // $filePath = Storage::disk('public')->put('images', request()->file('product_photo'));

            $data['product_photo'] = $filePath;
        }

        $product = Product::create($data);


        return response()->json([
            'message' => trans('the product was created successfully', ['attribute' => 'product']),
            'data' => new ProductResource($product),
        ], 201);
    }

    public function show(int $id):ProductResource
    {
        $product = QueryBuilder::for(Product::class)
            ->findOrFail($id);

        return ProductResource::make($product);
    }

    public function update(ProductRequest $request, Product $product):JsonResponse
    {
        // $product = Product::query()->findOrFail($id);

        // $this->authorize('update', $product);

        // ProductUpdateAction::execute($request->all(), $product->getKey());

        $validated = $request->validated();

        if ($request->hasFile('product_photo')) {
            Storage::disk('public')->delete($product->product_photo);

            $filePath = url(Storage::disk('public')->put('images', request()->file('product_photo')));

            // $filePath = Storage::disk('public')->put('images', request()->file('product_photo'));

            $validated['product_photo'] = $filePath;
        }

        $product->update($validated);


        return response()->json([
            'message' => trans('the product was updated successfully', ['attribute' => 'product']),
            'data' => new ProductResource($product),
        ], 200);
    }

    public function destroy(Product $product):JsonResponse
    {
        Storage::disk('public')->delete($product->product_photo);

        $product->delete();

        // $product = Product::query()->findOrFail($id);

        // $this->authorize('delete', $product);

        // ProductDestroyAction::execute([], $product->getKey());

        return response()->json([
            'message' => trans('the product was deleted successfully', ['attribute' => 'product']),
        ], 200);
    }
}



// namespace App\Http\Controllers\Api\V1\Product;

// use App\Models\Product;
// use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
// use Spatie\QueryBuilder\QueryBuilder;
// use App\Domain\Product\ProductSaveAction;
// use App\Domain\Product\ProductUpdateAction;
// use App\Domain\Product\ProductDestroyAction;
// use App\Http\Requests\Api\V1\ProductRequest;
// use App\Http\Resources\Api\V1\ProductResource;
// use Illuminate\Http\JsonResponse;
// use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

// class ProductController extends Controller
// {
//     public function index():AnonymousResourceCollection
//     {
//         $products = QueryBuilder::for(Product::class)
//             ->allowedFilters(['id', 'name', 'description','status', 'price', 'quantity' ])
//             ->paginate(20);

//         return ProductResource::collection($products);
//     }

//     public function store(ProductRequest $request):JsonResponse
//     {
//         $data = $request->all();

//         $product = ProductSaveAction::execute($data);

//         return response()->json([
//             'message' => trans('product was created successfully', ['attribute' => 'product']),
//             'data' => new ProductResource($product),
//         ], 201);
//     }

//     public function show(int $id):ProductResource
//     {
//         $product = QueryBuilder::for(Product::class)
//             ->findOrFail($id);

//         return ProductResource::make($product);
//     }

//     public function update(Request $request, string $id):JsonResponse
//     {
//         $product = Product::query()->findOrFail($id);

//         // $this->authorize('update', $product);

//         ProductUpdateAction::execute($request->all(), $product->getKey());

//         return response()->json([
//             'message' => trans('message.updated', ['attribute' => 'product']),
//         ], 200);
//     }

//     public function destroy(string $id):JsonResponse
//     {
//         $product = Product::query()->findOrFail($id);

//         // $this->authorize('delete', $product);

//         ProductDestroyAction::execute([], $product->getKey());

//         return response()->json([
//             'message' => trans('message.deleted', ['attribute' => 'product']),
//         ], 200);
//     }
// }
// public function store(ProductRequest $request):JsonResponse
// {
    //     $data = $request->validated();

    //     if ($request->hasFile('product_photo')) {
    //         $filePath = Storage::disk('public')->put('images', request()->file('product_photo'));
    //         // $filePath = url(Storage::disk('public')->put('images', request()->file('product_photo')));
    //         $data['product_photo'] = $filePath;
    //     }

// $data = $request->all();

    //     $product = ProductSaveAction::execute($data);

    //     return response()->json([
    //         'message' => trans('the product was created successfully', ['attribute' => 'product']),
    //         'data' => new ProductResource($product),
    //     ], 201);
// }
