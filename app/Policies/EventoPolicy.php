<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Evento;
use App\Models\User;

class EventoPolicy
{
    public function create(User $user): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::Organizer], true);
    }

    public function update(User $user, Evento $evento): bool
    {
        return $user->role === UserRole::Admin || $evento->usuario_id === $user->id;
    }

    public function delete(User $user, Evento $evento): bool
    {
        return $this->update($user, $evento);
    }
}
