@extends('layouts.app')
@section('title', 'Editar evento')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Editar: {{ $event->title }}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('organizer.events.update', $event) }}" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    @include('organizer.events._form')
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>Guardar cambios
                        </button>
                        <a href="{{ route('organizer.events.show', $event) }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
