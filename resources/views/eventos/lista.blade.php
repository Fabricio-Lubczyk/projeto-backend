@extends('estruturas.principal')

@section('titulo', 'Eventos')

@section('conteudo')

<h1>Eventos</h1>

<a href="{{ route('eventos.create') }}" class="botao">
    Novo evento
</a>

@if($eventos->isEmpty())

    <p>Nenhum evento cadastrado.</p>

@else

    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Categoria</th>
                <th>Organizador</th>
                <th>Data</th>
                <th>Horário</th>
                <th>Local</th>
                <th>Limite de participantes</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>

            @foreach($eventos as $evento)

                <tr>

                    <td>
                        {{ $evento->titulo }}
                    </td>

                    <td>
                        {{ $evento->categoria->nome }}
                    </td>

                    <td>
                        {{ $evento->organizador->name }}
                    </td>

                    <td>
                        {{ $evento->data_evento->format('d/m/Y') }}
                    </td>

                    <td>
                        {{ substr($evento->horario_inicio, 0, 5) }}
                        -
                        {{ substr($evento->horario_fim, 0, 5) }}
                    </td>

                    <td>
                        {{ $evento->local }}
                    </td>

                    <td class="vagas">
                        {{ $evento->max_participantes }}
                    </td>

                    <td>
                        <span class="status status-{{ $evento->status }}">
                            {{ ucfirst($evento->status) }}
                        </span>
                    </td>

                    <td>

                        <div class="acoes">

                            <a
                                href="{{ route('eventos.show', $evento) }}"
                                class="botao"
                            >
                                Visualizar
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

                        </div>

                    </td>

                </tr>

            @endforeach

        </tbody>
    </table>

@endif

@endsection