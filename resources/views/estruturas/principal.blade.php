<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('titulo', 'Sistema de Eventos')</title>

    <style>
        * {
            box-sizing: border-box;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 14px;
            font-weight: bold;
        }

        .status-ativo {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-inativo {
            background-color: #f3f4f6;
            color: #374151;
        }

        .status-cancelado {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .vagas {
            font-weight: bold;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            color: #1f2937;
            line-height: 1.5;
        }

        .container {
            width: min(100%, 1000px);
            max-width: 1000px;
            margin: 20px auto;
            background-color: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        }

        .navegacao {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #ddd;
        }

        .navegacao a {
            color: #333;
            font-weight: bold;
            text-decoration: none;
        }

        .navegacao a:hover,
        .link-navegacao:hover {
            color: #2563eb;
        }

        .navegacao form {
            display: flex;
            margin: 0;
        }

        .link-navegacao {
            padding: 0;
            border: 0;
            color: #333;
            cursor: pointer;
            font-weight: bold;
        }

        h1 {
            margin-top: 0;
        }

        .botao {
            display: inline-block;
            padding: 10px 15px;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #333;
            color: white;
            font: inherit;
            text-align: center;
            transition: background-color 0.2s ease, transform 0.2s ease;
        }

        .botao:hover {
            background-color: #111827;
            transform: translateY(-1px);
        }

        .botao-perigo {
            background-color: #b91c1c;
        }

        .tabela-responsiva {
            overflow-x: auto;
            margin-top: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        table {
            width: 100%;
            min-width: 680px;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .campo {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, textarea, select {
            width: 100%;
            padding: 9px;
            border: 1px solid #9ca3af;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input:focus, textarea:focus, select:focus {
            outline: 2px solid #93c5fd;
            border-color: #2563eb;
        }

        textarea {
            min-height: 100px;
        }

        .sucesso {
            background-color: #dcfce7;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .erro {
            background-color: #fee2e2;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .acoes {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
        }

        form {
            margin: 0;
        }

        @media (max-width: 640px) {
            body {
                padding: 10px;
            }

            .container {
                margin: 0 auto;
                padding: 18px;
                border-radius: 8px;
            }

            .navegacao {
                gap: 10px 14px;
            }

            h1 {
                font-size: 1.6rem;
            }

            .botao {
                width: 100%;
            }

            .acoes {
                align-items: stretch;
            }

            .acoes .botao,
            .acoes form {
                flex: 1 1 100%;
            }

            .acoes form .botao {
                width: 100%;
            }

            .tabela-responsiva {
                margin-inline: -18px;
                border-inline: 0;
                border-radius: 0;
            }

            table {
                min-width: 620px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <nav class="navegacao">
        <a href="{{ route('eventos.index') }}">Eventos</a>

        @auth
            <a href="{{ route('inscricoes.minhas') }}">Minhas inscrições</a>
            <a href="{{ route('dashboard') }}">Painel</a>

            @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                <a href="{{ route('categorias-eventos.index') }}">Categorias</a>
            @endif

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="link-navegacao">Sair</button>
            </form>
        @else
            <a href="{{ route('login') }}">Entrar</a>
            <a href="{{ route('register') }}">Cadastrar</a>
        @endauth
    </nav>

    @if(session('sucesso'))
        <div class="sucesso">
            {{ session('sucesso') }}
        </div>
    @endif

    @if(session('erro'))
        <div class="erro">
            {{ session('erro') }}
        </div>
    @endif

    @if($errors->any())
        <div class="erro">
            <ul>
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('conteudo')

</div>

</body>
</html>
