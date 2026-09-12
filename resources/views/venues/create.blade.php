<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo local</title>
</head>
<body>
    <h1>Novo local</h1>

    <form action="{{ route('venues.store') }}" method="POST">
        @csrf
        @include('venues._form', ['buttonLabel' => 'Cadastrar'])
    </form>

    <p><a href="{{ route('venues.index') }}">Voltar</a></p>
</body>
</html>
