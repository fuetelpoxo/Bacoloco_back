<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ImagenController extends Controller
{
    /**
     * Elimina una imagen del almacenamiento y de la base de datos.
     *
     * @param \App\Models\Imagen $imagen
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Imagen $imagen)
    {
        $user = Auth::user();

        if ($user->rol === 'organizador') {
            $ownsLugar = $imagen->lugar()->where('user_id', $user->id)->exists();
            $ownsEvento = $imagen->evento()->where('user_id', $user->id)->exists();

            if (!$ownsLugar && !$ownsEvento) {
                abort(403, 'No tienes permiso para eliminar esta imagen.');
            }
        } elseif ($user->rol !== 'admin') {
            abort(403, 'Acción no autorizada.');
        }

        if (Storage::disk('public')->exists($imagen->ruta)) {
            Storage::disk('public')->delete($imagen->ruta);
        }
        $imagen->delete();

        return redirect()->back()->with('success', 'Imagen eliminada correctamente.');
    }
}

