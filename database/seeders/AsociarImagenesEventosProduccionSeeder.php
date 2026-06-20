<?php

namespace Database\Seeders;

use App\Models\Evento;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AsociarImagenesEventosProduccionSeeder extends Seeder
{
    public function run()
    {
        // Configuración de IDs de imágenes para eventos según el tipo de lugar (tipo_id del lugar)
        $configuracion = [
            1 => [41, 42, 43, 44, 45, 46, 47], // 1 = Eventos de Discotecas
            3 => [48, 49, 50], // 3 = Eventos de Verbenas
        ];

        DB::transaction(function () use ($configuracion) {
            foreach ($configuracion as $tipoId => $imagenesIds) {
                // Si no hay imágenes configuradas para este tipo, lo ignoramos
                if (empty($imagenesIds)) {
                    continue;
                }

                // 1. Obtener todos los IDs de los eventos de este tipo de lugar
                $eventoIds = Evento::whereHas('lugar', function ($query) use ($tipoId) {
                    $query->where('tipo_id', $tipoId);
                })->pluck('id')->toArray();

                if (empty($eventoIds)) {
                    continue;
                }

                // 2. Eliminar en lote todas las asociaciones previas para estos eventos
                DB::table('evento_imagen')
                    ->whereIn('evento_id', $eventoIds)
                    ->delete();

                // 3. Preparar el lote de inserciones (Bulk insert)
                $relaciones = [];
                $totalImagenes = count($imagenesIds);

                foreach ($eventoIds as $index => $eventoId) {
                    $relaciones[] = [
                        'evento_id' => $eventoId,
                        'imagen_id' => $imagenesIds[$index % $totalImagenes],
                    ];
                }

                // 4. Insertar todas las relaciones en una sola consulta
                DB::table('evento_imagen')->insert($relaciones);
            }
        });
    }
}
