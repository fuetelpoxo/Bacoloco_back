<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lugar;
use Exception;
use Illuminate\Http\Request;

class LugarController extends Controller
{
    /**
     * Muestra el listado de lugares con filtros opcionales.
     *
     * Permite filtrar por:
     * - tipo
     * - municipio
     * - búsqueda por nombre
     * - ordenación
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $query = Lugar::with('etiquetas', 'imagenes');

            if ($request->tipo) {
                $query->where('tipo', $request->tipo);
            }

            if ($request->municipio) {
                $query->where('municipio', $request->municipio);
            }

            if ($request->buscar) {
                $query->where('nombre', 'like', '%' . $request->buscar . '%');
            }

            if ($request->order) {
                $query->orderBy($request->order, 'desc');
            }

            $lugares = $query->get();

            if ($lugares->isEmpty()) {
                return response()->json([
                    'message' => 'No se encontraron lugares.',
                ], 404);
            }
            return response()->json($lugares);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'No se han podido recoger los datos.',
            ], 500);
        }
    }
    /**
     * Obtiene los datos mínimos necesarios para mostrar
     * los marcadores en el mapa.
     *
     * Incluye:
     * - id
     * - nombre
     * - tipo
     * - municipio
     * - latitud
     * - longitud
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDatosMapa()
    {
        try {
            $lugares = Lugar::with('tipo:id,nombre')
                ->select(
                    'id',
                    'nombre',
                    'tipo_id',
                    'municipio',
                    'latitud',
                    'longitud'
                )
                ->get();
            if ($lugares->isEmpty()) {
                return response()->json([
                    'message' => 'No se encontraron datos de lugares para el mapa.',
                ], 404);
            }

            return response()->json($lugares);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al obtener los datos del mapa.',
            ], 500);
        }
    }

    /**
     * Obtiene los mejores lugares basados en su valoración media.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMejores(Request $request)
    {
        try {
            $query = Lugar::withAvg('valoraciones', 'puntuacion')
                ->with('tipo:id,nombre', 'imagenes')
                ->has('valoraciones')
                ->orderByDesc('valoraciones_avg_puntuacion');

            if ($request->has('tipo_id')) {
                $query->where('tipo_id', $request->tipo_id);
            }

            $limit = $request->has('limit') ? (int) $request->limit : 5;
            $lugares = $query->take($limit)->get();

            // Fallback: si no hay suficientes con valoración, traer los más recientes
            if ($lugares->isEmpty()) {
                $queryFallback = Lugar::withAvg('valoraciones', 'puntuacion')
                    ->with('tipo:id,nombre', 'imagenes')
                    ->orderByDesc('created_at');
                    
                if ($request->has('tipo_id')) {
                    $queryFallback->where('tipo_id', $request->tipo_id);
                }
                $lugares = $queryFallback->take($limit)->get();
            }

            return response()->json($lugares);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al obtener los mejores lugares.',
            ], 500);
        }
    }

    /**
     * Muestra el detalle completo de un lugar
     * junto con todas sus relaciones.
     *
     * Incluye:
     * - etiquetas
     * - eventos
     * - valoraciones
     * - imágenes
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $lugar = Lugar::with(
                'etiquetas',
                'eventos',
                'valoraciones',
                'imagenes'
            )->find($id);
            if (!$lugar) {
                return response()->json([
                    'message' => 'Lugar no encontrado.',
                ], 404);
            }

            return response()->json($lugar);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al obtener la información del lugar.',
            ], 500);
        }
    }
}
