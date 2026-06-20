<?php

namespace Database\Seeders;

use App\Models\Evento;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TempActualizarEventosSeeder extends Seeder
{
    public function run()
    {
        $targetDate = Carbon::create(2026, 6, 25, 23, 59, 59); // Fin del 25 de junio de 2026
        $eventos = Evento::all();
        $count = 0;

        foreach ($eventos as $evento) {
            $fechaInicio = Carbon::parse($evento->fecha_inicio);
            $fechaFin = Carbon::parse($evento->fecha_fin);

            if ($fechaInicio->lessThanOrEqualTo($targetDate)) {
                // Guardar la duración original del evento en minutos
                $duracionMinutos = $fechaInicio->diffInMinutes($fechaFin);

                // Generar un número aleatorio de días a sumar desde el 26 de junio (entre 0 y 45 días)
                $diasAleatorios = rand(0, 45);

                // Nueva fecha de inicio manteniendo la hora original
                $nuevaFechaInicio = Carbon::create(2026, 6, 26, $fechaInicio->hour, $fechaInicio->minute, $fechaInicio->second)
                    ->addDays($diasAleatorios);

                // Nueva fecha de fin manteniendo la duración original
                $nuevaFechaFin = $nuevaFechaInicio->copy()->addMinutes($duracionMinutos);

                $evento->fecha_inicio = $nuevaFechaInicio;
                $evento->fecha_fin = $nuevaFechaFin;
                $evento->save();
                $count++;
            }
        }

        $this->command->info("Se han actualizado {$count} eventos para ser posteriores al 25 de junio de 2026 con fechas aleatorias.");
    }
}
