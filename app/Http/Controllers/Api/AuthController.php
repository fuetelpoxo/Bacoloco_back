<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Registra un nuevo usuario en la aplicación.
     *
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $user = User::create([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'rol' => 'usuario',
            ]);

            Auth::login($user);
            $request->session()->regenerate();

            return response()->json([
                'message' => 'Usuario registrado correctamente.',
                'user' => [
                    'id' => $user->id,
                    'nombre' => $user->nombre,
                    'email' => $user->email,
                    'rol' => $user->rol,
                ],
            ], 201);
        } catch (\Exception) {
            return response()->json([
                'message' => 'No se pudo registrar el usuario.',
            ], 500);
        }
    }

    /**
     * Inicia sesión de un usuario existente.
     *
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (! Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Credenciales incorrectas',
            ], 401);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        return response()->json([
            'message' => 'Login correcto',
            'user' => [
                'id' => $user->id,
                'nombre' => $user->nombre,
                'email' => $user->email,
                'rol' => $user->rol,
            ],
        ]);
    }

    /**
     * Cierra la sesión del usuario autenticado.
     *
     * @return JsonResponse|RedirectResponse
     */
    public function logout(Request $request)
    {
        $isJson = $request->expectsJson();

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($isJson) {
            return response()->json([
                'message' => 'Logout correcto.',
            ]);
        }

        return redirect(config('app.frontend_url').'/login');
    }
}
