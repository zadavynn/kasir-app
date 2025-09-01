<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KasirController;

// Halaman Tambah Barang (Dashboard)
Route::get('/', [KasirController::class, 'index'])->name('kasir.index');
Route::post('/barang', [KasirController::class, 'tambahBarang'])->name('kasir.barang');

// Halaman Transaksi
Route::get('/transaksi', [KasirController::class, 'showTransaksi'])->name('kasir.transaksi.view');
Route::post('/transaksi', [KasirController::class, 'transaksi'])->name('kasir.transaksi');
