@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Produk Admin CRUD</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form tambah produk --}}
    <div class="card mb-4">
        <div class="card-header">Tambah Produk Baru</div>
        <div class="card-body">
            <form action="{{ route('admin.products.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="product_code" class="form-label">Kode Produk</label>
                    <input type="text" name="product_code" id="product_code" class="form-control @error('product_code') is-invalid @enderror" value="{{ old('product_code') }}" required>
                    @error('product_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="product_name" class="form-label">Nama Produk</label>
                    <input type="text" name="product_name" id="product_name" class="form-control @error('product_name') is-invalid @enderror" value="{{ old('product_name') }}" required>
                    @error('product_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required step="0.01" min="0">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">Stok</label>
                    <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock') }}" required min="0">
                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Tambah Produk</button>
            </form>
        </div>
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
                        <form action="{{ route('admin.products.update', ['product' => $product->product_id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <td>
                                <input type="text" name="product_code" value="{{ old('product_code', $product->product_code) }}" class="form-control" required>
                            </td>
                            <td>
                                <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}" class="form-control" required>
                            </td>
                            <td>
                                <input type="number" name="price" value="{{ old('price', $product->price) }}" class="form-control" step="0.01" min="0" required>
                            </td>
                            <td>
                                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="form-control" min="0" required>
                            </td>
                            <td class="d-flex gap-2">
                                <button type="submit" class="btn btn-success btn-sm">Update</button>
                        </form>
                        <form action="{{ route('admin.products.destroy', ['product' => $product->product_id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
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
