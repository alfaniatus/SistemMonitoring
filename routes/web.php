<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ManagerArea\ManagerAreaController;
use App\Http\Controllers\Admin\IndikatorController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // CRUD Indikator
    Route::get('/indikator/list', [IndikatorController::class, 'index'])->name('indikator.index');
    Route::get('/indikator/create', [IndikatorController::class, 'create'])->name('indikator.create');
    Route::post('/indikator', [IndikatorController::class, 'store'])->name('indikator.store');
    Route::get('/indikator/edit/{id}', [IndikatorController::class, 'edit'])->name('indikator.edit');
    Route::put('/indikator/{id}', [IndikatorController::class, 'update'])->name('indikator.update');
    Route::delete('/indikator/{id}', [IndikatorController::class, 'destroy'])->name('indikator.destroy');
});
//Dashboard Manager Area
Route::prefix('manager-area')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/dashboard', [ManagerAreaController::class, 'dashboard'])->name('manager-area.dashboard');
        Route::get('/indikator', [ManagerAreaController::class, 'indikator'])->name('manager-area.indikator');
        // Route::get('/indikator/isi/{id}', [ManagerAreaController::class, 'isiJawaban'])->name('manager-area.indikator.isi');
    });
