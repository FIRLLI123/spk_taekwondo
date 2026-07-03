<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModuleController;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/athletes', [ModuleController::class, 'athletes'])->name('athletes.index');
    Route::get('/criteria', [ModuleController::class, 'criteria'])->name('criteria.index');
    Route::get('/periods', [ModuleController::class, 'periods'])->name('periods.index');
    Route::get('/scores', [ModuleController::class, 'scores'])->name('scores.index');
    Route::get('/rankings', [ModuleController::class, 'rankings'])->name('rankings.index');

    Route::middleware('role:admin')->group(function () {
        Route::get('/users', [ModuleController::class, 'users'])->name('users.index');
        Route::get('/topsis/process', [ModuleController::class, 'topsis'])->name('topsis.process');
        Route::get('/reports', [ModuleController::class, 'reports'])->name('reports.index');
    });
});
