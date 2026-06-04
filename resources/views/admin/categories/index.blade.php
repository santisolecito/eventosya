@extends('layouts.app')
@section('title', 'Categorías')

@section('content')
<div class="row">
    <div class="col-md-7">
        <h2 class="mb-4"><i class="bi bi-tag me-2 text-warning"></i>Categorías</h2>
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-dark">
                        <tr><th>Nombre</th><th>Slug</th><th>Eventos</th><th>Acciones</th></tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $cat)
                        <tr>
                            <td><strong>{{ $cat->name }}</strong></td>
                            <td><code>{{ $cat->slug }}</code></td>
                            <td>{{ $cat->events_count }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}"
                                    onsubmit="return confirm('¿Eliminar?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted">Sin categorías.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <h4 class="mb-3">Nueva categoría</h4>
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción (opcional)</label>
                        <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                    </div>
                    <button class="btn btn-warning w-100">
                        <i class="bi bi-plus-circle me-1"></i>Crear categoría
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
