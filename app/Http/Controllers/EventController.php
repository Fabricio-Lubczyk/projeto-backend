<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Category;
use App\Models\Event;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Event::class);

        return view('events.index', [
            'events' => Event::query()
                ->with(['category', 'venue', 'organizer'])
                ->orderBy('starts_at')
                ->paginate(10),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Event::class);

        return view('events.create', $this->formData());
    }

    public function store(EventRequest $request): RedirectResponse
    {
        $this->authorize('create', Event::class);

        $request->user()->events()->create($request->validated());

        return to_route('events.index')->with('success', 'Evento cadastrado com sucesso.');
    }

    public function edit(Event $event): View
    {
        $this->authorize('update', $event);

        return view('events.edit', $this->formData($event));
    }

    public function update(EventRequest $request, Event $event): RedirectResponse
    {
        $this->authorize('update', $event);

        $event->update($request->validated());

        return to_route('events.index')->with('success', 'Evento atualizado com sucesso.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $this->authorize('delete', $event);

        $event->delete();

        return to_route('events.index')->with('success', 'Evento removido com sucesso.');
    }

    /**
     * @return array<string, Category|Event|Venue|null|Collection<int, Category>|Collection<int, Venue>>
     */
    private function formData(?Event $event = null): array
    {
        return [
            'event' => $event,
            'categories' => Category::query()->orderBy('name')->get(),
            'venues' => Venue::query()->orderBy('name')->get(),
        ];
    }
}
