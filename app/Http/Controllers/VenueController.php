<?php

namespace App\Http\Controllers;

use App\Http\Requests\VenueRequest;
use App\Models\Venue;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VenueController extends Controller
{
    public function index(): View
    {
        return view('venues.index', [
            'venues' => Venue::query()->orderBy('name')->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('venues.create', [
            'venue' => null,
        ]);
    }

    public function store(VenueRequest $request): RedirectResponse
    {
        Venue::create($request->validated());

        return to_route('venues.index')->with('success', 'Local cadastrado com sucesso.');
    }

    public function edit(Venue $venue): View
    {
        return view('venues.edit', compact('venue'));
    }

    public function update(VenueRequest $request, Venue $venue): RedirectResponse
    {
        $venue->update($request->validated());

        return to_route('venues.index')->with('success', 'Local atualizado com sucesso.');
    }

    public function destroy(Venue $venue): RedirectResponse
    {
        if ($venue->events()->exists()) {
            return to_route('venues.index')->with('error', 'Não é possível excluir um local vinculado a eventos.');
        }

        $venue->delete();

        return to_route('venues.index')->with('success', 'Local removido com sucesso.');
    }
}
