<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ManagerArea\ManagerAreaController;
use App\Http\Controllers\ManagerArea\ManagerIndikatorController;
use App\Http\Controllers\Admin\IndikatorController;
use App\Http\Controllers\ManagerArea\ManagerJawabanController;
use App\Http\Controllers\Admin\TemplateController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // CRUD Indikator
        Route::get('/indikator/create', [IndikatorController::class, 'create'])->name('indikator.create');
        Route::get('/indikator/list', [IndikatorController::class, 'index'])->name('indikator.index');
        Route::post('/indikator/{id}/publish', [IndikatorController::class, 'publish'])->name('indikator.publish');
        Route::post('/indikator/{id}/unpublish', [IndikatorController::class, 'unpublish'])->name('indikator.unpublish');
        Route::post('/indikator', [IndikatorController::class, 'store'])->name('indikator.store');
        Route::get('/indikator/edit/{id}', [IndikatorController::class, 'edit'])->name('indikator.edit');
        Route::put('/indikator/{id}', [IndikatorController::class, 'update'])->name('indikator.update');
        Route::delete('/indikator/{id}', [IndikatorController::class, 'destroy'])->name('indikator.destroy');
        

        // 🔁 ROUTE BARU: Template Indikator dipisah ke controller sendiri
        Route::get('/indikator/template', [TemplateController::class, 'template'])->name('indikator.template');
        Route::post('/indikator/template/publish', [TemplateController::class, 'bulkPublish'])->name('indikator.template.publish');
        Route::post('/indikator/template/copy', [TemplateController::class, 'copyTemplate'])->name('indikator.template.copy');
    });

Route::middleware(['auth'])
    ->prefix('manager-area')
    ->group(function () {
        Route::get('/dashboard', [ManagerAreaController::class, 'dashboard'])->name('manager-area.dashboard');
        Route::get('/indikator/{area}/{kategori}', [ManagerIndikatorController::class, 'index'])->name('manager-area.indikator.index');
        Route::get('/jawaban/{area}/{kategori}', [ManagerJawabanController::class, 'preview'])->name('manager-area.jawaban.preview');
        Route::post('/jawaban/simpan', [ManagerJawabanController::class, 'store'])->name('manager-area.jawaban.store');
    });
