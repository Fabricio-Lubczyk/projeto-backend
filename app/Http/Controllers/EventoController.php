<?php

namespace App\Http\Controllers;

use App\Models\CategoriaEvento;
use App\Models\Evento;
use App\Http\Requests\CriarEventoRequest;
use App\Http\Requests\AtualizarEventoRequest;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::with(['categoria', 'organizador'])
            ->orderBy('data_evento')
            ->orderBy('horario_inicio')
            ->get();

        return view('eventos.lista', compact('eventos'));
    }

    public function create()
    {
        $categorias = CategoriaEvento::orderBy('nome')->get();

        return view('eventos.criar', compact('categorias'));
    }
    public function store(CriarEventoRequest $request)
    {
        if (!auth()->check()) {
            abort(403, 'Você precisa estar autenticado para criar um evento.');
        }

        $dados = $request->validated();

        $dados['usuario_id'] = auth()->id();

        Evento::create($dados);

        return redirect()
            ->route('eventos.index')
            ->with('sucesso', 'Evento criado com sucesso.');
    }   

   public function show(Evento $evento)
    {
        $evento->load(['categoria', 'organizador']);
    
        return view('eventos.detalhes', compact('evento'));
    }

    public function edit(Evento $evento)
    {
        if (!auth()->check()) {
            abort(403, 'Você precisa estar autenticado.');
        }

        if ($evento->usuario_id !== auth()->id()) {
            abort(403, 'Você não possui permissão para editar este evento.');
        }

        $categorias = CategoriaEvento::orderBy('nome')->get();

        return view('eventos.editar', compact('evento', 'categorias'));
    }

    public function update(
    AtualizarEventoRequest $request,
    Evento $evento
    ) {
        if (!auth()->check()) {
            abort(403, 'Você precisa estar autenticado.');
        }

        if ($evento->usuario_id !== auth()->id()) {
            abort(403, 'Você não possui permissão para editar este evento.');
        }

        $dados = $request->validated();

        $evento->update($dados);

        return redirect()
            ->route('eventos.show', $evento)
            ->with('sucesso', 'Evento atualizado com sucesso.');
    }

    public function destroy(Evento $evento)
    {
        if (!auth()->check()) {
            abort(403, 'Você precisa estar autenticado.');
        }

        if ($evento->usuario_id !== auth()->id()) {
            abort(403, 'Você não possui permissão para excluir este evento.');
        }

        $evento->delete();

        return redirect()
            ->route('eventos.index')
            ->with('sucesso', 'Evento excluído com sucesso.');
    }
}