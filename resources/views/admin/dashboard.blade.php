@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid bg-white text-dark py-4">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="h3 fw-bold mb-1">Bienvenido a Bacoloco</h1>
            <p class="text-muted">Resumen de la plataforma y datos actuales.</p>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 border-start border-5 border-dark h-100 rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="text-muted text-uppercase fw-bold" style="font-size: 0.85rem; letter-spacing: 0.5px;">Total Usuarios</div>
                    </div>
                    <div class="h1 mb-0 fw-bolder">{{ $totalUsuarios }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 border-start border-5 border-secondary h-100 rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="text-muted text-uppercase fw-bold" style="font-size: 0.85rem; letter-spacing: 0.5px;">Lugares Registrados</div>
                    </div>
                    <div class="h1 mb-0 fw-bolder">{{ $totalLugares }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 border-start border-5 border-dark h-100 rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="text-muted text-uppercase fw-bold" style="font-size: 0.85rem; letter-spacing: 0.5px;">Eventos Activos</div>
                    </div>
                    <div class="h1 mb-0 fw-bolder">{{ $eventosActivos }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-12">
            <div class="card shadow-sm border rounded-3">
                <div class="card-body p-5 text-center">
                    <h4 class="mb-3 fw-bold">Panel de Administración</h4>
                    <p class="text-muted mb-4">Utiliza los diferentes apartados del menú lateral para gestionar los recursos, agregar nuevo contenido o administrar a qué tienen acceso los usuarios.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('eventos.index') }}" class="btn btn-outline-dark">Ver Eventos</a>
                        <a href="{{ route('lugares.index') }}" class="btn btn-dark">Ver Lugares</a>
                        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">Ver Usuarios</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
