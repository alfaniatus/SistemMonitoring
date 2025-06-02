<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndikatorController;

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

//admin dashboard
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        $userArea = auth()->user()->area;
        return redirect()->route('dashboard.area', $userArea);
    }

    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    // Dashboard Admin
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/indikator', [IndikatorController::class, 'index'])->name('indikator.index');

    // ✅ Dashboard Manager Area
Route::get('/manager-area/dashboard/area/{area}', [DashboardController::class, 'index'])
    ->where('area', '[1-6]')
    ->name('dashboard.area');
});

Route::middleware('auth')->group(function () {
    Route::get('/validasi', [ValidasiController::class, 'index'])->name('validasi.index');
});

// Area 1
Route::prefix('area1')->name('area1.')->middleware('auth')->group(function () {
    Route::get('/pemenuhan', [Area1Controller::class, 'pemenuhan'])->name('pemenuhan');
    Route::get('/reform', [Area1Controller::class, 'reform'])->name('reform');
    Route::get('/manajemen', [Area1Controller::class, 'manajemen'])->name('manajemen');
    Route::get('/lainnya', [Area1Controller::class, 'lainnya'])->name('lainnya');
});

// Area 2
Route::prefix('area2')->name('area2.')->middleware('auth')->group(function () {
    Route::get('/pemenuhan', [Area2Controller::class, 'pemenuhan'])->name('pemenuhan');
    Route::get('/reform', [Area2Controller::class, 'reform'])->name('reform');
    Route::get('/manajemen', [Area2Controller::class, 'manajemen'])->name('manajemen');
    Route::get('/lainnya', [Area2Controller::class, 'lainnya'])->name('lainnya');
});

// Area 3
Route::prefix('area3')->name('area3.')->middleware('auth')->group(function () {
    Route::get('/pemenuhan', [Area3Controller::class, 'pemenuhan'])->name('pemenuhan');
    Route::get('/reform', [Area3Controller::class, 'reform'])->name('reform');
    Route::get('/manajemen', [Area3Controller::class, 'manajemen'])->name('manajemen');
    Route::get('/lainnya', [Area3Controller::class, 'lainnya'])->name('lainnya');
});

// Area 4
Route::prefix('area4')->name('area4.')->middleware('auth')->group(function () {
    Route::get('/pemenuhan', [Area4Controller::class, 'pemenuhan'])->name('pemenuhan');
    Route::get('/reform', [Area4Controller::class, 'reform'])->name('reform');
    Route::get('/manajemen', [Area4Controller::class, 'manajemen'])->name('manajemen');
    Route::get('/lainnya', [Area4Controller::class, 'lainnya'])->name('lainnya');
});

// Area 5
Route::prefix('area5')->name('area5.')->middleware('auth')->group(function () {
    Route::get('/pemenuhan', [Area5Controller::class, 'pemenuhan'])->name('pemenuhan');
    Route::get('/reform', [Area5Controller::class, 'reform'])->name('reform');
    Route::get('/manajemen', [Area5Controller::class, 'manajemen'])->name('manajemen');
    Route::get('/lainnya', [Area5Controller::class, 'lainnya'])->name('lainnya');
});

// Area 6
Route::prefix('area6')->name('area6.')->middleware('auth')->group(function () {
    Route::get('/pemenuhan', [Area6Controller::class, 'pemenuhan'])->name('pemenuhan');
    Route::get('/reform', [Area6Controller::class, 'reform'])->name('reform');
    Route::get('/manajemen', [Area6Controller::class, 'manajemen'])->name('manajemen');
    Route::get('/lainnya', [Area6Controller::class, 'lainnya'])->name('lainnya');
});
