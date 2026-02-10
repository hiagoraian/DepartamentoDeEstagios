@extends('layouts.app')

@section('title', 'Admin - Editar Professor')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h4 class="fw-bold mb-0">Editar Professor</h4>
            <div class="text-muted">Atualize os dados do professor</div>
        </div>

        <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-secondary btn-sm">
            Voltar
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.teachers.update', $user) }}">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-bold">Nome completo</label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Tipo</label>
                        <select name="professor_type"
                                class="form-select @error('professor_type') is-invalid @enderror"
                                required>
                            <option value="efetivo" {{ old('professor_type', $user->professor_type) === 'efetivo' ? 'selected' : '' }}>Efetivo</option>
                            <option value="contratado" {{ old('professor_type', $user->professor_type) === 'contratado' ? 'selected' : '' }}>Contratado</option>
                        </select>
                        @error('professor_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">MASP</label>
                        <input type="text" name="masp"
                               class="form-control @error('masp') is-invalid @enderror"
                               value="{{ old('masp', $user->masp) }}" required>
                        @error('masp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">CPF</label>
                        <input type="text" name="cpf"
                               class="form-control @error('cpf') is-invalid @enderror"
                               value="{{ old('cpf', $user->cpf) }}" required>
                        @error('cpf') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Telefone</label>
                        <input type="text" name="phone"
                               class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $user->phone) }}">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Nova senha (opcional)</label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Confirmar senha</label>
                        <input type="password" name="password_confirmation"
                               class="form-control">
                    </div>
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary w-100">
                        Salvar alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
