<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
</head>
<body>
    <h1>Eventos</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @can('create', \App\Models\Event::class)
        <p><a href="{{ route('events.create') }}">Novo evento</a></p>
    @endcan

    <ul>
        @forelse ($events as $event)
            <li>
                <strong>{{ $event->title }}</strong>
                <span>- {{ $event->starts_at->format('d/m/Y H:i') }}</span>
                <span>({{ $event->category->name }} em {{ $event->venue->name }})</span>

                @if ($event->description)
                    <p>{{ $event->description }}</p>
                @endif

                <p>Organizador: {{ $event->organizer->name }}</p>

                @can('update', $event)
                    <a href="{{ route('events.edit', $event) }}">Editar</a>
                @endcan

                @can('delete', $event)
                    <form action="{{ route('events.destroy', $event) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Excluir</button>
                    </form>
                @endcan
            </li>
        @empty
            <li>Nenhum evento cadastrado.</li>
        @endforelse
    </ul>

    {{ $events->links() }}
</body>
</html>
