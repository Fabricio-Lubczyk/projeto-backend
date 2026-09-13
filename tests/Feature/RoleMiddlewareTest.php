<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_a_route_restricted_by_role(): void
    {
        Route::get('/teste-acesso-admin', fn () => response()->noContent())
            ->middleware('role:admin');

        $user = User::factory()->create([
            'role' => UserRole::Admin,
        ]);

        $this->actingAs($user)
            ->get('/teste-acesso-admin')
            ->assertNoContent();
    }

    public function test_participant_cannot_access_an_administrative_route(): void
    {
        Route::get('/teste-acesso-participante', fn () => response()->noContent())
            ->middleware('role:admin');

        $user = User::factory()->create([
            'role' => UserRole::Participant,
        ]);

        $this->actingAs($user)
            ->get('/teste-acesso-participante')
            ->assertForbidden();
    }
}
