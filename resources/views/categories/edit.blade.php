<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar categoria</title>
</head>
<body>
    <h1>Editar categoria</h1>

    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        @include('categories._form', ['buttonLabel' => 'Salvar'])
    </form>

    <p><a href="{{ route('categories.index') }}">Voltar</a></p>
</body>
</html>
