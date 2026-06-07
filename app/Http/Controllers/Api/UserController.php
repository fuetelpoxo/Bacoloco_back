<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Actualiza nombre y email del usuario autenticado.
     *
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255|unique:users,email,'.Auth::id(),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $user = User::find(Auth::id());

            if (! $user) {
                return response()->json([
                    'message' => 'Usuario no encontrado.',
                ], 404);
            }

            $user->update($request->only(['nombre', 'email']));

            return response()->json([
                'message' => 'Usuario actualizado correctamente.',
                'user' => $user,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'No se pudo actualizar el usuario.',
            ], 500);
        }
    }

    /**
     * Cambia la contraseña del usuario autenticado.
     *
     * @return JsonResponse
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password_actual' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $user = User::find(Auth::id());

            if (! $user) {
                return response()->json([
                    'message' => 'Usuario no encontrado.',
                ], 404);
            }

            if (! Hash::check($request->password_actual, $user->password)) {
                return response()->json([
                    'message' => 'La contraseña actual no es correcta.',
                ], 401);
            }

            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'message' => 'Contraseña actualizada correctamente.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'No se pudo cambiar la contraseña.',
            ], 500);
        }
    }

    /**
     * Elimina la cuenta del usuario autenticado.
     *
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        try {
            $user = $request->user();

            if (! $user) {
                return response()->json([
                    'message' => 'Usuario no autenticado.',
                ], 401);
            }

            $user->delete();

            // Cerrar la sesión de forma efectiva para el usuario que se borra a sí mismo
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json([
                'message' => 'Cuenta eliminada correctamente.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'No se pudo eliminar la cuenta.',
            ], 500);
        }
    }
}
