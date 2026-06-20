<?php

namespace Database\Seeders;

use App\Models\Lugar;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AsociarImagenesProduccionSeeder extends Seeder
{
    public function run()
    {
        // Configuración de IDs de imágenes para cada tipo de lugar (tipo_id)
        $configuracion = [
            1 => [4, 5, 6, 7, 9, 10, 11, 12, 13, 14, 15, 16, 17], // 1 = Discotecas
            2 => [19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29], // 2 = Bares
            3 => [30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40], // 3 = Verbenas
        ];

        DB::transaction(function () use ($configuracion) {
            foreach ($configuracion as $tipoId => $imagenesIds) {
                // Si no hay imágenes configuradas para este tipo, lo ignoramos
                if (empty($imagenesIds)) {
                    continue;
                }

                // 1. Obtener todos los IDs de los lugares de este tipo en una sola consulta
                $lugarIds = Lugar::where('tipo_id', $tipoId)->pluck('id')->toArray();

                if (empty($lugarIds)) {
                    continue;
                }

                // 2. Eliminar en lote todas las asociaciones previas para estos lugares
                DB::table('imagen_lugar')
                    ->whereIn('lugar_id', $lugarIds)
                    ->delete();

                // 3. Preparar el lote de inserciones (Bulk insert)
                $relaciones = [];
                $totalImagenes = count($imagenesIds);

                foreach ($lugarIds as $index => $lugarId) {
                    $relaciones[] = [
                        'lugar_id' => $lugarId,
                        'imagen_id' => $imagenesIds[$index % $totalImagenes],
                    ];
                }

                // 4. Insertar todas las relaciones en una sola consulta
                DB::table('imagen_lugar')->insert($relaciones);
            }
        });
    }
}
