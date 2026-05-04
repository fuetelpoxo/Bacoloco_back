{{-- resources/views/admin/lugares/index.blade.php --}}

@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- Título + botón crear --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Eventos</h1>
        <a href="#" class="btn btn-primary">Crear Lugar</a>
    </div>

    {{-- Tabla --}}
    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Tipo</th>
                        <th>Municipio</th>
                        <th>Direccion</th>
                        <th>Activo</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($eventos as $evento)
                        <tr>

                            <td>{{ $evento->nombre }}</td>
                            <td>{{ $evento->lugar->nombre }}</td>


                            <td class="text-end">
                                <a href="#" class="btn btn-sm btn-warning">
                                    Editar
                                </a>
                                <a href="#" class="btn btn-sm btn-danger">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
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
