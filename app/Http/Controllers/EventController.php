<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Auth::user()->events()->with('category')->latest()->paginate(10);
        return view('organizer.events.index', compact('events'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('organizer.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'venue'        => 'required|string|max:255',
            'city'         => 'required|string|max:100',
            'event_date'   => 'required|date|after:today',
            'event_time'   => 'required',
            'cover_image'  => 'nullable|image|max:2048',
            'active'       => 'boolean',
        ]);

        $data['organizer_id'] = Auth::id();
        $data['active'] = $request->boolean('active', true);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('events', 'public');
        }

        $event = Event::create($data);

        return redirect()->route('organizer.events.show', $event)
            ->with('success', 'Evento creado correctamente.');
    }

    public function show(Event $event)
    {
        $this->authorizeOrganizer($event);
        $event->load('tickets', 'category');
        return view('organizer.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $this->authorizeOrganizer($event);
        $categories = Category::all();
        return view('organizer.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorizeOrganizer($event);

        $data = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'venue'        => 'required|string|max:255',
            'city'         => 'required|string|max:100',
            'event_date'   => 'required|date',
            'event_time'   => 'required',
            'cover_image'  => 'nullable|image|max:2048',
            'active'       => 'boolean',
        ]);

        $data['active'] = $request->boolean('active');

        if ($request->hasFile('cover_image')) {
            if ($event->cover_image) {
                Storage::disk('public')->delete($event->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('events', 'public');
        }

        $event->update($data);

        return redirect()->route('organizer.events.show', $event)
            ->with('success', 'Evento actualizado.');
    }

    public function destroy(Event $event)
    {
        $this->authorizeOrganizer($event);
        $event->delete();
        return redirect()->route('organizer.events.index')
            ->with('success', 'Evento eliminado.');
    }

    private function authorizeOrganizer(Event $event): void
    {
        if ($event->organizer_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }
    }
}
