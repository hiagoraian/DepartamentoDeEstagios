@extends('layouts.app')

@section('title', 'Admin - Cidades')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h4 class="fw-bold mb-0">Cidades (MG)</h4>
            <div class="text-muted">Cadastro e padronização de cidades</div>
        </div>
        <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary btn-sm">Voltar</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-3">
        <div class="col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Cadastrar nova cidade</h6>

                    <form method="POST" action="{{ route('admin.cities.store') }}">
                        @csrf

                        <div class="mb-2">
                            <label class="form-label">Nome da cidade</label>
                            <input
                                type="text"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Ex: Janaúba"
                                value="{{ old('name') }}"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-primary w-100">Cadastrar</button>

                        <div class="small text-muted mt-2">
                            UF será salva como <strong>MG</strong>.
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Cidades cadastradas</h6>

                    <div class="table-responsive">
                        <table class="table table-sm align-middle">
                            <thead>
                                <tr class="text-muted">
                                    <th>Nome</th>
                                    <th style="width: 170px;" class="text-end">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cities as $city)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $city->name }}</div>
                                            <div class="text-muted small">{{ $city->uf }}</div>
                                        </td>
                                        <td class="text-end">
                                            <a class="btn btn-outline-primary btn-sm"
                                               href="{{ route('admin.cities.edit', $city) }}">
                                                Editar
                                            </a>

                                            <form method="POST"
                                                  action="{{ route('admin.cities.destroy', $city) }}"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Tem certeza que deseja remover esta cidade?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger btn-sm" type="submit">
                                                    Remover
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-muted">Nenhuma cidade cadastrada.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
