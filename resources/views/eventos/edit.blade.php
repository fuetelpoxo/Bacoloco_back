{{-- resources/views/eventos/edit.blade.php --}}

@extends('layouts.admin')

@section('content')
    <div class="container-fluid bg-white text-dark py-3">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Editar Evento</h1>
            <a href="{{ route('eventos.index') }}" class="btn btn-outline-secondary">Volver</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm rounded-3 border">
            <div class="card-body p-4">
                <form action="{{ route('eventos.update', $evento) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row gy-3">
                        <div class="col-md-6">
                            <label class="form-label">Lugar</label>
                            <select name="lugar_id" class="form-select">
                                <option value="">Seleccione un lugar</option>
                                @foreach ($lugares as $id => $nombre)
                                    <option value="{{ $id }}" {{ old('lugar_id', $evento->lugar_id) == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Usuario</label>
                            <select name="user_id" class="form-select" required>
                                <option value="">Seleccione un usuario</option>
                                @foreach ($users as $id => $nombre)
                                    <option value="{{ $id }}" {{ old('user_id', $evento->user_id) == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" value="{{ old('nombre', $evento->nombre) }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Precio</label>
                            <input type="number" step="0.01" min="0" name="precio" value="{{ old('precio', $evento->precio) }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha inicio</label>
                            <input type="datetime-local" name="fecha_inicio" value="{{ old('fecha_inicio', optional($evento->fecha_inicio)->format('Y-m-d\TH:i')) }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha fin</label>
                            <input type="datetime-local" name="fecha_fin" value="{{ old('fecha_fin', $evento->fecha_fin ? $evento->fecha_fin->format('Y-m-d\TH:i') : '') }}" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="4">{{ old('descripcion', $evento->descripcion) }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="activo" value="1" id="activo" {{ old('activo', $evento->activo) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activo">Activo</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Añadir nuevas fotos</label>
                            <input type="file" name="imagenes[]" class="form-control" multiple accept="image/*">
                            <div class="form-text">Las fotos nuevas se añaden sin reemplazar las existentes.</div>
                        </div>
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-dark">Actualizar</button>
                        </div>
                    </div>
                </form>

                <div class="col-md-12">
                    <label class="form-label">Fotos actuales</label>
                    @if ($evento->imagenes->isEmpty())
                        <p class="text-muted mb-0">Este evento no tiene fotos.</p>
                    @else
                        <div class="row g-3">
                            @foreach ($evento->imagenes as $imagen)
                                <div class="col-6 col-md-3">
                                    <div class="card">
                                        <img src="{{ asset('storage/' . $imagen->ruta) }}" class="card-img-top"
                                            alt="Foto del evento">
                                        <div class="card-body text-center p-2">
                                            <form action="{{ route('imagenes.destroy', $imagen) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
