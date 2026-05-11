<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ImagenController extends Controller
{
    public function destroy(Imagen $imagen)
    {
        if (Storage::disk('public')->exists($imagen->ruta)) {
            Storage::disk('public')->delete($imagen->ruta);
        }
        $imagen->delete();

        return redirect()->back()->with('success', 'Imagen eliminada correctamente.');
    }
}
