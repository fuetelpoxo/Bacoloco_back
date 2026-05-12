{{-- resources/views/usuarios/index.blade.php --}}

@extends('layouts.admin')

@section('content')

    <div class="container-fluid bg-white text-dark py-3">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Usuarios</h1>
            <a href="{{ route('usuarios.create') }}" class="btn btn-dark">Crear Usuario</a>
        </div>

        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="nombre" class="form-control" placeholder="Buscar por nombre"
                    value="{{ request('nombre') }}">
            </div>
            <div class="col-md-4">
                <input type="text" name="email" class="form-control" placeholder="Buscar por email"
                    value="{{ request('email') }}">
            </div>
            <div class="col-md-4">
                <select name="rol" class="form-select">
                    <option value="">Todos los roles</option>
                    <option value="admin" {{ request('rol') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="organizador" {{ request('rol') === 'organizador' ? 'selected' : '' }}>Organizador</option>
                    <option value="usuario" {{ request('rol') === 'usuario' ? 'selected' : '' }}>Usuario</option>
                </select>
            </div>

            <div class="col-md-12 d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-dark">Filtrar</button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">Limpiar</a>
            </div>
        </form>

        <div class="card shadow-sm rounded-3 border">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Fecha de creación</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($usuarios as $usuario)
                                <tr>
                                    <td>{{ $usuario->nombre }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ $usuario->rol === 'admin' ? 'danger' : ($usuario->rol === 'organizador' ? 'warning' : 'info') }}">
                                            {{ ucfirst($usuario->rol) }}
                                        </span>
                                    </td>
                                    <td>{{ $usuario->created_at ? $usuario->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-sm btn-outline-dark">
                                            Editar
                                        </a>

                                        <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST"
                                            class="d-inline-block" onsubmit="return confirm('¿Eliminar este usuario?');">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No hay usuarios registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                <div class="d-flex justify-content-center mt-4">
                    {{ $usuarios->links() }}
                </div>
            </div>
        </div>

    </div>

@endsection
