@extends('organizador.layouts.organizador')

@section('content')
    <div class="container-fluid bg-light min-vh-100 py-4 px-4">

        <!-- HEADER & SELECTOR -->
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h1 class="h3 fw-bold mb-1 text-dark">Panel de Gestión</h1>
                <p class="text-muted mb-0">Administrando: <strong>{{ $lugarSeleccionado->nombre ?? 'Sin lugar' }}</strong>
                </p>
            </div>
            <div class="col-md-6 d-flex justify-content-md-end gap-2 mt-3 mt-md-0">
                @if ($lugares->count() > 1)
                    <div class="dropdown">
                        <button class="btn btn-outline-dark shadow-sm px-4 dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-geo-alt me-1"></i>{{ $lugarSeleccionado->nombre }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                            @foreach ($lugares as $lugar)
                                <li>
                                    <a class="dropdown-item {{ $lugarSeleccionado && $lugarSeleccionado->id == $lugar->id ? 'active' : '' }}"
                                        href="{{ route('organizador.dashboard', ['lugar_id' => $lugar->id]) }}">
                                        {{ $lugar->nombre }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- Botón que activa el Modal de creación -->
                <button class="btn btn-dark shadow-sm  px-4" data-bs-toggle="modal" data-bs-target="#createEventModal">
                    <i class="bi bi-plus-lg me-2"></i>Nuevo Evento
                </button>
                <a href="{{ config('app.frontend_url') }}" class="btn btn-outline-secondary shadow-sm px-4">
                    <i class="bi bi-box-arrow-up-right me-1"></i>Ir al sitio
                </a>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger shadow-sm  px-4">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">{{ session('success') }}</div>
        @endif

        @if ($lugares->isEmpty())
            <div class="text-center py-5">
                <img src="/path-to-empty-img.svg" width="150" alt="vacio" class="mb-3 opacity-50">
                <h4>No tienes lugares asignados</h4>
                <p class="text-muted">Por favor, contacta con el administrador para que te asigne un lugar.</p>
            </div>
        @else
            <!-- STATS RÁPIDAS -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-3">
                        <div class="d-flex align-items-center">
                            <div>
                                <h4>Eventos</h4>
                                <span class="h4 fw-bold mb-0">{{ $eventos->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-3">
                        <div class="d-flex align-items-center">
                            <div>
                                <h4>Valoración Media</h4>
                                <span class="h4 fw-bold mb-0">{{ number_format($promedioValoraciones, 1) }} /
                                    5</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-3">
                        <div class="d-flex align-items-center">
                            <div>
                                <h4>Reseñas</h4>
                                <span class="h4 fw-bold mb-0">{{ $totalValoraciones }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- EVENTOS (Listado Visual) -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0">Mis Eventos</h5>

                                <!-- BUSCADOR DE EVENTOS LARAVEL -->
                                <form action="{{ route('organizador.dashboard') }}" method="GET" class="d-flex gap-2">
                                    <input type="hidden" name="lugar_id" value="{{ $lugarSeleccionado->id }}">
                                    <div class="position-relative">
                                        <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            class="form-control form-control-sm border-0 bg-light ps-5"
                                            placeholder="Buscar evento..." style="width: 200px;">
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-dark px-3">Buscar</button>
                                    @if (request('search'))
                                        <a href="{{ route('organizador.dashboard', ['lugar_id' => $lugarSeleccionado->id]) }}"
                                            class="btn btn-sm btn-light px-3">Limpiar</a>
                                    @endif
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover align-middle">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Evento</th>
                                            <th>Fecha</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-end">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="eventsTableBody">
                                        @foreach ($eventos as $evento)
                                            <tr class="event-row">
                                                <td>
                                                    <div class="fw-bold text-dark event-name">{{ $evento->nombre }}</div>
                                                    <small
                                                        class="text-muted">{{ $evento->precio ? number_format($evento->precio, 2) . '€' : 'Gratis' }}</small>
                                                </td>
                                                <td>
                                                    <span
                                                        class="d-block small text-dark fw-semibold">{{ $evento->fecha_inicio->format('d M, Y') }}</span>
                                                    <small
                                                        class="text-muted small">{{ $evento->fecha_inicio->format('H:i') }}</small>
                                                </td>
                                                <td class="text-center">
                                                    @if ($evento->activo)
                                                        <span
                                                            class="badge bg-success-subtle text-success px-3">Activo</span>
                                                    @else
                                                        <span
                                                            class="badge bg-secondary-subtle text-secondary px-3">Pausado</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">

                                                    <button type="button" class="btn btn-sm btn-outline-dark  px-3"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editEventModal{{ $evento->id }}">
                                                        Editar
                                                    </button>

                                                    <form action="{{ route('organizador.eventos.destroy', $evento) }}"
                                                        method="POST" class="d-inline-block"
                                                        onsubmit="return confirm('¿Eliminar este evento?');">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            Eliminar
                                                        </button>
                                                    </form>

                                                    <div class="modal fade text-start"
                                                        id="editEventModal{{ $evento->id }}" tabindex="-1"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                                            <div class="modal-content border-0 shadow rounded-4">
                                                                <div class="modal-header border-0 px-4 pt-4">
                                                                    <h5 class="fw-bold text-dark">Editar Evento:
                                                                        {{ $evento->nombre }}</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <form
                                                                    action="{{ route('organizador.eventos.update', $evento) }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" name="lugar_id"
                                                                        value="{{ $evento->lugar_id }}">
                                                                    <div class="modal-body p-4">
                                                                        <div class="row g-3">
                                                                            <div class="col-md-8 text-start">
                                                                                <label
                                                                                    class="form-label fw-semibold">Nombre
                                                                                    del
                                                                                    evento</label>
                                                                                <input type="text" name="nombre"
                                                                                    class="form-control bg-light border-0"
                                                                                    value="{{ $evento->nombre }}"
                                                                                    required>
                                                                            </div>
                                                                            <div class="col-md-4 text-start">
                                                                                <label
                                                                                    class="form-label fw-semibold">Precio
                                                                                    (€)
                                                                                </label>
                                                                                <input type="number" step="0.01"
                                                                                    name="precio"
                                                                                    class="form-control bg-light border-0"
                                                                                    value="{{ $evento->precio }}">
                                                                            </div>
                                                                            <div class="col-md-6 text-start">
                                                                                <label class="form-label fw-semibold">Fecha
                                                                                    Inicio</label>
                                                                                <input type="datetime-local"
                                                                                    name="fecha_inicio"
                                                                                    class="form-control bg-light border-0"
                                                                                    value="{{ $evento->fecha_inicio->format('Y-m-d\TH:i') }}"
                                                                                    required>
                                                                            </div>
                                                                            <div class="col-md-6 text-start">
                                                                                <label class="form-label fw-semibold">Fecha
                                                                                    Fin</label>
                                                                                <input type="datetime-local"
                                                                                    name="fecha_fin"
                                                                                    class="form-control bg-light border-0"
                                                                                    value="{{ $evento->fecha_fin ? $evento->fecha_fin->format('Y-m-d\TH:i') : '' }}">
                                                                            </div>
                                                                            <div class="col-md-12 text-start">
                                                                                <label
                                                                                    class="form-label fw-semibold">Descripción</label>
                                                                                <textarea name="descripcion" class="form-control bg-light border-0" rows="3">{{ $evento->descripcion }}</textarea>
                                                                            </div>
                                                                            {{-- Imágenes existentes --}}
                                                                            @if ($evento->imagenes->isNotEmpty())
                                                                                <div class="col-md-12 text-start">
                                                                                    <label
                                                                                        class="form-label fw-semibold">Foto actual</label>
                                                                                    <div class="d-flex flex-wrap gap-2">
                                                                                        @foreach ($evento->imagenes as $imagen)
                                                                                            <div class="position-relative"
                                                                                                style="width: 100px; height: 100px;">
                                                                                                <img src="{{ $imagen->url }}"
                                                                                                    class="rounded-3 w-100 h-100 object-fit-cover border"
                                                                                                    alt="Foto del evento">
                                                                                            </div>
                                                                                        @endforeach
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                            {{-- Subir nuevas imágenes --}}
                                                                            <div class="col-md-12 text-start">
                                                                                <label
                                                                                    class="form-label fw-semibold">Cambiar foto <span
                                                                                        class="text-muted fw-normal">(máx.
                                                                                        1, hasta 2MB)</span></label>
                                                                                <input type="file" name="imagenes[]"
                                                                                    class="form-control bg-light border-0 image-input"
                                                                                    accept="image/jpeg,image/png,image/gif,image/webp"
                                                                                    data-max-files="1"
                                                                                    data-max-size="2097152">
                                                                                <div class="form-text">Si seleccionas una foto, sustituirá a la que hay ahora.
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12 text-start etiquetas-wrapper">
                                                                                <label class="form-label fw-semibold">Etiquetas</label>
                                                                                <select class="form-select etiquetas-select bg-light border-0">
                                                                                    <option value="">Seleccione una etiqueta...</option>
                                                                                    @foreach ($etiquetas as $id => $nombre)
                                                                                        <option value="{{ $id }}">{{ $nombre }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                <div class="etiquetas-contenedor d-flex flex-wrap gap-2 mt-2">
                                                                                    @foreach ($evento->etiquetas as $etiqueta)
                                                                                        <span class="badge bg-dark text-white p-2 d-inline-flex align-items-center gap-2 rounded" data-badge-id="{{ $etiqueta->id }}">
                                                                                            {{ $etiqueta->nombre }}
                                                                                            <button type="button" class="btn-close btn-close-white p-0" style="font-size: 0.65rem;" data-id="{{ $etiqueta->id }}"></button>
                                                                                        </span>
                                                                                        <input type="hidden" name="etiquetas[]" value="{{ $etiqueta->id }}">
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer border-0 p-4 pt-0">
                                                                        <button type="button" class="btn btn-light px-4"
                                                                            data-bs-dismiss="modal">Cancelar</button>
                                                                        <button type="submit"
                                                                            class="btn btn-dark px-4">Guardar
                                                                            Cambios</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- VALORACIONES (Sidebar de feedback) -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Feedback Reciente</h5>
                            @foreach ($valoraciones as $valoracion)
                                <div class="mb-4 pb-3 border-bottom border-light last-child-no-border">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="fw-bold small">{{ $valoracion->user->nombre ?? 'Anónimo' }}</span>
                                        <span class="text-warning small">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="bi bi-star{{ $i <= $valoracion->puntuacion ? '-fill' : '' }}"></i>
                                            @endfor
                                        </span>
                                    </div>
                                    <p class="text-muted small mb-2">"{{ Str::limit($valoracion->comentario, 60) }}"</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted"
                                            style="font-size: 0.7rem;">{{ $valoracion->created_at->diffForHumans() }}</small>
                                        <form action="{{ route('valoraciones.reportar', $valoracion->id) }}"
                                            method="POST">
                                            @csrf
                                            <button
                                                class="btn btn-link p-0 text-{{ $valoracion->reportado ? 'warning' : 'muted' }} small text-decoration-none">
                                                <i class="bi bi-flag-fill"></i>
                                                {{ $valoracion->reportado ? 'Reportado' : 'Reportar' }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach

                            @if ($valoraciones->hasPages())
                                <div class="mt-3 d-flex justify-content-center">
                                    {{ $valoraciones->links('pagination::bootstrap-5') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- MODAL PARA CREAR EVENTO (Mantiene el dashboard limpio) -->
    <div class="modal fade" id="createEventModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-0 px-4 pt-4">
                    <h5 class="fw-bold">Crear Nuevo Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('organizador.eventos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <input type="hidden" name="lugar_id" value="{{ $lugarSeleccionado->id ?? '' }}">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fw-semibold">Nombre del evento</label>
                                <input type="text" name="nombre" class="form-control bg-light border-0"
                                    placeholder="Ej: Concierto Rock" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Precio (€)</label>
                                <input type="number" step="0.01" name="precio"
                                    class="form-control bg-light border-0" placeholder="0.00">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Fecha Inicio</label>
                                <input type="datetime-local" name="fecha_inicio" class="form-control bg-light border-0"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Fecha Fin</label>
                                <input type="datetime-local" name="fecha_fin" class="form-control bg-light border-0">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Descripción</label>
                                <textarea name="descripcion" class="form-control bg-light border-0" rows="3" placeholder="Cuéntanos más..."></textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Foto del evento <span class="text-muted fw-normal">(máx. 1, hasta 2MB)</span></label>
                                <input type="file" name="imagenes[]"
                                    class="form-control bg-light border-0 image-input"
                                    accept="image/jpeg,image/png,image/gif,image/webp" data-max-files="1"
                                    data-max-size="2097152">
                                <div class="form-text">Formatos: JPG, PNG, GIF, WebP</div>
                            </div>
                            <div class="col-md-12 etiquetas-wrapper">
                                <label class="form-label fw-semibold">Etiquetas</label>
                                <select class="form-select etiquetas-select bg-light border-0">
                                    <option value="">Seleccione una etiqueta...</option>
                                    @foreach ($etiquetas as $id => $nombre)
                                        <option value="{{ $id }}">{{ $nombre }}</option>
                                    @endforeach
                                </select>
                                <div class="etiquetas-contenedor d-flex flex-wrap gap-2 mt-2">
                                    {{-- Los inputs ocultos y chapas se inyectarán dinámicamente aquí --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-dark px-4">Publicar Evento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/admin/etiquetas.js')
    @vite('resources/js/admin/eventos.js')
@endpush
