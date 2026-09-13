<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Evento;
use App\Models\Inscricao;
use App\Models\User;

class InscricaoPolicy
{
    public function create(User $user, Evento $evento): bool
    {
        return $evento->status === 'ativo';
    }

    public function delete(User $user, Inscricao $inscricao): bool
    {
        return $user->role === UserRole::Admin || $inscricao->usuario_id === $user->id;
    }

    public function viewParticipants(User $user, Evento $evento): bool
    {
        return $user->role === UserRole::Admin || $evento->usuario_id === $user->id;
    }
}
