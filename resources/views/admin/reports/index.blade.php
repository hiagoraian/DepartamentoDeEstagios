@extends('layouts.app')

@section('title', 'Admin - Situação dos Relatórios')

@section('content')


<div class="d-flex align-items-end justify-content-between mb-3">
    <div>
        <h4 class="fw-bold mb-0">Relatórios do Semestre</h4>
        <div class="text-muted">Semestre: <strong>{{ $semester }}</strong></div>
    </div>

    <form method="GET" action="{{ route('admin.reports.index') }}" class="d-flex gap-2">
        <select name="semester" class="form-select form-select-sm" style="min-width: 140px" required>
            <option value="1.2026" {{ $semester === '1.2026' ? 'selected' : '' }}>1.2026</option>
            <option value="2.2026" {{ $semester === '2.2026' ? 'selected' : '' }}>2.2026</option>
            <option value="1.2027" {{ $semester === '1.2027' ? 'selected' : '' }}>1.2027</option>
            <option value="2.2027" {{ $semester === '2.2027' ? 'selected' : '' }}>2.2027</option>
        </select>

        <button class="btn btn-primary btn-sm">Filtrar</button>
    </form>
    <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary btn-sm">Voltar</a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead>
                    <tr class="text-muted">
                        <th>Professor</th>
                        <th>MASP</th>
                        <th>Campus</th>
                        <th>Curso</th>
                        <th>Disciplina</th>
                        <th>Status</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td class="fw-semibold">{{ $report->user?->name }}</td>
                            <td>{{ $report->user?->masp }}</td>
                            <td>{{ $report->campus ?? '-' }}</td>
                            <td>{{ $report->course ?? '-' }}</td>
                            <td>{{ $report->discipline ?? '-' }}</td>
                            <td>
                                @if($report->status === 'submitted')
                                    <span class="badge text-bg-success">Enviado</span>
                                @else
                                    <span class="badge text-bg-warning">Rascunho</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <form method="POST"
                                      action="{{ route('admin.reports.destroy', ['report' => $report->id]) }}"
                                      onsubmit="return confirm('Excluir este relatório? Essa ação não pode ser desfeita.');"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-outline-danger btn-sm"
                                            {{ $report->status === 'submitted' ? 'disabled' : '' }}>
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-muted">Nenhum relatório encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection