<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use Exception;

class EventoController extends Controller
{
    /**
     * Muestra el detalle completo de un evento
     * junto con sus relaciones asociadas.
     *
     * Incluye:
     * - etiquetas
     * - imágenes
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $evento = Evento::with(
                'etiquetas',
                'imagenes'
            )->find($id);

            if (!$evento) {
                return response()->json([
                    'message' => 'Evento no encontrado.',
                ], 404);
            }

            return response()->json($evento);
        } catch (Exception) {
            return response()->json([
                'message' => 'Error al obtener el evento.',
            ], 500);
        }
    }
}
