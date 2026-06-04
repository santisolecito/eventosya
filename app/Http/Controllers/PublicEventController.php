<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;

class PublicEventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('category', 'organizer', 'tickets')
            ->where('active', true)
            ->where('event_date', '>=', today());

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $events     = $query->orderBy('event_date')->paginate(9)->withQueryString();
        $categories = Category::all();

        return view('events.index', compact('events', 'categories'));
    }

    public function show(Event $event)
    {
        $event->load('category', 'organizer', 'tickets');
        return view('events.show', compact('event'));
    }
}
