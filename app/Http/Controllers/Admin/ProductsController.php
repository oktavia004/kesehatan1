<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Storage;


class ProductsController extends Controller
{
    public function dashboard()
    {
        $products = Product::with('category')->get();
        return view('admin.dashboardAdmin', compact('products'));
    }

    public function index()
    {
        $products = Product::with('category')->get();
        return view('admin.productsAdmin', compact('products'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('admin.productForm', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
        'product_code' => 'required|string|max:50|unique:products,product_code',
        'product_name' => 'required|string|max:100',
        'description'  => 'nullable|string',
        'price'        => 'required|numeric|min:0',
        'stock'        => 'required|integer|min:0',
        'category_id'  => 'nullable|exists:product_categories,category_id',
        'image_url'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    $imagePath = null;
    if ($request->hasFile('image_url')) {
        $imagePath = $request->file('image_url')->store('products', 'public');
    }

    Product::create([
        'product_code' => $request->product_code,
        'product_name' => $request->product_name,
        'description'  => $request->description,
        'price'        => $request->price,
        'stock'        => $request->stock,
        'category_id'  => $request->category_id,
        'image_url'    => $imagePath,
    ]);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $product    = Product::findOrFail($id);
        $categories = ProductCategory::all();
        return view('admin.productForm', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
        'product_code' => 'required|string|max:50|unique:products,product_code,' . $product->product_id . ',product_id',
        'product_name' => 'required|string|max:100',
        'description'  => 'nullable|string',
        'price'        => 'required|numeric|min:0',
        'stock'        => 'required|integer|min:0',
        'category_id'  => 'nullable|exists:product_categories,category_id',
        'image_url'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    $imagePath = $product->image_url;
    if ($request->hasFile('image_url')) {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
        $imagePath = $request->file('image_url')->store('products', 'public');
    }

    $product->update([
        'product_code' => $request->product_code,
        'product_name' => $request->product_name,
        'description'  => $request->description,
        'price'        => $request->price,
        'stock'        => $request->stock,
        'category_id'  => $request->category_id,
        'image_url'    => $imagePath,
    ]);


        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk berhasil dihapus!');
    }
}
