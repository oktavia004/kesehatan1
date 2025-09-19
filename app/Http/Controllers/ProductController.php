<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        $categories = ProductCategory::all();
        $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');

        return view('dashboard', compact('products', 'categories', 'cartCount'));
    }
}

