{{-- resources/views/usuarios/create.blade.php --}}

@extends('admin.layouts.admin')

@section('content')
    <div class="container-fluid bg-white text-dark py-3">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Crear Usuario</h1>
            <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">Volver</a>
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
                <form action="{{ route('usuarios.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row gy-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contraseña</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirmar contraseña</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rol</label>
                            <select name="rol" class="form-select" required>
                                <option value="">Seleccione un rol</option>
                                <option value="admin" {{ old('rol') === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="organizador" {{ old('rol') === 'organizador' ? 'selected' : '' }}>Organizador</option>
                                <option value="usuario" {{ old('rol') === 'usuario' ? 'selected' : '' }}>Usuario</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Avatar</label>
                            <input type="file" name="avatar" class="form-control" accept="image/*">
                            <small class="text-muted">Formatos soportados: JPG, PNG, GIF, WebP. Máximo 2MB</small>
                        </div>
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-dark">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection
