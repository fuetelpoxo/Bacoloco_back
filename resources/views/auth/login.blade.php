<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Bacoloco</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
        }

        .login-card {
            background-color: #2f2d2d;
            color: white;
            width: 100%;
            max-width: 420px;
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
        }

        .logo {
            width: 90px;
            height: 90px;
            object-fit: contain;
        }

        .btn-bacoloco {
            background-color: white;
            color: #2f2d2d;
            border: none;
        }

        .btn-bacoloco:hover {
            background-color: #2f2d2d;
            color: white;
            border: 0.5px solid white;
        }
    </style>
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <div class="card login-card p-4">

            <div class="text-center mb-4">

                <img src="{{ asset('imagenes/logoBlanco.png') }}" alt="Logo Bacoloco" class="logo mb-3">

                <h1 class="h3 fw-bold">Iniciar sesión</h1>

            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">

                @csrf

                <div class="mb-3">

                    <label for="email" class="form-label">
                        Email
                    </label>

                    <input id="email" name="email" type="email" class="form-control" autocomplete="email"
                        value="{{ old('email') }}" required autofocus>

                </div>

                <div class="mb-4">

                    <label for="password" class="form-label">
                        Contraseña
                    </label>

                    <input id="password" name="password" type="password" class="form-control"
                        autocomplete="current-password" required>

                </div>

                <button type="submit" class="btn btn-bacoloco w-100 py-2">
                    Entrar
                </button>

            </form>

        </div>

    </div>

</body>

</html>
