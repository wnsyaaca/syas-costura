<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingCalendarController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartCheckoutController;
use Illuminate\Support\Facades\Route;


// ========================================
// BERANDA
// ========================================
Route::get('/', [HomeController::class, 'index'])
    ->name('home');


// ========================================
// KATALOG
// ========================================
Route::get('/katalog', [CatalogController::class, 'index'])
    ->name('katalog');

Route::get('/katalog/{service}', [CatalogController::class, 'show'])
    ->name('katalog.show');


// ========================================
// KERANJANG BELANJA
// ========================================
Route::get('/keranjang', [CartController::class, 'index'])
    ->name('cart.index');

Route::post('/keranjang/{service}', [CartController::class, 'store'])
    ->name('cart.store');

Route::patch('/keranjang/{key}', [CartController::class, 'update'])
    ->name('cart.update');

Route::delete('/keranjang/{key}', [CartController::class, 'destroy'])
    ->name('cart.destroy');


// ========================================
// BOOKING FITTING
// ========================================
Route::get('/booking', [BookingCalendarController::class, 'index'])
    ->name('booking.index');


// ========================================
// DASHBOARD
// ========================================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// ========================================
// FITUR YANG MEMERLUKAN LOGIN
// ========================================
Route::middleware('auth')->group(function () {

    // BOOKING FITTING
    Route::post('/booking', [BookingCalendarController::class, 'store'])
        ->name('booking.calendar.store');


    // ========================================
    // PEMESANAN SATU PRODUK LAMA
    // ========================================
    Route::get('/checkout/pesan/{service}', [BookingController::class, 'create'])
        ->name('checkout.create');

    Route::post('/checkout/pesan/{service}', [BookingController::class, 'store'])
        ->name('checkout.store');


    // ========================================
    // CHECKOUT KERANJANG ONLINE
    // ========================================
    Route::get('/checkout/keranjang', [CartCheckoutController::class, 'create'])
        ->name('cart.checkout');

    Route::post('/checkout/keranjang', [CartCheckoutController::class, 'store'])
        ->name('cart.checkout.store');


    // ========================================
    // RIWAYAT CHECKOUT
    // ========================================
    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');

    Route::get('/checkout/{code}', [CheckoutController::class, 'show'])
        ->name('checkout.show');


    // ========================================
    // TRACKING PESANAN
    // ========================================
    Route::get('/tracking', [TrackingController::class, 'index'])
        ->name('tracking.index');

    Route::get('/tracking/{code}', [TrackingController::class, 'show'])
        ->name('tracking.show');


    // ========================================
    // PROFILE
    // ========================================
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});


// ========================================
// ADMIN
// ========================================
Route::middleware(['auth', 'role:admin'])->get('/admin', function () {
    return 'Halo Admin, middleware role berhasil.';
});


// ========================================
// AUTHENTICATION
// ========================================
require __DIR__ . '/auth.php';
