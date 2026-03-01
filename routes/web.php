<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Professor\ReportController;
use App\Http\Controllers\Admin\ReportStatusController;
use App\Http\Controllers\Professor\PasswordController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GeneralReportController;


Route::get('/', fn() => redirect()->route('login'));

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');


/*
|--------------------------------------------------------------------------
| ROTAS PROFESSOR
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Dashboard Professor
    Route::get('/professor', function () {
        return view('professor.dashboard');
    })->name('professor.home');

    // Relatórios (Professor)
    Route::get('/professor/relatorio/{semester}', [ReportController::class, 'show'])
        ->name('professor.report.show');

    Route::post('/professor/relatorio/{semester}/salvar', [ReportController::class, 'save'])
        ->name('professor.report.save');

    Route::post('/professor/relatorio/{semester}/enviar', [ReportController::class, 'submit'])
        ->name('professor.report.submit');

    // Alterar senha (Professor)
    Route::get('/professor/senha', [PasswordController::class, 'edit'])
        ->name('professor.password.edit');

    Route::post('/professor/senha', [PasswordController::class, 'update'])
        ->name('professor.password.update');

    Route::get('/professor/relatorios/{semester}', [ReportController::class, 'index'])
        ->name('professor.reports.index');

    Route::get('/professor/relatorios/{semester}/novo', [ReportController::class, 'create'])
        ->name('professor.reports.create');

    Route::post('/professor/relatorios/{semester}', [ReportController::class, 'store'])
        ->name('professor.reports.store');

    Route::get('/professor/relatorio/id/{report}', [ReportController::class, 'edit'])
        ->name('professor.report.edit');

    Route::post('/professor/relatorio/id/{report}/salvar', [ReportController::class, 'saveById'])
        ->name('professor.report.saveById');

    Route::post('/professor/relatorio/id/{report}/enviar', [ReportController::class, 'submitById'])
        ->name('professor.report.submitById');
});



/*
|--------------------------------------------------------------------------
| ROTAS ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'is_admin'])
    ->group(function () {

        // Dashboard Admin
        Route::get('/', [DashboardController::class, 'index'])
            ->name('admin.home');

        // Cidades
        Route::get('/cidades', [CityController::class, 'index'])
            ->name('admin.cities.index');

        Route::post('/cidades', [CityController::class, 'store'])
            ->name('admin.cities.store');

        Route::get('/cidades/{city}/editar', [CityController::class, 'edit'])
            ->name('admin.cities.edit');

        Route::put('/cidades/{city}', [CityController::class, 'update'])
            ->name('admin.cities.update');

        Route::delete('/cidades/{city}', [CityController::class, 'destroy'])
            ->name('admin.cities.destroy');

        // Professores
        Route::get('/professores', [TeacherController::class, 'index'])
            ->name('admin.teachers.index');

        Route::get('/professores/novo', [TeacherController::class, 'create'])
            ->name('admin.teachers.create');

        Route::post('/professores', [TeacherController::class, 'store'])
            ->name('admin.teachers.store');

        Route::get('/professores/{user}/editar', [TeacherController::class, 'edit'])
            ->name('admin.teachers.edit');

        Route::put('/professores/{user}', [TeacherController::class, 'update'])
            ->name('admin.teachers.update');

        Route::delete('/professores/{user}', [TeacherController::class, 'destroy'])
            ->name('admin.teachers.destroy');

        // Situação dos relatórios
        Route::get('/relatorios', [ReportStatusController::class, 'index'])
            ->name('admin.reports.index');

        Route::post('/relatorios/{report}/liberar-edicao', [ReportStatusController::class, 'unlock'])
            ->name('admin.reports.unlock');

        // Relatório geral
        Route::get('/relatorio-geral', [GeneralReportController::class, 'index'])
            ->name('admin.general-report');

        Route::get('/relatorio-geral/pdf', [GeneralReportController::class, 'pdf'])
            ->name('admin.general-report.pdf');

        Route::get('/relatorios/{report}', [GeneralReportController::class, 'show'])
            ->name('admin.reports.show');

        Route::delete('/relatorios/{report}', [ReportStatusController::class, 'destroy'])
            ->name('admin.reports.destroy');

        Route::post('/professores/{user}/semestre', [TeacherController::class, 'toggleSemester'])
            ->name('admin.teachers.semester.toggle');
    });
