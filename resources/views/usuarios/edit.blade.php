{{-- resources/views/usuarios/edit.blade.php --}}

@extends('layouts.admin')

@section('content')
    <div class="container-fluid bg-white text-dark py-3">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Editar Usuario</h1>
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
                <form action="{{ route('usuarios.update', $usuario) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row gy-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" value="{{ old('nombre', $usuario->nombre) }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email', $usuario->email) }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contraseña</label>
                            <input type="password" name="password" class="form-control">
                            <small class="text-muted">Dejar vacío para mantener la contraseña actual</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirmar contraseña</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rol</label>
                            <select name="rol" class="form-select" required>
                                <option value="">Seleccione un rol</option>
                                <option value="admin" {{ old('rol', $usuario->rol) === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="organizador" {{ old('rol', $usuario->rol) === 'organizador' ? 'selected' : '' }}>Organizador</option>
                                <option value="usuario" {{ old('rol', $usuario->rol) === 'usuario' ? 'selected' : '' }}>Usuario</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Avatar</label>
                            <input type="file" name="avatar" class="form-control" accept="image/*">
                            <small class="text-muted">Formatos soportados: JPG, PNG, GIF, WebP. Máximo 2MB</small>
                        </div>

                        @if ($usuario->avatar)
                            <div class="col-md-12">
                                <label class="form-label">Avatar actual</label>
                                <div>
                                    <img src="{{ asset('storage/' . $usuario->avatar) }}"
                                        alt="{{ $usuario->nombre }}" style="max-width: 200px; max-height: 200px; border-radius: 4px;">
                                </div>
                                <div class="form-text">Las fotos nuevas se añaden reemplazando las existentes.</div>
                            </div>
                        @endif

                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-dark">Actualizar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection
