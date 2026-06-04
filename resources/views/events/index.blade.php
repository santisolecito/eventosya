@extends('layouts.app')
@section('title', 'Explorar eventos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-calendar-event me-2 text-warning"></i>Próximos eventos</h2>
</div>

<form method="GET" action="{{ route('events.index') }}" class="row g-2 mb-4">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Buscar evento..." value="{{ request('search') }}">
    </div>
    <div class="col-md-3">
        <select name="category" class="form-select">
            <option value="">Todas las categorías</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <input type="text" name="city" class="form-control" placeholder="Ciudad..." value="{{ request('city') }}">
    </div>
    <div class="col-md-2">
        <button class="btn btn-dark w-100" type="submit">
            <i class="bi bi-search me-1"></i>Filtrar
        </button>
    </div>
</form>

@if($events->isEmpty())
    <div class="text-center py-5 text-muted">
        <i class="bi bi-calendar-x" style="font-size:3rem;"></i>
        <p class="mt-3">No hay eventos disponibles.</p>
    </div>
@else
    <div class="row g-4">
        @foreach($events as $event)
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                @if($event->cover_image)
                    <img src="{{ Storage::url($event->cover_image) }}" class="card-img-top" style="height:180px;object-fit:cover;" alt="{{ $event->title }}">
                @else
                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height:180px;">
                        <i class="bi bi-calendar-event" style="font-size:3rem;opacity:.4;"></i>
                    </div>
                @endif
                <div class="card-body d-flex flex-column">
                    <span class="badge bg-warning text-dark mb-2 align-self-start">{{ $event->category->name }}</span>
                    <h5 class="card-title">{{ $event->title }}</h5>
                    <p class="text-muted small mb-1">
                        <i class="bi bi-geo-alt me-1"></i>{{ $event->venue }}, {{ $event->city }}
                    </p>
                    <p class="text-muted small mb-3">
                        <i class="bi bi-calendar3 me-1"></i>{{ $event->event_date->format('d/m/Y') }}
                    </p>
                    <div class="mt-auto">
                        @php $disponibles = $event->availableSpots(); @endphp
                        @if($disponibles > 0)
                            <span class="badge bg-success mb-2">{{ $disponibles }} cupos</span>
                        @else
                            <span class="badge bg-danger mb-2">Agotado</span>
                        @endif
                        <a href="{{ route('events.show', $event->slug) }}" class="btn btn-outline-dark btn-sm w-100">
                            Ver detalles
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $events->links() }}</div>
@endif
@endsection
