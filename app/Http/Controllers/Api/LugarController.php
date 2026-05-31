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
            $query = Lugar::with('etiquetas', 'imagenes')
                ->withAvg('valoraciones', 'puntuacion');
            $this->aplicarFiltros($query, $request);

            if ($request->has('limit')) {
                $limit = (int) $request->limit;
                $offset = (int) $request->input('offset', 0);
                $query->skip($offset)->take($limit);
            }

            $lugares = $query->get();

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
                ->with('tipo:id,nombre')
                ->has('valoraciones')
                ->orderByDesc('valoraciones_avg_puntuacion');

            if ($request->has('tipo_id')) {
                $query->where('tipo_id', $request->tipo_id);
            }

            $limit = $request->has('limit') ? (int) $request->limit : 5;
            $lugares = $query->take($limit)->get();

            if ($lugares->isEmpty()) {
                $queryFallback = Lugar::withAvg('valoraciones', 'puntuacion')
                    ->with('tipo:id,nombre')
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
            $lugar = Lugar::with([
                'etiquetas',
                'eventos' => function ($query) {
                    $query->where('activo', true)
                        ->where('fecha_inicio', '>=', now())
                        ->orderBy('fecha_inicio', 'asc')
                        ->take(5);
                },
                'imagenes'
            ])->find($id);

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

    /**
     * Aplica los filtros de búsqueda a la consulta de lugares.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function aplicarFiltros($query, Request $request)
    {
        return $query
            ->when($request->has('tipo_id') || $request->has('tipo'), function ($query) use ($request) {
                $tipoId = $request->input('tipo_id', $request->input('tipo'));
                $query->where('tipo_id', $tipoId);
            })
            ->when($request->municipio, function ($query, $municipio) {
                $query->where('municipio', $municipio);
            })
            ->when($request->buscar, function ($query, $buscar) {
                $query->where('nombre', 'like', '%' . $buscar . '%');
            })
            ->when($request->order, function ($query, $order) {
                $allowedColumns = ['nombre', 'municipio', 'created_at', 'id'];
                if (in_array($order, $allowedColumns, true)) {
                    $query->orderBy($order, 'desc');
                }
            });
    }

    /**
     * Devuelve el lugar y todos sus eventos ordenados por fecha de inicio.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEventosPorLugar($id)
    {
        try {
            $lugar = Lugar::with('imagenes')->find($id);

            if (!$lugar) {
                return response()->json(['message' => 'Lugar no encontrado.'], 404);
            }

            $eventos = $lugar->eventos()
                ->with('imagenes')
                ->orderBy('fecha_inicio', 'asc')
                ->get();

            return response()->json([
                'lugar'   => $lugar,
                'eventos' => $eventos,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al obtener los eventos del lugar.',
            ], 500);
        }
    }
}
