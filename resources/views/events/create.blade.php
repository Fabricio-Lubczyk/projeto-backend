<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo evento</title>
</head>
<body>
    <h1>Novo evento</h1>

    <form action="{{ route('events.store') }}" method="POST">
        @csrf
        @include('events._form', ['buttonLabel' => 'Cadastrar'])
    </form>

    <p><a href="{{ route('events.index') }}">Voltar</a></p>
</body>
</html>
