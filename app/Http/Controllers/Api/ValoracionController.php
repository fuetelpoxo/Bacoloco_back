<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Valoracion;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ValoracionController extends Controller
{
    /**
     * Obtiene todas las valoraciones del usuario autenticado.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $valoraciones = Valoracion::with('lugar')
                ->where('user_id', Auth::id())
                ->get();

            if ($valoraciones->isEmpty()) {
                return response()->json([
                    'message' => 'No se encontraron valoraciones para este usuario.',
                ], 404);
            }

            return response()->json($valoraciones);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'No se pudieron obtener las valoraciones.',
            ], 500);
        }
    }

    /**
     * Crea una nueva valoración.
     *
     * Valida que:
     * - el usuario exista
     * - el lugar exista
     * - la puntuación esté entre 1 y 5
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lugar_id' => 'required|exists:lugares,id',
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $valoracion = Valoracion::create([
                'user_id' => Auth::id(),
                'lugar_id' => $request->lugar_id,
                'puntuacion' => $request->puntuacion,
                'comentario' => $request->comentario,
            ]);

            return response()->json([
                'message' => 'Valoración creada correctamente.',
                'valoracion' => $valoracion,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'No se pudo crear la valoración.',
            ], 500);
        }
    }

    /**
     * Actualiza una valoración por su ID.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'puntuacion' => 'sometimes|required|integer|min:1|max:5',
            'comentario' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $valoracion = Valoracion::find($id);

            if (!$valoracion) {
                return response()->json([
                    'message' => 'Valoración no encontrada.',
                ], 404);
            }

            $valoracion->update($request->only(['puntuacion', 'comentario']));

            return response()->json([
                'message' => 'Valoración actualizada correctamente.',
                'valoracion' => $valoracion,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'No se pudo actualizar la valoración.',
            ], 500);
        }
    }

    /**
     * Elimina una valoración por su ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $valoracion = Valoracion::find($id);

            if (!$valoracion) {
                return response()->json([
                    'message' => 'Valoración no encontrada.',
                ], 404);
            }

            $valoracion->delete();

            return response()->json([
                'message' => 'Valoración eliminada correctamente.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'No se pudo eliminar la valoración.',
            ], 500);
        }
    }
}
