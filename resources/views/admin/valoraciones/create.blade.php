@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid bg-white text-dark py-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Crear Valoración</h1>
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
            <form action="{{ route('valoraciones.store') }}" method="POST">
                @csrf
                <div class="row gy-3">
                    <div class="col-md-6">
                        <label class="form-label">Usuario</label>
                        <select name="user_id" class="form-select" required>
                            <option value="">Seleccione...</option>
                            @foreach ($usuarios as $id => $nombre)
                                <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Lugar</label>
                        <select name="lugar_id" class="form-select" required>
                            <option value="">Seleccione...</option>
                            @foreach ($lugares as $id => $nombre)
                                <option value="{{ $id }}" {{ old('lugar_id') == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Puntuación</label>
                        <input type="number" name="puntuacion" value="{{ old('puntuacion') }}" class="form-control" min="1" max="5" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Comentario</label>
                        <textarea name="comentario" class="form-control" rows="3">{{ old('comentario') }}</textarea>
                    </div>
                    <div class="col-md-12 text-end">
                        <button type="submit" class="btn btn-dark">Crear</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
