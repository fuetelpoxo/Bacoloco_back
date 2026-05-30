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
                'imagenes',
                'lugar'
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

    /**
     * Obtiene las próximas verbenas (eventos en lugares de tipo 3)
     * ordenados por fecha de inicio más cercana.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function proximasVerbenas()
    {
        try {
            $hoy = now()->startOfDay();
            
            $eventos = Evento::with('lugar')
                ->whereHas('lugar', function ($query) {
                    $query->where('tipo_id', 3);
                })
                ->where('fecha_inicio', '>=', $hoy)
                ->orderBy('fecha_inicio', 'asc')
                ->take(5)
                ->get();

            if ($eventos->isEmpty()) {
                $eventos = Evento::with('lugar')
                    ->whereHas('lugar', function ($query) {
                        $query->where('tipo_id', 3);
                    })
                    ->orderBy('fecha_inicio', 'desc')
                    ->take(5)
                    ->get();
            }

            return response()->json($eventos);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las próximas verbenas: ' . $e->getMessage(),
            ], 500);
        }
    }
}
