@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Produk Admin CRUD</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Tambah Produk Baru</a>
    </div>

    {{-- Daftar produk --}}
    <div class="card">
        <div class="card-header">Daftar Produk</div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->product_code }}</td>
                        <td>{{ $product->product_name }}</td>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>{{ $product->stock }}</td>
                        <td class="d-flex gap-2">
                            <a href="{{ route('admin.products.edit', $product->product_id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product->product_id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @if($products->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada produk.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
