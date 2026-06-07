<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ImageService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Muestra el listado de usuarios con filtros opcionales.
     *
     * @return View
     */
    public function index(Request $request)
    {
        $query = User::query();

        $this->aplicarFiltros($query, $request);

        $usuarios = $query->paginate(10)
            ->withQueryString();

        return view('admin.usuarios.index', compact('usuarios'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     *
     * @return View
     */
    public function create()
    {
        return view('admin.usuarios.create');
    }

    /**
     * Guarda un nuevo usuario en la base de datos.
     *
     * @return RedirectResponse
     */
    public function store(Request $request, ImageService $imageService)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'rol' => 'required|string|in:admin,organizador,usuario',
            'avatar' => 'nullable|image|max:2048|mimes:jpeg,png,gif,webp',
        ]);

        $data['password'] = Hash::make($data['password']);

        if ($request->hasFile('avatar')) {
            $ruta = $imageService->optimizarYGuardar($request->file('avatar'), 'usuarios/logos', 400);
            $data['avatar'] = $ruta;
        }

        User::create($data);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un usuario existente.
     *
     * @return View
     */
    public function edit(User $usuario)
    {
        return view('admin.usuarios.edit', compact('usuario'));
    }

    /**
     * Actualiza un usuario existente en la base de datos.
     *
     * @return RedirectResponse
     */
    public function update(Request $request, User $usuario, ImageService $imageService)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$usuario->id,
            'password' => 'nullable|string|min:6|confirmed',
            'rol' => 'required|string|in:admin,organizador,usuario',
            'avatar' => 'nullable|image|max:2048|mimes:jpeg,png,gif,webp',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        if ($request->hasFile('avatar')) {
            if ($usuario->avatar) {
                Storage::disk()->delete($usuario->avatar);
            }

            $ruta = $imageService->optimizarYGuardar($request->file('avatar'), 'usuarios/logos', 400);
            $data['avatar'] = $ruta;
        }

        $usuario->update($data);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Elimina un usuario de la base de datos.
     *
     * @return RedirectResponse
     */
    public function destroy(User $usuario)
    {
        if ($usuario->avatar) {
            Storage::disk()->delete($usuario->avatar);
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }

    /**
     * Aplica los filtros de búsqueda a la consulta de usuarios.
     *
     * @param  Builder  $query
     * @return Builder
     */
    private function aplicarFiltros($query, Request $request)
    {
        return $query
            ->when($request->nombre, function ($query, $nombre) {
                $query->where('nombre', 'like', '%'.$nombre.'%');
            })
            ->when($request->email, function ($query, $email) {
                $query->where('email', 'like', '%'.$email.'%');
            })
            ->when($request->rol, function ($query, $rol) {
                $query->where('rol', '=', $rol);
            });
    }
}
