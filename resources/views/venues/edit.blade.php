<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar local</title>
</head>
<body>
    <h1>Editar local</h1>

    <form action="{{ route('venues.update', $venue) }}" method="POST">
        @csrf
        @method('PUT')
        @include('venues._form', ['buttonLabel' => 'Salvar'])
    </form>

    <p><a href="{{ route('venues.index') }}">Voltar</a></p>
</body>
</html>
