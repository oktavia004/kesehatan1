<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Tampilkan isi keranjang
     */
    public function index()
    {
        $userId = Session::get('user_id');

        $cartItems = Cart::with('product')
            ->where('user_id', $userId)
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart', compact('cartItems', 'total'));
    }

    /**
     * Tambahkan produk ke keranjang
     */
    public function add(Request $request, $productId)
    {
      
        $userId = Session::get('user_id');

        $product = Product::findOrFail($productId);

        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id'    => $userId,
                'product_id' => $productId,
                'quantity'   => 1,
            ]);
        }

        $cartCount = Cart::where('user_id', $userId)->sum('quantity');

        if ($request->ajax()) {
            return response()->json([
                'success'   => true,
                'cartCount' => $cartCount,
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    /**
     * Hapus produk dari keranjang
     */
    public function remove(Request $request, $id)
    {
        $userId = Session::get('user_id');

        $cartItem = Cart::findOrFail($id);

        if ($cartItem->user_id == $userId) {
            $cartItem->delete();
        }

        $cartCount = Cart::where('user_id',  $userId)->sum('quantity');

        if ($request->ajax()) {
            return response()->json([
                'success'   => true,
                'cartCount' => $cartCount,
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    /**
     * Kosongkan seluruh keranjang
     */
    public function clear(Request $request)
    {
        $userId = Session::get('user_id');
        Cart::where('user_id',  $userId)->delete();

        if ($request->ajax()) {
            return response()->json([
                'success'   => true,
                'cartCount' => 0,
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', 'Keranjang berhasil dikosongkan.');
    }
}