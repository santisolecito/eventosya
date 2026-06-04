@extends('layouts.app')
@section('title', 'Asistentes — '.$event->title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-people me-2 text-warning"></i>Asistentes — {{ $event->title }}</h2>
    <a href="{{ route('organizer.events.show', $event) }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Volver al evento
    </a>
</div>

{{-- Ocupación por ticket --}}
<div class="row g-3 mb-4">
    @foreach($event->tickets as $ticket)
    <div class="col-md-3">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <h6 class="text-muted">{{ $ticket->name }}</h6>
                <div style="font-size:1.8rem;font-weight:600;">{{ $ticket->sold_qty }}/{{ $ticket->total_qty }}</div>
                <div class="progress mt-2" style="height:6px;">
                    <div class="progress-bar bg-warning" style="width:{{ $ticket->total_qty > 0 ? ($ticket->sold_qty/$ticket->total_qty)*100 : 0 }}%"></div>
                </div>
                <small class="text-muted">{{ $ticket->available() }} disponibles</small>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Tabla de asistentes --}}
@if($registrations->isEmpty())
    <div class="text-center py-5 text-muted">
        <i class="bi bi-people" style="font-size:3rem;"></i>
        <p class="mt-3">Aún no hay asistentes registrados.</p>
    </div>
@else
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Ticket</th>
                        <th>Código</th>
                        <th>Fecha registro</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registrations as $reg)
                    <tr>
                        <td><strong>{{ $reg->user->name }}</strong></td>
                        <td>{{ $reg->user->email }}</td>
                        <td>{{ $reg->user->phone ?? '—' }}</td>
                        <td><span class="badge bg-warning text-dark">{{ $reg->ticket->name }}</span></td>
                        <td><code>{{ $reg->code }}</code></td>
                        <td>{{ $reg->registered_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $registrations->links() }}</div>
@endif
@endsection
