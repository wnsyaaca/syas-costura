<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\BookingController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/katalog', [CatalogController::class, 'index'])->name('katalog');
Route::get('/katalog/{service}', [CatalogController::class, 'show'])
    ->name('katalog.show');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'role:admin'])->get('/admin', function () {
    return 'Halo Admin, middleware role berhasil.';
});
Route::middleware('auth')->group(function () {
    Route::get('/booking/{service}', [BookingController::class, 'create'])
        ->name('booking.create');

    Route::post('/booking/{service}', [BookingController::class, 'store'])
        ->name('booking.store');
});
require __DIR__ . '/auth.php';
