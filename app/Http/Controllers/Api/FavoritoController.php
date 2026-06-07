<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorito;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FavoritoController extends Controller
{
    /**
     * Guarda un lugar como favorito para un usuario.
     *
     * Valida que:
     * - el usuario exista
     * - el lugar exista
     * - no exista ya ese favorito previamente
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lugar_id' => 'required|exists:lugares,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $favoritoExistente = Favorito::where('user_id', Auth::id())
                ->where('lugar_id', $request->lugar_id)
                ->first();

            if ($favoritoExistente) {
                return response()->json([
                    'message' => 'Este lugar ya está en favoritos.',
                    'favorito' => $favoritoExistente,
                ], 200);
            }

            $favorito = Favorito::create([
                'user_id' => Auth::id(),
                'lugar_id' => $request->lugar_id,
            ]);

            return response()->json([
                'message' => 'Favorito guardado correctamente.',
                'favorito' => $favorito,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'No se pudo guardar el favorito.',
            ], 500);
        }
    }

    /**
     * Obtiene todos los favoritos de un usuario
     * junto con la información del lugar relacionado.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $favoritos = Favorito::with('lugar.imagenes')
                ->where('user_id', Auth::id())
                ->get();

            return response()->json($favoritos);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'No se pudieron obtener los favoritos.',
            ], 500);
        }
    }

    /**
     * Elimina un favorito mediante su ID.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            $favorito = Favorito::find($id);

            if (! $favorito) {
                return response()->json([
                    'message' => 'Favorito no encontrado.',
                ], 404);
            }

            if ($favorito->user_id !== Auth::id()) {
                return response()->json([
                    'message' => 'Acción no autorizada.',
                ], 403);
            }

            $favorito->delete();

            return response()->json([
                'message' => 'favorito eliminado correctamente.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'No se pudo eliminar el favorito.',
            ], 500);
        }
    }
}
