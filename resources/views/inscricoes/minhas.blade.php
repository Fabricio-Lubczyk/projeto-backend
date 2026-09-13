@extends('estruturas.principal')

@section('titulo', 'Minhas inscrições')

@section('conteudo')

<h1>Minhas inscrições</h1>

<a href="{{ route('eventos.index') }}" class="botao">Ver eventos</a>

@if($inscricoes->isEmpty())
    <p>Você ainda não possui inscrições em eventos.</p>
@else
    <table>
        <thead>
            <tr>
                <th>Evento</th>
                <th>Categoria</th>
                <th>Data</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inscricoes as $inscricao)
                <tr>
                    <td>{{ $inscricao->evento->titulo }}</td>
                    <td>{{ $inscricao->evento->categoria->nome }}</td>
                    <td>{{ $inscricao->evento->data_evento->format('d/m/Y') }}</td>
                    <td>{{ ucfirst($inscricao->status) }}</td>
                    <td class="acoes">
                        <a href="{{ route('eventos.show', $inscricao->evento) }}" class="botao">Visualizar</a>

                        @if($inscricao->status === 'confirmada')
                            <form action="{{ route('inscricoes.destroy', $inscricao) }}" method="POST" onsubmit="return confirm('Deseja cancelar esta inscrição?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="botao botao-perigo">Cancelar</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

@endsection
