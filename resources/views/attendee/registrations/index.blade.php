@extends('layouts.app')
@section('title', 'Mis entradas')

@section('content')
<h2 class="mb-4"><i class="bi bi-ticket-perforated me-2 text-warning"></i>Mis entradas</h2>

@if($registrations->isEmpty())
    <div class="text-center py-5 text-muted">
        <i class="bi bi-ticket-x" style="font-size:3rem;"></i>
        <p class="mt-3">Aún no tienes entradas.</p>
        <a href="{{ route('events.index') }}" class="btn btn-warning">Explorar eventos</a>
    </div>
@else
    <div class="row g-3">
        @foreach($registrations as $reg)
        @php $event = $reg->ticket->event; @endphp
        <div class="col-md-6">
            <div class="card h-100 {{ $reg->status === 'cancelled' ? 'opacity-50' : '' }}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title mb-0">{{ $event->title }}</h5>
                        @if($reg->status === 'active')
                            <span class="badge bg-success">Activa</span>
                        @else
                            <span class="badge bg-secondary">Cancelada</span>
                        @endif
                    </div>
                    <p class="text-muted small mb-1">
                        <i class="bi bi-geo-alt me-1"></i>{{ $event->venue }}, {{ $event->city }}
                    </p>
                    <p class="text-muted small mb-1">
                        <i class="bi bi-calendar3 me-1"></i>{{ $event->event_date->format('d/m/Y') }}
                    </p>
                    <p class="text-muted small mb-2">
                        <i class="bi bi-ticket me-1"></i>{{ $reg->ticket->name }}
                    </p>
                    <div class="d-flex align-items-center justify-content-between">
                        <code class="bg-light px-2 py-1 rounded">{{ $reg->code }}</code>
                        @if($reg->status === 'active')
                            <form method="POST" action="{{ route('attendee.registrations.cancel', $reg) }}">
                                @csrf @method('PATCH')
                                <button class="btn btn-outline-danger btn-sm"
                                    onclick="return confirm('¿Cancelar esta entrada?')">
                                    Cancelar
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $registrations->links() }}</div>
@endif
@endsection
