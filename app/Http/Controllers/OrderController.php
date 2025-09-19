<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    // Proses checkout dari form
    public function processCheckout(Request $request)
    {
        $user = Auth::user();

        // Ambil semua item di cart user
        $cartItems = Cart::where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect('/cart')->with('error', 'Keranjang kosong!');
        }

        // Hitung total
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        // Simpan order
        $order = Order::create([
            'user_id' => $user->id,
            'order_date' => Carbon::now(),
            'payment_method' => $request->payment_method,
            'paypal_id' => $request->paypal_id,
            'bank_name' => $request->bank_name,
            'total_amount' => $total,
        ]);

        // Simpan order items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        // Hapus cart setelah checkout
        Cart::where('user_id', $user->id)->delete();

        return redirect()->route('invoice.show', $order->id);
    }

    // Tampilkan invoice
    public function showInvoice($orderId)
    {
        $order = Order::with('items.product', 'user')->findOrFail($orderId);
        return view('invoice', compact('order'));
    }

    // Download PDF
    public function downloadPdf($orderId)
    {
        $order = Order::with('items.product', 'user')->findOrFail($orderId);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('invoice', compact('order'));
        return $pdf->download('invoice_'.$order->order_id.'.pdf');
    }
}
