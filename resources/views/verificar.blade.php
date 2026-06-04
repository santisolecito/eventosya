@extends('layouts.app')
@section('title', 'Verificar entrada')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="bi bi-patch-check me-2"></i>Verificar entrada</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Ingresa el código de la entrada para verificar su estado.</p>
                <form method="POST" action="{{ route('verificar.buscar') }}">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="code" class="form-control form-control-lg @error('code') is-invalid @enderror"
                            placeholder="Ej: MG5LJ9A3JF"
                            value="{{ old('code') }}"
                            style="text-transform:uppercase;"
                            required>
                        <button class="btn btn-warning" type="submit">
                            <i class="bi bi-search me-1"></i>Verificar
                        </button>
                    </div>
                    @error('code')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </form>
            </div>
        </div>

        {{-- Resultado --}}
        @isset($registration)
            @if($registration)
                <div class="card shadow-sm mt-4 border-{{ $registration->status === 'active' ? 'success' : 'danger' }}">
                    <div class="card-header bg-{{ $registration->status === 'active' ? 'success' : 'danger' }} text-white">
                        <h5 class="mb-0">
                            @if($registration->status === 'active')
                                <i class="bi bi-check-circle-fill me-2"></i>Entrada VÁLIDA
                            @else
                                <i class="bi bi-x-circle-fill me-2"></i>Entrada CANCELADA
                            @endif
                        </h5>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">Asistente</dt>
                            <dd class="col-sm-8">{{ $registration->user->name }}</dd>

                            <dt class="col-sm-4">Email</dt>
                            <dd class="col-sm-8">{{ $registration->user->email }}</dd>

                            <dt class="col-sm-4">Evento</dt>
                            <dd class="col-sm-8">{{ $registration->ticket->event->title }}</dd>

                            <dt class="col-sm-4">Fecha</dt>
                            <dd class="col-sm-8">{{ $registration->ticket->event->event_date->format('d/m/Y') }}</dd>

                            <dt class="col-sm-4">Lugar</dt>
                            <dd class="col-sm-8">{{ $registration->ticket->event->venue }}, {{ $registration->ticket->event->city }}</dd>

                            <dt class="col-sm-4">Tipo ticket</dt>
                            <dd class="col-sm-8">{{ $registration->ticket->name }}</dd>

                            <dt class="col-sm-4">Código</dt>
                            <dd class="col-sm-8"><code>{{ $registration->code }}</code></dd>

                            <dt class="col-sm-4">Estado</dt>
                            <dd class="col-sm-8">
                                @if($registration->status === 'active')
                                    <span class="badge bg-success fs-6">Activa</span>
                                @else
                                    <span class="badge bg-danger fs-6">Cancelada</span>
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>
            @else
                <div class="alert alert-warning mt-4">
                    <i class="bi bi-exclamation-triangle me-2"></i>No se encontró ninguna entrada con ese código.
                </div>
            @endif
        @endisset
    </div>
</div>
@endsection
