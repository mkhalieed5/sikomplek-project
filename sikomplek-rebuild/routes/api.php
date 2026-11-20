<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KartuKeluargaController;
use App\Http\Controllers\Api\WargaController;
use App\Http\Controllers\Api\KategoriIuranController;
use App\Http\Controllers\Api\PembayaranIuranController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// Route Publik
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/register-rt', [AuthController::class, 'registerTenant'])->middleware('throttle:5,1');

// Route Terproteksi (Wajib kirim Token Sanctum)
Route::name('api.')->middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('kartu-keluarga', KartuKeluargaController::class);
    Route::apiResource('warga', WargaController::class);
    Route::apiResource('kategori-iuran', KategoriIuranController::class);
    Route::apiResource('pembayaran-iuran', PembayaranIuranController::class);
});