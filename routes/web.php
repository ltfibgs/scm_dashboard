<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| 1. ROUTE PUBLIC (Bisa diakses tanpa login)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| 2. ROUTE TERPROTEKSI MIDDLEWARE (Harus Login Dulu)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth.custom'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Manajemen Supplier
    Route::get('/manajemen-supplier', [SupplierController::class, 'index'])->name('supplier.index');
    Route::post('/manajemen-supplier', [SupplierController::class, 'store'])->name('supplier.store');
    Route::put('/manajemen-supplier/{supplierId}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/manajemen-supplier/{supplierId}', [SupplierController::class, 'destroy'])->name('supplier.destroy');

    // Pengadaan
    Route::get('/pengadaan', [PengadaanController::class, 'index'])->name('pengadaan.index');
    Route::post('/pengadaan', [PengadaanController::class, 'store'])->name('pengadaan.store');
    Route::put('/pengadaan/{pengadaanId}', [PengadaanController::class, 'update'])->name('pengadaan.update');
    Route::delete('/pengadaan/{pengadaanId}', [PengadaanController::class, 'destroy'])->name('pengadaan.destroy');

    // Gudang
    Route::get('/gudang', [GudangController::class, 'index'])->name('gudang.index');
    Route::post('/gudang', [GudangController::class, 'store'])->name('gudang.store');
    Route::put('/gudang/{id}', [GudangController::class, 'update'])->name('gudang.update');

    // Produksi
    Route::get('/produksi', [ProduksiController::class, 'index'])->name('produksi.index');
    Route::post('/produksi', [ProduksiController::class, 'store'])->name('produksi.store');
    Route::put('/produksi/complete/{id}', [ProduksiController::class, 'complete'])->name('produksi.complete');

    // Pengiriman
    Route::get('/pengiriman', [PengirimanController::class, 'index'])->name('pengiriman.index');
    Route::post('/pengiriman', [PengirimanController::class, 'store'])->name('pengiriman.store');
    Route::patch('/pengiriman/{id}/status', [PengirimanController::class, 'updateStatus'])->name('pengiriman.updateStatus');

// Penjualan
    Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::post('/penjualan', [PenjualanController::class, 'store'])->name('penjualan.store');
    Route::patch('/penjualan/{id}/status', [PenjualanController::class, 'updateStatus'])->name('penjualan.updateStatus');

    // Manajemen Pengguna
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

});
