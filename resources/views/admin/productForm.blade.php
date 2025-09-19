@extends('layouts.app')

@section('title', isset($product) ? 'Edit Produk' : 'Tambah Produk')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5>{{ isset($product) ? 'Edit Produk' : 'Tambah Produk' }}</h5>
        </div>
        <div class="card-body">
            @if(isset($product))
                <form action="{{ route('admin.products.update', $product->product_id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
            @else
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @endif
                @csrf
                <div class="mb-3">
                    <label for="product_code" class="form-label">Kode Produk</label>
                    <input type="text" name="product_code" id="product_code" class="form-control @error('product_code') is-invalid @enderror" value="{{ old('product_code', isset($product) ? $product->product_code : '') }}" required>
                    @error('product_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="product_name" class="form-label">Nama Produk</label>
                    <input type="text" name="product_name" id="product_name" class="form-control @error('product_name') is-invalid @enderror" value="{{ old('product_name', isset($product) ? $product->product_name : '') }}" required>
                    @error('product_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3" required>{{ old('description', isset($product) ? $product->description : '') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', isset($product) ? $product->price : '') }}" required step="0.01" min="0">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">Stok</label>
                    <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', isset($product) ? $product->stock : '') }}" required min="0">
                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->category_id }}" {{ old('category_id', isset($product) ? $product->category_id : '') == $category->category_id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="image_url" class="form-label">Gambar Produk</label>
                    <input type="file" name="image_url" id="image_url" class="form-control @error('image_url') is-invalid @enderror" {{ isset($product) ? '' : 'required' }}>
                    @error('image_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if(isset($product) && $product->image_url)
                        <img src="{{ asset('storage/' . $product->image_url) }}" alt="Gambar Produk" class="img-thumbnail mt-2" style="max-width: 200px;">
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">{{ isset($product) ? 'Simpan Perubahan' : 'Tambah Produk' }}</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection