<?php

namespace App\Http\Controllers;

use App\Models\Lugar;
use App\Models\User;
use App\Models\Valoracion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ValoracionController extends Controller
{
    /**
     * Muestra el listado de valoraciones con filtros opcionales.
     *
     * @return View
     */
    public function index(Request $request)
    {
        $query = Valoracion::with(['user', 'lugar']);

        $this->aplicarFiltros($query, $request);

        $valoraciones = $query->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        $lugares = Lugar::orderBy('nombre')->pluck('nombre', 'id');

        $usuarios = User::has('valoraciones')
            ->orderBy('nombre')
            ->pluck('nombre', 'id');

        return view('admin.valoraciones.index', compact('valoraciones', 'lugares', 'usuarios'));
    }

    /**
     * Muestra el formulario para crear una nueva valoración.
     *
     * @return View
     */
    public function create()
    {
        $lugares = Lugar::orderBy('nombre')->pluck('nombre', 'id');
        $usuarios = User::orderBy('nombre')->pluck('nombre', 'id');

        return view('admin.valoraciones.create', compact('lugares', 'usuarios'));
    }

    /**
     * Guarda una nueva valoración en la base de datos.
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'lugar_id' => 'required|exists:lugares,id',
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:1000',
        ]);

        $data['user_id'] = $data['user_id'];

        Valoracion::create($data);

        return redirect()->route('valoraciones.index')->with('success', 'Valoración creada correctamente.');
    }

    /**
     * Muestra el formulario para editar una valoración existente.
     *
     * @return View
     */
    public function edit(Valoracion $valoracion)
    {
        $lugares = Lugar::orderBy('nombre')->pluck('nombre', 'id');
        $usuarios = User::orderBy('nombre')->pluck('nombre', 'id');

        return view('admin.valoraciones.edit', compact('valoracion', 'lugares', 'usuarios'));
    }

    /**
     * Actualiza una valoración existente en la base de datos.
     *
     * @return RedirectResponse
     */
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

    /**
     * Elimina una valoración de la base de datos.
     *
     * @return RedirectResponse
     */
    public function destroy(Valoracion $valoracion)
    {
        $valoracion->delete();

        return redirect()->route('valoraciones.index')->with('success', 'Valoración eliminada correctamente.');
    }

    /**
     * Aplica los filtros de búsqueda a la consulta de valoraciones.
     *
     * @param  Builder  $query
     * @return Builder
     */
    private function aplicarFiltros($query, Request $request)
    {
        return $query
            ->when($request->filled('user_id'), function ($query) use ($request) {
                $query->where('user_id', '=', $request->user_id);
            })
            ->when($request->filled('puntuacion'), function ($query) use ($request) {
                $query->where('puntuacion', '=', $request->puntuacion);
            })
            ->when($request->filled('lugar_id'), function ($query) use ($request) {
                $query->where('lugar_id', '=', $request->lugar_id);
            })
            ->when($request->filled('reportado'), function ($query) use ($request) {
                $query->where('reportado', '=', $request->reportado);
            });
    }
}
