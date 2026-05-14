@extends('organizador.layouts.organizador')

@section('content')
<div class="container-fluid bg-white text-dark py-3">

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($lugares->isEmpty())
        <div class="alert alert-info">
            <p>No tienes lugares creados.</p>
        </div>
    @else
        <!-- PANEL DE CREACIÓN DE EVENTOS -->
        <div class="card shadow-sm rounded-3 border mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">{{ $lugarSeleccionado->nombre ?? '' }} - Panel de Control</h5>
            </div>
            <div class="card-body p-4">
                @if ($lugares->count() > 1)
                    <form method="GET" class="mb-3">
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <label class="form-label">Selecciona un lugar</label>
                                <select name="lugar_id" class="form-select" onchange="this.form.submit()">
                                    @foreach ($lugares as $lugar)
                                        <option value="{{ $lugar->id }}" {{ $lugarSeleccionado && $lugarSeleccionado->id == $lugar->id ? 'selected' : '' }}>
                                            {{ $lugar->nombre }} ({{ $lugar->municipio }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                @else
                    <p class="text-muted mb-3">Lugar: <strong>{{ $lugarSeleccionado->nombre }}</strong> ({{ $lugarSeleccionado->municipio }})</p>
                @endif

                <div class="divider my-3"></div>

                <!-- Formulario de creación de evento -->
                <h6 class="mb-3">Crear nuevo evento</h6>
                <form action="{{ route('eventos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="lugar_id" value="{{ $lugarSeleccionado->id }}">
                    
                    <div class="row gy-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre del evento</label>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Precio</label>
                            <input type="number" step="0.01" min="0" name="precio" value="{{ old('precio') }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha inicio</label>
                            <input type="datetime-local" name="fecha_inicio" value="{{ old('fecha_inicio') }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha fin</label>
                            <input type="datetime-local" name="fecha_fin" value="{{ old('fecha_fin') }}" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion') }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Imágenes</label>
                            <input type="file" name="imagenes[]" class="form-control" accept="image/*" multiple>
                        </div>
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-dark">Crear evento</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- LISTA DE EVENTOS -->
        <div class="card shadow-sm rounded-3 border mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Eventos - {{ $lugarSeleccionado->nombre }}</h5>
            </div>
            <div class="card-body p-4">
                @if ($eventos->isEmpty())
                    <p class="text-muted text-center py-4">No hay eventos para este lugar.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Fecha inicio</th>
                                    <th>Fecha fin</th>
                                    <th>Precio</th>
                                    <th>Activo</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($eventos as $evento)
                                    <tr>
                                        <td>{{ $evento->nombre }}</td>
                                        <td>{{ $evento->fecha_inicio->format('d/m/Y H:i') }}</td>
                                        <td>{{ $evento->fecha_fin ? $evento->fecha_fin->format('d/m/Y H:i') : 'N/A' }}</td>
                                        <td>{{ $evento->precio ? number_format($evento->precio, 2) : 'Gratis' }}</td>
                                        <td>{{ $evento->activo ? 'Sí' : 'No' }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('eventos.edit', $evento) }}" class="btn btn-sm btn-outline-dark">Editar</a>
                                            <form action="{{ route('eventos.destroy', $evento) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Eliminar este evento?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <!-- VALORACIONES DEL LUGAR -->
        <div class="card shadow-sm rounded-3 border">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Valoraciones - {{ $lugarSeleccionado->nombre }}</h5>
            </div>
            <div class="card-body p-4">
                @if ($valoraciones->isEmpty())
                    <p class="text-muted text-center py-4">No hay valoraciones para este lugar.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Usuario</th>
                                    <th>Puntuación</th>
                                    <th>Comentario</th>
                                    <th>Reportado</th>
                                    <th>Fecha</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($valoraciones as $valoracion)
                                    <tr>
                                        <td>{{ $valoracion->user->nombre ?? 'Anónimo' }}</td>
                                        <td>{{ $valoracion->puntuacion }} / 5</td>
                                        <td>{{ Str::limit($valoracion->comentario, 80) }}</td>
                                        <td>{{ $valoracion->reportado ? 'Sí' : 'No' }}</td>
                                        <td>{{ $valoracion->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="text-end">
                                            <form action="{{ route('valoraciones.reportar', $valoracion->id) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                <button type="submit" class="btn btn-sm {{ $valoracion->reportado ? 'btn-warning' : 'btn-outline-warning' }}">
                                                    {{ $valoracion->reportado ? 'Reportado' : 'Reportar' }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $valoraciones->links() }}
                    </div>
                @endif
            </div>
        </div>
    @endif

</div>
@endsection
