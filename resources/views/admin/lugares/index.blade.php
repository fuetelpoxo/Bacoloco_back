@extends('admin.layouts.admin')

@section('content')
    <div class="container-fluid bg-white text-dark py-3">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Lugares</h1>
            <a href="{{ route('lugares.create') }}" class="btn btn-dark">Crear Lugar</a>
        </div>
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <input type="text" name="nombre" class="form-control" placeholder="Buscar por nombre"
                    value="{{ request('nombre') }}">
            </div>

            <div class="col-md-2">
                <input type="text" name="municipio" class="form-control" placeholder="Municipio"
                    value="{{ request('municipio') }}">
            </div>

            <div class="col-md-2">
                <select name="tipo_id" class="form-select">
                    <option value="">Tipo</option>
                    @foreach ($tipos as $id => $nombre)
                        <option value="{{ $id }}" {{ request('tipo_id') == $id ? 'selected' : '' }}>
                            {{ $nombre }}
                        </option>
                    @endforeach
                </select>
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
                <a href="{{ route('lugares.index') }}" class="btn btn-outline-secondary">Limpiar</a>
            </div>
        </form>
        <div class="card shadow-sm rounded-3 border">
            <div class="card-body p-4">

                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Municipio</th>
                            <th>Dirección</th>
                            <th>Activo</th>
                            <th>Eventos</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lugares as $lugar)
                            <tr>
                                <td>{{ $lugar->nombre }}</td>
                                <td>{{ optional($lugar->tipo)->nombre }}</td>
                                <td>{{ $lugar->municipio }}</td>
                                <td>{{ $lugar->direccion }}</td>
                                <td>{{ $lugar->activo ? 'SI' : 'NO' }}</td>
                                <td>
                                    @if ($lugar->eventos->count())
                                        {{ $lugar->eventos->count() }}
                                    @else
                                        <span class="text-muted">Sin eventos</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('lugares.edit', $lugar) }}" class="btn btn-sm btn-outline-dark">
                                        Editar
                                    </a>
                                    <form action="{{ route('lugares.destroy', $lugar) }}" method="POST"
                                        class="d-inline-block" onsubmit="return confirm('¿Eliminar este lugar?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    No hay lugares disponibles
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if ($lugares->hasPages())
                    <div class="mt-3 d-flex justify-content-end">
                        {{ $lugares->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                @endif

            </div>
        </div>

    </div>
@endsection
