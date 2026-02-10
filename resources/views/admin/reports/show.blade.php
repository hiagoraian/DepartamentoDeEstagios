@extends('layouts.app')

@section('title', 'Admin - Visualizar Relatório')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h4 class="fw-bold mb-0">Relatório do Professor</h4>
            <div class="text-muted">
                Semestre: <strong>{{ $report->semester }}</strong> —
                {{ $report->user?->name }} ({{ $report->user?->masp }})
            </div>
        </div>

        <a href="{{ route('admin.general-report', ['semester' => $report->semester]) }}" class="btn btn-outline-secondary btn-sm">
            Voltar ao Relatório Geral
        </a>
    </div>

    <div class="row g-3">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-2">Configurações Gerais</h6>
                    <div class="row g-2">
                        <div class="col-md-4"><span class="text-muted">Instituição:</span> <strong>{{ $report->institution ?? '—' }}</strong></div>
                        <div class="col-md-4"><span class="text-muted">Local:</span> <strong>{{ $report->place ?? '—' }}</strong></div>
                        <div class="col-md-4"><span class="text-muted">Curso:</span> <strong>{{ $report->course ?? '—' }}</strong></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-2">Identificação do Orientador</h6>
                    <div class="row g-2">
                        <div class="col-md-6"><span class="text-muted">Nome:</span> <strong>{{ $report->user?->name }}</strong></div>
                        <div class="col-md-3"><span class="text-muted">MASP:</span> <strong>{{ $report->user?->masp }}</strong></div>
                        <div class="col-md-3"><span class="text-muted">Telefone:</span> <strong>{{ $report->user?->phone ?? '—' }}</strong></div>
                        <div class="col-md-6"><span class="text-muted">E-mail:</span> <strong>{{ $report->user?->email ?? '—' }}</strong></div>
                        <div class="col-md-6"><span class="text-muted">CPF:</span> <strong>{{ $report->user?->cpf ?? '—' }}</strong></div>
                    </div>
                </div>
            </div>
        </div>

        @php
            $box = fn($title, $text) => '<div class="card shadow-sm border-0 mb-3"><div class="card-body"><h6 class="fw-bold mb-2">'.$title.'</h6><div class="text-muted" style="white-space: pre-wrap;">'.e($text ?: '—').'</div></div></div>';
        @endphp

        <div class="col-12">
            {!! $box('Apresentação', $report->presentation) !!}
            {!! $box('Descrição breve das atividades realizadas', $report->activities_description) !!}
            {!! $box('Encargos Docentes', $report->teaching_assignments) !!}
            {!! $box('Encargos Didático', $report->didactic_assignments) !!}
        </div>

        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-2">Escolas Atendidas</h6>

                    <div class="table-responsive">
                        <table class="table table-sm align-middle">
                            <thead>
                                <tr class="text-muted">
                                    <th>Cidade</th>
                                    <th>Escola</th>
                                    <th>Alunos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($report->schools as $s)
                                    <tr>
                                        <td class="fw-semibold">{{ $s->city?->name ?? '—' }}</td>
                                        <td>{{ $s->school_name }}</td>
                                        <td>{{ $s->students_impacted }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-muted">Nenhuma escola registrada.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-12">
            {!! $box('Aspectos Positivos', $report->positive_aspects) !!}
            {!! $box('Aspectos Negativos', $report->negative_aspects) !!}
            {!! $box('Sugestões de Melhorias', $report->improvement_suggestions) !!}
            {!! $box('ENADE', $report->enade) !!}
            {!! $box('Conclusão', $report->conclusion) !!}
        </div>

        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-2">Produções do Semestre</h6>
                    @php $items = $report->semester_productions ?? []; @endphp
                    <div class="text-muted">
                        @if(empty($items))
                            —
                        @else
                            {{ implode(', ', $items) }}
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-2">Anexos</h6>

                    <div class="d-flex flex-wrap gap-2">
                        @if($report->teaching_plan_path)
                            <a class="btn btn-outline-primary btn-sm"
                               href="{{ asset('storage/' . $report->teaching_plan_path) }}" target="_blank">
                                Plano de Ensino
                            </a>
                        @endif

                        @if($report->visit_term_path)
                            <a class="btn btn-outline-primary btn-sm"
                               href="{{ asset('storage/' . $report->visit_term_path) }}" target="_blank">
                                Termo de Visita
                            </a>
                        @endif

                        @if(!$report->teaching_plan_path && !$report->visit_term_path)
                            <span class="text-muted">—</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
