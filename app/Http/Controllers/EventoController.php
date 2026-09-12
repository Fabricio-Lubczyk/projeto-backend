<?php

namespace App\Http\Controllers;

use App\Models\CategoriaEvento;
use App\Models\Evento;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $dados = $request->validate([
            'categoria_evento_id' => 'required|exists:categorias_eventos,id',
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'local' => 'required|string|max:255',
            'data_evento' => 'required|date',
            'horario_inicio' => 'required',
            'horario_fim' => 'required',
            'max_participantes' => 'required|integer|min:1',
            'status' => 'required|string|max:50',
        ]);

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
        $categorias = CategoriaEvento::orderBy('nome')->get();

        return view('eventos.edit', compact('evento', 'categorias'));
    }

    public function update(Request $request, Evento $evento)
    {
        $dados = $request->validate([
            'categoria_evento_id' => 'required|exists:categorias_eventos,id',
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'local' => 'required|string|max:255',
            'data_evento' => 'required|date',
            'horario_inicio' => 'required',
            'horario_fim' => 'required',
            'max_participantes' => 'required|integer|min:1',
            'status' => 'required|string|max:50',
        ]);

        $evento->update($dados);

        return redirect()
            ->route('eventos.show', $evento)
            ->with('sucesso', 'Evento atualizado com sucesso.');
    }

    public function destroy(Evento $evento)
    {
        $evento->delete();

        return redirect()
            ->route('eventos.index')
            ->with('sucesso', 'Evento excluído com sucesso.');
    }
}