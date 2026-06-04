@extends('layouts.app')
@section('title', 'Mis eventos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-calendar-plus me-2 text-warning"></i>Mis eventos</h2>
    <a href="{{ route('organizer.events.create') }}" class="btn btn-warning">
        <i class="bi bi-plus-circle me-1"></i>Nuevo evento
    </a>
</div>

@if($events->isEmpty())
    <div class="text-center py-5 text-muted">
        <i class="bi bi-calendar-x" style="font-size:3rem;"></i>
        <p class="mt-3">Aún no has creado eventos.</p>
    </div>
@else
    <div class="table-responsive">
        <table class="table table-hover align-middle bg-white rounded shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>Evento</th>
                    <th>Categoría</th>
                    <th>Fecha</th>
                    <th>Ciudad</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                <tr>
                    <td><strong>{{ $event->title }}</strong></td>
                    <td><span class="badge bg-warning text-dark">{{ $event->category->name }}</span></td>
                    <td>{{ $event->event_date->format('d/m/Y') }}</td>
                    <td>{{ $event->city }}</td>
                    <td>
                        @if($event->active)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-secondary">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('organizer.events.show', $event) }}" class="btn btn-sm btn-outline-dark">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('organizer.events.edit', $event) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('organizer.events.destroy', $event) }}" class="d-inline"
                            onsubmit="return confirm('¿Eliminar este evento?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $events->links() }}
@endif
@endsection
