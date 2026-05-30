<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use App\Models\Evento;
use App\Models\Lugar;
use App\Models\User;
use App\Models\Etiqueta;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class EventoController extends Controller
{
    /**
     * Muestra el listado de eventos con filtros opcionales.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $eventos = Evento::with(['lugar', 'user'])
            ->where($this->aplicarFiltros($request))
            ->orderByDesc('fecha_inicio')
            ->paginate(10)
            ->withQueryString();

        $lugares = Lugar::orderBy('nombre')->pluck('nombre', 'id');

        return view('admin.eventos.index', compact('eventos', 'lugares'));
    }

    /**
     * Muestra el formulario para crear un nuevo evento.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $lugares = Lugar::orderBy('nombre')->pluck('nombre', 'id');
        $users = User::orderBy('nombre')->pluck('nombre', 'id');
        $etiquetas = Etiqueta::orderBy('nombre')->pluck('nombre', 'id');

        return view('admin.eventos.create', compact('lugares', 'users', 'etiquetas'));
    }

    /**
     * Guarda un nuevo evento en la base de datos.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\ImageService $imageService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, ImageService $imageService)
    {
        $userIdRule = Auth::user()->rol === 'organizador' ? 'nullable' : 'required|integer|exists:users,id';
        $maxImagenes = Auth::user()->rol === 'organizador' ? 1 : 3;

        $data = $request->validate([
            'lugar_id' => 'nullable|integer|exists:lugares,id',
            'user_id' => $userIdRule,
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'precio' => 'nullable|numeric|min:0',
            'activo' => 'sometimes|boolean',
            'imagenes' => 'nullable|array|max:' . $maxImagenes,
            'imagenes.*' => 'nullable|image|max:2048|mimes:jpeg,png,gif,webp',
            'etiquetas' => 'nullable|array|max:4',
            'etiquetas.*' => 'integer|exists:etiquetas,id',
        ]);

        return DB::transaction(function () use ($request, $data, $imageService) {
            if (Auth::user()->rol === 'organizador') {
                if ($data['lugar_id'] ?? null) {
                    $lugar = Lugar::findOrFail($data['lugar_id']);
                    if ($lugar->user_id !== Auth::id()) {
                        return redirect()->route('organizador.dashboard')->with('error', 'No tienes permiso para crear eventos en este lugar.');
                    }
                }
                $data['user_id'] = Auth::id();
            }

            $evento = Evento::create($data);

            if ($request->hasFile('imagenes')) {
                foreach ($request->file('imagenes') as $archivo) {
                    $ruta = $imageService->optimizarYGuardar($archivo, 'eventos');

                    $imagen = Imagen::create([
                        'ruta' => $ruta,
                        'tipo' => 'evento',
                    ]);

                    $evento->imagenes()->attach($imagen->id);
                }
            }

            if ($request->has('etiquetas')) {
                $evento->etiquetas()->attach($request->input('etiquetas'));
            }

            if (Auth::user()->rol === 'organizador') {
                return redirect()->route('organizador.dashboard')->with('success', 'Evento creado correctamente.');
            }

            return redirect()->route('eventos.index')->with('success', 'Evento creado correctamente.');
        });
    }

    /**
     * Muestra el formulario para editar un evento existente.
     *
     * @param \App\Models\Evento $evento
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Evento $evento)
    {
        if (Auth::user()->rol === 'organizador' && $evento->user_id !== Auth::id()) {
            return redirect()->route('organizador.dashboard')->with('error', 'No tienes permiso para editar este evento.');
        }

        $evento->load(['imagenes', 'etiquetas']);

        if (Auth::user()->rol === 'organizador') {
            $lugares = Lugar::where('user_id', Auth::id())->orderBy('nombre')->pluck('nombre', 'id');
        } else {
            $lugares = Lugar::orderBy('nombre')->pluck('nombre', 'id');
        }

        $users = User::orderBy('nombre')->pluck('nombre', 'id');
        $etiquetas = Etiqueta::orderBy('nombre')->pluck('nombre', 'id');

        return view('admin.eventos.edit', compact('evento', 'lugares', 'users', 'etiquetas'));
    }

    /**
     * Actualiza un evento existente en la base de datos.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Evento $evento
     * @param \App\Services\ImageService $imageService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Evento $evento, ImageService $imageService)
    {
        if (Auth::user()->rol === 'organizador' && $evento->user_id !== Auth::id()) {
            return redirect()->route('organizador.dashboard')->with('error', 'No tienes permiso para editar este evento.');
        }

        $userIdRule = Auth::user()->rol === 'organizador' ? 'nullable' : 'required|integer|exists:users,id';
        $maxImagenesRule = Auth::user()->rol === 'organizador' ? 'nullable|array|max:1' : 'nullable|array';

        $data = $request->validate([
            'lugar_id' => 'nullable|integer|exists:lugares,id',
            'user_id' => $userIdRule,
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'precio' => 'nullable|numeric|min:0',
            'activo' => 'sometimes|boolean',
            'imagenes' => $maxImagenesRule,
            'imagenes.*' => 'nullable|image|max:2048|mimes:jpeg,png,gif,webp',
            'etiquetas' => 'nullable|array|max:4',
            'etiquetas.*' => 'integer|exists:etiquetas,id',
        ]);

        return DB::transaction(function () use ($request, $data, $evento, $imageService) {
            if (Auth::user()->rol === 'organizador') {
                if ($data['lugar_id'] ?? null) {
                    $lugar = Lugar::findOrFail($data['lugar_id']);
                    if ($lugar->user_id !== Auth::id()) {
                        return redirect()->route('organizador.dashboard')->with('error', 'No tienes permiso para usar este lugar.');
                    }
                }
                $data['user_id'] = Auth::id();
            }

            $evento->update($data);

            if ($request->hasFile('imagenes')) {
                if (Auth::user()->rol === 'organizador') {
                    foreach ($evento->imagenes as $prevImagen) {
                        if (Storage::disk('public')->exists($prevImagen->ruta)) {
                            Storage::disk('public')->delete($prevImagen->ruta);
                        }
                        $prevImagen->delete();
                    }
                    $evento->imagenes()->detach();
                }

                foreach ($request->file('imagenes') as $archivo) {
                    $ruta = $imageService->optimizarYGuardar($archivo, 'eventos');

                    $imagen = Imagen::create([
                        'ruta' => $ruta,
                        'tipo' => 'evento',
                    ]);

                    $evento->imagenes()->attach($imagen->id);
                }
            }

            $evento->etiquetas()->sync($request->input('etiquetas', []));

            if (Auth::user()->rol === 'organizador') {
                return redirect()->route('organizador.dashboard')->with('success', 'Evento actualizado correctamente.');
            }
            return redirect()->route('eventos.index')->with('success', 'Evento actualizado correctamente.');
        });
    }

    /**
     * Elimina un evento de la base de datos.
     *
     * @param \App\Models\Evento $evento
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Evento $evento)
    {
        if (Auth::user()->rol === 'organizador' && $evento->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para eliminar este evento.');
        }

        $evento->delete();

        if (Auth::user()->rol === 'organizador') {
            return redirect()->route('organizador.dashboard')->with('success', 'Evento eliminado correctamente.');
        }
        return redirect()->route('eventos.index')->with('success', 'Evento eliminado correctamente.');
    }

    /**
     * Aplica los filtros de búsqueda a la consulta de eventos.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    private function aplicarFiltros(Request $request)
    {
        $filtros = [];

        if ($request->nombre_evento) {
            $filtros[] = ['nombre', 'like', '%' . $request->nombre_evento . '%'];
        }

        if ($request->precio_desde) {
            $filtros[] = ['precio', '>=', $request->precio_desde];
        }

        if ($request->precio_hasta) {
            $filtros[] = ['precio', '<=', $request->precio_hasta];
        }

        if ($request->activo !== null && $request->activo !== '') {
            $filtros[] = ['activo', '=', $request->activo];
        }

        return $filtros;
    }
}
