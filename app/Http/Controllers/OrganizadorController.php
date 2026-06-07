<?php

namespace App\Http\Controllers;

use App\Models\Etiqueta;
use App\Models\Lugar;
use App\Models\Valoracion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrganizadorController extends Controller
{
    /**
     * Muestra el panel de control del organizador.
     *
     * @return View|RedirectResponse
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();

        $lugares = Lugar::where('user_id', $user->id)
            ->withCount('valoraciones')
            ->withAvg('valoraciones', 'puntuacion')
            ->orderBy('nombre')
            ->get();

        if ($lugares->isEmpty()) {
            return view('organizador.dashboard', [
                'lugares' => $lugares,
                'lugarSeleccionado' => null,
                'valoraciones' => collect(),
                'eventos' => collect(),
            ]);
        }

        $lugarId = $request->input('lugar_id', $lugares->first()->id);
        $lugarSeleccionado = $lugares->find($lugarId);

        if (! $lugarSeleccionado) {
            $lugarSeleccionado = $lugares->first();
            $lugarId = $lugarSeleccionado->id;
        }

        $search = $request->input('search');
        $eventos = $lugarSeleccionado->eventos()
            ->with(['imagenes', 'etiquetas'])
            ->when($search, function ($query, $search) {
                return $query->where('nombre', 'like', '%'.$search.'%');
            })
            ->orderByDesc('fecha_inicio')
            ->get();

        $valoraciones = $lugarSeleccionado->valoraciones()
            ->with('user')
            ->orderByDesc('created_at')
            ->paginate(10)
            ->appends($request->query());

        $promedioValoraciones = $lugarSeleccionado->valoraciones_avg_puntuacion ?? 0;
        $totalValoraciones = $lugarSeleccionado->valoraciones_count;

        $etiquetas = Etiqueta::orderBy('nombre')->pluck('nombre', 'id');

        return view('organizador.dashboard', compact(
            'lugares',
            'lugarSeleccionado',
            'eventos',
            'valoraciones',
            'etiquetas',
            'promedioValoraciones',
            'totalValoraciones'
        ));
    }

    /**
     * Alterna el estado de reporte de una valoración.
     *
     * @param  int  $valoracionId
     * @return RedirectResponse
     */
    public function reportarValoracion($valoracionId)
    {
        $valoracion = Valoracion::findOrFail($valoracionId);

        if ($valoracion->lugar->user_id !== Auth::id()) {
            abort(403);
        }

        $valoracion->update(['reportado' => ! $valoracion->reportado]);

        return back()->with('success', 'Estado de reporte actualizado.');
    }
}
