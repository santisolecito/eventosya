@extends('layouts.app')
@section('title', 'Crear evento')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="bi bi-calendar-plus me-2"></i>Crear nuevo evento</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('organizer.events.store') }}" enctype="multipart/form-data">
                    @csrf
                    @include('organizer.events._form')
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check-circle me-1"></i>Crear evento
                        </button>
                        <a href="{{ route('organizer.events.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
