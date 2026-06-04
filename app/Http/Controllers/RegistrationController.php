<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function index()
    {
        $registrations = Auth::user()->registrations()
            ->with('ticket.event')
            ->latest()
            ->paginate(10);

        return view('attendee.registrations.index', compact('registrations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
        ]);

        $ticket = Ticket::findOrFail($request->ticket_id);

        if (!$ticket->event->active) {
            return back()->with('error', 'Este evento no está disponible.');
        }

        $yaRegistrado = Auth::user()->registrations()
            ->whereHas('ticket', fn($q) => $q->where('event_id', $ticket->event_id))
            ->where('status', 'active')
            ->exists();

        if ($yaRegistrado) {
            return back()->with('error', 'Ya tienes una entrada para este evento.');
        }

        DB::transaction(function () use ($ticket) {
            $ticket->refresh();
            if (!$ticket->hasStock()) {
                throw new \Exception('No hay cupos disponibles.');
            }

            Registration::create([
                'ticket_id'     => $ticket->id,
                'user_id'       => Auth::id(),
                'status'        => 'active',
                'registered_at' => now(),
            ]);

            $ticket->increment('sold_qty');
        });

        return redirect()->route('attendee.registrations.index')
            ->with('success', '¡Registro exitoso! Tu entrada ha sido generada.');
    }

    public function cancel(Registration $registration)
    {
        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }

        if ($registration->status !== 'active') {
            return back()->with('error', 'Esta entrada ya fue cancelada.');
        }

        DB::transaction(function () use ($registration) {
            $registration->update(['status' => 'cancelled']);
            $registration->ticket->decrement('sold_qty');
        });

        return back()->with('success', 'Entrada cancelada.');
    }
}
