@extends('estruturas.principal')

@section('titulo', 'Cadastrar Evento')

@section('conteudo')

<h1>Cadastrar Evento</h1>

<form action="{{ route('eventos.store') }}" method="POST">

    @csrf

    <div class="campo">
        <label for="categoria_evento_id">Categoria</label>

        <select name="categoria_evento_id" id="categoria_evento_id">
            <option value="">Selecione uma categoria</option>

            @foreach($categorias as $categoria)
                <option
                    value="{{ $categoria->id }}"
                    @selected(old('categoria_evento_id') == $categoria->id)
                >
                    {{ $categoria->nome }}
                </option>
            @endforeach
        </select>

        @error('categoria_evento_id')
            <div class="erro">{{ $message }}</div>
        @enderror
    </div>

    <div class="campo">
        <label for="titulo">Título</label>

        <input
            type="text"
            name="titulo"
            id="titulo"
            value="{{ old('titulo') }}"
        >

        @error('titulo')
            <div class="erro">{{ $message }}</div>
        @enderror
    </div>

    <div class="campo">
        <label for="descricao">Descrição</label>

        <textarea
            name="descricao"
            id="descricao"
        >{{ old('descricao') }}</textarea>

        @error('descricao')
            <div class="erro">{{ $message }}</div>
        @enderror
    </div>

    <div class="campo">
        <label for="local">Local</label>

        <input
            type="text"
            name="local"
            id="local"
            value="{{ old('local') }}"
        >

        @error('local')
            <div class="erro">{{ $message }}</div>
        @enderror
    </div>

    <div class="campo">
        <label for="data_evento">Data do evento</label>

        <input
            type="date"
            name="data_evento"
            id="data_evento"
            value="{{ old('data_evento') }}"
        >

        @error('data_evento')
            <div class="erro">{{ $message }}</div>
        @enderror
    </div>

    <div class="campo">
        <label for="horario_inicio">Horário de início</label>

        <input
            type="time"
            name="horario_inicio"
            id="horario_inicio"
            value="{{ old('horario_inicio') }}"
        >

        @error('horario_inicio')
            <div class="erro">{{ $message }}</div>
        @enderror
    </div>

    <div class="campo">
        <label for="horario_fim">Horário de término</label>

        <input
            type="time"
            name="horario_fim"
            id="horario_fim"
            value="{{ old('horario_fim') }}"
        >

        @error('horario_fim')
            <div class="erro">{{ $message }}</div>
        @enderror
    </div>

    <div class="campo">
        <label for="max_participantes">
            Número máximo de participantes
        </label>

        <input
            type="number"
            name="max_participantes"
            id="max_participantes"
            min="1"
            value="{{ old('max_participantes') }}"
        >

        @error('max_participantes')
            <div class="erro">{{ $message }}</div>
        @enderror
    </div>

    <div class="campo">
        <label for="status">Status</label>

        <select name="status" id="status">
            <option value="ativo" @selected(old('status') === 'ativo')>
                Ativo
            </option>

            <option value="inativo" @selected(old('status') === 'inativo')>
                Inativo
            </option>

            <option value="cancelado" @selected(old('status') === 'cancelado')>
                Cancelado
            </option>
        </select>

        @error('status')
            <div class="erro">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="botao">
        Cadastrar evento
    </button>

    <a href="{{ route('eventos.index') }}" class="botao">
        Voltar
    </a>

</form>

@endsection