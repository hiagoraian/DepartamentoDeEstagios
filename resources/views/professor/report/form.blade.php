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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Escolas Atendidas</h5>

                @if(!$isLocked)
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="addSchoolRow()">
                    + Adicionar escola
                </button>
                @endif
            </div>

            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead>
                        <tr class="text-muted">
                            <th style="width: 30%;">Cidade</th>
                            <th style="width: 45%;">Nome da Escola</th>
                            <th style="width: 15%;">Alunos</th>
                            @if(!$isLocked)
                            <th style="width: 10%;" class="text-end">Ação</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody id="schoolsTableBody">
                        @php
                        $oldSchools = old('schools');
                        $savedSchools = $report->schools ?? [];
                        $schoolsData = $oldSchools ?? $savedSchools;
                        @endphp

                        @forelse($schoolsData as $index => $school)
                        <tr>
                            <td>
                                <select name="schools[{{ $index }}][city_id]" class="form-select form-select-sm" {{ $isLocked ? 'disabled' : '' }}>
                                    <option value="" disabled>Selecione...</option>

                                    @foreach($cities as $city)
                                    @php
                                    $selectedCity = is_array($school)
                                    ? ($school['city_id'] ?? null)
                                    : ($school->city_id ?? null);
                                    @endphp

                                    <option value="{{ $city->id }}" {{ (string)$selectedCity === (string)$city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                @php
                                $schoolName = is_array($school)
                                ? ($school['school_name'] ?? '')
                                : ($school->school_name ?? '');
                                @endphp

                                <input type="text"
                                    name="schools[{{ $index }}][school_name]"
                                    class="form-control form-control-sm"
                                    value="{{ $schoolName }}"
                                    {{ $isLocked ? 'disabled' : '' }}>
                            </td>

                            <td>
                                @php
                                $students = is_array($school)
                                ? ($school['students_impacted'] ?? 0)
                                : ($school->students_impacted ?? 0);
                                @endphp

                                <input type="number"
                                    min="0"
                                    name="schools[{{ $index }}][students_impacted]"
                                    class="form-control form-control-sm"
                                    value="{{ $students }}"
                                    {{ $isLocked ? 'disabled' : '' }}>
                            </td>

                            @if(!$isLocked)
                            <td class="text-end">
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeSchoolRow(this)">
                                    Remover
                                </button>
                            </td>
                            @endif
                        </tr>
                        @empty
                        {{-- começa vazio --}}
                        @endforelse
                    </tbody>
                </table>
            </div>

            @error('schools.*.city_id')
            <div class="text-danger small mt-2">Verifique se todas as escolas possuem cidade selecionada.</div>
            @enderror
            @error('schools.*.school_name')
            <div class="text-danger small mt-2">Verifique se todas as escolas possuem nome preenchido.</div>
            @enderror
            @error('schools.*.students_impacted')
            <div class="text-danger small mt-2">Verifique se todos os campos de alunos estão preenchidos corretamente.</div>
            @enderror

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

@if(!$isLocked)
    <div id="schoolsMeta"
         data-school-index="{{ is_array(old('schools')) ? count(old('schools')) : ($report->schools ? $report->schools->count() : 0) }}">
    </div>

    <template id="citiesOptions">
        @foreach($cities as $city)
            <option value="{{ $city->id }}">{{ $city->name }}</option>
        @endforeach
    </template>
@endif

<script>
    const meta = document.getElementById('schoolsMeta');
    let schoolIndex = Number(meta.dataset.schoolIndex);

    const citiesOptionsHtml = document.getElementById('citiesOptions').innerHTML;

    function addSchoolRow() {
        const tbody = document.getElementById('schoolsTableBody');
        const row = document.createElement('tr');

        row.innerHTML = `
            <td>
                <select name="schools[${schoolIndex}][city_id]" class="form-select form-select-sm" required>
                    <option value="" selected disabled>Selecione...</option>
                    ${citiesOptionsHtml}
                </select>
            </td>

            <td>
                <input type="text"
                       name="schools[${schoolIndex}][school_name]"
                       class="form-control form-control-sm"
                       required>
            </td>

            <td>
                <input type="number"
                       min="0"
                       name="schools[${schoolIndex}][students_impacted]"
                       class="form-control form-control-sm"
                       value="0"
                       required>
            </td>

            <td class="text-end">
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeSchoolRow(this)">
                    Remover
                </button>
            </td>
        `;

        tbody.appendChild(row);
        schoolIndex++;
    }

    function removeSchoolRow(button) {
        button.closest('tr').remove();
    }
</script>

@endsection