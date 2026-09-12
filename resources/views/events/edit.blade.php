<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar evento</title>
</head>
<body>
    <h1>Editar evento</h1>

    <form action="{{ route('events.update', $event) }}" method="POST">
        @csrf
        @method('PUT')
        @include('events._form', ['buttonLabel' => 'Salvar'])
    </form>

    <p><a href="{{ route('events.index') }}">Voltar</a></p>
</body>
</html>
