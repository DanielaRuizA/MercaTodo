<?php

namespace App\Http\Controllers\Store;

use Inertia\Inertia;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        //dd(Product::all());
        return Inertia::render('Store/Index', [
            'products'=> Product::latest()->paginate(20)
            
        ]);
    }
}
