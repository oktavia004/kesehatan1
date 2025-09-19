<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Toko Alat Kesehatan')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* ✅ Full height untuk dorong footer */
    html, body {
      height: 100%;
      margin: 0;
    }
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    main {
      flex: 1;
    }

    /* ✅ Header */
    header {
      background-color: #0d6efd;
      color: white;
      padding: 12px 20px;
    }
    header h4 {
      font-size: 16px;
      margin: 0;
    }

    /* ✅ Kontainer isi */
    .container {
      margin-top: 15px !important;
      max-width: 1100px;
    }

    /* ✅ Style tambahan */
    .category-item { cursor: pointer; }
    .category-item.active { background-color: #0d6efd; color: white; }
    .cart-icon {
      cursor: pointer;
      position: relative;
      font-size: 1.8rem;
      text-decoration: none;
      color: black;
    }
    .cart-count {
      position: absolute;
      top: -8px;
      right: -8px;
      background: red;
      color: white;
      border-radius: 50%;
      font-size: 0.7rem;
      padding: 2px 6px;
    }
    .product-card img {
      max-height: 150px;
      object-fit: contain;
    }
    .card-footer .btn-group {
      display: flex;
      width: 100%;
      gap: 0;
    }
    .card-footer .btn-group .btn {
      flex: 1;
      border-radius: 0;
    }
    .card-footer .btn-group .btn:first-child {
      border-top-left-radius: .375rem;
      border-bottom-left-radius: .375rem;
    }
    .card-footer .btn-group .btn:last-child {
      border-top-right-radius: .375rem;
      border-bottom-right-radius: .375rem;
    }
    .product-card {
      transition: all 0.3s ease;
    }

    /* ✅ Footer */
    footer {
      font-size: 13px;
    }
  </style>
</head>
<body class="bg-light">

<header class="d-flex justify-content-between align-items-center">
  <h4 class="mb-0">Selamat datang di Toko Alat Kesehatan</h4>
  <!-- ✅ Navbar Login/Register atau Logout -->
  <nav class="navbar navbar-light bg-transparent justify-content-end px-3 m-0 p-0">
    <div class="d-flex">
      @if(Session::has('role'))
        <form action="{{ route('logout') }}" method="POST" class="mb-0">
          @csrf
          <button type="submit" class="btn btn-danger btn-sm">
            Logout ({{ Session::get('username') }})
          </button>
        </form>
      @else
        <a href="{{ route('login.show') }}" class="btn btn-primary btn-sm me-2">Login</a>
        <a href="{{ route('register.show') }}" class="btn btn-success btn-sm">Register</a>
      @endif
    </div>
  </nav>
</header>

<main class="container">
  @yield('content')
</main>

<footer class="bg-light text-center py-3 border-top mt-auto">
  &copy; {{ date('Y') }} Toko Alat Kesehatan. All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
