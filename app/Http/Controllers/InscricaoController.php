<?php

namespace App\Http\Controllers;

use App\Http\Requests\CriarInscricaoRequest;
use App\Models\Evento;
use App\Models\Inscricao;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class InscricaoController extends Controller
{
    public function store(CriarInscricaoRequest $request, Evento $evento): RedirectResponse
    {
        $this->authorize('create', [Inscricao::class, $evento]);

        DB::transaction(function () use ($request, $evento): void {
            $evento = Evento::query()->lockForUpdate()->findOrFail($evento->id);

            if (! $evento->possuiVagas()) {
                throw ValidationException::withMessages([
                    'evento' => 'Este evento não possui mais vagas disponíveis.',
                ]);
            }

            $inscricao = Inscricao::query()
                ->where('evento_id', $evento->id)
                ->where('usuario_id', $request->user()->id)
                ->first();

            if ($inscricao?->status === 'confirmada') {
                throw ValidationException::withMessages([
                    'evento' => 'Você já está inscrito neste evento.',
                ]);
            }

            Inscricao::query()->updateOrCreate(
                [
                    'evento_id' => $evento->id,
                    'usuario_id' => $request->user()->id,
                ],
                ['status' => 'confirmada'],
            );
        });

        return to_route('eventos.show', $evento)->with('sucesso', 'Inscrição realizada com sucesso.');
    }

    public function destroy(Inscricao $inscricao): RedirectResponse
    {
        $this->authorize('delete', $inscricao);

        $inscricao->update(['status' => 'cancelada']);

        return to_route('inscricoes.minhas')->with('sucesso', 'Inscrição cancelada com sucesso.');
    }

    public function minhasInscricoes(): View
    {
        return view('inscricoes.minhas', [
            'inscricoes' => auth()->user()->inscricoes()->with(['evento.categoria'])->latest()->get(),
        ]);
    }

    public function participantes(Evento $evento): View
    {
        $this->authorize('viewParticipants', [Inscricao::class, $evento]);

        return view('inscricoes.participantes', [
            'evento' => $evento,
            'inscricoes' => $evento->inscricoesConfirmadas()->with('usuario')->get(),
        ]);
    }
}
