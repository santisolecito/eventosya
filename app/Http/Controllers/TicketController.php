<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function store(Request $request, Event $event)
    {
        if ($event->organizer_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $data = $request->validate([
            'name'      => 'required|string|max:100',
            'price'     => 'required|numeric|min:0',
            'total_qty' => 'required|integer|min:1',
        ]);

        $data['event_id'] = $event->id;
        Ticket::create($data);

        return redirect()->route('organizer.events.show', $event)
            ->with('success', 'Tipo de ticket agregado.');
    }

    public function destroy(Ticket $ticket)
    {
        $event = $ticket->event;

        if ($event->organizer_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $ticket->delete();

        return redirect()->route('organizer.events.show', $event)
            ->with('success', 'Ticket eliminado.');
    }
}
