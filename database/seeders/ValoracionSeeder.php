<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ValoracionSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('valoraciones')->truncate();
        Schema::enableForeignKeyConstraints();

        $faker = \Faker\Factory::create('es_ES');
        $valoraciones = [];
        $id = 1;

        // Comentarios temáticos para dar realismo a las discotecas y bares
        // Mínimo 30 de cada tipo (positivos, neutros, negativos)
        $comentariosPositivos = [
            'Increíble sitio, la música excelente y el trato inmejorable.',
            'Muy buen ambiente, volveremos seguro el próximo fin de semana.',
            'Un lugar con mucho encanto, las copas de calidad y bien de precio.',
            'El mejor local de la ciudad para salir de fiesta.',
            'Espectacular decoración y el sonido de primera.',
            'Nos lo pasamos genial, totalmente recomendado.',
            'Buen rollito y música muy bailable.',
            'Camareros súper simpáticos y servicio rápido.',
            'Excelente selección musical y copas muy cuidadas. ¡Un 10!',
            'Un sitio top para disfrutar con amigos, muy seguro y divertido.',
            'Hacía tiempo que no me lo pasaba tan bien, súper recomendable.',
            'Los cócteles están riquísimos y el DJ sabe cómo animar a la gente.',
            'Increíbles luces, sonido impecable y seguridad atenta.',
            'El ambiente es inmejorable, la decoración muy moderna.',
            'Muy buena vibra en este local. Volveré sin dudarlo.',
            'Los camareros nos atendieron genial y con una sonrisa siempre.',
            'La música es variada y bailable, perfecta para desconectar.',
            'Un oasis en la noche. Las copas premium merecen la pena.',
            'Súper espacioso y bien climatizado. No agobia nada.',
            'El mejor tardeo de la zona con diferencia. Repetiremos.',
            'Me encanta la terraza que tienen, muy agradable y bien decorada.',
            'Organizan eventos brutales, siempre sorprenden.',
            'Muy limpio todo, trato excelente y rapidez en barra.',
            'Es el lugar perfecto para celebrar cumpleaños o lo que sea.',
            'Muy buena acústica en los conciertos en directo.',
            'Gente muy maja y ambiente súper sano para salir.',
            'Servicio de mesa excelente y cócteles creativos.',
            'Local muy acogedor y de trato muy familiar.',
            'La música comercial que ponen está súper actualizada.',
            'Volveré mil veces, es nuestro sitio de confianza definitivo.',
            'Excelente ambiente, música de calidad y el personal muy atento.'
        ];

        $comentariosNeutros = [
            'Está bien para tomar una copa tranquila, aunque a veces se llena demasiado.',
            'Normal, un sitio más para salir. Los precios están en la media.',
            'El ambiente es bueno pero tardaron bastante en atendernos.',
            'Está bien decorado, pero la música no era de mi estilo.',
            'Correcto para pasar el rato con amigos.',
            'Sitio normalito. La entrada es algo cara para lo que es.',
            'Las copas están bien, pero el espacio es un poco pequeño.',
            'Música pasable, aunque repiten demasiado las mismas canciones.',
            'Está bien, pero le falta algo de chispa para ser un sitio top.',
            'El trato de los camareros fue correcto, sin más.',
            'Bien climatizado pero los aseos podrían estar algo más limpios.',
            'Precios normales y ambiente variado, a ratos aburrido.',
            'Para tomar una cerveza rápida por la tarde cumple de sobra.',
            'Ni fu ni fa, un local estándar de copas por el centro.',
            'El DJ no estuvo muy inspirado hoy, pero el sitio no está mal.',
            'Aceptable para hacer una parada y seguir la ruta.',
            'Se llena demasiado los sábados, es difícil moverse.',
            'Bebidas normales, ambiente un poco ruidoso de más.',
            'La terraza es bonita pero tardan bastante en servir fuera.',
            'Tiene potencial, pero el sonido a veces satura bastante.',
            'La decoración es un poco antigua pero el ambiente es sano.',
            'Un bar más del montón, sin destacar en nada en especial.',
            'Cócteles pasables, precios estándar de la zona.',
            'La zona VIP no merece mucho la pena para el precio que tiene.',
            'Está bien si vas temprano, luego es imposible pedir en barra.',
            'Correcto en líneas generales, no destaca ni para bien ni para mal.',
            'El aire acondicionado estaba demasiado fuerte hoy.',
            'Música un poco alta para poder hablar tranquilamente.',
            'El servicio es un poco despistado pero el sitio es agradable.',
            'No está mal para ir de vez en cuando a tomar algo rápido.',
            'Normalito, un local con luces y sombras pero pasable.'
        ];

        $comentariosNegativos = [
            'Demasiada gente y el servicio bastante lento.',
            'Las copas carísimas para lo que ofrecen.',
            'No me gustó el ambiente de hoy, muy ruidoso.',
            'Tardaron una eternidad en servirnos en la barra.',
            'El portero fue bastante desagradable a la entrada.',
            'Hacía un calor insoportable dentro, no se podía respirar.',
            'Las bebidas parecían de garrafón, fatal la calidad.',
            'Muy mala organización en los accesos, colas interminables.',
            'El sonido era malísimo, distorsionaba y molestaba al oído.',
            'Precios abusivos para la calidad del servicio ofrecido.',
            'Los baños estaban sucios y sin papel. Lamentable.',
            'No vuelvo a pisar este sitio, muy mala experiencia.',
            'Ambiente pesado y peleas en la puerta, nada seguro.',
            'El personal de barra fue bastante borde con nosotros.',
            'Nos cobraron entrada y luego dentro no había casi nadie.',
            'Música desfasada y aburrida, la gente se iba marchando.',
            'Nos sentimos bastante incómodos con la actitud del personal.',
            'Una estafa de sitio, no lo recomiendo para nada.',
            'No respetan los aforos, apenas te puedes mover.',
            'El trato al cliente brilla por su ausencia en este bar.',
            'Tardamos media hora para que nos cobraran una copa.',
            'Sitio descuidado y sucio, necesita una reforma urgente.',
            'El DJ cortaba las canciones a la mitad, horrible.',
            'Huele bastante mal en la zona cercana a los baños.',
            'Copas mal servidas, vasos de plástico y caros.',
            'Nos echaron de malas maneras porque decían que iban a cerrar ya.',
            'No nos dejaron pasar sin darnos ninguna explicación coherente.',
            'Poca variedad de bebidas y muchas de la carta no tenían.',
            'Muy mala ventilación, salimos oliendo a humo y sudor.',
            'Una decepción absoluta tras haber leído buenas críticas.',
            'Pésima experiencia, servicio desorganizado y mal ambiente.'
        ];

        // Generar valoraciones para los Lugares (Discotecas 1-79, Bares 80-168)
        // Las verbenas (169-280) no suelen tener valoraciones de este tipo de comentarios de discoteca,
        // pero podemos valorar todos los lugares hasta el 168.
        for ($lugarId = 1; $lugarId <= 168; $lugarId++) {
            // Cada local tendrá entre 3 y 6 valoraciones
            $numVal = rand(3, 6);
            // Usamos un conjunto de usuarios aleatorios distintos para que no vote el mismo dos veces en un local
            $userIds = range(4, 100);
            shuffle($userIds);

            for ($j = 0; $j < $numVal; $j++) {
                $puntuacion = rand(3, 5); // La mayoría de valoraciones suelen ser de 3 a 5
                // Con menor probabilidad, metemos malas notas (1 o 2)
                if (rand(1, 10) === 1) {
                    $puntuacion = rand(1, 2);
                }

                if ($puntuacion >= 4) {
                    $comentario = $comentariosPositivos[array_rand($comentariosPositivos)];
                } elseif ($puntuacion == 3) {
                    $comentario = $comentariosNeutros[array_rand($comentariosNeutros)];
                } else {
                    $comentario = $comentariosNegativos[array_rand($comentariosNegativos)];
                }

                $valoraciones[] = [
                    'id' => $id++,
                    'user_id' => array_pop($userIds),
                    'lugar_id' => $lugarId,
                    'puntuacion' => $puntuacion,
                    'comentario' => $comentario,
                    'reportado' => 0,
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now()
                ];
            }
        }

        // Insertar en bloques
        foreach (array_chunk($valoraciones, 100) as $chunk) {
            DB::table('valoraciones')->insert($chunk);
        }
    }
}
