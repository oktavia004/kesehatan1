<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    /**
     * Tampilkan halaman checkout
     */
    public function show()
    {
        $userId = Session::get('user_id');

        // Ambil data user dari tabel users
        $user = \App\Models\User::find($userId);

        // Ambil item di cart
        $cartItems = Cart::with('product')
            ->where('user_id', $userId)
            ->get();

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        return view('checkout', compact('cartItems', 'total', 'user'));
    }

    /**
     * Proses checkout dan simpan order
     */
    public function process(Request $request)
    {
        $userId = Session::get('user_id');

        $request->validate([
            'payment_method' => 'required|in:Prepaid,Postpaid',
        ]);

        // Gunakan transaction supaya aman
        $order = DB::transaction(function () use ($request, $userId) {
            $cartItems = Cart::with('product')
                ->where('user_id', $userId)
                ->get();

            if ($cartItems->isEmpty()) {
                abort(400, 'Keranjang kosong');
            }

            $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

            // Simpan order
            $order = Order::create([
                'user_id'        => $userId,
                'total_amount'   => $total,
                'payment_method' => $request->payment_method,
                'paypal_id'      => $request->paypal_id,
                'bank_name'      => $request->bank_name,
            ]);

            // Simpan order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'   => $order->order_id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->price,
                ]);
            }

            // Kosongkan cart
            Cart::where('user_id', $userId)->delete();

            return $order; // kembalikan order
        });

        // Redirect ke halaman invoice dengan order id
        return redirect()->route('invoice.show', $order->order_id);
    }

    /**
     * Tampilkan halaman invoice
     */
    public function showInvoice($orderId)
    {
        $order = Order::with('items.product', 'user')->findOrFail($orderId);
        return view('invoice', compact('order'));
    }
}
