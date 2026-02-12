<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Relatório Geral - {{ $semester }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        .header { margin-bottom: 12px; }
        .title { font-size: 18px; font-weight: bold; margin: 0; }
        .subtitle { margin: 4px 0 0 0; color: #444; }

        .section { margin-top: 14px; }
        .section h2 { font-size: 14px; margin: 0 0 6px 0; padding-bottom: 4px; border-bottom: 1px solid #ddd; }

        .kpis { width: 100%; border-collapse: collapse; margin-top: 6px; }
        .kpis td { padding: 8px; border: 1px solid #e5e5e5; }
        .kpis .label { color: #555; font-size: 11px; }
        .kpis .value { font-size: 16px; font-weight: bold; }

        table { width: 100%; border-collapse: collapse; margin-top: 6px; }
        th, td { border: 1px solid #e5e5e5; padding: 6px; vertical-align: top; }
        th { background: #f3f6fb; text-align: left; }

        .muted { color: #666; }
        .small { font-size: 10px; }
    </style>
</head>
<body>

<div class="header">
    <p class="title">Relatório Geral do Semestre</p>
    <p class="subtitle">Semestre: <strong>{{ $semester }}</strong></p>
</div>

<div class="section">
    <h2>Painel Geral</h2>

    <table class="kpis">
        <tr>
            <td>
                <div class="label">Professores</div>
                <div class="value">{{ $teachersTotal }}</div>
            </td>
            <td>
                <div class="label">Enviados</div>
                <div class="value">{{ $submittedCount }}</div>
            </td>
            <td>
                <div class="label">Rascunho</div>
                <div class="value">{{ $draftCount }}</div>
            </td>
            <td>
                <div class="label">Não iniciou</div>
                <div class="value">{{ $notStartedCount }}</div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="label">Total de escolas atendidas</div>
                <div class="value">{{ $totalSchools }}</div>
            </td>
            <td colspan="2">
                <div class="label">Total de alunos impactados</div>
                <div class="value">{{ $totalStudents }}</div>
            </td>
        </tr>
    </table>
</div>

<div class="section">
    <h2>Produção Semestral dos Professores</h2>

    <table>
        <thead>
            <tr>
                <th>Artigos</th>
                <th>Palestras</th>
                <th>Anais</th>
                <th>Outros</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $productionsCount['artigos'] }}</td>
                <td>{{ $productionsCount['palestras'] }}</td>
                <td>{{ $productionsCount['anais'] }}</td>
                <td>{{ $productionsCount['outros'] }}</td>
            </tr>
        </tbody>
    </table>

    <p class="muted small">
        Contagem baseada em quantos relatórios marcaram cada opção.
    </p>
</div>

<div class="section">
    <h2>Escolas e Alunos Impactados</h2>

    <h3 style="font-size: 12px; margin: 10px 0 4px 0;">Top 10 Cidades (Alunos impactados)</h3>
    <table>
        <thead>
            <tr>
                <th>Cidade</th>
                <th>Escolas</th>
                <th>Alunos</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topCitiesByStudents as $row)
                <tr>
                    <td>{{ $row['city'] }}</td>
                    <td>{{ $row['schools'] }}</td>
                    <td>{{ $row['students'] }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="muted">Sem dados.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h3 style="font-size: 12px; margin: 10px 0 4px 0;">Top 10 Cidades (Quantidade de Escolas)</h3>
    <table>
        <thead>
            <tr>
                <th>Cidade</th>
                <th>Escolas</th>
                <th>Alunos</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topCitiesBySchools as $row)
                <tr>
                    <td>{{ $row['city'] }}</td>
                    <td>{{ $row['schools'] }}</td>
                    <td>{{ $row['students'] }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="muted">Sem dados.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h3 style="font-size: 12px; margin: 10px 0 4px 0;">Consolidado por Cidade</h3>
    <table>
        <thead>
            <tr>
                <th>Cidade</th>
                <th>Escolas</th>
                <th>Alunos</th>
            </tr>
        </thead>
        <tbody>
            @forelse($byCity as $row)
                <tr>
                    <td>{{ $row['city'] }}</td>
                    <td>{{ $row['schools'] }}</td>
                    <td>{{ $row['students'] }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="muted">Sem dados.</td></tr>
            @endforelse
        </tbody>
    </table>

    <p class="muted small">
        Observação: o mapa de calor será incluído posteriormente (exige coordenadas lat/lon das cidades).
    </p>
</div>

<div class="section">
    <h2>Professores que enviaram</h2>

    <table>
        <thead>
            <tr>
                <th>Professor</th>
                <th>MASP</th>
            </tr>
        </thead>
        <tbody>
            @php
                $sent = $reports->where('status', 'submitted');
            @endphp

            @forelse($sent as $r)
                <tr>
                    <td>{{ $r->user?->name }}</td>
                    <td>{{ $r->user?->masp }}</td>
                </tr>
            @empty
                <tr><td colspan="2" class="muted">Nenhum relatório enviado neste semestre.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

</body>
</html>
