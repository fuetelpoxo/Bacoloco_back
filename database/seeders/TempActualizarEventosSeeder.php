<?php

namespace Database\Seeders;

use App\Models\Evento;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TempActualizarEventosSeeder extends Seeder
{
    public function run()
    {
        $targetDate = Carbon::create(2026, 6, 25, 0, 0, 0);
        $eventos = Evento::all();
        $count = 0;

        foreach ($eventos as $evento) {
            $fechaInicio = Carbon::parse($evento->fecha_inicio);
            $fechaFin = Carbon::parse($evento->fecha_fin);

            if ($fechaInicio->lessThanOrEqualTo($targetDate)) {
                // Calcular la diferencia en días para adelantarla
                $diffInDays = $targetDate->diffInDays($fechaInicio);
                $daysToAdd = $diffInDays + 1;

                $evento->fecha_inicio = $fechaInicio->addDays($daysToAdd);
                $evento->fecha_fin = $fechaFin->addDays($daysToAdd);
                $evento->save();
                $count++;
            }
        }

        $this->command->info("Se han actualizado {$count} eventos para ser posteriores al 25 de junio de 2026.");
    }
}
