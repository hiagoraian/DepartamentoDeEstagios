@extends('layouts.app')

@section('title', 'Admin - Situação dos Relatórios')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h4 class="fw-bold mb-0">Situação dos Relatórios</h4>
            <div class="text-muted">Controle por semestre</div>
        </div>

        <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary btn-sm">Voltar</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.index') }}" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Semestre</label>
                    <select name="semester" class="form-select">
                        <option value="1.2026" {{ $semester === '1.2026' ? 'selected' : '' }}>1.2026</option>
                        <option value="2.2026" {{ $semester === '2.2026' ? 'selected' : '' }}>2.2026</option>
                        <option value="1.2027" {{ $semester === '1.2027' ? 'selected' : '' }}>1.2027</option>
                        <option value="2.2027" {{ $semester === '2.2027' ? 'selected' : '' }}>2.2027</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <button class="btn btn-primary w-100">Filtrar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h6 class="fw-bold mb-3">Professores</h6>

            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead>
                        <tr class="text-muted">
                            <th>Professor</th>
                            <th>MASP</th>
                            <th>Status</th>
                            <th>Edição</th>
                            <th class="text-end">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teachers as $teacher)
                            @php
                                $report = $reports->get($teacher->id);
                                $status = $report?->status ?? null;
                                $locked = $report ? ($report->status === 'submitted' && !$report->edit_unlocked) : false;
                            @endphp

                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $teacher->name }}</div>
                                    <div class="text-muted small">{{ $teacher->professor_type }}</div>
                                </td>
                                <td>{{ $teacher->masp }}</td>

                                <td>
                                    @if(!$report)
                                        <span class="badge text-bg-secondary">Não iniciou</span>
                                    @elseif($status === 'draft')
                                        <span class="badge text-bg-warning">Rascunho</span>
                                    @elseif($status === 'submitted')
                                        <span class="badge text-bg-success">Enviado</span>
                                    @endif
                                </td>

                                <td>
                                    @if(!$report)
                                        <span class="text-muted">—</span>
                                    @elseif($locked)
                                        <span class="badge text-bg-danger">Bloqueada</span>
                                    @else
                                        <span class="badge text-bg-primary">Liberada</span>
                                    @endif
                                </td>

                                <td class="text-end">
                                    @if($report && $locked)
                                        <form method="POST" action="{{ route('admin.reports.unlock', $report) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                                Liberar edição
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-muted small">
                “Liberar edição” só aparece quando o relatório estiver <strong>Enviado</strong> e <strong>Bloqueado</strong>.
            </div>
        </div>
    </div>
@endsection
