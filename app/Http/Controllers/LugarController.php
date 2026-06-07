<?php

namespace App\Http\Controllers;

use App\Models\Etiqueta;
use App\Models\Imagen;
use App\Models\Lugar;
use App\Models\Tipo;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LugarController extends Controller
{
    /**
     * Muestra la lista de lugares con filtros aplicados.
     *
     * @return View
     */
    public function index(Request $request)
    {
        $query = Lugar::with('tipo')->withCount('eventos');

        $this->aplicarFiltros($query, $request);

        $lugares = $query->paginate(10)
            ->withQueryString();

        $tipos = Tipo::pluck('nombre', 'id');

        return view('admin.lugares.index', compact('lugares', 'tipos'));
    }

    /**
     * Muestra el formulario para crear un nuevo lugar.
     *
     * @return View
     */
    public function create()
    {
        $tipos = Tipo::pluck('nombre', 'id');
        $users = User::pluck('nombre', 'id');
        $etiquetas = Etiqueta::orderBy('nombre')->pluck('nombre', 'id');

        return view('admin.lugares.create', compact('tipos', 'users', 'etiquetas'));
    }

    /**
     * Guarda un nuevo lugar en la base de datos.
     *
     * @return RedirectResponse
     */
    public function store(Request $request, ImageService $imageService)
    {
        $data = $request->validate([
            'tipo_id' => 'required|integer|exists:tipos,id',
            'user_id' => 'required|integer|exists:users,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'latitud' => 'required|numeric|between:-90,90',
            'longitud' => 'required|numeric|between:-180,180',
            'municipio' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'activo' => 'sometimes|boolean',
            'imagenes' => 'nullable|array',
            'imagenes.*' => 'nullable|image|max:2048|mimes:jpeg,png,gif,webp',
            'etiquetas' => 'nullable|array|max:4',
            'etiquetas.*' => 'integer|exists:etiquetas,id',
        ]);

        return DB::transaction(function () use ($request, $data, $imageService) {
            $lugar = Lugar::create($data);

            if ($request->hasFile('imagenes')) {
                foreach ($request->file('imagenes') as $archivo) {
                    $ruta = $imageService->optimizarYGuardar($archivo, 'lugares');

                    $imagen = Imagen::create([
                        'ruta' => $ruta,
                        'tipo' => 'lugar',
                    ]);

                    $lugar->imagenes()->attach($imagen->id);
                }
            }

            if ($request->has('etiquetas')) {
                $lugar->etiquetas()->attach($request->input('etiquetas'));
            }

            return redirect()->route('lugares.index')->with('success', 'Lugar creado correctamente.');
        });
    }

    /**
     * Muestra el formulario para editar un lugar existente.
     *
     * @return View
     */
    public function edit(Lugar $lugar)
    {
        $lugar->load(['imagenes', 'etiquetas']);
        $tipos = Tipo::orderBy('nombre')->pluck('nombre', 'id');
        $users = User::orderBy('nombre')->pluck('nombre', 'id');
        $etiquetas = Etiqueta::orderBy('nombre')->pluck('nombre', 'id');

        return view('admin.lugares.edit', compact('lugar', 'tipos', 'users', 'etiquetas'));
    }

    /**
     * Actualiza un lugar existente en la base de datos.
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Lugar $lugar, ImageService $imageService)
    {
        $data = $request->validate([
            'tipo_id' => 'required|integer|exists:tipos,id',
            'user_id' => 'required|integer|exists:users,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'latitud' => 'required|numeric|between:-90,90',
            'longitud' => 'required|numeric|between:-180,180',
            'municipio' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'activo' => 'sometimes|boolean',
            'imagenes' => 'nullable|array',
            'imagenes.*' => 'nullable|image|max:2048|mimes:jpeg,png,gif,webp',
            'etiquetas' => 'nullable|array|max:4',
            'etiquetas.*' => 'integer|exists:etiquetas,id',
        ]);

        return DB::transaction(function () use ($request, $data, $lugar, $imageService) {
            $lugar->update($data);

            if ($request->hasFile('imagenes')) {
                foreach ($request->file('imagenes') as $archivo) {
                    $ruta = $imageService->optimizarYGuardar($archivo, 'lugares');

                    $imagen = Imagen::create([
                        'ruta' => $ruta,
                        'tipo' => 'lugar',
                    ]);

                    $lugar->imagenes()->attach($imagen->id);
                }
            }

            $lugar->etiquetas()->sync($request->input('etiquetas', []));

            return redirect()->route('lugares.index')->with('success', 'Lugar actualizado correctamente.');
        });
    }

    /**
     * Elimina un lugar de la base de datos.
     *
     * @return RedirectResponse
     */
    public function destroy(Lugar $lugar)
    {
        $lugar->delete();

        return redirect()->route('lugares.index')->with('success', 'Lugar eliminado correctamente.');
    }

    /**
     * Genera la lista de filtros aplicados.
     *
     * @param  Builder  $query
     * @return Builder
     */
    private function aplicarFiltros($query, Request $request)
    {
        return $query
            ->when($request->activo !== null && $request->activo !== '', function ($query) use ($request) {
                $query->where('activo', '=', $request->activo);
            })
            ->when($request->tipo_id, function ($query, $tipoId) {
                $query->where('tipo_id', '=', $tipoId);
            })
            ->when($request->municipio, function ($query, $municipio) {
                $query->where('municipio', '=', $municipio);
            })
            ->when($request->nombre, function ($query, $nombre) {
                $query->where('nombre', 'like', '%'.$nombre.'%');
            });
    }
}
