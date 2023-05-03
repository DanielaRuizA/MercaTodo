<?php

namespace App\Http\Controllers\Store;

use Inertia\Inertia;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public function index()
    {
        //dd(DB::table('products')->where('status', 0)->first());
        // latest()->paginate(20);
        // $products = Product::where('status', 1)->get();
        //$products = DB::table('products')->where('name', 'soda')->first();
        // 'products' => Product::all()


        return Inertia::render('Store/Index', [
            //'products' => $products
            // 'products' => Product::latest()

            'products' => Product::query()
                ->where('status', 0)
                ->latest()
                ->get()
            //->where('status', 0)

            // 'products'=> Product::where('status', 0)->get()

        ]);

        // {
        //     $usersList = User::orderBy('id', 'desc')
        //                     ->paginate(6);
        //     return Inertia::render('UserView', [
        //         'usersList' => $usersList
        //     ]);
        // }
    }
}
