<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'DEPE')</title>

    {{-- Bootstrap 5 (CDN) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(90deg, #0a1f44, #144a9c);">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">
            DEPE
        </a>

        <div class="d-flex align-items-center gap-3">
            @auth
                <span class="text-white small">
                    {{ auth()->user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-light btn-sm" type="submit">Sair</button>
                </form>
            @endauth
        </div>
    </div>
</nav>

<main class="container py-4">
    @yield('content')
</main>

{{-- Bootstrap JS (CDN) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
