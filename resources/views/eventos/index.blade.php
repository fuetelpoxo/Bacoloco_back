{{-- resources/views/eventos/index.blade.php --}}

@extends('layouts.admin')

@section('content')

    <div class="container-fluid bg-white text-dark py-3">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Eventos</h1>
            <a href="{{ route('eventos.create') }}" class="btn btn-dark">Crear Evento</a>
        </div>

        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <input type="text" name="nombre_lugar" class="form-control" placeholder="Buscar por lugar"
                    value="{{ request('nombre_lugar') }}">
            </div>

            <div class="col-md-3">
                <input type="text" name="nombre_evento" class="form-control" placeholder="Buscar por evento"
                    value="{{ request('nombre_evento') }}">
            </div>

            <div class="col-md-2">
                <input type="number" step="0.01" min="0" name="precio_desde" class="form-control" placeholder="Precio desde"
                    value="{{ request('precio_desde') }}">
            </div>

            <div class="col-md-2">
                <input type="number" step="0.01" min="0" name="precio_hasta" class="form-control" placeholder="Precio hasta"
                    value="{{ request('precio_hasta') }}">
            </div>

            <div class="col-md-2">
                <select name="activo" class="form-select">
                    <option value="">Activo</option>
                    <option value="1" {{ request('activo') === '1' ? 'selected' : '' }}>Sí</option>
                    <option value="0" {{ request('activo') === '0' ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <div class="col-md-12 d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-dark">Filtrar</button>
                <a href="{{ route('eventos.index') }}" class="btn btn-outline-secondary">Limpiar</a>
            </div>
        </form>

        <div class="card shadow-sm rounded-3 border">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Evento</th>
                                <th>Lugar</th>
                                <th>Usuario</th>
                                <th>Fecha inicio</th>
                                <th>Fecha fin</th>
                                <th>Precio</th>
                                <th>Activo</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($eventos as $evento)
                                <tr>
                                    <td>{{ $evento->nombre }}</td>

                                    <td>{{ $evento->lugar?->nombre ?? 'Sin lugar' }}</td>

                                    <td>{{ $evento->user?->nombre ?? 'Sin usuario' }}</td>

                                    <td>{{ $evento->fecha_inicio?->format('d/m/Y H:i') ?? 'Sin fecha' }}</td>

                                    <td>{{ $evento->fecha_fin?->format('d/m/Y H:i') ?? 'Sin fecha' }}</td>

                                    <td>
                                        {{ $evento->precio !== null ? number_format($evento->precio, 2) : 'Sin precio' }}
                                    </td>

                                    <td>{{ $evento->activo ? 'SI' : 'NO' }}</td>

                                    <td class="text-end">
                                        <a href="{{ route('eventos.edit', $evento) }}" class="btn btn-sm btn-outline-dark">
                                            Editar
                                        </a>

                                        <form action="{{ route('eventos.destroy', $evento) }}" method="POST"
                                            class="d-inline-block" onsubmit="return confirm('¿Eliminar este evento?');">

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
                                    <td colspan="8" class="text-center text-muted">
                                        No hay eventos disponibles
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($eventos->hasPages())
                    <div class="mt-3 d-flex justify-content-end">
                        {{ $eventos->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>

    </div>

@endsection
