<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\ProductsController;

/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA (Visitor bisa lihat produk)
|--------------------------------------------------------------------------
*/
Route::get('/', [ProductController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'show'])->name('login.show');
Route::post('/login', [LoginController::class, 'process'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'show'])->name('register.show');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
    Route::get('/dashboard', [ProductsController::class, 'dashboard'])->name('dashboard');
    Route::resource('products', ProductsController::class);
});



Route::get('/dashboard', [ProductController::class, 'index'])->name('dashboard');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('orders.success');


// Tampilkan invoice
Route::get('/invoice/{order}', [OrderController::class, 'showInvoice'])->name('invoice.show');

// Download PDF
Route::get('/invoice/{order}/pdf', [OrderController::class, 'downloadPdf'])->name('invoice.pdf');