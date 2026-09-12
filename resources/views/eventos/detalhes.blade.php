@extends('estruturas.principal')

@section('titulo', 'Detalhes do Evento')

@section('conteudo')

<h1>{{ $evento->titulo }}</h1>

<p>
    <strong>Categoria:</strong>
    {{ $evento->categoria->nome }}
</p>

<p>
    <strong>Organizador:</strong>
    {{ $evento->organizador->name }}
</p>

<p>
    <strong>Descrição:</strong>
    {{ $evento->descricao }}
</p>

<p>
    <strong>Local:</strong>
    {{ $evento->local }}
</p>

<p>
    <strong>Data:</strong>
    {{ $evento->data_evento->format('d/m/Y') }}
</p>

<p>
    <strong>Horário:</strong>
    {{ substr($evento->horario_inicio, 0, 5) }}
    até
    {{ substr($evento->horario_fim, 0, 5) }}
</p>

<p>
    <strong>Limite de participantes:</strong>

    <span class="vagas">
        {{ $evento->max_participantes }}
    </span>
</p>

<p>
    <strong>Status:</strong>

    <span class="status status-{{ $evento->status }}">
        {{ ucfirst($evento->status) }}
    </span>
</p>

<a
    href="{{ route('eventos.index') }}"
    class="botao"
>
    Voltar
</a>

@auth

    @if(auth()->id() === $evento->usuario_id)

        <a
            href="{{ route('eventos.edit', $evento) }}"
            class="botao"
        >
            Editar
        </a>

        <form
            action="{{ route('eventos.destroy', $evento) }}"
            method="POST"
            style="display: inline-block;"
            onsubmit="return confirm('Deseja realmente excluir este evento?')"
        >

            @csrf
            @method('DELETE')

            <button
                type="submit"
                class="botao botao-perigo"
            >
                Excluir
            </button>

        </form>

    @endif

@endauth

@endsection