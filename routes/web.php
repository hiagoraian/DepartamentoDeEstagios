<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', fn () => redirect()->route('login'));

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/professor', function () {
        return view('professor.dashboard');
    })->name('professor.home');

    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.home');
});

