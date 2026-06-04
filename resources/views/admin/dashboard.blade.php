@extends('layouts.app')
@section('title', 'Panel de administración')

@section('content')
<h2 class="mb-4"><i class="bi bi-speedometer2 me-2 text-warning"></i>Panel de administración</h2>

<div class="row g-3 mb-5">
    <div class="col-sm-3">
        <div class="card text-center shadow-sm border-0 bg-dark text-white">
            <div class="card-body">
                <div style="font-size:2rem;">{{ $stats['users'] }}</div>
                <div class="small text-white-50">Usuarios</div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card text-center shadow-sm border-0 bg-warning">
            <div class="card-body">
                <div style="font-size:2rem;">{{ $stats['events'] }}</div>
                <div class="small text-dark">Eventos</div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card text-center shadow-sm border-0 bg-success text-white">
            <div class="card-body">
                <div style="font-size:2rem;">{{ $stats['registrations'] }}</div>
                <div class="small">Registros</div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card text-center shadow-sm border-0 bg-info text-white">
            <div class="card-body">
                <div style="font-size:2rem;">{{ $stats['categories'] }}</div>
                <div class="small">Categorías</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Últimos eventos</h6>
                <a href="{{ route('admin.events.index') }}" class="btn btn-sm btn-outline-dark">Ver todos</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr><th>Título</th><th>Organizador</th><th>Fecha</th><th>Estado</th></tr>
                    </thead>
                    <tbody>
                        @foreach($latestEvents as $event)
                        <tr>
                            <td>{{ $event->title }}</td>
                            <td>{{ $event->organizer->name }}</td>
                            <td>{{ $event->event_date->format('d/m/Y') }}</td>
                            <td>
                                @if($event->active)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-secondary">Inactivo</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header"><h6 class="mb-0">Accesos rápidos</h6></div>
            <div class="list-group list-group-flush">
                <a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-tag me-2"></i>Gestionar categorías
                </a>
                <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-people me-2"></i>Gestionar usuarios
                </a>
                <a href="{{ route('admin.events.index') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-calendar me-2"></i>Todos los eventos
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
