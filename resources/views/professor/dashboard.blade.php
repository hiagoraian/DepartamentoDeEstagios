@extends('layouts.app')

@section('title', 'Professor - Dashboard')

@section('content')
<div class="row g-3">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h4 class="fw-bold mb-1">Área do Professor</h4>
                <p class="text-muted mb-0">Olá, {{ auth()->user()->name }}. Selecione o semestre para iniciar seu relatório.</p>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Escolher semestre</h5>

                <form method="GET" action="{{ route('professor.report.show', ['semester' => '__SEM__']) }}"
                    onsubmit="this.action = this.action.replace('__SEM__', document.getElementById('semesterSelect').value);">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-6">
                            <label class="form-label">Semestre</label>
                            <select id="semesterSelect" class="form-select" required>
                                <option selected disabled value="">Selecione...</option>
                                <option>1.2026</option>
                                <option>2.2026</option>
                                <option>1.2027</option>
                                <option>2.2027</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary w-100">
                                Abrir relatório
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Ações</h5>

                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('professor.password.edit') }}" class="btn btn-outline-primary">
                                Alterar senha
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection