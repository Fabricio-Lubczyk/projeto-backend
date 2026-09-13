<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@sistemaeventos.test'],
            [
                'name' => 'Administrador',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => UserRole::Admin,
            ],
        );

        User::query()->updateOrCreate(
            ['email' => 'organizador@sistemaeventos.test'],
            [
                'name' => 'Organizador',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => UserRole::Organizer,
            ],
        );

        User::query()->updateOrCreate(
            ['email' => 'participante@sistemaeventos.test'],
            [
                'name' => 'Participante',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => UserRole::Participant,
            ],
        );
    }
}
