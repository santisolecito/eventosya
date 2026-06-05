@extends('layouts.app')
@section('title', $event->title)

@section('content')
{{-- Hero imagen --}}
<div class="position-relative mb-4 rounded-4 overflow-hidden" style="height:350px;">
    @if($event->cover_image)
        <img src="{{ Storage::url($event->cover_image) }}" class="w-100 h-100" style="object-fit:cover;">
    @else
        <div class="w-100 h-100 bg-dark d-flex align-items-center justify-content-center">
            <i class="bi bi-calendar-event text-secondary" style="font-size:5rem;opacity:.3;"></i>
        </div>
    @endif
    {{-- Overlay degradado --}}
    <div class="position-absolute bottom-0 start-0 w-100 p-4"
        style="background:linear-gradient(transparent, rgba(0,0,0,0.85));">
        <span class="badge bg-warning text-dark mb-2 fs-6">{{ $event->category->name }}</span>
        <h1 class="text-white mb-0 fw-bold">{{ $event->title }}</h1>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        {{-- Info rápida --}}
        <div class="row g-3 mb-4">
            <div class="col-sm-6">
                <div class="card border-0 bg-white shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center"
                            style="width:45px;height:45px;flex-shrink:0;">
                            <i class="bi bi-calendar-fill text-dark"></i>
                        </div>
                        <div>
                            <div class="small text-muted">Fecha</div>
                            <div class="fw-semibold">{{ $event->event_date->format('d \d\e F \d\e Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card border-0 bg-white shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center"
                            style="width:45px;height:45px;flex-shrink:0;">
                            <i class="bi bi-clock-fill text-dark"></i>
                        </div>
                        <div>
                            <div class="small text-muted">Hora</div>
                            <div class="fw-semibold">{{ \Carbon\Carbon::parse($event->event_time)->format('H:i') }} hrs</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card border-0 bg-white shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center"
                            style="width:45px;height:45px;flex-shrink:0;">
                            <i class="bi bi-geo-alt-fill text-dark"></i>
                        </div>
                        <div>
                            <div class="small text-muted">Lugar</div>
                            <div class="fw-semibold">{{ $event->venue }}</div>
                            <div class="small text-muted">{{ $event->city }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card border-0 bg-white shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center"
                            style="width:45px;height:45px;flex-shrink:0;">
                            <i class="bi bi-person-fill text-dark"></i>
                        </div>
                        <div>
                            <div class="small text-muted">Organizador</div>
                            <div class="fw-semibold">{{ $event->organizer->name }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Descripción --}}
        <div class="card border-0 bg-white shadow-sm">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-3"><i class="bi bi-info-circle me-2 text-warning"></i>Sobre este evento</h4>
                <p class="lead mb-0" style="white-space:pre-line;">{{ $event->description }}</p>
            </div>
        </div>
    </div>

    {{-- Panel de entradas --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm sticky-top" style="top:20px;">
            <div class="card-header bg-dark text-white py-3">
                <h5 class="mb-0"><i class="bi bi-ticket-perforated me-2 text-warning"></i>Entradas</h5>
            </div>
            <div class="card-body p-3">
                @forelse($event->tickets as $ticket)
                    <div class="border rounded-3 p-3 mb-3 {{ !$ticket->hasStock() ? 'opacity-50' : '' }}">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $ticket->name }}</h6>
                                <small class="text-muted">{{ $ticket->available() }} de {{ $ticket->total_qty }} disponibles</small>
                            </div>
                            <span class="badge bg-dark fs-6 px-3 py-2">
                                {{ $ticket->price > 0 ? '$'.number_format($ticket->price, 0, ',', '.') : 'Gratis' }}
                            </span>
                        </div>
                        {{-- Barra de ocupación --}}
                        <div class="progress mb-3" style="height:5px;">
                            @php $pct = $ticket->total_qty > 0 ? ($ticket->sold_qty / $ticket->total_qty) * 100 : 0; @endphp
                            <div class="progress-bar {{ $pct >= 80 ? 'bg-danger' : 'bg-warning' }}"
                                style="width:{{ $pct }}%"></div>
                        </div>
                        @auth
                            @if($ticket->hasStock() && $event->active)
                                <form method="POST" action="{{ route('attendee.registrations.store') }}">
                                    @csrf
                                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                    <button class="btn btn-warning w-100 fw-semibold" type="submit">
                                        <i class="bi bi-check-circle me-1"></i>Registrarme
                                    </button>
                                </form>
                            @elseif(!$ticket->hasStock())
                                <button class="btn btn-secondary w-100" disabled>Agotado</button>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-dark w-100">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Inicia sesión para registrarte
                            </a>
                        @endauth
                    </div>
                @empty
                    <p class="text-muted text-center py-3">Sin tickets configurados.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
