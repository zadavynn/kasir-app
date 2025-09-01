<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KasirController;

// Dashboard / Tambah Barang
Route::get('/', [KasirController::class, 'index'])->name('kasir.index');
Route::get('/barang', [KasirController::class, 'formBarang'])->name('kasir.barang.form'); // optional
Route::post('/barang', [KasirController::class, 'tambahBarang'])->name('kasir.barang.store');

// Transaksi
Route::get('/transaksi', [KasirController::class, 'showTransaksi'])->name('transaksi');
Route::post('/transaksi', [KasirController::class, 'transaksi'])->name('kasir.transaksi.store');
