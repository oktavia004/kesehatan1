<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Belanja #{{ $order->order_id }}</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px; 
            margin: 20px; /* beri jarak dari tepi PDF */
            padding: 0;
        }
        h2, h3 { text-align: center; margin: 0; }
        h2 { font-size: 16px; font-weight: bold; }
        h3 { font-size: 14px; margin-bottom: 20px; }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
        }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background: #f2f2f2; }

        /* Info user */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr; 
            gap: 20px;
            margin-bottom: 15px;
        }
        .info-grid p { margin: 2px 0; }

        .total-text { 
            margin-top: 15px; 
            font-weight: bold; 
        }

        .signature { 
            margin-top: 80px;  /* Jarak dari tabel/total ke tanda tangan */
            text-align: right; 
            font-weight: bold; 
        }
    </style>
</head>
<body>

    <!-- Judul -->
    <h3>Toko Alat Kesehatan</h3>

    <!-- Info User & Transaksi -->
    <table style="width:100%; margin-bottom:15px; border:none; border-collapse: collapse;">
        <tr>
            <!-- Kolom kiri -->
            <td style="vertical-align: top; width:50%; border:none;">
                <p><strong>User ID:</strong> {{ $order->user->username }}</p>
                <p><strong>Nama:</strong> {{ $order->user->username ?? '-' }}</p>
                <p><strong>Alamat:</strong> {{ $order->user->address ?? '-' }}</p>
                <p><strong>No HP:</strong> {{ $order->user->contact_no ?? '-' }}</p>
            </td>

            <!-- Kolom kanan -->
            <td style="vertical-align: top; width:50%; border:none;">
                <p><strong>Email:</strong> {{ $order->user->email ?? '-' }}</p>
                <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('d-m-Y') }}</p>
                <p><strong>Cara Bayar:</strong> {{ $order->payment_method }}</p>
                <p><strong>Nama Bank:</strong> {{ $order->bank_name ?? '-' }}</p>
            </td>
        </tr>
    </table>

    <!-- Tabel Produk -->
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Produk dengan IDnya</th>
                <th>Jumlah</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product->product_name }} ({{ $item->product->product_code ?? 'N/A' }})</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Total Belanja -->
    <p class="total-text">
        Total belanja (termasuk pajak): Rp {{ number_format($order->total_amount, 0, ',', '.') }}
    </p>

    <!-- Tanda Tangan -->
    <div class="signature">
        TANDATANGAN TOKO
    </div>

</body>
</html>