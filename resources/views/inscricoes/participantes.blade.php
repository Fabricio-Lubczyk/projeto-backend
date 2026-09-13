@extends('estruturas.principal')

@section('titulo', 'Participantes do evento')

@section('conteudo')

<h1>Participantes: {{ $evento->titulo }}</h1>

<a href="{{ route('eventos.show', $evento) }}" class="botao">Voltar ao evento</a>

@if($inscricoes->isEmpty())
    <p>Nenhum participante confirmado até o momento.</p>
@else
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Inscrito em</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inscricoes as $inscricao)
                <tr>
                    <td>{{ $inscricao->usuario->name }}</td>
                    <td>{{ $inscricao->usuario->email }}</td>
                    <td>{{ $inscricao->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

@endsection
