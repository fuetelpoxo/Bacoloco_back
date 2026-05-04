{{-- resources/views/layouts/admin.blade.php --}}

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="d-flex">

        @include('components.sidebar')

        <main class="p-4 w-100" style="min-height: 100vh;">
            @yield('content')
        </main>

    </div>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Estilos básicos --}}
    <style>
        body {
            margin: 0;
            background-color: #f8f9fa;
        }

        .nav-link:hover {
            background-color: #495057;
            border-radius: 5px;
        }
    </style>

</body>
</html>
