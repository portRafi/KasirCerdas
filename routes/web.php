<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return redirect('/login');
});

// Route::middleware(['auth', 'role:kasir'])->group(function () {
//     Route::get('/kasir', function () {
//         return view('kasir.index'); // Halaman khusus untuk kasir
//     })->name('kasir');
// });

// // routes/api.php
// Route::middleware(['auth:sanctum', 'role.kasir'])->group(function () {
//     Route::get('/products', [ProductController::class, 'index']); // Tampilkan produk
//     Route::post('/transactions', [TransactionController::class, 'store']); // Simpan transaksi
// });
