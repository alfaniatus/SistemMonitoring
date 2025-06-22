<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ManagerArea\ManagerAreaController;
use App\Http\Controllers\ManagerArea\ManagerIndikatorController;
use App\Http\Controllers\Admin\IndikatorController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/indikator', [IndikatorController::class, 'index'])->name('indikator.index');

        // CRUD Indikator
        Route::get('/indikator/list', [IndikatorController::class, 'index'])->name('indikator.index');
        Route::get('/indikator/create', [IndikatorController::class, 'create'])->name('indikator.create');
        Route::post('/indikator', [IndikatorController::class, 'store'])->name('indikator.store');
        Route::get('/indikator/edit/{id}', [IndikatorController::class, 'edit'])->name('indikator.edit');
        Route::put('/indikator/{id}', [IndikatorController::class, 'update'])->name('indikator.update');
        Route::delete('/indikator/{id}', [IndikatorController::class, 'destroy'])->name('indikator.destroy');
        //Publish Indikator
        Route::get('/indikator/template', [IndikatorController::class, 'template'])->name('indikator.template');
        Route::patch('/indikator/{id}/toggle-publish', [IndikatorController::class, 'togglePublish'])->name('indikator.toggle-publish');
    });

Route::middleware(['auth'])
    ->prefix('manager-area')
    ->group(function () {
        Route::get('/dashboard', [ManagerAreaController::class, 'dashboard'])->name('manager-area.dashboard');

        // GANTI YANG INI
        Route::get('/indikator/{area}/{kategori}', [ManagerIndikatorController::class, 'index'])->name('manager-area.indikator.index');
        Route::post('/jawaban/store', [ManagerIndikatorController::class, 'store'])->name('manager-area.jawaban.store');
    });
