@extends('layouts.admin')

@section('content')
<div class="container-fluid bg-white text-dark py-3">

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Valoraciones</h1>
        <a href="{{ route('valoraciones.create') }}" class="btn btn-dark">Crear Valoración</a>
    </div>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <select name="user_id" class="form-select">
                <option value="">Todos los usuarios</option>
                @foreach($usuarios as $id => $nombre)
                    <option value="{{ $id }}" {{ request('user_id') == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="number" name="puntuacion" class="form-control" placeholder="Buscar por puntuación (1-5)" min="1" max="5" value="{{ request('puntuacion') }}">
        </div>
        <div class="col-md-4">
            <select name="lugar_id" class="form-select">
                <option value="">Todos los lugares</option>
                @foreach($lugares as $id => $nombre)
                    <option value="{{ $id }}" {{ request('lugar_id') == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12 d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-dark">Filtrar</button>
            <a href="{{ route('valoraciones.index') }}" class="btn btn-outline-secondary">Limpiar</a>
        </div>
    </form>

    <div class="card shadow-sm rounded-3 border">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Usuario</th>
                            <th>Lugar</th>
                            <th>Puntuación</th>
                            <th>Comentario</th>
                            <th>Fecha de creación</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($valoraciones as $valoracion)
                            <tr>
                                <td>{{ $valoracion->user->nombre ?? 'N/A' }}</td>
                                <td>{{ $valoracion->lugar->nombre ?? 'N/A' }}</td>
                                <td>{{ $valoracion->puntuacion }} / 5</td>
                                <td>{{ Str::limit($valoracion->comentario, 50) }}</td>
                                <td>{{ $valoracion->created_at ? $valoracion->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('valoraciones.edit', $valoracion) }}" class="btn btn-sm btn-outline-dark">Editar</a>
                                    <form action="{{ route('valoraciones.destroy', $valoracion) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Eliminar esta valoración?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No hay valoraciones registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $valoraciones->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
