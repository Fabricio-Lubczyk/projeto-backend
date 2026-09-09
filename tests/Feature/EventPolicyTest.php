<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_organizer_can_create_and_update_own_event(): void
    {
        $organizer = User::factory()->create([
            'role' => UserRole::Organizer,
        ]);

        $event = $this->createEvent($organizer);

        $this->assertTrue($organizer->can('create', Event::class));
        $this->assertTrue($organizer->can('update', $event));
    }

    public function test_another_organizer_cannot_update_event_from_someone_else(): void
    {
        $event = $this->createEvent(User::factory()->create([
            'role' => UserRole::Organizer,
        ]));

        $anotherOrganizer = User::factory()->create([
            'role' => UserRole::Organizer,
        ]);

        $this->assertFalse($anotherOrganizer->can('update', $event));
    }

    public function test_participant_cannot_create_events(): void
    {
        $participant = User::factory()->create([
            'role' => UserRole::Participant,
        ]);

        $this->assertFalse($participant->can('create', Event::class));
    }

    public function test_event_capacity_cannot_exceed_venue_capacity(): void
    {
        $organizer = User::factory()->create([
            'role' => UserRole::Organizer,
        ]);

        $category = Category::create([
            'name' => 'Palestra',
        ]);

        $venue = Venue::create([
            'name' => 'Auditório',
            'address' => 'Bloco A',
            'capacity' => 50,
        ]);

        $this->actingAs($organizer)
            ->post(route('events.store'), [
                'category_id' => $category->id,
                'venue_id' => $venue->id,
                'title' => 'Evento teste',
                'starts_at' => '2026-10-10 14:00:00',
                'capacity' => 51,
                'status' => 'rascunho',
            ])
            ->assertSessionHasErrors('capacity');

        $this->assertDatabaseCount('events', 0);
    }

    private function createEvent(User $organizer): Event
    {
        $category = Category::create([
            'name' => 'Workshop',
        ]);

        $venue = Venue::create([
            'name' => 'Sala Multiuso',
            'address' => 'Bloco B, sala 12',
            'capacity' => 60,
        ]);

        return $organizer->events()->create([
            'category_id' => $category->id,
            'venue_id' => $venue->id,
            'title' => 'Introdução ao Laravel',
            'starts_at' => '2026-10-10 14:00:00',
            'capacity' => 30,
            'status' => 'rascunho',
        ]);
    }
}
