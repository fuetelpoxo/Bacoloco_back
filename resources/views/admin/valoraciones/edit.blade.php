@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid bg-white text-dark py-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Editar Valoración</h1>
        <a href="{{ route('valoraciones.index') }}" class="btn btn-outline-secondary">Volver</a>
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

    <div class="card shadow-sm border">
        <div class="card-body p-4">
            <form action="{{ route('valoraciones.update', $valoracion) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row gy-3">
                    <div class="col-md-6">
                        <label class="form-label">Usuario</label>
                        <select name="user_id" class="form-select" required>
                            @foreach ($usuarios as $id => $nombre)
                                <option value="{{ $id }}" {{ old('user_id', $valoracion->user_id) == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Lugar</label>
                        <select name="lugar_id" class="form-select" required>
                            @foreach ($lugares as $id => $nombre)
                                <option value="{{ $id }}" {{ old('lugar_id', $valoracion->lugar_id) == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Puntuación</label>
                        <input type="number" name="puntuacion" value="{{ old('puntuacion', $valoracion->puntuacion) }}" class="form-control" min="1" max="5" required>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check mt-4">
                            <input type="checkbox" name="reportado" value="1" class="form-check-input" id="reportado" {{ old('reportado', $valoracion->reportado) ? 'checked' : '' }}>
                            <label class="form-check-label" for="reportado">Reportado</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Comentario</label>
                        <textarea name="comentario" class="form-control" rows="3">{{ old('comentario', $valoracion->comentario) }}</textarea>
                    </div>
                    <div class="col-md-12 text-end">
                        <button type="submit" class="btn btn-dark">Actualizar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
