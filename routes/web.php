<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ManagerArea\ManagerAreaController;
use App\Http\Controllers\IndikatorController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Admin
Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('indikator/create', [AdminController::class, 'createIndikator'])->name('admin.indikator');
        Route::get('indikator/edit/{id}', [AdminController::class, 'editIndikator'])->name('admin.indikator.edit');
    });
//Dashboard Manager Area
Route::prefix('manager-area')
    ->middleware(['auth', 'role:manager'])
    ->group(function () {
        Route::get('/dashboard', [ManagerAreaController::class, 'dashboard'])->name('manager-area.dashboard');
        Route::get('/indikator', [ManagerAreaController::class, 'indikator'])->name('manager-area.indikator');
        // Route::get('/indikator/isi/{id}', [ManagerAreaController::class, 'isiJawaban'])->name('manager-area.indikator.isi');
    });
