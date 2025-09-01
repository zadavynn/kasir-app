<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KasirController;

Route::get('/', [KasirController::class, 'index'])->name('kasir.index');
Route::post('/barang', [KasirController::class, 'tambahBarang'])->name('kasir.barang');
Route::post('/transaksi', [KasirController::class, 'transaksi'])->name('kasir.transaksi');

// Route::get('/', function () {
//     return view('welcome');
// });
