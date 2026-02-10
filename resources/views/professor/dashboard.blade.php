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

                <form>
                    <div class="row g-2 align-items-end">
                        <div class="col-md-6">
                            <label class="form-label">Semestre</label>
                            <select class="form-select">
                                <option selected disabled>Selecione...</option>
                                <option>1.2026</option>
                                <option>2.2026</option>
                                <option>1.2027</option>
                                <option>2.2027</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <a href="{{ route('professor.report.show', '1.2026') }}" class="btn btn-primary w-100">
                                Abrir relatório
                            </a>
                        </div>
                    </div>
                </form>

                <div class="alert alert-info mt-3 mb-0">
                    <strong>Obs:</strong> o botão ainda não abre o relatório — vamos implementar depois.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection