@extends('layouts.app')
@section('title', 'Todos los eventos')

@section('content')
<h2 class="mb-4"><i class="bi bi-calendar me-2 text-warning"></i>Todos los eventos</h2>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-dark">
                <tr><th>Título</th><th>Organizador</th><th>Categoría</th><th>Fecha</th><th>Ciudad</th><th>Estado</th><th>Acción</th></tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                <tr>
                    <td><strong>{{ $event->title }}</strong></td>
                    <td>{{ $event->organizer->name }}</td>
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
                        <form method="POST" action="{{ route('admin.events.toggle', $event) }}">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm {{ $event->active ? 'btn-outline-secondary' : 'btn-outline-success' }}">
                                {{ $event->active ? 'Desactivar' : 'Activar' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $events->links() }}</div>
@endsection
