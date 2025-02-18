<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//sistem sortir login kasir/admin
Route::get('redirects', [LoginController::class, 'index'])->name('redirects');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/dashboard', [BarangController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
    
Route::get('/rejected', function(){
    return Inertia::render('Rejected');
});

Route::get('/demo', [\App\Http\Controllers\DummyController::class, 'index'])->name('demo');

Route::middleware('auth')->group(function () {
    Route::get('/pos', [\App\Http\Controllers\BarangController::class, 'index'])->name('pos');
    Route::resource('/barangs', BarangController::class);
    Route::resource('/metodepembayaran', BarangController::class);
    Route::resource('/pajak', BarangController::class);
    Route::post('/checkout', [BarangController::class, 'store']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
