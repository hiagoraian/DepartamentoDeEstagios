<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', fn () => redirect()->route('login'));

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/professor', function () {
        return '<h1>Professor</h1>';
    })->name('professor.home');

    Route::get('/admin', function () {
        return '<h1>Admin</h1>';
    })->name('admin.home');
});
