@extends('layouts.app')

@section('title', 'Admin - Professores')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h4 class="fw-bold mb-0">Professores</h4>
            <div class="text-muted">Cadastro e gerenciamento</div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary btn-sm">Voltar</a>
            <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary btn-sm">+ Novo professor</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead>
                        <tr class="text-muted">
                            <th>Nome</th>
                            <th>MASP</th>
                            <th>CPF</th>
                            <th>Tipo</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($teachers as $teacher)
                            <tr>
                                <td class="fw-semibold">{{ $teacher->name }}</td>
                                <td>{{ $teacher->masp }}</td>
                                <td>{{ $teacher->cpf }}</td>
                                <td>
                                    @if($teacher->professor_type === 'efetivo')
                                        <span class="badge text-bg-primary">Efetivo</span>
                                    @else
                                        <span class="badge text-bg-warning">Contratado</span>
                                    @endif
                                </td>
                                <td>{{ $teacher->email ?? '-' }}</td>
                                <td>{{ $teacher->phone ?? '-' }}</td>

                                <td class="text-end">
                                    <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-outline-primary btn-sm">
                                        Editar
                                    </a>

                                    <form method="POST"
                                          action="{{ route('admin.teachers.destroy', $teacher) }}"
                                          class="d-inline"
                                          onsubmit="return confirm('Tem certeza que deseja remover este professor?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            Remover
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted">Nenhum professor cadastrado.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection
