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
            style="display: inline-block;"
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