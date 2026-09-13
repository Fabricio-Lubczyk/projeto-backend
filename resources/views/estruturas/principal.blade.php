<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('titulo', 'Sistema de Eventos')</title>

    <style>
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
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin: 40px auto;
            background-color: white;
            padding: 25px;
            border-radius: 8px;
        }

        .navegacao {
            display: flex;
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
        }

        .botao-perigo {
            background-color: #b91c1c;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
            box-sizing: border-box;
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
        }

        form {
            margin: 0;
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
