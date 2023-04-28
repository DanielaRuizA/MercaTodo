<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'description'=> 'required',
            'price'=> 'required',
            'quantity'=> 'required',
            'product_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);


        $validated = $request->all();
        
        if ($request->hasFile('product_photo')) {
            $filePath = Storage::disk('public')->put('images', request()->file('product_photo'));

            $validated['product_photo'] = $filePath;
        }

        $product = Product::create($validated);

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

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'description'=> 'required',
            'price'=> 'required',
            'quantity'=> 'required',
            // 'product_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // $validated = $request->all();
        
        // if ($request->hasFile('product_photo')) {
        //     $filePath = Storage::disk('public')->put('images', request()->file('product_photo'));

        //     $validated['product_photo'] = $filePath;
        // }

        $product->update($request->all());

        return redirect()->route('products.index')->with('message', 'Producto Actualizado');
    }

    public function destroy(Product $product)
    {
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
