<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// inventaris
Auth::routes();

// tracking
// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Dashboard routes
Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('index');
    Route::resource('users', App\Http\Controllers\Dashboard\UserController::class);
});
// routes/web.php
Route::middleware('auth')->group(function () {
    Route::resource('kategori', App\Http\Controllers\KategoriController::class);
    Route::resource('lokasi', App\Http\Controllers\LokasiController::class);
    Route::resource('barang', App\Http\Controllers\BarangController::class);
    Route::get('peminjaman/export/excel', [App\Http\Controllers\PeminjamanController::class, 'exportExcel'])->name('peminjaman.export.excel');
    Route::get('peminjaman/export/pdf', [App\Http\Controllers\PeminjamanController::class, 'exportPdf'])->name('peminjaman.export.pdf');
    Route::resource('peminjaman', App\Http\Controllers\PeminjamanController::class);
    Route::post('peminjaman/{peminjaman}/kembalikan', [App\Http\Controllers\PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
});