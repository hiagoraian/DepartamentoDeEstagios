<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - DEPE</title>

    <style>
        :root {
            --blue-900: #0a1f44;
            --blue-700: #144a9c;
            --blue-600: #1d5fd1;
            --blue-100: #eaf2ff;
            --gray-100: #f5f7fb;
            --gray-400: #94a3b8;
            --gray-700: #334155;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--blue-900), var(--blue-700));
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            background: var(--white);
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0px 10px 35px rgba(0, 0, 0, 0.25);
        }

        .logo-area {
            text-align: center;
            margin-bottom: 25px;
        }

        .logo-area img {
            max-width: 220px;
            margin-bottom: 10px;
        }

        .logo-area h1 {
            font-size: 18px;
            color: var(--blue-900);
            font-weight: bold;
        }

        .logo-area p {
            font-size: 13px;
            color: var(--gray-700);
            margin-top: 4px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: bold;
            color: var(--blue-900);
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #d0d7e2;
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            transition: 0.2s;
            background: var(--gray-100);
        }

        input:focus {
            border-color: var(--blue-600);
            box-shadow: 0 0 0 3px rgba(29, 95, 209, 0.2);
            background: var(--white);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(90deg, var(--blue-700), var(--blue-600));
            border: none;
            border-radius: 10px;
            color: var(--white);
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-login:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .error-box {
            background: #ffecec;
            border: 1px solid #ffb3b3;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 14px;
            color: #b00020;
        }

        .footer {
            text-align: center;
            margin-top: 18px;
            font-size: 12px;
            color: var(--gray-400);
        }
    </style>
</head>

<body>
    <div class="login-container">

        <div class="logo-area">
            {{-- Coloque sua logo aqui se quiser --}}
            {{-- <img src="{{ asset('img/logo.png') }}" alt="Logo Unimontes"> --}}

            <h1>DEPE - Relatórios Semestrais</h1>
            <p>Departamento de Estágios e Práticas Escolares</p>
        </div>

        @if ($errors->any())
            <div class="error-box">
                <ul style="margin-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <div class="form-group">
                <label for="masp">MASP</label>
                <input id="masp" name="masp" type="text" value="{{ old('masp') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Senha</label>
                <input id="password" name="password" type="password" required>
            </div>

            <button class="btn-login" type="submit">Entrar</button>
        </form>

        <div class="footer">
            © {{ date('Y') }} - Unimontes / DEPE
        </div>

    </div>
</body>
</html>
