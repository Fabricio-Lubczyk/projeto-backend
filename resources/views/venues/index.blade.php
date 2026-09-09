<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locais</title>
</head>
<body>
    <h1>Locais de eventos</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <p><a href="{{ route('venues.create') }}">Novo local</a></p>

    <ul>
        @forelse ($venues as $venue)
            <li>
                <strong>{{ $venue->name }}</strong>
                <span>- {{ $venue->address }} ({{ $venue->capacity }} pessoas)</span>

                <a href="{{ route('venues.edit', $venue) }}">Editar</a>

                <form action="{{ route('venues.destroy', $venue) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Excluir</button>
                </form>
            </li>
        @empty
            <li>Nenhum local cadastrado.</li>
        @endforelse
    </ul>

    {{ $venues->links() }}
</body>
</html>
