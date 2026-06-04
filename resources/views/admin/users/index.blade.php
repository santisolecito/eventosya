@extends('layouts.app')
@section('title', 'Usuarios')

@section('content')
<h2 class="mb-4"><i class="bi bi-people me-2 text-warning"></i>Usuarios del sistema</h2>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-dark">
                <tr><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Rol</th><th>Registro</th><th>Cambiar rol</th></tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td><strong>{{ $user->name }}</strong></td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? '—' }}</td>
                    <td>
                        @if($user->role === 'admin')
                            <span class="badge bg-danger">Admin</span>
                        @elseif($user->role === 'organizer')
                            <span class="badge bg-primary">Organizador</span>
                        @else
                            <span class="badge bg-secondary">Asistente</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.users.role', $user) }}" class="d-flex gap-1">
                            @csrf @method('PATCH')
                            <select name="role" class="form-select form-select-sm" style="width:120px;">
                                <option value="admin"     @selected($user->role === 'admin')>Admin</option>
                                <option value="organizer" @selected($user->role === 'organizer')>Organizador</option>
                                <option value="attendee"  @selected($user->role === 'attendee')>Asistente</option>
                            </select>
                            <button class="btn btn-sm btn-outline-dark">
                                <i class="bi bi-save"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $users->links() }}</div>
@endsection
