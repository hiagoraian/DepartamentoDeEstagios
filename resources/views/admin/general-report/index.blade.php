@extends('layouts.app')

@section('title', 'Admin - Relatório Geral')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h3 class="fw-bold mb-0">Relatório Geral do Semestre</h3>
        <div class="text-muted">Visão geral e consolidados</div>
    </div>

    <a href="{{ route('admin.home', ['semester' => $semester]) }}" class="btn btn-outline-secondary btn-sm">
        Voltar
    </a>
</div>

<div class="card shadow-sm border-0 mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.general-report') }}" class="row g-2 align-items-end">
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

        </form>

    </div>
</div>

<div class="row g-3 mb-3">
    <h5 class="fw-bold mb-2">Painel Geral</h5>
    <div class="text-muted mb-3">Indicadores do semestre selecionado</div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="text-muted">Professores</div>
                <div class="fs-3 fw-bold">{{ $teachersTotal }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="text-muted">Enviados</div>
                <div class="fs-3 fw-bold">{{ $submittedCount }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="text-muted">Rascunho</div>
                <div class="fs-3 fw-bold">{{ $draftCount }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="text-muted">Não iniciou</div>
                <div class="fs-3 fw-bold">{{ $notStartedCount }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="text-muted">Total de escolas atendidas</div>
                <div class="fs-3 fw-bold">{{ $totalSchools }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="text-muted">Total de alunos impactados</div>
                <div class="fs-3 fw-bold">{{ $totalStudents }}</div>
            </div>
        </div>
    </div>
</div>


<div class="row g-3 mb-3">
    <h5 class="fw-bold mb-2">Produção Semestral dos Professores</h5>
    <div class="text-muted mb-3">Quantidade de relatórios que marcaram cada tipo de produção</div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="text-muted">Artigos</div>
                <div class="fs-3 fw-bold">{{ $productionsCount['artigos'] }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="text-muted">Palestras</div>
                <div class="fs-3 fw-bold">{{ $productionsCount['palestras'] }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="text-muted">Anais</div>
                <div class="fs-3 fw-bold">{{ $productionsCount['anais'] }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="text-muted">Outros</div>
                <div class="fs-3 fw-bold">{{ $productionsCount['outros'] }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <h5 class="fw-bold mb-2">Escolas e Alunos Impactados</h5>
    <div class="text-muted mb-3">Consolidado por cidade e ranking de impacto</div>

    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Top 10 Cidades (Alunos impactados)</h6>

                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead>
                            <tr class="text-muted">
                                <th>Cidade</th>
                                <th>Escolas</th>
                                <th>Alunos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topCitiesByStudents as $row)
                            <tr>
                                <td class="fw-semibold">{{ $row['city'] }}</td>
                                <td>{{ $row['schools'] }}</td>
                                <td>{{ $row['students'] }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-muted">Sem dados.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Top 10 Cidades (Quantidade de Escolas)</h6>

                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead>
                            <tr class="text-muted">
                                <th>Cidade</th>
                                <th>Escolas</th>
                                <th>Alunos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topCitiesBySchools as $row)
                            <tr>
                                <td class="fw-semibold">{{ $row['city'] }}</td>
                                <td>{{ $row['schools'] }}</td>
                                <td>{{ $row['students'] }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-muted">Sem dados.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <h6 class="fw-bold mb-2">Mapa de calor (em breve)</h6>
            <div class="text-muted small">
                Próximo passo: adicionar coordenadas (lat/lon) das cidades para plotar o mapa do semestre.
            </div>
            <div class="mt-3" style="height: 320px; background: #f5f7fb; border-radius: 12px;"></div>
        </div>
    </div>

</div>


<div class="card shadow-sm border-0 mb-3">
    <div class="card-body">
        <h6 class="fw-bold mb-3">Consolidado por Cidade</h6>

        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead>
                    <tr class="text-muted">
                        <th>Cidade</th>
                        <th>Escolas</th>
                        <th>Alunos impactados</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($byCity as $row)
                    <tr>
                        <td class="fw-semibold">{{ $row['city'] }}</td>
                        <td>{{ $row['schools'] }}</td>
                        <td>{{ $row['students'] }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-muted">Nenhum dado de escolas para este semestre.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="card shadow-sm border-0 mb-3">
    <div class="card-body">
        <h5 class="fw-bold mb-2">Aspectos Positivos, Negativos e Melhorias</h5>
        <div class="text-muted mb-3">Resumo por professor (clique para expandir)</div>

        @forelse($reports as $report)
        <details class="mb-2">
            <summary class="fw-semibold">
                {{ $report->user?->name }} — {{ $report->user?->masp }}
                <span class="text-muted fw-normal">({{ $report->schools->count() }} escolas, {{ $report->schools->sum('students_impacted') }} alunos)</span>
            </summary>

            <div class="mt-2 small">
                <div class="mb-2">
                    <span class="fw-bold">Cidades/Escolas:</span>
                    <span class="text-muted">
                        @foreach($report->schools as $s)
                        {{ $s->city?->name }} — {{ $s->school_name }} ({{ $s->students_impacted }})@if(!$loop->last); @endif
                        @endforeach
                    </span>
                </div>

                <div class="row g-2">
                    <div class="col-md-4">
                        <div class="border rounded p-2 h-100">
                            <div class="fw-bold mb-1">Aspectos positivos</div>
                            <div class="text-muted" style="max-height: 140px; overflow: auto;">
                                {{ $report->positive_aspects ?: '—' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="border rounded p-2 h-100">
                            <div class="fw-bold mb-1">Aspectos negativos</div>
                            <div class="text-muted" style="max-height: 140px; overflow: auto;">
                                {{ $report->negative_aspects ?: '—' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="border rounded p-2 h-100">
                            <div class="fw-bold mb-1">Sugestões de melhoria</div>
                            <div class="text-muted" style="max-height: 140px; overflow: auto;">
                                {{ $report->improvement_suggestions ?: '—' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </details>
        @empty
        <div class="text-muted">Nenhum relatório encontrado para este semestre.</div>
        @endforelse
    </div>
</div>


<div class="card shadow-sm border-0">
    <div class="card-body">
        <h6 class="fw-bold mb-3">Relatórios (detalhado)</h6>

        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead>
                    <tr class="text-muted">
                        <th>Professor</th>
                        <th>MASP</th>
                        <th>Status</th>
                        <th>Qtd. Escolas</th>
                        <th>Alunos</th>
                        <th class="text-end">Ações</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                    <tr>
                        <td class="fw-semibold">{{ $report->user?->name }}</td>
                        <td>{{ $report->user?->masp }}</td>
                        <td>
                            @if($report->status === 'submitted')
                            <span class="badge text-bg-success">Enviado</span>
                            @else
                            <span class="badge text-bg-warning">Rascunho</span>
                            @endif
                        </td>
                        <td>{{ $report->schools->count() }}</td>
                        <td>{{ $report->schools->sum('students_impacted') }}</td>

                        <td class="text-end">
                            <a href="{{ route('admin.reports.show', $report) }}" class="btn btn-outline-primary btn-sm">
                                Ver relatório
                            </a>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="5" class="text-muted">Nenhum relatório encontrado para este semestre.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="text-muted small">
            “Não iniciou” significa professor cadastrado sem relatório criado nesse semestre.
        </div>
    </div>
</div>
@endsection