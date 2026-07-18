<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PengadaanController;

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

