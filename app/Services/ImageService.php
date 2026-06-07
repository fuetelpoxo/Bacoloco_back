<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class ImageService
{
    /**
     * Optimiza una imagen subida, la convierte a WebP, la redimensiona y la guarda.
     *
     * @param  UploadedFile  $archivo  El archivo subido.
     * @param  string  $carpeta  Carpeta de destino dentro del disco public (ej. 'lugares', 'eventos').
     * @param  int|null  $anchoMaximo  Ancho máximo permitido para redimensionar (opcional).
     * @param  int  $calidad  Calidad de la compresión WebP (1-100).
     * @return string Ruta relativa del archivo guardado (ej. 'lugares/nombre-unico.webp').
     */
    public function optimizarYGuardar(UploadedFile $archivo, string $carpeta, ?int $anchoMaximo = 1200, int $calidad = 80): string
    {
        // 1. Leer el archivo con Intervention Image
        $imagen = Image::read($archivo);

        // 2. Redimensionar si se especifica un ancho máximo y la imagen es más grande
        if ($anchoMaximo && $imagen->width() > $anchoMaximo) {
            $imagen->scale(width: $anchoMaximo);
        }

        // 3. Codificar a WebP con la calidad deseada
        $imagenWebP = $imagen->toWebp($calidad);

        // 4. Generar una ruta y nombre único para el archivo
        $nombreArchivo = $carpeta.'/'.Str::uuid().'.webp';

        // 5. Guardar en el almacenamiento por defecto (local/public en dev, s3/R2 en producción)
        Storage::disk()->put($nombreArchivo, (string) $imagenWebP);

        return $nombreArchivo;
    }
}
