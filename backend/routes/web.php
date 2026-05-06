<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AdminAuthController;
use App\Http\Controllers\Web\AdminDashboardController;
use App\Http\Controllers\Web\AdminJurusanController;
use App\Http\Controllers\Web\KeuanganAuthController;
use App\Http\Controllers\Web\KeuanganDashboardController;
use App\Http\Controllers\Web\StudentDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('siswa.login');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest routes
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    
    // Protected routes
    Route::middleware('admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/calon-siswa', [AdminDashboardController::class, 'calonSiswaIndex'])->name('calon-siswa.index');
        
        // Jurusan CRUD
        Route::get('/jurusan', [AdminJurusanController::class, 'index'])->name('jurusan.index');
        Route::post('/jurusan', [AdminJurusanController::class, 'store'])->name('jurusan.store');
        Route::put('/jurusan/{id}', [AdminJurusanController::class, 'update'])->name('jurusan.update');
        Route::delete('/jurusan/{id}', [AdminJurusanController::class, 'destroy'])->name('jurusan.destroy');
    });
});

// Keuangan Routes
Route::prefix('keuangan')->name('keuangan.')->group(function () {
    // Guest routes
    Route::get('/login', [KeuanganAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [KeuanganAuthController::class, 'login']);
    
    // Protected routes
    Route::middleware('keuangan')->group(function () {
        Route::post('/logout', [KeuanganAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [KeuanganDashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/verifikasi', [KeuanganDashboardController::class, 'verifikasiIndex'])->name('verifikasi');
        Route::post('/verifikasi/{id}', [KeuanganDashboardController::class, 'verifikasiUpdate'])->name('verifikasi.update');
    });
});

// Student/Siswa Routes
Route::prefix('siswa')->name('siswa.')->group(function () {
    // Guest routes
    Route::get('/register', [StudentDashboardController::class, 'showRegister'])->name('register.form');
    Route::post('/register', [StudentDashboardController::class, 'register'])->name('register');
    Route::get('/login', [StudentDashboardController::class, 'showLogin'])->name('login');
    Route::post('/login', [StudentDashboardController::class, 'login']);
    
    // Protected routes
    Route::middleware('student')->group(function () {
        Route::post('/logout', [StudentDashboardController::class, 'logout'])->name('logout');
        Route::get('/dashboard', function() {
            $siswa = \App\Models\CalonSiswa::find(request()->session()->get('user.id'));
            return \Inertia\Inertia::render('Student/Dashboard', ['siswa' => $siswa]);
        })->name('dashboard');
        Route::get('/dokumen', function() {
            return \Inertia\Inertia::render('Student/Dashboard', ['siswa' => []]);
        })->name('dokumen');
        Route::get('/pembayaran', function() {
            return \Inertia\Inertia::render('Student/Dashboard', ['siswa' => []]);
        })->name('pembayaran');
        Route::get('/formulir', function() {
            return \Inertia\Inertia::render('Student/Dashboard', ['siswa' => []]);
        })->name('formulir');
    });
});
