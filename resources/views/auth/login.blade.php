<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - DEPE</title>

    {{-- Bootstrap 5 (CDN) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0a1f44, #144a9c);
        }

        .login-card {
            border-radius: 16px;
        }

        .login-title {
            color: #0a1f44;
        }

        .btn-depe {
            background: linear-gradient(90deg, #144a9c, #1d5fd1);
            border: none;
        }

        .btn-depe:hover {
            opacity: 0.9;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center p-3">

    <div class="container" style="max-width: 420px;">
        <div class="card shadow-lg border-0 login-card">
            <div class="card-body p-4">

                <div class="text-center mb-4">
                    <h4 class="fw-bold login-title mb-1">DEPE</h4>
                    <p class="text-muted mb-0 small">
                        Departamento de Estágios e Práticas Escolares
                    </p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="masp" class="form-label fw-bold">MASP</label>
                        <input
                            id="masp"
                            name="masp"
                            type="text"
                            class="form-control"
                            value="{{ old('masp') }}"
                            required
                            autofocus
                        >
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">Senha</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="form-control"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-primary btn-depe w-100 fw-bold py-2">
                        Entrar
                    </button>
                </form>

                <div class="text-center mt-4 small text-muted">
                    © {{ date('Y') }} - Unimontes / DEPE
                </div>

            </div>
        </div>
    </div>

    {{-- Bootstrap JS (CDN) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
