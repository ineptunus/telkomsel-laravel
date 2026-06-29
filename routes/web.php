<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\StatistikController;
use App\Http\Controllers\SarcasmController;
use App\Http\Controllers\HateSpeechController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PredictionController;


Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::post('/api/predict-tweet', [PredictionController::class, 'predict']);


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/statistik-kepuasan', [StatistikController::class, 'index'])->name('statistik');
    Route::get('/tren-sarcasm', [SarcasmController::class, 'index'])->name('tren.sarcasm');
    Route::get('/tren-hate-speech', [HateSpeechController::class, 'index'])->name('tren.hate');
    Route::get('/export-laporan', [ExportController::class, 'index'])->name('export');
    Route::get('/export-laporan/download/{template}', [ExportController::class, 'downloadReport'])->name('export.download.report');
});

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});