<?php

namespace App\Http\Controllers;

use App\Models\Valoracion;
use App\Models\Lugar;
use App\Models\User;
use Illuminate\Http\Request;

class ValoracionController extends Controller
{
    public function index(Request $request)
    {
        $filtros = $this->aplicarFiltros($request);

        // Cargamos todas las valoraciones con su usuario y lugar, aplicando los filtros
        $valoraciones = Valoracion::with(['user', 'lugar'])
            ->where($filtros)
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        // Obtenemos los lugares para el select del filtro
        $lugares = Lugar::orderBy('nombre')->pluck('nombre', 'id');

        // Obtenemos los usuarios que tienen valoraciones para el select del filtro
        $usuarios = User::has('valoraciones')
            ->orderBy('nombre')
            ->pluck('nombre', 'id');

        return view('admin.valoraciones.index', compact('valoraciones', 'lugares', 'usuarios'));
    }

    public function create()
    {
        $lugares = Lugar::orderBy('nombre')->pluck('nombre', 'id');
        $usuarios = User::orderBy('nombre')->pluck('nombre', 'id');
        return view('admin.valoraciones.create', compact('lugares', 'usuarios'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'lugar_id' => 'required|exists:lugares,id',
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:1000',
        ]);

        Valoracion::create($data);

        return redirect()->route('valoraciones.index')->with('success', 'Valoración creada correctamente.');
    }

    public function edit(Valoracion $valoracion)
    {
        $lugares = Lugar::orderBy('nombre')->pluck('nombre', 'id');
        $usuarios = User::orderBy('nombre')->pluck('nombre', 'id');
        return view('admin.valoraciones.edit', compact('valoracion', 'lugares', 'usuarios'));
    }

    public function update(Request $request, Valoracion $valoracion)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'lugar_id' => 'required|exists:lugares,id',
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:1000',
            'reportado' => 'nullable|boolean',
        ]);

        $valoracion->update($data);

        return redirect()->route('valoraciones.index')->with('success', 'Valoración actualizada correctamente.');
    }

    public function destroy(Valoracion $valoracion)
    {
        $valoracion->delete();

        return redirect()->route('valoraciones.index')->with('success', 'Valoración eliminada correctamente.');
    }

    private function aplicarFiltros(Request $request)
    {
        $filtros = [];

        // Filtro por ID de usuario (viene del select)
        if ($request->filled('user_id')) {
            $filtros[] = ['user_id', '=', $request->user_id];
        }

        // Filtro por puntuación (número exacto)
        if ($request->filled('puntuacion')) {
            $filtros[] = ['puntuacion', '=', $request->puntuacion];
        }

        // Filtro por ID de lugar (viene del select)
        if ($request->filled('lugar_id')) {
            $filtros[] = ['lugar_id', '=', $request->lugar_id];
        }

        // Filtro por reportado
        if ($request->filled('reportado')) {
            $filtros[] = ['reportado', '=', $request->reportado];
        }

        return $filtros;
    }
}