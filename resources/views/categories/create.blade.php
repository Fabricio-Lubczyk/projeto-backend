<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova categoria</title>
</head>
<body>
    <h1>Nova categoria</h1>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        @include('categories._form', ['buttonLabel' => 'Cadastrar'])
    </form>

    <p><a href="{{ route('categories.index') }}">Voltar</a></p>
</body>
</html>
