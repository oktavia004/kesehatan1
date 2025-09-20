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
     * Tambahkan produk ke keranjang dengan validasi stok
     */
    public function add(Request $request, $productId)
    {
        $userId = Session::get('user_id');
        $product = Product::findOrFail($productId);
        $quantityToAdd = $request->input('quantity', 1);

        // ✅ Cek stok produk sebelum ditambahkan
        if ($product->stock < $quantityToAdd) {
            return $request->ajax()
                ? response()->json([
                    'success' => false,
                    'message' => "Stok produk hanya tersisa {$product->stock}, tidak bisa menambah {$quantityToAdd} item."
                ], 400)
                : back()->with('error', "Stok produk hanya tersisa {$product->stock}");
        }

        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        $existingQty = $cartItem ? $cartItem->quantity : 0;

        // ✅ Pastikan total tidak melebihi stok
        if ($existingQty + $quantityToAdd > $product->stock) {
            return $request->ajax()
                ? response()->json([
                    'success' => false,
                    'message' => "Jumlah di keranjang melebihi stok. Maksimal hanya {$product->stock} item."
                ], 400)
                : back()->with('error', "Jumlah di keranjang melebihi stok (maksimal {$product->stock}).");
        }

        // ✅ Tambahkan ke keranjang
        if ($cartItem) {
            $cartItem->quantity += $quantityToAdd;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id'    => $userId,
                'product_id' => $productId,
                'quantity'   => $quantityToAdd,
            ]);
        }

        $cartCount = Cart::where('user_id', $userId)->sum('quantity');

        if ($request->ajax()) {
            return response()->json([
                'success'   => true,
                'cartCount' => $cartCount,
                'message'   => "Produk berhasil ditambahkan ke keranjang."
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

     public function update(Request $request, $id)
{
    $cart = Cart::with('product')->findOrFail($id);

    if ($request->action === 'increase') {
        // ✅ Cek stok produk
        if ($cart->quantity + 1 > $cart->product->stock) {
            return $request->ajax()
                ? response()->json([
                    'success' => false,
                    'message' => "Stok produk hanya {$cart->product->stock}, tidak bisa menambah lagi."
                ], 400)
                : back()->with('error', "Stok produk hanya {$cart->product->stock}");
        }

        $cart->quantity += 1;
    } elseif ($request->action === 'decrease') {
        if ($cart->quantity > 1) {
            $cart->quantity -= 1;
        } else {
            return $request->ajax()
                ? response()->json([
                    'success' => false,
                    'message' => "Jumlah minimal 1"
                ], 400)
                : back()->with('error', "Jumlah minimal 1");
        }
    }

    $cart->save();

    // ✅ Hitung subtotal item & total keranjang
    $subtotal = $cart->product->price * $cart->quantity;
    $total = Cart::with('product')
        ->where('user_id', Session::get('user_id'))
        ->get()
        ->sum(fn($item) => $item->product->price * $item->quantity);

    if ($request->ajax()) {
        return response()->json([
            'success'  => true,
            'message'  => 'Jumlah produk diperbarui',
            'newQty'   => $cart->quantity,
            'subtotal' => number_format($subtotal, 0, ',', '.'),
            'total'    => number_format($total, 0, ',', '.')
        ]);
    }

    return back()->with('success', 'Jumlah produk diperbarui');
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
