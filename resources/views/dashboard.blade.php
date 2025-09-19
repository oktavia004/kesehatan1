<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container my-5">
  <div class="card shadow">
    <div class="card-body">
      <h3 class="mb-4 text-center">Product Page</h3>

      <div class="row">
        <!-- Produk -->
        <div class="col-md-9">
          <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($products as $product)
              <div class="col product-card" data-category="{{ $product->category->category_name }}">
                <div class="card h-100 text-center shadow-sm">
                  <!-- Foto produk -->
                  <img src="{{ asset($product->image_url ?? 'img/no-image.png') }}" class="card-img-top">
                  <div class="card-body">
                    <h5 class="card-title">{{ $product->product_name }}</h5>
                    <p class="text-muted mb-0">{{ $product->category->category_name }}</p>
                  </div>
                  <div class="card-footer">
                    <div class="btn-group">
                      <!-- Tombol View -->
                      <button class="btn btn-outline-primary btn-sm view-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#productModal"
                        data-name="{{ $product->product_name }}"
                        data-code="{{ $product->product_code }}"
                        data-desc="{{ $product->description ?? 'Tidak ada deskripsi.' }}"
                        data-price="{{ $product->price }}"
                        data-stock="{{ $product->stock ?? 0 }}"
                        data-image="{{ asset($product->image_url ?? 'img/no-image.png') }}">
                        View
                      </button>

                      {{-- ✅ Kondisi tombol Buy/Login --}}
                      @if(Session::has('role') && Session::get('role') === 'customer')
                        <!-- Customer bisa langsung beli -->
                        <form action="{{ route('cart.add', $product->product_id) }}" method="POST" class="d-inline add-to-cart-form" style="flex:1">
                          @csrf
                          <button type="submit" class="btn btn-success btn-sm w-100">Buy</button>
                        </form>
                      @else
                        <!-- Visitor diarahkan ke login -->
                        <a href="{{ route('login.show') }}" class="btn btn-secondary btn-sm w-100">Login to Buy</a>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <!-- Kategori & Keranjang -->
        <div class="col-md-3">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Category</h5>
            <a href="{{ route('cart.index') }}" class="cart-icon">
              <i class="bi bi-cart"></i>
              <span class="cart-count" id="cart-count">{{ $cartCount ?? 0 }}</span>
            </a>
          </div>
          <ul class="list-group shadow-sm mb-4">
            <li class="list-group-item category-item active" data-category="all">All</li>
            @foreach($categories as $category)
              <li class="list-group-item category-item" data-category="{{ $category->category_name }}">
                {{ $category->category_name }}
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Detail Produk -->
<div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow">
      <div class="modal-header">
        <h5 class="modal-title" id="modalProductName"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <img id="modalProductImage" class="img-fluid mb-3" style="max-height:200px;">
        <p class="text-muted mb-1" id="modalProductCode"></p>
        <p id="modalProductDesc" class="text-muted"></p>
        <p class="text-muted mb-1" id="modalProductStock"></p>
        <h5 class="text-success" id="modalProductPrice"></h5>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', () => {
  // ✅ Modal detail produk
  const viewButtons = document.querySelectorAll('.view-btn');
  const modalProductName = document.getElementById('modalProductName');
  const modalProductImage = document.getElementById('modalProductImage');
  const modalProductCode = document.getElementById('modalProductCode');
  const modalProductDesc = document.getElementById('modalProductDesc');
  const modalProductPrice = document.getElementById('modalProductPrice');
  const modalProductStock = document.getElementById('modalProductStock');

  viewButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      modalProductName.textContent = btn.dataset.name;
      modalProductImage.src = btn.dataset.image;
      modalProductCode.textContent = "Kode: " + btn.dataset.code;
      modalProductDesc.textContent = btn.dataset.desc;
      modalProductStock.textContent = "Stock: " + btn.dataset.stock;
      modalProductPrice.textContent =
        "Rp " + Number(btn.dataset.price).toLocaleString('id-ID');
    });
  });

  // ✅ Ajax update cart count
  const cartCount = document.getElementById('cart-count');
  document.querySelectorAll('.add-to-cart-form').forEach(form => {
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      fetch(this.action, {
        method: "POST",
        body: new FormData(this),
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          cartCount.textContent = data.cartCount;
          cartCount.style.display = 'inline-block';
        }
      })
      .catch(err => console.error(err));
    });
  });

  // ✅ Filter produk berdasarkan kategori
  const categoryItems = document.querySelectorAll('.category-item');
  const productCards = document.querySelectorAll('.product-card');

  categoryItems.forEach(item => {
    item.addEventListener('click', () => {
      categoryItems.forEach(cat => cat.classList.remove('active'));
      item.classList.add('active');

      const category = item.dataset.category;

      productCards.forEach(card => {
        if (category === "all" || card.dataset.category === category) {
          card.style.display = "block";
        } else {
          card.style.display = "none";
        }
      });
    });
  });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
