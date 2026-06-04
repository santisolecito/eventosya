@extends('layouts.app')
@section('title', $event->title)

@section('content')
<div class="row">
    <div class="col-lg-8">
        @if($event->cover_image)
            <img src="{{ Storage::url($event->cover_image) }}" class="img-fluid rounded mb-4 w-100" style="max-height:350px;object-fit:cover;">
        @endif

        <span class="badge bg-warning text-dark mb-2">{{ $event->category->name }}</span>
        <h1 class="mb-3">{{ $event->title }}</h1>

        <ul class="list-unstyled text-muted mb-4">
            <li class="mb-1"><i class="bi bi-geo-alt-fill me-2 text-danger"></i>{{ $event->venue }}, {{ $event->city }}</li>
            <li class="mb-1"><i class="bi bi-calendar-fill me-2 text-primary"></i>{{ $event->event_date->format('d \d\e F \d\e Y') }}</li>
            <li class="mb-1"><i class="bi bi-clock-fill me-2 text-success"></i>{{ \Carbon\Carbon::parse($event->event_time)->format('H:i') }} hrs</li>
            <li><i class="bi bi-person-fill me-2"></i>Organizado por <strong>{{ $event->organizer->name }}</strong></li>
        </ul>

        <h5>Sobre este evento</h5>
        <p class="lead">{{ $event->description }}</p>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="bi bi-ticket-perforated me-2"></i>Entradas</h5>
            </div>
            <div class="card-body">
                @forelse($event->tickets as $ticket)
                    <div class="border rounded p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-0">{{ $ticket->name }}</h6>
                                <small class="text-muted">{{ $ticket->available() }} disponibles</small>
                            </div>
                            <span class="badge bg-dark fs-6">
                                {{ $ticket->price > 0 ? '$'.number_format($ticket->price, 0, ',', '.') : 'Gratis' }}
                            </span>
                        </div>
                        @auth
                            @if($ticket->hasStock() && $event->active)
                                <form method="POST" action="{{ route('attendee.registrations.store') }}" class="mt-2">
                                    @csrf
                                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                    <button class="btn btn-warning btn-sm w-100" type="submit">
                                        <i class="bi bi-check-circle me-1"></i>Registrarme
                                    </button>
                                </form>
                            @elseif(!$ticket->hasStock())
                                <button class="btn btn-secondary btn-sm w-100 mt-2" disabled>Agotado</button>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-dark btn-sm w-100 mt-2">
                                Inicia sesión para registrarte
                            </a>
                        @endauth
                    </div>
                @empty
                    <p class="text-muted text-center">Sin tickets configurados.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
