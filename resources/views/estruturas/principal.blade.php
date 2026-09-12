<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('titulo', 'Sistema de Eventos')</title>

    <style>
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

    @yield('conteudo')

</div>

</body>
</html>