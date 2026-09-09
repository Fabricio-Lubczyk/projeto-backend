<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias</title>
</head>
<body>
    <h1>Categorias</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <p><a href="{{ route('categories.create') }}">Nova categoria</a></p>

    <ul>
        @forelse ($categories as $category)
            <li>
                <strong>{{ $category->name }}</strong>

                @if ($category->description)
                    <span>- {{ $category->description }}</span>
                @endif

                <a href="{{ route('categories.edit', $category) }}">Editar</a>

                <form action="{{ route('categories.destroy', $category) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Excluir</button>
                </form>
            </li>
        @empty
            <li>Nenhuma categoria cadastrada.</li>
        @endforelse
    </ul>

    {{ $categories->links() }}
</body>
</html>
