{{-- resources/views/lugares/edit.blade.php --}}

@extends('layouts.admin')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Editar Lugar</h1>
            <a href="{{ route('lugares.index') }}" class="btn btn-secondary">Volver</a>
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

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('lugares.update', $lugar) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row gy-3">
                        <div class="col-md-6">
                            <label class="form-label">Tipo</label>
                            <select name="tipo_id" class="form-control">
                                <option value="">Seleccione un tipo</option>
                                @foreach ($tipos as $id => $nombre)
                                    <option value="{{ $id }}" {{ old('tipo_id', $lugar->tipo_id) == $id ? 'selected' : '' }}>
                                        {{ $nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Usuario</label>
                            <select name="user_id" class="form-control">
                                <option value="">Seleccione un usuario</option>
                                @foreach ($users as $id => $name)
                                    <option value="{{ $id }}" {{ old('user_id', $lugar->user_id) == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" value="{{ old('nombre', $lugar->nombre) }}"
                                class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Municipio</label>
                            <input type="text" name="municipio" value="{{ old('municipio', $lugar->municipio) }}"
                                class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Descripción</label>
                            <textarea name="descripcion" class="form-control"
                                rows="3">{{ old('descripcion', $lugar->descripcion) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Dirección</label>
                            <input type="text" name="direccion" value="{{ old('direccion', $lugar->direccion) }}"
                                class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Latitud</label>
                            <input type="text" name="latitud" value="{{ old('latitud', $lugar->latitud) }}"
                                class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Longitud</label>
                            <input type="text" name="longitud" value="{{ old('longitud', $lugar->longitud) }}"
                                class="form-control">
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="activo" value="1" id="activo" {{ old('activo', $lugar->activo) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activo">Activo</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Añadir nuevas fotos</label>
                            <input type="file" name="imagenes[]" class="form-control" multiple accept="image/*">
                        </div>
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-sm btn-outline-dark">Actualizar</button>
                        </div>
                    </div>
                </form>

                <div class="col-md-12">
                    <label class="form-label">Fotos actuales</label>
                    @if ($lugar->imagenes->isEmpty())
                        <p class="text-muted mb-0">Este lugar no tiene fotos.</p>
                    @else
                        <div class="row g-3">
                            @foreach ($lugar->imagenes as $imagen)
                                <div class="col-6 col-md-3">
                                    <div class="card">
                                        <img src="{{ asset('storage/' . $imagen->ruta) }}" class="card-img-top"
                                            alt="Foto del lugar">
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
