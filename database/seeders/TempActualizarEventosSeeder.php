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
        $limitDate = Carbon::create(2026, 6, 26, 0, 0, 0); // Inicio del 26 de junio de 2026
        $eventos = Evento::all();
        $count = 0;

        foreach ($eventos as $evento) {
            $fechaInicio = Carbon::parse($evento->fecha_inicio);
            $fechaFin = Carbon::parse($evento->fecha_fin);

            if ($fechaInicio->lessThanOrEqualTo($targetDate)) {
                // Calculamos cuántos días sumar para que el inicio sea >= 2026-06-26 00:00:00
                $daysToAdd = 0;
                while ($fechaInicio->copy()->addDays($daysToAdd)->lessThan($limitDate)) {
                    $daysToAdd++;
                }

                $evento->fecha_inicio = $fechaInicio->addDays($daysToAdd);
                $evento->fecha_fin = $fechaFin->addDays($daysToAdd);
                $evento->save();
                $count++;
            }
        }

        $this->command->info("Se han actualizado {$count} eventos para ser posteriores al 25 de junio de 2026.");
    }
}
