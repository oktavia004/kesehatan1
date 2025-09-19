<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        $categories = ProductCategory::all();
        // ✅ Hitung cartCount user (default 0 kalau belum login/keranjang kosong)
        $cartCount = 0;
        if (Session::has('user_id')) {
            $cartCount = Cart::where('user_id', Session::get('user_id'))->sum('quantity');
        }

        return view('dashboard', compact('products', 'categories', 'cartCount'));
    }
}

