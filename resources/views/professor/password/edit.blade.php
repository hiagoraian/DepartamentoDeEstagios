@extends('layouts.app')

@section('title', 'Alterar Senha')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h4 class="fw-bold mb-0">Alterar Senha</h4>
            <div class="text-muted">Atualize sua senha de acesso</div>
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

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('professor.password.update') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">Senha atual</label>
                    <input type="password"
                           name="current_password"
                           class="form-control @error('current_password') is-invalid @enderror"
                           required>

                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Nova senha</label>
                    <input type="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           required>

                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Confirmar nova senha</label>
                    <input type="password"
                           name="password_confirmation"
                           class="form-control"
                           required>
                </div>

                <button class="btn btn-primary w-100">
                    Salvar nova senha
                </button>
            </form>
        </div>
    </div>
@endsection
