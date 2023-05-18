<?php

namespace App\Http\Controllers\AdminPanel;

use App\Actions\Product\ProductIndexAction;
use App\Actions\Product\changeProductStatusActions;
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
    public function index(Request $request, ProductIndexAction $productIndexAction): Response
    {
        // $productIndexAction->handle($request);

        // return Inertia::render('AdminPanel/Products/Index', [
        //     'products' => $productIndexAction
        // ]);
        return Inertia::render('AdminPanel/Products/Index', [

            'products' => Product::latest()
                ->where('id', 'LIKE', "%$request->q%")
                ->orWhere('name', 'LIKE', "%$request->q%")
                ->orWhere('price', 'LIKE', "%$request->q%")
                ->orWhere('quantity', 'LIKE', "%$request->q%")
                ->paginate(20, ['id', 'name', 'price', 'quantity', 'product_photo']),
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

    public function changeProductStatus(changeProductStatusActions $changeProductStatusActions, Request $request): JsonResponse
    {
        $changeProductStatusActions->handle($request);

        return response()->json(['success' => 'Status change successfully.']);
    }
}
