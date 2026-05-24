{{-- resources/views/lugares/create.blade.php --}}

@extends('admin.layouts.admin')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Crear Lugar</h1>
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
                <form action="{{ route('lugares.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row gy-3">
                        <div class="col-md-6">
                            <label class="form-label">Tipo</label>
                            <select name="tipo_id" class="form-control">
                                <option value="">Seleccione un tipo</option>
                                @foreach ($tipos as $id => $nombre)
                                    <option value="{{ $id }}" {{ old('tipo_id') == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Usuario</label>
                            <select name="user_id" class="form-control">
                                <option value="">Seleccione un usuario</option>
                                @foreach ($users as $id => $name)
                                    <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Municipio</label>
                            <input type="text" name="municipio" value="{{ old('municipio') }}" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Dirección</label>
                            <input type="text" name="direccion" value="{{ old('direccion') }}" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Latitud</label>
                            <input type="text" name="latitud" value="{{ old('latitud') }}" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Longitud</label>
                            <input type="text" name="longitud" value="{{ old('longitud') }}" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="activo" value="1" id="activo" {{ old('activo') ? 'checked' : '' }}>
                                <label class="form-check-label" for="activo">Activo</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Imágenes</label>
                            <input type="file" name="imagenes[]" class="form-control" accept="image/*" multiple>
                            <small class="text-muted">Puedes seleccionar una o varias imágenes. Formatos soportados: JPG, PNG, GIF, WebP</small>
                        </div>
                        <div class="col-md-12 etiquetas-wrapper">
                            <label class="form-label">Etiquetas</label>
                            <select id="etiquetas-select" class="form-select etiquetas-select">
                                <option value="">Seleccione una etiqueta...</option>
                                @foreach ($etiquetas as $id => $nombre)
                                    <option value="{{ $id }}">{{ $nombre }}</option>
                                @endforeach
                            </select>
                            
                            <!-- Contenedor de insignias (badges) -->
                            <div id="etiquetas-contenedor" class="d-flex flex-wrap gap-2 mt-2 etiquetas-contenedor">
                                {{-- Los inputs ocultos y chapas se inyectarán dinámicamente aquí --}}
                            </div>
                        </div>
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-sm btn-outline-dark">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script para gestión de etiquetas -->
    @vite('resources/js/admin/etiquetas.js')
@endsection
