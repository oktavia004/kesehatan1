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
      font-size: 16px;
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
    .total {
      text-align: left;
      margin-top: 15px;
      font-weight: bold;
      font-size: 18px;
    }
    .highlight {
      color: #d9534f;
    }
    .btn-cancel {
      background-color: #ff7f32;
      color: #fff;
      border: none;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }
    .btn-cancel:hover {
      background-color: #e86a1d;
      color: #fff;
      transform: scale(1.05);
    }
    .btn-cancel:active {
      background-color: #cc580f;
      transform: scale(0.98);
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
          <tr id="row-{{ $item->cart_id }}">
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->product->product_name }} ({{ $item->product->product_code }})</td>
            <td>
              <div class="d-flex align-items-center justify-content-center">
                <!-- Tombol minus -->
                <button data-id="{{ $item->cart_id }}" data-action="decrease" class="btn btn-sm btn-secondary me-1 update-cart">-</button>

                <!-- Input jumlah -->
                <input type="text" id="qty-{{ $item->cart_id }}" 
                       value="{{ $item->quantity }}" 
                       class="form-control text-center" 
                       style="width: 60px;" readonly>

                <!-- Tombol plus -->
                <button data-id="{{ $item->cart_id }}" data-action="increase" class="btn btn-sm btn-secondary ms-1 update-cart">+</button>
              </div>
            </td>
            <td>
              Rp. <span id="price-{{ $item->cart_id }}">{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
            </td>
            <td>
              <form action="{{ route('cart.remove', $item->cart_id) }}" method="POST" class="delete-form" data-id="{{ $item->cart_id }}">
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
      <span class="highlight" id="cart-total">Rp. {{ number_format($total, 0, ',', '.') }}</span>
    </div>

    <!-- Tombol aksi -->
    <div style="margin-top: 20px; text-align: right;">
      <a href="{{ route('dashboard') }}" class="btn btn-cancel">Cancel</a>
      <a href="{{ url('/checkout') }}" class="btn btn-primary">Checkout</a>
    </div>
  </div>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function(){

  // ✅ Update jumlah dengan AJAX
  $(".update-cart").click(function(e){
    e.preventDefault();
    let id = $(this).data("id");
    let action = $(this).data("action");

    $.ajax({
      url: "/cart/update/" + id,
      type: "PUT",
      data: {
        _token: "{{ csrf_token() }}",
        action: action
      },
      success: function(res){
        if(res.success){
          $("#qty-"+id).val(res.newQty);
          $("#price-"+id).text(res.subtotal);
          $("#cart-total").text("Rp. " + res.total);
        }
        Swal.fire({
          icon: 'success',
          title: 'Berhasil',
          text: res.message,
          timer: 1500,
          showConfirmButton: false
        });
      },
      error: function(xhr){
        let err = xhr.responseJSON;
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: err.message
        });
      }
    });
  });

  // ✅ Hapus produk dengan konfirmasi
  $(".delete-form").submit(function(e){
    e.preventDefault();
    let form = this;
    let id = $(this).data("id");

    Swal.fire({
      title: "Yakin hapus produk?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya, hapus",
      cancelButtonText: "Batal"
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit();
      }
    });
  });

});
</script>
</body>
</html>
