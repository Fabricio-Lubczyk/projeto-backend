@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<label for="title">Título</label>
<input id="title" name="title" type="text" value="{{ old('title', $event?->title) }}" required>

<label for="category_id">Categoria</label>
<select id="category_id" name="category_id" required>
    <option value="">Selecione</option>
    @foreach ($categories as $category)
        <option value="{{ $category->id }}" @selected(old('category_id', $event?->category_id) == $category->id)>
            {{ $category->name }}
        </option>
    @endforeach
</select>

<label for="venue_id">Local</label>
<select id="venue_id" name="venue_id" required>
    <option value="">Selecione</option>
    @foreach ($venues as $venue)
        <option value="{{ $venue->id }}" @selected(old('venue_id', $event?->venue_id) == $venue->id)>
            {{ $venue->name }}
        </option>
    @endforeach
</select>

<label for="starts_at">Início</label>
<input id="starts_at" name="starts_at" type="datetime-local" value="{{ old('starts_at', $event?->starts_at?->format('Y-m-d\TH:i')) }}" required>

<label for="ends_at">Fim</label>
<input id="ends_at" name="ends_at" type="datetime-local" value="{{ old('ends_at', $event?->ends_at?->format('Y-m-d\TH:i')) }}">

<label for="capacity">Capacidade</label>
<input id="capacity" name="capacity" type="number" min="1" value="{{ old('capacity', $event?->capacity) }}" required>

<label for="status">Status</label>
<select id="status" name="status" required>
    @foreach (['rascunho', 'publicado', 'cancelado'] as $status)
        <option value="{{ $status }}" @selected(old('status', $event?->status ?? 'rascunho') === $status)>
            {{ ucfirst($status) }}
        </option>
    @endforeach
</select>

<label for="description">Descrição</label>
<textarea id="description" name="description">{{ old('description', $event?->description) }}</textarea>

<button type="submit">{{ $buttonLabel }}</button>
