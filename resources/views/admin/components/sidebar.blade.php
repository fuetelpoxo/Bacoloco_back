{{-- resources/views/components/admin/sidebar.blade.php --}}

<aside class="bg-dark text-white p-3 d-flex flex-column" style="width: 250px; min-height: 100vh;">

    <a href="{{ auth()->user()->rol === 'admin' ? route('admin.dashboard') : route('lugares.index') }}"
        class="text-center mb-3">
        <img src="{{ asset('imagenes/LogoBlanco.png') }}" alt="Logo" class="img-fluid w-50">
    </a>
    <ul class="nav flex-column">

        <li class="nav-item mb-2">
            <a href="{{ route('lugares.index') }}" class="nav-link text-white fw-bold">
                <i class="bi bi-geo-alt me-2"></i>Lugares
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('eventos.index') }}" class="nav-link text-white fw-bold">
                <i class="bi bi-calendar-event me-2"></i>Eventos
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('usuarios.index') }}" class="nav-link text-white fw-bold">
                <i class="bi bi-people me-2"></i>Usuarios
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('valoraciones.index') }}" class="nav-link text-white fw-bold">
                <i class="bi bi-star me-2"></i>Valoraciones
            </a>
        </li>

    </ul>

    <div class="mt-auto pt-3 border-top border-secondary">
        <a href="{{ config('app.frontend_url') }}" class="btn btn-outline-light w-100 mb-2">
            <i class="bi bi-box-arrow-up-right me-2"></i>Ir al sitio
        </a>
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-100">
                <i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión
            </button>
        </form>
    </div>

</aside>
