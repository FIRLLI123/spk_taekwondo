<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AthleteController;
use App\Http\Controllers\CriterionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\TopsisController;
use App\Http\Controllers\UserController;

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

    Route::get('/scores', [ScoreController::class, 'index'])->name('scores.index');
    Route::post('/scores', [ScoreController::class, 'store'])->name('scores.store');
    Route::get('/rankings', [RankingController::class, 'index'])->name('rankings.index');
    Route::get('/athletes', [AthleteController::class, 'index'])->name('athletes.index');

    Route::middleware('role:admin')->group(function () {
        Route::resource('athletes', AthleteController::class)->except(['index', 'show']);
        Route::resource('criteria', CriterionController::class)->except('show');
        Route::resource('periods', PeriodController::class)->except('show');
        Route::resource('users', UserController::class)->except('show');
        Route::get('/topsis/process', [TopsisController::class, 'index'])->name('topsis.process');
        Route::post('/topsis/process', [TopsisController::class, 'store'])->name('topsis.run');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/print', [ReportController::class, 'print'])->name('reports.print');
        Route::get('/reports/export/xlsx', [ReportController::class, 'exportXlsx'])->name('reports.export.xlsx');
        Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
    });
});
