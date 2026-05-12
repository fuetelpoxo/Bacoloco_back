{{-- resources/views/components/admin/sidebar.blade.php --}}

<aside class="bg-dark text-white p-3 d-flex flex-column" style="width: 250px; min-height: 100vh;">

    <img src="{{ asset('imagenes/LogoBlanco.png') }}" href alt="Logo" class="img-fluid w-50">
    <ul class="nav flex-column">

        <li class="nav-item mb-2">
            <a href="{{ route('lugares.index') }}" class="nav-link text-white fw-bold">
                Lugares
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('eventos.index') }}" class="nav-link text-white fw-bold">
                Eventos
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('usuarios.index') }}" class="nav-link text-white fw-bold">
                Usuarios
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('valoraciones.index') }}" class="nav-link text-white fw-bold">
                Valoraciones
            </a>
        </li>

    </ul>
    <form action="{{ route('logout') }}" method="POST" class="mt-auto">
        @csrf

        <button type="submit" class="btn btn-outline-light w-100">
            Cerrar sesión
        </button>
    </form>

</aside>
