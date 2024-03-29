<?php

namespace App\Http\Controllers\AdminPanel;

use App\Actions\Product\ChangeProductStatusAction;
use App\Actions\Product\ProductDestroyAction;
use App\Actions\Product\ProductStoreAction;
use App\Actions\Product\ProductUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\ProductStoreRequest;
use App\Http\Requests\AdminPanel\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('AdminPanel/Products/Index', [
            'products' => Product::latest()
                ->where('id', 'LIKE', "%$request->search%")
                ->orWhere('name', 'LIKE', "%$request->search%")
                ->orWhere('price', 'LIKE', "%$request->search%")
                ->orWhere('quantity', 'LIKE', "%$request->search%")
                ->paginate(20, ['id', 'name', 'status', 'price', 'quantity', 'product_photo']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('AdminPanel/Products/Create');
    }

    public function store(ProductStoreRequest $request, ProductStoreAction $productStoreAction): RedirectResponse
    {
        $productStoreAction->handle($request);

        return redirect()->route('products.index')->with('message', 'Producto Creado');
    }

    public function show(Product $product): Response
    {
        return Inertia::render('AdminPanel/Products/Show', compact('product'));
    }

    public function edit(Product $product): Response
    {
        return Inertia::render('AdminPanel/Products/Edit', compact('product'));
    }

    public function update(ProductUpdateRequest $request, Product $product, ProductUpdateAction $productUpdateAction): RedirectResponse
    {
        $product = $productUpdateAction->handle($request, $product);

        return redirect()->route('products.index')->with('message', 'Producto Actualizado');
    }

    public function destroy(ProductDestroyAction $productDestroyAction, Product $product): RedirectResponse
    {
        $productDestroyAction->handle($product);

        return redirect()->route('products.index')->with('message', 'Producto Eliminado');
    }

    public function changeProductStatus(ChangeProductStatusAction $changeProductStatusAction, Request $request): JsonResponse
    {
        $changeProductStatusAction->handle($request);

        return response()->json(['success' => 'Status change successfully.']);
    }
}
