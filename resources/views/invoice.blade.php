@extends('layouts.app')

@section('title', 'Laporan Belanja')

@section('content')
<div class="invoice-wrapper border p-4 shadow-lg bg-white rounded">

    <!-- Tombol Download PDF -->
    <a href="{{ route('invoice.pdf', $order->order_id) }}" class="btn btn-primary btn-sm float-end">
    Download PDF & Kirim Email
</a>

    <!-- Judul -->
    <h3 class="text-center mb-4">Toko Alat Kesehatan</h3>
        
    <!-- Info User & Transaksi -->
    <table class="table table-borderless mb-4">
        <tr>
            <td width="50%">User ID: {{ $order->user->username }}</td>
            <td width="50%">Email: {{ $order->user->email ?? '-' }}</td>
        </tr>
        <tr>
            <td>Nama: {{ $order->user->username ?? '-' }}</td>
            <td>Tanggal: {{ \Carbon\Carbon::parse($order->order_date)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <td>Alamat: {{ $order->user->address ?? '-' }}</td>
            <td>Cara Bayar: {{ $order->payment_method }}</td>
        </tr>
        <tr>
            <td>No HP: {{ $order->user->contact_no ?? '-' }}</td>
            <td>Nama Bank: {{ $order->bank_name ?? '-' }}</td>
        </tr>
    </table>

    <!-- Tabel Produk -->
    <table class="table table-bordered">
        <thead class="table-light">
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
    <p class="fw-bold mt-3">
        Total belanja (termasuk pajak): Rp {{ number_format($order->total_amount, 0, ',', '.') }}
    </p>

    <!-- Tanda Tangan -->
    <div class="text-end mt-5 mb-5 fw-bold">
        TANDATANGAN TOKO
    </div>
</div>
@endsection
