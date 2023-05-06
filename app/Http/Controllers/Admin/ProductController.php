<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Requests\Admin\ProductUpdateRequest;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Products/Index', [
            'products'=> Product::latest()->get(['id','name','description','status','price','quantity','product_photo'])
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Products/Create');
    }

    public function store(ProductRequest $request, Product $product)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'description'=> 'required',
        //     'price'=> 'required',
        //     'quantity'=> 'required',
        //     'product_photo' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048'
        // ]);


        $validated = $request->validated();
        
        if ($request->hasFile('product_photo')) {
            $filePath = Storage::disk('public')->put('images', request()->file('product_photo'));

            $validated['product_photo'] = $filePath;
        }

        Product::create($validated);

        return redirect()->route('products.index', $product->id)->with('message', 'Producto Creado');
    }

    public function show(Product $product)
    {
        return Inertia::render('Admin/Products/Show', compact('product'));
    }

    public function edit(Product $product)
    {
        return Inertia::render('Admin/Products/Edit', compact('product'));
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        // $request->validate([
        // 'name' => 'required',
        // 'description'=> 'required',
        // 'price'=> 'required',
        // 'quantity'=> 'required',
        // 'product_photo' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048'
        // ]);

        $validated = $request->validated();

        if ($request->hasFile('product_photo')) {
            Storage::disk('public')->delete($product->product_photo);

            $filePath = Storage::disk('public')->put('images', request()->file('product_photo'));
            
            $validated['product_photo'] = $filePath;
        }

        $product->update($validated);

        return redirect()->route('products.index')->with('message', 'Producto Actualizado');
    }


    public function destroy(Product $product)
    {
        Storage::disk('public')->delete($product->product_photo);
        
        $product->delete();

        return redirect()->route('products.index')->with('message', 'Producto Eliminado');
    }

    public function changeProductStatus(Request $request)
    {
        $product = Product::find($request->product_id);

        $product->status = $request->status;

        $product->save();

        return response()->json(['success'=>'Status change successfully.']);
    }
}
