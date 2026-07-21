<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\PenjualanController;

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/', [DashboardController::class, 'index']);

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

//Gudang
Route::get('/gudang', [GudangController::class, 'index'])->name('gudang.index');
Route::post('/gudang', [GudangController::class, 'store'])->name('gudang.store'); // <-- Tambah Baris Ini
Route::put('/gudang/{id}', [GudangController::class, 'update'])->name('gudang.update');

Route::get('/produksi', [ProduksiController::class, 'index'])->name('produksi.index');
Route::post('/produksi', [ProduksiController::class, 'store'])->name('produksi.store');
Route::put('/produksi/complete/{id}', [ProduksiController::class, 'complete'])->name('produksi.complete');


// Route untuk Pengiriman
Route::get('/pengiriman', [PengirimanController::class, 'index'])->name('pengiriman.index');
Route::post('/pengiriman', [PengirimanController::class, 'store'])->name('pengiriman.store');
Route::patch('/pengiriman/{id}/status', [PengirimanController::class, 'updateStatus'])->name('pengiriman.updateStatus');



Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
Route::post('/penjualan', [PenjualanController::class, 'store'])->name('penjualan.store');
Route::patch('/penjualan/{id}/status', [PenjualanController::class, 'updateStatus'])->name('penjualan.updateStatus');