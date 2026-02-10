<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Professor\ReportController;
use App\Http\Controllers\Admin\ReportStatusController;
use App\Http\Controllers\Professor\PasswordController;
use App\Http\Controllers\Admin\TeacherController;


Route::get('/', fn() => redirect()->route('login'));

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

    // Relatórios (Professor)
    Route::get('/professor/relatorio/{semester}', [ReportController::class, 'show'])->name('professor.report.show');
    Route::post('/professor/relatorio/{semester}/salvar', [ReportController::class, 'save'])->name('professor.report.save');
    Route::post('/professor/relatorio/{semester}/enviar', [ReportController::class, 'submit'])->name('professor.report.submit');

    // Situação de relatórios (Admin)
    Route::get('/admin/relatorios', [ReportStatusController::class, 'index'])->name('admin.reports.index');
    Route::post('/admin/relatorios/{report}/liberar-edicao', [ReportStatusController::class, 'unlock'])->name('admin.reports.unlock');

    // Alterar senha (Professor)
    Route::get('/professor/senha', [PasswordController::class, 'edit'])->name('professor.password.edit');
    Route::post('/professor/senha', [PasswordController::class, 'update'])->name('professor.password.update');

    // Professores (Admin)
    Route::get('/admin/professores', [TeacherController::class, 'index'])->name('admin.teachers.index');
    Route::get('/admin/professores/novo', [TeacherController::class, 'create'])->name('admin.teachers.create');
    Route::post('/admin/professores', [TeacherController::class, 'store'])->name('admin.teachers.store');
    Route::get('/admin/professores/{user}/editar', [TeacherController::class, 'edit'])->name('admin.teachers.edit');
    Route::put('/admin/professores/{user}', [TeacherController::class, 'update'])->name('admin.teachers.update');
    Route::delete('/admin/professores/{user}', [TeacherController::class, 'destroy'])->name('admin.teachers.destroy');
});
