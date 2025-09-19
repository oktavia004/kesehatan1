<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->order_id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 14px; 
            background: #f9f9f9; 
            padding: 20px;
        }
        .invoice-wrapper {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            max-width: 800px;
            margin: auto;
            box-shadow: 0px 2px 8px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 10px;
        }
        .btn-pdf {
            display: inline-block;
            margin-bottom: 15px;
            padding: 6px 12px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
        .btn-pdf:hover { background-color: #0056b3; color: #fff; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }
        th {
            background: #f2f2f2;
            text-align: left;
        }
        .total-row td {
            font-weight: bold;
        }
        .user-info p {
            margin: 2px 0;
        }
    </style>
</head>
<body>
    <div class="invoice-wrapper">
        <!-- Tombol Download PDF -->
        <a href="{{ route('invoice.pdf', $order->order_id) }}" class="btn-pdf" target="_blank">Download PDF</a>

        <!-- Judul Invoice -->
        <h2>Invoice #{{ $order->order_id }}</h2>

        <!-- Info User & Tanggal -->
        <div class="user-info">
            <p><strong>Nama:</strong> {{ $order->user->username }}</p>
            <p><strong>Email:</strong> {{ $order->user->email }}</p>
            <p><strong>Tanggal:</strong> {{ $order->order_date->format('d M Y H:i') }}</p>
            <p><strong>Metode Pembayaran:</strong> {{ $order->payment_method }}</p>
            @if($order->paypal_id)
                <p><strong>Paypal ID:</strong> {{ $order->paypal_id }}</p>
            @endif
            @if($order->bank_name)
                <p><strong>Bank:</strong> {{ $order->bank_name }}</p>
            @endif
        </div>

        <!-- Tabel Produk -->
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3">Total</td>
                    <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
