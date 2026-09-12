@extends('estruturas.principal')

@section('titulo', 'Cadastrar Categoria')

@section('conteudo')

<h1>Cadastrar Categoria</h1>

<form
    action="{{ route('categorias-eventos.store') }}"
    method="POST"
>

    @csrf

    <div class="campo">

        <label for="nome">Nome</label>

        <input
            type="text"
            name="nome"
            id="nome"
            value="{{ old('nome') }}"
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
        >{{ old('descricao') }}</textarea>

        @error('descricao')
            <div class="erro">
                {{ $message }}
            </div>
        @enderror

    </div>

    <button type="submit" class="botao">
        Salvar
    </button>

    <a
        href="{{ route('categorias-eventos.index') }}"
        class="botao"
    >
        Voltar
    </a>

</form>

@endsection