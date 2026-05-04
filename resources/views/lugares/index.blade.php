{{-- resources/views/lugares/index.blade.php --}}

@extends('layouts.admin')

@section('content')

    <div class="container-fluid">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Lugares</h1>
            <a href="{{ route('lugares.create') }}" class="btn btn-primary">Crear Lugar</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">

                <table class="table table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
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
                                <td>{{ $lugar->descripcion }}</td>
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
                                    <a href="{{ route('lugares.edit', $lugar) }}" class="btn btn-sm btn-warning">
                                        Editar
                                    </a>
                                    <form action="{{ route('lugares.destroy', $lugar) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Eliminar este lugar?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
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

            </div>
        </div>

    </div>

@endsection
