@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<label for="name">Nome</label>
<input id="name" name="name" type="text" value="{{ old('name', $category?->name) }}" required>

<label for="description">Descrição</label>
<textarea id="description" name="description">{{ old('description', $category?->description) }}</textarea>

<button type="submit">{{ $buttonLabel }}</button>
