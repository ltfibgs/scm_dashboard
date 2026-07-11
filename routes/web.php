<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

// Mengarahkan halaman utama/dashboard ke Controller
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/', [DashboardController::class, 'index']);