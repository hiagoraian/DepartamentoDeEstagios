@extends('layouts.app')

@section('title', 'Novo Relatório - ' . $semester)

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h4 class="fw-bold mb-0">Novo Relatório</h4>
        <div class="text-muted">Semestre: <strong>{{ $semester }}</strong></div>
    </div>

    <a href="{{ route('professor.reports.index', $semester) }}"
       class="btn btn-outline-secondary btn-sm">
        Voltar
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form method="POST"
              action="{{ route('professor.reports.store', $semester) }}">
            @csrf

            <div class="row g-3">

                <div class="col-md-4">
                    <label class="form-label fw-bold">Campus</label>
                    <input type="text"
                           name="campus"
                           class="form-control @error('campus') is-invalid @enderror"
                           value="{{ old('campus') }}"
                           required>
                    @error('campus')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Curso</label>
                    <input type="text"
                           name="course"
                           class="form-control @error('course') is-invalid @enderror"
                           value="{{ old('course') }}"
                           required>
                    @error('course')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Disciplina</label>
                    <input type="text"
                           name="discipline"
                           class="form-control @error('discipline') is-invalid @enderror"
                           value="{{ old('discipline') }}"
                           required>
                    @error('discipline')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary w-100">
                    Criar relatório
                </button>
            </div>

        </form>
    </div>
</div>
@endsection