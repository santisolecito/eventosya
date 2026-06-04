@extends('layouts.app')
@section('title', $event->title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">{{ $event->title }}</h2>
    <div class="d-flex gap-2">
        <a href="{{ route('organizer.events.edit', $event) }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-pencil me-1"></i>Editar
        </a>
        <a href="{{ route('events.show', $event->slug) }}" class="btn btn-outline-dark btn-sm" target="_blank">
            <i class="bi bi-eye me-1"></i>Ver público
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Categoría</dt>
                    <dd class="col-sm-8"><span class="badge bg-warning text-dark">{{ $event->category->name }}</span></dd>
                    <dt class="col-sm-4">Fecha</dt>
                    <dd class="col-sm-8">{{ $event->event_date->format('d/m/Y') }} a las {{ \Carbon\Carbon::parse($event->event_time)->format('H:i') }}</dd>
                    <dt class="col-sm-4">Lugar</dt>
                    <dd class="col-sm-8">{{ $event->venue }}, {{ $event->city }}</dd>
                    <dt class="col-sm-4">Estado</dt>
                    <dd class="col-sm-8">
                        @if($event->active)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-secondary">Inactivo</span>
                        @endif
                    </dd>
                    <dt class="col-sm-4">Descripción</dt>
                    <dd class="col-sm-8">{{ $event->description }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h6 class="mb-0"><i class="bi bi-ticket me-1"></i>Tickets</h6>
            </div>
            <div class="card-body">
                @forelse($event->tickets as $ticket)
                <div class="d-flex justify-content-between align-items-start border-bottom pb-2 mb-2">
                    <div>
                        <strong>{{ $ticket->name }}</strong><br>
                        <small class="text-muted">
                            ${{ number_format($ticket->price, 0, ',', '.') }} ·
                            {{ $ticket->sold_qty }}/{{ $ticket->total_qty }} vendidos
                        </small>
                    </div>
                    <form method="POST" action="{{ route('organizer.tickets.destroy', $ticket) }}"
                        onsubmit="return confirm('¿Eliminar?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
                @empty
                    <p class="text-muted small">Sin tickets aún.</p>
                @endforelse

                <hr>
                <p class="fw-bold small mb-2">Agregar ticket</p>
                <form method="POST" action="{{ route('organizer.events.tickets.store', $event) }}">
                    @csrf
                    <div class="mb-2">
                        <select name="name" class="form-select form-select-sm" required>
                            <option value="General">General</option>
                            <option value="VIP">VIP</option>
                            <option value="Estudiante">Estudiante</option>
                        </select>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <input type="number" name="price" class="form-control form-control-sm"
                                placeholder="Precio ($)" min="0" step="1000" required>
                        </div>
                        <div class="col-6">
                            <input type="number" name="total_qty" class="form-control form-control-sm"
                                placeholder="Cupos" min="1" required>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-warning w-100">
                        <i class="bi bi-plus me-1"></i>Agregar ticket
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
