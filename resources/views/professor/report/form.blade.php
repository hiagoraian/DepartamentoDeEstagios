@extends('layouts.app')

@section('title', 'Relatório - ' . $semester)

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h4 class="fw-bold mb-0">Relatório Semestral</h4>
            <div class="text-muted">Semestre: <strong>{{ $semester }}</strong></div>
        </div>

        <a href="{{ route('professor.home') }}" class="btn btn-outline-secondary btn-sm">
            Voltar
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($isLocked)
        <div class="alert alert-warning">
            <strong>Relatório enviado.</strong> A edição está bloqueada. Caso precise editar, solicite liberação ao administrador.
        </div>
    @endif

    <form method="POST" action="{{ route('professor.report.save', $semester) }}">
        @csrf

        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Configurações Gerais</h5>

                <div class="row g-2">
                    <div class="col-md-4">
                        <label class="form-label">Instituição</label>
                        <input type="text" name="institution" class="form-control"
                               value="{{ old('institution', $report->institution) }}"
                               {{ $isLocked ? 'disabled' : '' }}>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Local</label>
                        <input type="text" name="place" class="form-control"
                               value="{{ old('place', $report->place) }}"
                               {{ $isLocked ? 'disabled' : '' }}>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Curso</label>
                        <input type="text" name="course" class="form-control"
                               value="{{ old('course', $report->course) }}"
                               {{ $isLocked ? 'disabled' : '' }}>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Identificação do Orientador</h5>

                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">MASP</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->masp }}" disabled>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Telefone</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->phone }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">E-mail</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->email }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">CPF</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->cpf }}" disabled>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Apresentação e Atividades</h5>

                <div class="mb-3">
                    <label class="form-label">Apresentação</label>
                    <textarea name="presentation" class="form-control" rows="4"
                        {{ $isLocked ? 'disabled' : '' }}>{{ old('presentation', $report->presentation) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descrição breve das atividades realizadas</label>
                    <textarea name="activities_description" class="form-control" rows="4"
                        {{ $isLocked ? 'disabled' : '' }}>{{ old('activities_description', $report->activities_description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Encargos Docentes</label>
                    <textarea name="teaching_assignments" class="form-control" rows="4"
                        {{ $isLocked ? 'disabled' : '' }}>{{ old('teaching_assignments', $report->teaching_assignments) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Encargos Didático</label>
                    <textarea name="didactic_assignments" class="form-control" rows="4"
                        {{ $isLocked ? 'disabled' : '' }}>{{ old('didactic_assignments', $report->didactic_assignments) }}</textarea>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Aspectos e Considerações</h5>

                <div class="mb-3">
                    <label class="form-label">Aspectos Positivos</label>
                    <textarea name="positive_aspects" class="form-control" rows="4"
                        {{ $isLocked ? 'disabled' : '' }}>{{ old('positive_aspects', $report->positive_aspects) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Aspectos Negativos</label>
                    <textarea name="negative_aspects" class="form-control" rows="4"
                        {{ $isLocked ? 'disabled' : '' }}>{{ old('negative_aspects', $report->negative_aspects) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Sugestões de Melhorias</label>
                    <textarea name="improvement_suggestions" class="form-control" rows="4"
                        {{ $isLocked ? 'disabled' : '' }}>{{ old('improvement_suggestions', $report->improvement_suggestions) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">ENADE</label>
                    <textarea name="enade" class="form-control" rows="4"
                        {{ $isLocked ? 'disabled' : '' }}>{{ old('enade', $report->enade) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Conclusão</label>
                    <textarea name="conclusion" class="form-control" rows="4"
                        {{ $isLocked ? 'disabled' : '' }}>{{ old('conclusion', $report->conclusion) }}</textarea>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Produções do Semestre</h5>

                @php
                    $productions = old('semester_productions', $report->semester_productions ?? []);
                @endphp

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="semester_productions[]" value="artigos"
                        {{ in_array('artigos', $productions) ? 'checked' : '' }}
                        {{ $isLocked ? 'disabled' : '' }}>
                    <label class="form-check-label">Artigos</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="semester_productions[]" value="palestras"
                        {{ in_array('palestras', $productions) ? 'checked' : '' }}
                        {{ $isLocked ? 'disabled' : '' }}>
                    <label class="form-check-label">Palestras</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="semester_productions[]" value="anais"
                        {{ in_array('anais', $productions) ? 'checked' : '' }}
                        {{ $isLocked ? 'disabled' : '' }}>
                    <label class="form-check-label">Anais</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="semester_productions[]" value="outros"
                        {{ in_array('outros', $productions) ? 'checked' : '' }}
                        {{ $isLocked ? 'disabled' : '' }}>
                    <label class="form-check-label">Outros</label>
                </div>
            </div>
        </div>

        @if(!$isLocked)
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">
                    Salvar rascunho
                </button>
            </form>

            <form method="POST" action="{{ route('professor.report.submit', $semester) }}" class="w-100">
                @csrf
                <button type="submit" class="btn btn-success w-100"
                        onclick="return confirm('Após enviar, não será possível editar. Deseja continuar?')">
                    Enviar relatório
                </button>
            </form>
        @else
            </form>
        @endif

@endsection
