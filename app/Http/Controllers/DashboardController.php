<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $usuario = auth()->user();

        return view('dashboard', [
            'eventosAtivos' => Evento::query()->where('status', 'ativo')->count(),
            'minhasInscricoes' => $usuario->inscricoes()->where('status', 'confirmada')->count(),
            'eventosOrganizados' => $usuario->eventosOrganizados()->count(),
        ]);
    }
}
