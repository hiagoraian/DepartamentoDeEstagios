@extends('layouts.app')

@section('title', 'Admin - Editar Cidade')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h4 class="fw-bold mb-0">Editar Cidade</h4>
            <div class="text-muted">Padronize o nome da cidade</div>
        </div>
        <a href="{{ route('admin.cities.index') }}" class="btn btn-outline-secondary btn-sm">Voltar</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.cities.update', $city) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-bold">Nome</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $city->name) }}"
                        required
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary">Salvar</button>
            </form>
        </div>
    </div>
@endsection
