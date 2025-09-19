<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Checkout</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      background:#f9f9f9;
    }
    .wrapper {
      width: 85%;
      margin: 20px auto;
      background: #fff;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 8px;
      box-shadow: 0px 2px 8px rgba(0,0,0,0.1);
    }
    .title-box {
      text-align: center;
      margin-bottom: 15px;
    }
    .title-box h2 {
      display: inline-block;
      padding: 8px 16px;
      border: 1px solid #ddd;
      border-radius: 5px;
      background-color: #f1f1f1;
      margin: 0;
      font-size: 18px;
    }
    .user-info {
      margin-bottom: 20px;
      padding: 15px;
      background: #f8f9fa;
      border-radius: 6px;
      border: 1px solid #ddd;
    }
    .user-info h6 {
      margin-bottom: 10px;
      font-weight: bold;
    }
    .summary {
      margin-bottom: 20px;
      padding: 15px;
      background: #fefefe;
      border: 1px solid #ddd;
      border-radius: 6px;
    }
    .summary h6 {
      font-weight: bold;
      margin-bottom: 10px;
    }
    .product-item {
      margin-bottom: 5px;
    }
    .total {
      font-weight: bold;
      font-size: 16px;
      margin-top: 10px;
    }
    .btn-cancel {
      background-color: #6c757d;
      color: #fff;
    }
    .btn-cancel:hover {
      background-color: #5a6268;
      color: #fff;
    }
    .form-control, .form-select {
      max-width: 300px;
    }
  </style>
</head>
<body class="bg-light">

@extends('layouts.app')

@section('title', 'checkout')

@section('content')
<!-- Konten -->
<div class="wrapper">
  <div class="title-box">
    <h2>Checkout</h2>
  </div>

  <!-- Data User -->
  <div class="user-info">
    <h6>Data Pemesan</h6>
    <p><strong>Nama:</strong> {{ $user->username }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Alamat:</strong> {{ $user->address ?? '-' }}</p>
    <p><strong>No. HP:</strong> {{ $user->contact_no ?? '-' }}</p>
  </div>

  <!-- Ringkasan Belanja -->
  <div class="summary">
    <h6>Ringkasan Belanja</h6>
    @foreach($cartItems as $item)
      <div class="product-item">
        {{ $item->product->product_name }} ({{ $item->quantity }} x Rp. {{ number_format($item->product->price, 0, ',', '.') }})
      </div>
    @endforeach
    <div class="total">
      Total: Rp. {{ number_format($total, 0, ',', '.') }}
    </div>
  </div>

  <!-- Form Checkout -->
  <form id="checkoutForm" action="{{ route('checkout.process') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label class="form-label">Pilih Metode Pembayaran:</label>
      <select name="payment_method" class="form-select" required>
        <option value="">-- Pilih --</option>
        <option value="Prepaid">Prepaid</option>
        <option value="Postpaid">Postpaid</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">ID Paypal (opsional):</label>
      <input type="text" name="paypal_id" class="form-control">
    </div>

    <div class="mb-3">
      <label class="form-label">Nama Bank (opsional):</label>
      <input type="text" name="bank_name" class="form-control">
    </div>

    <div class="d-flex justify-content-end gap-2">
      <a href="{{ url('/cart') }}" class="btn btn-cancel">Cancel</a>
      <button type="submit" class="btn btn-primary">Proses Pesanan</button>
    </div>
  </form>
</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>