<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\CityController;

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

    // Cidades (Admin)
    Route::get('/admin/cidades', [CityController::class, 'index'])->name('admin.cities.index');
    Route::post('/admin/cidades', [CityController::class, 'store'])->name('admin.cities.store');
    Route::get('/admin/cidades/{city}/editar', [CityController::class, 'edit'])->name('admin.cities.edit');
    Route::put('/admin/cidades/{city}', [CityController::class, 'update'])->name('admin.cities.update');
    Route::delete('/admin/cidades/{city}', [CityController::class, 'destroy'])->name('admin.cities.destroy');

});


