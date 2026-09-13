@extends('estruturas.principal')

@section('titulo', 'Categorias de Eventos')

@section('conteudo')

<h1>Categorias de Eventos</h1>

<a href="{{ route('categorias-eventos.create') }}" class="botao">
    Nova categoria
</a>

@if($categorias->isEmpty())

    <p>Nenhuma categoria cadastrada.</p>

@else

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            @foreach($categorias as $categoria)

                <tr>
                    <td>{{ $categoria->nome }}</td>

                    <td>
                        {{ $categoria->descricao ?? 'Sem descrição' }}
                    </td>

                    <td>
                        <div class="acoes">

                            <a
                                href="{{ route('categorias-eventos.edit', $categoria) }}"
                                class="botao"
                            >
                                Editar
                            </a>

                            <form
                                action="{{ route('categorias-eventos.destroy', $categoria) }}"
                                method="POST"
                                onsubmit="return confirm('Deseja realmente excluir esta categoria?')"
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

                        </div>
                    </td>
                </tr>

            @endforeach
        </tbody>
    </table>

@endif

@endsection