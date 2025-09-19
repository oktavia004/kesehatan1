<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Keranjang Belanja</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .wrapper {
      width: 85%;
      margin: 0 auto;
      background: #fff;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 8px;
      box-shadow: 0px 2px 8px rgba(0,0,0,0.1);
    }
    
    .title-box {
      text-align: center;
      margin-bottom: 20px;
    }
    .title-box h2 {
      display: inline-block;
      padding: 10px 20px;
      border: 1px solid #ddd;
      border-radius: 5px;
      background-color: #f1f1f1;
      margin: 0;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    table, th, td {
      border: 1px solid #ddd;
    }
    th {
      background-color: #f1f1f1;
      padding: 10px;
      text-align: center;
    }
    td {
      padding: 10px;
      text-align: center;
    }
    .title-box h2 {
      font-size: 16px;
    }
    .total {
      text-align: left;
      margin-top: 15px;
      font-weight: bold;
      font-size: 18px;
    }
    .highlight {
      color: #d9534f;
    }
    .btn {
      display: inline-block;
      padding: 6px 12px;
      margin: 2px;
      font-size: 12px;
      cursor: pointer;
      border-radius: 4px;
      text-decoration: none;
      border: none;
    }
    .btn-danger {
      background-color: #dc3545;
      color: #fff;
    }
    .btn-primary {
      background-color: #0d6efd;
      color: #fff;
    }
  </style>
</head>
<body class="bg-light">


@extends('layouts.app')

@section('title', 'cart')

@section('content')
<div class="container my-5">
  <div class="wrapper">
    <div class="title-box">
      <h2>Keranjang Belanja</h2>
    </div>


    <table>
      <thead>
        <tr>
          <th>No.</th>
          <th>Nama Produk dengan ID</th>
          <th>Jumlah</th>
          <th>Harga</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($cartItems as $index => $item)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->product->product_name }} ({{ $item->product->product_code }})</td>
            <td>{{ $item->quantity }}</td>
            <td>Rp. {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</td>
            <td>
              <form action="{{ route('cart.remove', $item->cart_id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center">Keranjang kosong</td>
          </tr>
        @endforelse
      </tbody>
    </table>


    <div class="total">
      Total belanja (termasuk pajak):
      <span class="highlight">Rp. {{ number_format($total, 0, ',', '.') }}</span>
    </div>


    <div style="margin-top: 20px; text-align: right;">
      <a href="{{ url('/checkout') }}" class="btn btn-primary">Checkout</a>
    </div>
  </div>
</div>
@endsection



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
