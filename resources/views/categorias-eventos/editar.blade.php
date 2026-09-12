@extends('estruturas.principal')

@section('titulo', 'Editar Categoria')

@section('conteudo')

<h1>Editar Categoria</h1>

<form
    action="{{ route('categorias-eventos.update', $categoriaEvento) }}"
    method="POST"
>

    @csrf
    @method('PUT')

    <div class="campo">

        <label for="nome">Nome</label>

        <input
            type="text"
            name="nome"
            id="nome"
            value="{{ old('nome', $categoriaEvento->nome) }}"
        >

        @error('nome')
            <div class="erro">
                {{ $message }}
            </div>
        @enderror

    </div>

    <div class="campo">

        <label for="descricao">Descrição</label>

        <textarea
            name="descricao"
            id="descricao"
        >{{ old('descricao', $categoriaEvento->descricao) }}</textarea>

        @error('descricao')
            <div class="erro">
                {{ $message }}
            </div>
        @enderror

    </div>

    <button type="submit" class="botao">
        Atualizar
    </button>

    <a
        href="{{ route('categorias-eventos.index') }}"
        class="botao"
    >
        Voltar
    </a>

</form>

@endsection
    