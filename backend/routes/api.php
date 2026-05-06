<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JurusanController;
use App\Http\Controllers\Api\PembayaranController;
use App\Http\Controllers\Api\DokumenController;
use App\Http\Controllers\Api\FormulirLengkapController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KeuanganAuthController;
use App\Http\Controllers\KeuanganController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/test', function() {
    return response()->json(['message' => 'API Working!']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/verify', [AuthController::class, 'verify']);
Route::post('/verify-token', [AuthController::class, 'verify']); // Alias for compatibility
Route::post('/resend-verification', [AuthController::class, 'resendVerification']);
Route::post('/resend-token', [AuthController::class, 'resendVerification']); // Alias for compatibility
Route::get('/jurusan', [JurusanController::class, 'index']);
Route::get('/jurusan/{id}', [JurusanController::class, 'show']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'getMe']);
    
    // Pembayaran
    Route::get('/pembayaran', [PembayaranController::class, 'index']);
    Route::post('/pembayaran', [PembayaranController::class, 'store']);
    Route::get('/pembayaran/{id}', [PembayaranController::class, 'show']);
    Route::get('/pembayaran/check/status', [PembayaranController::class, 'checkStatus']);
    
    // Formulir Lengkap
    Route::get('/formulir-lengkap', [FormulirLengkapController::class, 'show']);
    Route::post('/formulir-lengkap', [FormulirLengkapController::class, 'store']);

    // Dokumen
    Route::post('/dokumen/upload-kk', [DokumenController::class, 'uploadKK']);

    // Midtrans Payment
    Route::post('/pembayaran/create-transaction', [PembayaranController::class, 'createTransaction']);
});

// Midtrans Notification Handler
Route::post('/pembayaran/notification', [PembayaranController::class, 'notificationHandler']);


// Admin routes
Route::prefix('admin')->group(function () {
    // Admin auth (public)
    Route::post('/login', [AdminAuthController::class, 'login']);
    
    // Admin protected routes - SIMPLE: sanctum akan cek token dari model yang punya token
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout']);
        Route::get('/me', [AdminAuthController::class, 'getAdmin']);
        Route::get('/dashboard/stats', [AdminController::class, 'getDashboardStats']);
        Route::get('/calon-siswa', [AdminController::class, 'getCalonSiswa']);
        Route::get('/calon-siswa/{id}', [AdminController::class, 'getDetailCalonSiswa']);
        Route::delete('/calon-siswa/{id}', [AdminController::class, 'deleteCalonSiswa']);
        Route::post('/jurusan', [JurusanController::class, 'store']);
        Route::put('/jurusan/{id}', [JurusanController::class, 'update']);
        Route::delete('/jurusan/{id}', [JurusanController::class, 'destroy']);
    });
});

// Keuangan routes  
Route::prefix('keuangan')->group(function () {
    Route::post('/login', [KeuanganAuthController::class, 'login']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [KeuanganAuthController::class, 'logout']);
        Route::get('/me', [KeuanganAuthController::class, 'getKeuangan']);
        Route::get('/dashboard/stats', [KeuanganController::class, 'getDashboardStats']);
        Route::get('/calon-siswa', [KeuanganController::class, 'getCalonSiswa']);
        Route::get('/calon-siswa/{id}', [KeuanganController::class, 'getDetailCalonSiswa']);
        Route::post('/pembayaran/{id}/verifikasi', [KeuanganController::class, 'verifikasiPembayaran']);
        Route::post('/pembayaran/{id}/tolak', [KeuanganController::class, 'tolakPembayaran']);
    });
});
