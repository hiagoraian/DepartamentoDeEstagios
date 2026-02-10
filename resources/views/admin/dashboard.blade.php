@extends('layouts.app')

@section('title', 'Admin - Dashboard')

@section('content')
<div class="row g-3">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h4 class="fw-bold mb-1">Dashboard do Administrador</h4>
                <p class="text-muted mb-0">Bem-vindo(a), {{ auth()->user()->name }}.</p>
                <form method="GET" action="{{ route('admin.home') }}" class="mt-3">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Semestre</label>
                            <select name="semester" class="form-select">
                                <option value="1.2026" {{ $semester === '1.2026' ? 'selected' : '' }}>1.2026</option>
                                <option value="2.2026" {{ $semester === '2.2026' ? 'selected' : '' }}>2.2026</option>
                                <option value="1.2027" {{ $semester === '1.2027' ? 'selected' : '' }}>1.2027</option>
                                <option value="2.2027" {{ $semester === '2.2027' ? 'selected' : '' }}>2.2027</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-primary w-100">
                                Filtrar
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Professores</h6>
                <div class="fs-3 fw-bold">{{ $teachersTotal }}</div>
                <small class="text-muted">Total cadastrados</small>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Relatórios enviados</h6>
                <div class="fs-3 fw-bold">{{ $submittedCount }}</div>
                <small class="text-muted">No semestre selecionado</small>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Pendentes</h6>
                <div class="fs-3 fw-bold">{{ $pendingCount }}</div>
                <small class="text-muted">Aguardando envio</small>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Ações rápidas</h5>

                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.cities.index') }}" class="btn btn-primary">Cidades (MG)</a>
                    <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-primary">Professores</a>
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-primary">Situação por semestre</a>
                <a href="{{ route('admin.general-report', ['semester' => $semester ?? '1.2026']) }}" class="btn btn-outline-secondary">Relatório geral</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection