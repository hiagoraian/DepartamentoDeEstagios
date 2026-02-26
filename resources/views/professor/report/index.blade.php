@extends('layouts.app')

@section('title', 'Relatórios - ' . $semester)

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h4 class="fw-bold mb-0">Meus Relatórios</h4>
        <div class="text-muted">Semestre: <strong>{{ $semester }}</strong></div>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('professor.home') }}" class="btn btn-outline-secondary btn-sm">Voltar</a>
        <a href="{{ route('professor.reports.create', $semester) }}" class="btn btn-primary btn-sm">+ Novo relatório</a>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead>
                    <tr class="text-muted">
                        <th>Campus</th>
                        <th>Curso</th>
                        <th>Disciplina</th>
                        <th>Status</th>
                        <th class="text-end">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                    <tr>
                        <td class="fw-semibold">{{ $report->campus ?? '-' }}</td>
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
                            <a href="{{ route('professor.report.edit', $report) }}"
                                class="btn btn-outline-primary btn-sm">
                                Abrir
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-muted">Nenhum relatório criado neste semestre.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection