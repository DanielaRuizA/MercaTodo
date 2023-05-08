<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Product\changeProductStatusActions;
use App\Actions\Product\ProductDestroyAction;
use App\Actions\Product\ProductStoreAction;
use App\Actions\Product\ProductUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductStoreRequest;
use App\Http\Requests\Admin\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Admin/Products/Index', [
            'products' => Product::latest()
                ->where('name', 'LIKE', "%$request->q%")
                ->get(['id', 'name', 'status', 'price', 'quantity', 'product_photo']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Products/Create');
    }

    public function store(ProductStoreRequest $request, ProductStoreAction $productStoreAction)
    {
        $productStoreAction->handle($request);

        return redirect()->route('products.index')->with('message', 'Producto Creado');
    }

    public function show(Product $product)
    {
        return Inertia::render('Admin/Products/Show', compact('product'));
    }

    public function edit(Product $product)
    {
        return Inertia::render('Admin/Products/Edit', compact('product'));
    }

    public function update(ProductUpdateRequest $request, Product $product, ProductUpdateAction $productUpdateAction)
    {
        $product = $productUpdateAction->handle($request, $product);

        return redirect()->route('products.index')->with('message', 'Producto Actualizado');
    }

    public function destroy(ProductDestroyAction $productDestroyAction, Product $product)
    {
        $productDestroyAction->handle($product);

        return redirect()->route('products.index')->with('message', 'Producto Eliminado');
    }

    public function changeProductStatus(changeProductStatusActions $changeProductStatusActions, Request $request)
    {
        $changeProductStatusActions->handle($request);

        return response()->json(['success' => 'Status change successfully.']);
    }
}
