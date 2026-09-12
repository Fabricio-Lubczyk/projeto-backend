@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<label for="name">Nome</label>
<input id="name" name="name" type="text" value="{{ old('name', $venue?->name) }}" required>

<label for="address">Endereço</label>
<input id="address" name="address" type="text" value="{{ old('address', $venue?->address) }}" required>

<label for="capacity">Capacidade</label>
<input id="capacity" name="capacity" type="number" min="1" value="{{ old('capacity', $venue?->capacity) }}" required>

<button type="submit">{{ $buttonLabel }}</button>
