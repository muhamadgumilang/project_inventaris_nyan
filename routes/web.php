<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// inventaris
Auth::routes(['register' => false]);

// tracking
// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Dashboard routes
Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('index');
    Route::resource('users', App\Http\Controllers\Dashboard\UserController::class);
});


//routes/web nya
Route::resource('kategori', App\Http\Controllers\KategoriController::class);
Route::resource('barang', App\Http\Controllers\BarangController::class);
Route::resource('peminjaman', App\Http\Controllers\PeminjamanController::class);