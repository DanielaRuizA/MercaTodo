<?php

namespace App\Http\Controllers\Cart;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function index()
    {
        return Inertia::render('Cart/Index');
    }


    public function store()
    {
        return redirect()->route('cart.index');
    }
}
