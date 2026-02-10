@extends('layouts.app')

@section('title', 'Admin - Dashboard')

@section('content')
    <div class="row g-3">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="fw-bold mb-1">Dashboard do Administrador</h4>
                    <p class="text-muted mb-0">Bem-vindo(a), {{ auth()->user()->name }}.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Professores</h6>
                    <div class="fs-3 fw-bold">—</div>
                    <small class="text-muted">Total cadastrados</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Relatórios enviados</h6>
                    <div class="fs-3 fw-bold">—</div>
                    <small class="text-muted">No semestre selecionado</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Pendentes</h6>
                    <div class="fs-3 fw-bold">—</div>
                    <small class="text-muted">Aguardando envio</small>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Ações rápidas</h5>

                    <div class="d-flex flex-wrap gap-2">
                         <a href="{{ route('admin.cities.index') }}" class="btn btn-primary">Cidades (MG)</a>
                        <a href="#" class="btn btn-primary">Cadastrar professor</a>
                        <a href="#" class="btn btn-outline-primary">Ver situação por semestre</a>
                        <a href="#" class="btn btn-outline-secondary">Relatório geral</a>
                    </div>

                    <div class="alert alert-info mt-3 mb-0">
                        <strong>Obs:</strong> os botões ainda não estão ligados às telas — vamos criar depois.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
