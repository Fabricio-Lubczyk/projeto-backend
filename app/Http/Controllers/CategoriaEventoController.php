<?php

namespace App\Http\Controllers;

use App\Models\CategoriaEvento;
use Illuminate\Http\Request;

class CategoriaEventoController extends Controller
{
    public function index()
    {
        $categorias = CategoriaEvento::orderBy('nome')->get();

        return view('categorias-eventos.lista', compact('categorias'));
    }

    public function create()
    {
        return view('categorias-eventos.criar');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255|unique:categorias_eventos,nome',
            'descricao' => 'nullable|string',
        ]);

        CategoriaEvento::create($dados);

        return redirect()
            ->route('categorias-eventos.index')
            ->with('sucesso', 'Categoria criada com sucesso.');
    }

    public function edit(CategoriaEvento $categoriaEvento)
    {
        return view(
            'categorias-eventos.editar',
            compact('categoriaEvento')
        );
    }

    public function update(Request $request, CategoriaEvento $categoriaEvento)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255|unique:categorias_eventos,nome,' . $categoriaEvento->id,
            'descricao' => 'nullable|string',
        ]);

        $categoriaEvento->update($dados);

        return redirect()
            ->route('categorias-eventos.index')
            ->with('sucesso', 'Categoria atualizada com sucesso.');
    }

    public function destroy(CategoriaEvento $categoriaEvento)
    {
        if ($categoriaEvento->eventos()->exists()) {
            return redirect()
                ->route('categorias-eventos.index')
                ->with('erro', 'Não é possível excluir uma categoria que possui eventos.');
        }

        $categoriaEvento->delete();

        return redirect()
            ->route('categorias-eventos.index')
            ->with('sucesso', 'Categoria excluída com sucesso.');
    }
}