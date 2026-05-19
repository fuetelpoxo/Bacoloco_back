<?php

namespace App\Http\Controllers;

use App\Models\Lugar;
use App\Models\Valoracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizadorController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();

        // Obtener todos los lugares del usuario
        $lugares = Lugar::where('user_id', $user->id)
            ->withCount('valoraciones')
            ->orderBy('nombre')
            ->get();

        // Si no tiene lugares, mostrar mensaje
        if ($lugares->isEmpty()) {
            return view('organizador.dashboard', [
                'lugares' => $lugares,
                'lugarSeleccionado' => null,
                'valoraciones' => collect(),
                'eventos' => collect(),
            ]);
        }

        // Determinar lugar seleccionado
        $lugarId = $request->input('lugar_id', $lugares->first()->id);
        $lugarSeleccionado = $lugares->find($lugarId);

        // Si el lugar no existe o no pertenece al usuario, redirigir
        if (!$lugarSeleccionado) {
            $lugarSeleccionado = $lugares->first();
            $lugarId = $lugarSeleccionado->id;
        }

        // Obtener eventos del lugar seleccionado con filtro de búsqueda
        $search = $request->input('search');
        $eventos = $lugarSeleccionado->eventos()
            ->with('imagenes')
            ->when($search, function ($query, $search) {
                return $query->where('nombre', 'like', '%' . $search . '%');
            })
            ->orderByDesc('fecha_inicio')
            ->get();

        // Obtener valoraciones del lugar seleccionado
        $valoraciones = $lugarSeleccionado->valoraciones()
            ->with('user')
            ->orderByDesc('created_at')
            ->paginate(10)
            ->appends($request->query());

        return view('organizador.dashboard', compact('lugares', 'lugarSeleccionado', 'eventos', 'valoraciones'));
    }

    public function reportarValoracion($valoracionId)
    {
        $valoracion = Valoracion::findOrFail($valoracionId);

        // Verificar que el lugar pertenece al usuario
        if ($valoracion->lugar->user_id !== Auth::id()) {
            abort(403);
        }

        $valoracion->update(['reportado' => !$valoracion->reportado]);

        return back()->with('success', 'Estado de reporte actualizado.');
    }
}
