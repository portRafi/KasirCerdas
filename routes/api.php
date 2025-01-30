<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/userinfo', function () {
    $user = Auth::user();
    return response()->json([
        'user' => $user,
        'bisnis' => $user->bisnis ?? 'Bisnis tidak ditemukan',
        'cabang' => $user->cabang ?? 'Cabang tidak ditemukan'
    ]);
});
