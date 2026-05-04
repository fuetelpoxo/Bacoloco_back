{{-- resources/views/components/admin/sidebar.blade.php --}}

<aside class="text-white p-3" style="width: 250px; min-height: 100vh; background-color: #2f2d2d;">

    <img src="{{ asset('imagenes/LogoBlanco.png') }}" alt="Logo" class="img-fluid w-50">
    <ul class="nav flex-column">

        <li class="nav-item mb-2">
            <a href="/lugares" class="nav-link text-white fw-bold">
                Lugares
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="/eventos" class="nav-link text-white fw-bold">
                Eventos
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="#" class="nav-link text-white">
                Usuarios
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="#" class="nav-link text-white">
                Valoraciones
            </a>
        </li>

    </ul>

</aside>
