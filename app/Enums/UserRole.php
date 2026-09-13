<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Organizer = 'organizador';
    case Participant = 'participante';
}
