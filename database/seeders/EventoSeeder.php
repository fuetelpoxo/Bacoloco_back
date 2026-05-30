<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EventoSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('eventos')->truncate();
        Schema::enableForeignKeyConstraints();

        $eventos = [];
        $id = 1;

        // --- 1. EVENTOS PARA DISCOTECAS Y BARES ---
        // Discotecas importantes:
        // Kudeta (1), Cambalache (2), Sümmum (5), Rocambole (7), Queen (8), New Times (25), Botavara (34), ZUL (39), Enjoy Castro (62), Moonlight (68), Velvet (70), Kapital (75)
        // Cada una debe tener mínimo 2 eventos.

        // Kudeta (1)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 1,
            'user_id' => 2,
            'nombre' => 'Kudeta Summer Kickoff',
            'descripcion' => 'Inauguración de la temporada de verano junto al puerto con los mejores DJs locales de comercial y urbano.',
            'fecha_inicio' => now()->addDays(5)->setTime(23, 0, 0),
            'fecha_fin' => now()->addDays(6)->setTime(6, 0, 0),
            'precio' => 15.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 1,
            'user_id' => 2,
            'nombre' => 'Ladies Night Kudeta',
            'descripcion' => 'La noche dedicada a ellas con barra libre de cava hasta la 1:00 y música comercial/reggaetón.',
            'fecha_inicio' => now()->addDays(12)->setTime(23, 0, 0),
            'fecha_fin' => now()->addDays(13)->setTime(6, 0, 0),
            'precio' => 12.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Cambalache (2)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 2,
            'user_id' => 2,
            'nombre' => 'San Cemento Universitario',
            'descripcion' => 'La fiesta universitaria más loca del año con grandes ofertas en barra y música comercial.',
            'fecha_inicio' => now()->addDays(4)->setTime(22, 30, 0),
            'fecha_fin' => now()->addDays(5)->setTime(5, 30, 0),
            'precio' => 8.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 2,
            'user_id' => 2,
            'nombre' => 'Jueves de Locura',
            'descripcion' => 'Descuentos universitarios toda la noche y animación especial en cabina con DJ Residente.',
            'fecha_inicio' => now()->addDays(11)->setTime(23, 0, 0),
            'fecha_fin' => now()->addDays(12)->setTime(5, 0, 0),
            'precio' => 6.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Sümmum (5)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 5,
            'user_id' => 3,
            'nombre' => 'Sümmum House Session',
            'descripcion' => 'Una noche elegante con los sonidos house y tech house más exclusivos importados de Ibiza.',
            'fecha_inicio' => now()->addDays(6)->setTime(23, 30, 0),
            'fecha_fin' => now()->addDays(7)->setTime(6, 0, 0),
            'precio' => 18.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 5,
            'user_id' => 3,
            'nombre' => 'Glow Neon Party',
            'descripcion' => 'Pintura fluorescente, pulseras luminosas y espectacular show visual en la discoteca más elegante de la ciudad.',
            'fecha_inicio' => now()->addDays(20)->setTime(23, 0, 0),
            'fecha_fin' => now()->addDays(21)->setTime(6, 0, 0),
            'precio' => 15.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Rocambole (7)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 7,
            'user_id' => 1,
            'nombre' => 'Rocambole Indie Club',
            'descripcion' => 'Sesión especial indie pop-rock con los grandes himnos de ayer y de hoy en pleno centro.',
            'fecha_inicio' => now()->addDays(7)->setTime(23, 30, 0),
            'fecha_fin' => now()->addDays(8)->setTime(6, 0, 0),
            'precio' => 10.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 7,
            'user_id' => 1,
            'nombre' => 'Vinyl Session Nostalgia',
            'descripcion' => 'Viaje musical en formato vinilo a los años 80 y 90 de la mano de DJs veteranos.',
            'fecha_inicio' => now()->addDays(14)->setTime(23, 30, 0),
            'fecha_fin' => now()->addDays(15)->setTime(6, 0, 0),
            'precio' => 12.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Queen (8)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 8,
            'user_id' => 1,
            'nombre' => 'Queen Reggaeton Fest',
            'descripcion' => 'Una noche del perreo más intenso con DJs especializados y concurso de baile.',
            'fecha_inicio' => now()->addDays(8)->setTime(23, 0, 0),
            'fecha_fin' => now()->addDays(9)->setTime(6, 0, 0),
            'precio' => 15.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 8,
            'user_id' => 1,
            'nombre' => 'Urban Hits Night',
            'descripcion' => 'Todos los éxitos de la música urbana actual reunidos en una sola noche llena de ritmo.',
            'fecha_inicio' => now()->addDays(15)->setTime(23, 0, 0),
            'fecha_fin' => now()->addDays(16)->setTime(6, 0, 0),
            'precio' => 12.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // New Times (25)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 25,
            'user_id' => 1,
            'nombre' => 'Torrelavega Baila',
            'descripcion' => 'La gran sesión comercial de Torrelavega con megatrón, animación y regalos exclusivos.',
            'fecha_inicio' => now()->addDays(5)->setTime(23, 30, 0),
            'fecha_fin' => now()->addDays(6)->setTime(6, 0, 0),
            'precio' => 12.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 25,
            'user_id' => 1,
            'nombre' => 'Mega Perreo Session',
            'descripcion' => 'La discoteca se transforma en un templo urbano con los mejores ritmos de reggaetón y trap.',
            'fecha_inicio' => now()->addDays(19)->setTime(23, 30, 0),
            'fecha_fin' => now()->addDays(20)->setTime(6, 0, 0),
            'precio' => 10.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Botavara (34)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 34,
            'user_id' => 1,
            'nombre' => 'White Sunset Botavara',
            'descripcion' => 'Disfruta del atardecer en nuestra terraza veraniega vistiendo de blanco con copas premium y DJ set.',
            'fecha_inicio' => now()->addDays(6)->setTime(20, 0, 0),
            'fecha_fin' => now()->addDays(7)->setTime(4, 0, 0),
            'precio' => 15.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 34,
            'user_id' => 1,
            'nombre' => 'Ibiza Sound Experience',
            'descripcion' => 'Sesiones de deep house al aire libre con cóctel de bienvenida incluido.',
            'fecha_inicio' => now()->addDays(13)->setTime(19, 0, 0),
            'fecha_fin' => now()->addDays(14)->setTime(3, 0, 0),
            'precio' => 20.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // ZUL (39)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 39,
            'user_id' => 1,
            'nombre' => 'ZUL Techno Temple',
            'descripcion' => 'La mítica fiesta electrónica del norte con un Line Up nacional de primer orden y sonido atronador.',
            'fecha_inicio' => now()->addDays(15)->setTime(23, 0, 0),
            'fecha_fin' => now()->addDays(16)->setTime(8, 0, 0),
            'precio' => 22.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 39,
            'user_id' => 1,
            'nombre' => 'Hardcore & Remember Fest',
            'descripcion' => 'Reunimos los clásicos de la electrónica del norte y las mejores sesiones remember en una noche mítica.',
            'fecha_inicio' => now()->addDays(29)->setTime(23, 0, 0),
            'fecha_fin' => now()->addDays(30)->setTime(8, 0, 0),
            'precio' => 25.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Enjoy Castro (62)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 62,
            'user_id' => 1,
            'nombre' => 'Enjoy Weekend Welcome',
            'descripcion' => 'Arrancamos el fin de semana en Castro con entrada reducida para los primeros clientes y hits del momento.',
            'fecha_inicio' => now()->addDays(7)->setTime(23, 0, 0),
            'fecha_fin' => now()->addDays(8)->setTime(6, 0, 0),
            'precio' => 10.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 62,
            'user_id' => 1,
            'nombre' => 'Salsa & Bachata Special Night',
            'descripcion' => 'Taller de baile social al inicio de la noche y fiesta latina con DJ Invitado.',
            'fecha_inicio' => now()->addDays(21)->setTime(21, 30, 0),
            'fecha_fin' => now()->addDays(22)->setTime(5, 0, 0),
            'precio' => 12.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Moonlight Club (68)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 68,
            'user_id' => 1,
            'nombre' => 'Moonlight VIP Opening',
            'descripcion' => 'Show premium, performances en directo y cócteles de autor en la sala comercial de moda.',
            'fecha_inicio' => now()->addDays(4)->setTime(23, 30, 0),
            'fecha_fin' => now()->addDays(5)->setTime(6, 0, 0),
            'precio' => 15.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 68,
            'user_id' => 1,
            'nombre' => 'Urban Deluxe',
            'descripcion' => 'R&B, trap y reggaetón en una sesión refinada para los amantes de los ritmos urbanos.',
            'fecha_inicio' => now()->addDays(18)->setTime(23, 30, 0),
            'fecha_fin' => now()->addDays(19)->setTime(6, 0, 0),
            'precio' => 15.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Velvet Santander (70)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 70,
            'user_id' => 1,
            'nombre' => 'Velvet Red Session',
            'descripcion' => 'Música comercial mezclada con los grandes éxitos del pop español e internacional.',
            'fecha_inicio' => now()->addDays(7)->setTime(23, 0, 0),
            'fecha_fin' => now()->addDays(8)->setTime(6, 0, 0),
            'precio' => 12.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 70,
            'user_id' => 1,
            'nombre' => 'Retro Pop-Rock 90s',
            'descripcion' => 'Una fiesta dedicada por completo a la música y la cultura de los años noventa.',
            'fecha_inicio' => now()->addDays(28)->setTime(23, 0, 0),
            'fecha_fin' => now()->addDays(29)->setTime(6, 0, 0),
            'precio' => 10.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Kapital Santander (75)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 75,
            'user_id' => 1,
            'nombre' => 'Kapital Mega Event',
            'descripcion' => 'La sala más espaciosa acoge un festival con 3 zonas de música diferentes y DJs internacionales.',
            'fecha_inicio' => now()->addDays(9)->setTime(22, 0, 0),
            'fecha_fin' => now()->addDays(10)->setTime(7, 0, 0),
            'precio' => 20.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 75,
            'user_id' => 1,
            'nombre' => 'Spring Electronic Festival',
            'descripcion' => 'Dedicado íntegramente a los subgéneros de la electrónica: Trance, House y Techno.',
            'fecha_inicio' => now()->addDays(23)->setTime(22, 0, 0),
            'fecha_fin' => now()->addDays(24)->setTime(7, 0, 0),
            'precio' => 25.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Algunos eventos extras en bares míticos para completar la oferta nocturna (Bares: 80 - 168)
        // Little Bobby (80)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 80,
            'user_id' => 1,
            'nombre' => 'Afterwork Coctelería',
            'descripcion' => 'Disfruta de cócteles clásicos y de autor elaborados por maestros cocteleros con música jazz de fondo.',
            'fecha_inicio' => now()->addDays(3)->setTime(19, 0, 0),
            'fecha_fin' => now()->addDays(3)->setTime(23, 30, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Peter Pan (81)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 81,
            'user_id' => 1,
            'nombre' => 'Trivial de Cerveza y Rock',
            'descripcion' => 'Demuestra tus conocimientos musicales en nuestro famoso trivial universitario de los miércoles.',
            'fecha_inicio' => now()->addDays(5)->setTime(21, 0, 0),
            'fecha_fin' => now()->addDays(6)->setTime(1, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Rock Beer The New (86)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 86,
            'user_id' => 1,
            'nombre' => 'Concierto Rock Metal Directo',
            'descripcion' => 'Música en vivo con bandas emergentes de la escena cántabra y nacional de heavy/metal.',
            'fecha_inicio' => now()->addDays(7)->setTime(21, 0, 0),
            'fecha_fin' => now()->addDays(8)->setTime(1, 30, 0),
            'precio' => 8.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];


        // --- 2. EVENTOS DE VERBENAS Y FIESTAS POPULARES ---
        // Santander (ID 245)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 245,
            'user_id' => 1,
            'nombre' => 'Semana Grande (Santiago)',
            'descripcion' => 'Conciertos masivos, verbenas populares, feria taurina, casetas de gastronomía y ambiente festivo inigualable en toda la capital santanderina.',
            'fecha_inicio' => now()->addDays(60)->setTime(12, 0, 0),
            'fecha_fin' => now()->addDays(70)->setTime(4, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 245,
            'user_id' => 1,
            'nombre' => 'Fiestas de Barrios (Cañadío, Cueto, Peñacastillo)',
            'descripcion' => 'Verbenas tradicionales de barrio organizadas por las peñas locales, con parrilladas, música tradicional y atracciones.',
            'fecha_inicio' => now()->addDays(40)->setTime(18, 0, 0),
            'fecha_fin' => now()->addDays(45)->setTime(2, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Torrelavega (ID 255)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 255,
            'user_id' => 1,
            'nombre' => 'Virgen Grande (La Patrona)',
            'descripcion' => 'Probablemente las verbenas más multitudinarias y espectaculares de toda Cantabria, con desfile de carrozas, atracciones y grandes orquestas.',
            'fecha_inicio' => now()->addDays(75)->setTime(10, 0, 0),
            'fecha_fin' => now()->addDays(85)->setTime(5, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 255,
            'user_id' => 1,
            'nombre' => 'Fiestas de San Juan (Peñas y Barrios)',
            'descripcion' => 'Hogueras populares, romerías en los barrios de la ciudad y el tradicional chupinazo de las peñas torrelaveguenses.',
            'fecha_inicio' => now()->addDays(25)->setTime(17, 0, 0),
            'fecha_fin' => now()->addDays(28)->setTime(4, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Castro-Urdiales (ID 189)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 189,
            'user_id' => 1,
            'nombre' => 'Coso Blanco',
            'descripcion' => 'Espectacular desfile nocturno de carrozas iluminadas elaboradas con papel de seda, fuegos artificiales y romería tradicional en el parque Amestoy.',
            'fecha_inicio' => now()->addDays(35)->setTime(21, 0, 0),
            'fecha_fin' => now()->addDays(36)->setTime(6, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 189,
            'user_id' => 1,
            'nombre' => 'Fiestas del Carmen Castro',
            'descripcion' => 'La gran procesión marítima en honor a la patrona de los marineros, seguida de verbenas con orquestas y sardinada popular en el puerto.',
            'fecha_inicio' => now()->addDays(48)->setTime(12, 0, 0),
            'fecha_fin' => now()->addDays(51)->setTime(3, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Laredo (ID 202)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 202,
            'user_id' => 1,
            'nombre' => 'Batalla de Flores',
            'descripcion' => 'El evento más famoso y turístico de Laredo. Espectaculares carrozas cubiertas completamente por miles de flores naturales y romería masiva por la noche.',
            'fecha_inicio' => now()->addDays(90)->setTime(16, 0, 0),
            'fecha_fin' => now()->addDays(91)->setTime(6, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 202,
            'user_id' => 1,
            'nombre' => 'San Juan y Verano Laredano',
            'descripcion' => 'Hoguera tradicional en la playa de la Salvé y conciertos de verano con verbenas gigantescas repartidas por el municipio.',
            'fecha_inicio' => now()->addDays(24)->setTime(20, 0, 0),
            'fecha_fin' => now()->addDays(26)->setTime(4, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Santoña (ID 249)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 249,
            'user_id' => 1,
            'nombre' => 'Carnaval de Santoña (Carnaval del Norte)',
            'descripcion' => 'Uno de los carnavales más importantes del norte de España, con el famoso Juicio en el Fondo del Mar, el Entierro del Besugo y animadas verbenas de disfraces.',
            'fecha_inicio' => now()->addDays(270)->setTime(12, 0, 0),
            'fecha_fin' => now()->addDays(275)->setTime(5, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 249,
            'user_id' => 1,
            'nombre' => 'Virgen del Puerto y Fiestas del Carmen',
            'descripcion' => 'Procesión marítima con barcos pesqueros engalanados, regatas de traineras, marmitada popular y grandes orquestas en la plaza de San Antonio.',
            'fecha_inicio' => now()->addDays(95)->setTime(11, 0, 0),
            'fecha_fin' => now()->addDays(100)->setTime(4, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Suances (ID 254)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 254,
            'user_id' => 1,
            'nombre' => 'Fiestas de San Juan Suances',
            'descripcion' => 'Tradicional hoguera playera en el arenal de la Concha con música de orquesta, pasacalles y chocolate con churros para los asistentes.',
            'fecha_inicio' => now()->addDays(25)->setTime(21, 0, 0),
            'fecha_fin' => now()->addDays(26)->setTime(5, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 254,
            'user_id' => 1,
            'nombre' => 'Verbenas de Temporada Turística Suances',
            'descripcion' => 'Verbenas y conciertos al aire libre orientados al gran flujo de visitantes estivales en la zona del puerto y la playa.',
            'fecha_inicio' => now()->addDays(55)->setTime(22, 0, 0),
            'fecha_fin' => now()->addDays(58)->setTime(4, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Noja (ID 217)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 217,
            'user_id' => 1,
            'nombre' => 'Fiestas de San Emeterio y San Celedonio',
            'descripcion' => 'Grandes fiestas patronales que cierran el verano de Noja por todo lo alto, con orquestas de renombre nacional y fuegos artificiales.',
            'fecha_inicio' => now()->addDays(92)->setTime(18, 0, 0),
            'fecha_fin' => now()->addDays(95)->setTime(4, 30, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 217,
            'user_id' => 1,
            'nombre' => 'Verbenas de Verano en Noja',
            'descripcion' => 'Romerías estivales repartidas por las plazas principales y pubs locales, ofreciendo música en directo.',
            'fecha_inicio' => now()->addDays(50)->setTime(22, 0, 0),
            'fecha_fin' => now()->addDays(53)->setTime(4, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Comillas (ID 193)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 193,
            'user_id' => 1,
            'nombre' => 'Santo Cristo del Amparo Comillas',
            'descripcion' => 'La fiesta más representativa de Comillas, con su mítica procesión nocturna al puerto engalanado y verbenas de gran envergadura.',
            'fecha_inicio' => now()->addDays(46)->setTime(20, 0, 0),
            'fecha_fin' => now()->addDays(49)->setTime(5, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 193,
            'user_id' => 1,
            'nombre' => 'Verbenas de Verano Turísticas',
            'descripcion' => 'Las plazas históricas de Comillas acogen romerías tradicionales con agrupaciones folclóricas y orquestas modernas.',
            'fecha_inicio' => now()->addDays(60)->setTime(21, 30, 0),
            'fecha_fin' => now()->addDays(62)->setTime(3, 30, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // San Vicente de la Barquera (ID 242)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 242,
            'user_id' => 1,
            'nombre' => 'La Folía',
            'descripcion' => 'Procesión marítima de enorme fama y tradición. Barcos pesqueros decorados con flores llevan a la virgen por la ría acompañados de cantos tradicionales y verbenas nocturnas.',
            'fecha_inicio' => now()->addDays(15)->setTime(10, 0, 0),
            'fecha_fin' => now()->addDays(17)->setTime(3, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 242,
            'user_id' => 1,
            'nombre' => 'Fiestas del Carmen San Vicente',
            'descripcion' => 'Verbena popular marinera, cucaña infantil y sardinadas a la brasa al son de orquestas norteñas.',
            'fecha_inicio' => now()->addDays(48)->setTime(18, 0, 0),
            'fecha_fin' => now()->addDays(50)->setTime(4, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Potes (ID 225)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 225,
            'user_id' => 1,
            'nombre' => 'Fiesta del Orujo',
            'descripcion' => 'Fiesta de Interés Turístico Nacional. Degustación del orujo lebaniego destilado en alquitaras de cobre tradicionales, acompañada de música celta, pasacalles y verbena.',
            'fecha_inicio' => now()->addDays(170)->setTime(11, 0, 0),
            'fecha_fin' => now()->addDays(173)->setTime(5, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 225,
            'user_id' => 1,
            'nombre' => 'Fiestas Patronales de la Cruz Potes',
            'descripcion' => 'Música tradicional folk, mercadillo gastronómico local y romería campestre nocturna en la plaza del pueblo.',
            'fecha_inicio' => now()->addDays(105)->setTime(17, 0, 0),
            'fecha_fin' => now()->addDays(108)->setTime(3, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Cabezón de la Sal (ID 180)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 180,
            'user_id' => 1,
            'nombre' => 'Día de Cantabria (Día de la Montaña)',
            'descripcion' => 'La gran fiesta de la identidad regional. Desfile de carrozas típicas, bandas de gaitas, deportes rurales y una grandísima verbena folclórica por la noche.',
            'fecha_inicio' => now()->addDays(72)->setTime(9, 0, 0),
            'fecha_fin' => now()->addDays(73)->setTime(5, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 180,
            'user_id' => 1,
            'nombre' => 'San Cosme y San Damián',
            'descripcion' => 'Verbena popular, romería típica cántabra con jotas y pito y tambor, cerrando las fiestas patronales de Cabezón.',
            'fecha_inicio' => now()->addDays(115)->setTime(19, 0, 0),
            'fecha_fin' => now()->addDays(117)->setTime(3, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Los Corrales de Buelna (ID 207)
        // Buscamos ID 207 en LugarSeeder para comprobar que se corresponde.
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 207,
            'user_id' => 1,
            'nombre' => 'Guerras Cántabras',
            'descripcion' => 'Impresionante recreación histórica de Interés Turístico Internacional que transporta al municipio a la época romana. Campamento, desfiles, luchas de gladiadores y música nocturna.',
            'fecha_inicio' => now()->addDays(92)->setTime(11, 0, 0),
            'fecha_fin' => now()->addDays(99)->setTime(4, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 207,
            'user_id' => 1,
            'nombre' => 'Fiestas de San Juan Los Corrales',
            'descripcion' => 'Encendido tradicional de la hoguera con danzas locales y verbena nocturna con orquestas cántabras.',
            'fecha_inicio' => now()->addDays(25)->setTime(20, 0, 0),
            'fecha_fin' => now()->addDays(27)->setTime(4, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Camargo (Maliaño / Muriedas)
        // IDs: Camargo (184), Maliaño (273), Muriedas (274)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 184,
            'user_id' => 1,
            'nombre' => 'Fiestas de San Juan Camargo',
            'descripcion' => 'Gran hoguera de San Juan con música en directo y animación para los vecinos en la explanada municipal.',
            'fecha_inicio' => now()->addDays(25)->setTime(21, 0, 0),
            'fecha_fin' => now()->addDays(26)->setTime(4, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 184,
            'user_id' => 1,
            'nombre' => 'Fiestas de San Vicente Camargo',
            'descripcion' => 'Romería campestre y verbenas municipales que se reparten a lo largo de los diferentes barrios del valle.',
            'fecha_inicio' => now()->addDays(265)->setTime(18, 0, 0),
            'fecha_fin' => now()->addDays(267)->setTime(2, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Piélagos (Renedo / Boo)
        // IDs: Piélagos (222), Boo de Piélagos (279), Renedo de Piélagos (280)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 222,
            'user_id' => 1,
            'nombre' => 'Fiestas de San Antonio Piélagos',
            'descripcion' => 'Romería tradicional en la campa de San Antonio con el reparto de panecillos bendecidos, deportes tradicionales y música.',
            'fecha_inicio' => now()->addDays(14)->setTime(11, 0, 0),
            'fecha_fin' => now()->addDays(15)->setTime(4, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 222,
            'user_id' => 1,
            'nombre' => 'San Antonio Abad Piélagos',
            'descripcion' => 'Verbena de invierno con bendición de animales y gran chocolatada popular para hacer frente al frío.',
            'fecha_inicio' => now()->addDays(230)->setTime(17, 0, 0),
            'fecha_fin' => now()->addDays(231)->setTime(1, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Astillero (ID 176)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 176,
            'user_id' => 1,
            'nombre' => 'Fiestas de San José Astillero',
            'descripcion' => 'Una de las primeras fiestas del año en Cantabria. Grandiosas verbenas, carrera de traineras en la ría y el desfile de carrozas engalanadas.',
            'fecha_inicio' => now()->addDays(295)->setTime(12, 0, 0),
            'fecha_fin' => now()->addDays(300)->setTime(3, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 176,
            'user_id' => 1,
            'nombre' => 'Conciertos de Verano Astillero',
            'descripcion' => 'Espectáculos musicales gratuitos al aire libre en la plaza de la Constitución con orquestas de primer orden.',
            'fecha_inicio' => now()->addDays(65)->setTime(22, 0, 0),
            'fecha_fin' => now()->addDays(67)->setTime(4, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Santa Cruz de Bezana (ID 243)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 243,
            'user_id' => 1,
            'nombre' => 'Fiestas de San Pedro Bezana',
            'descripcion' => 'Patrón de Bezana con romerías infantiles, torneos deportivos, feria de día y grandes verbenas en el centro cívico.',
            'fecha_inicio' => now()->addDays(30)->setTime(18, 0, 0),
            'fecha_fin' => now()->addDays(33)->setTime(4, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 243,
            'user_id' => 1,
            'nombre' => 'Verbenas de Verano Bezana',
            'descripcion' => 'Conciertos familiares al aire libre y mercado de artesanía con música folk en directo.',
            'fecha_inicio' => now()->addDays(52)->setTime(21, 0, 0),
            'fecha_fin' => now()->addDays(54)->setTime(2, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Colindres (ID 192)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 192,
            'user_id' => 1,
            'nombre' => 'Fiestas del Carmen Colindres',
            'descripcion' => 'Espectaculares y potentes verbenas marineras en los aledaños del puerto, con degustación de bonito a la brasa y orquestas excelentes.',
            'fecha_inicio' => now()->addDays(47)->setTime(19, 0, 0),
            'fecha_fin' => now()->addDays(50)->setTime(5, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 192,
            'user_id' => 1,
            'nombre' => 'Fiestas de San Ginés Colindres',
            'descripcion' => 'Día de fiesta tradicional con juegos infantiles, marmitada popular y romería nocturna en los jardines municipales.',
            'fecha_inicio' => now()->addDays(88)->setTime(12, 0, 0),
            'fecha_fin' => now()->addDays(89)->setTime(3, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Ampuero (ID 170)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 170,
            'user_id' => 1,
            'nombre' => 'Encierros de Ampuero',
            'descripcion' => 'Los encierros de toros más famosos de Cantabria, atrayendo a miles de corredores. Por la noche, verbenas multitudinarias y peñas de música.',
            'fecha_inicio' => now()->addDays(102)->setTime(12, 0, 0),
            'fecha_fin' => now()->addDays(106)->setTime(5, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 170,
            'user_id' => 1,
            'nombre' => 'Fiestas de San Pedruco',
            'descripcion' => 'Romería campestre y verbena tradicional en los barrios altos con orquesta popular y folclore regional.',
            'fecha_inicio' => now()->addDays(32)->setTime(18, 0, 0),
            'fecha_fin' => now()->addDays(34)->setTime(2, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Ramales de la Victoria (ID 227)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 227,
            'user_id' => 1,
            'nombre' => 'Fiestas de San Juan y San Pedro Ramales',
            'descripcion' => 'La cuna del folclore en el Asón. Romerías muy tradicionales en la plaza mayor y orquestas hasta altas horas de la madrugada.',
            'fecha_inicio' => now()->addDays(24)->setTime(20, 0, 0),
            'fecha_fin' => now()->addDays(27)->setTime(4, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 227,
            'user_id' => 1,
            'nombre' => 'Verbenas Tradicionales de Ramales',
            'descripcion' => 'Fiestas de pueblo con atracciones, mercadillos artesanos y romería campestre típica.',
            'fecha_inicio' => now()->addDays(56)->setTime(21, 0, 0),
            'fecha_fin' => now()->addDays(58)->setTime(3, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Liérganes (ID 206)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 206,
            'user_id' => 1,
            'nombre' => 'Fiestas del Carmen Liérganes',
            'descripcion' => 'El casco histórico de Liérganes se llena de música, mercadillos de quesos lebaniegos y animadas verbenas estivales.',
            'fecha_inicio' => now()->addDays(48)->setTime(19, 0, 0),
            'fecha_fin' => now()->addDays(50)->setTime(4, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 206,
            'user_id' => 1,
            'nombre' => 'San Pantaleón Liérganes',
            'descripcion' => 'Romería rural al mirador de Liérganes con música tradicional de pito y tambor y posterior verbena.',
            'fecha_inicio' => now()->addDays(58)->setTime(16, 0, 0),
            'fecha_fin' => now()->addDays(59)->setTime(2, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Solares (ID 271)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 271,
            'user_id' => 1,
            'nombre' => 'Fiestas de San Juan Solares',
            'descripcion' => 'Encendido de la hoguera principal con fuegos artificiales, verbenas populares y carruseles infantiles en el centro del municipio.',
            'fecha_inicio' => now()->addDays(25)->setTime(21, 0, 0),
            'fecha_fin' => now()->addDays(26)->setTime(4, 30, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 271,
            'user_id' => 1,
            'nombre' => 'Romerías de Verano Solares',
            'descripcion' => 'Música en vivo los fines de semana de verano para animar a locales y veraneantes.',
            'fecha_inicio' => now()->addDays(60)->setTime(22, 0, 0),
            'fecha_fin' => now()->addDays(62)->setTime(3, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Sarón (Santa María de Cayón) (ID 272)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 272,
            'user_id' => 1,
            'nombre' => 'Fiestas de San Andrés Sarón',
            'descripcion' => 'Grandes verbenas del valle del Cayón que congregan a miles de personas de la comarca con reconocidas orquestas del norte.',
            'fecha_inicio' => now()->addDays(185)->setTime(21, 0, 0),
            'fecha_fin' => now()->addDays(188)->setTime(4, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Santa María de Cayón (ID 244)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 244,
            'user_id' => 1,
            'nombre' => 'Fiestas Patronales de San Andrés Cayón',
            'descripcion' => 'Múltiples eventos religiosos, deportivos e infantiles repartidos por todo el municipio con romerías de pandereteras y pito.',
            'fecha_inicio' => now()->addDays(184)->setTime(12, 0, 0),
            'fecha_fin' => now()->addDays(187)->setTime(3, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Costa Oriental (Somo, Loredo, Ajo, Isla)
        // IDs: Somo (275), Loredo (276), Ajo (277), Isla (278)
        // Somo (275)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 275,
            'user_id' => 1,
            'nombre' => 'Verano Costero en Somo',
            'descripcion' => 'Ambiente surfero y turístico con verbenas al aire libre junto al paseo marítimo y DJs de moda.',
            'fecha_inicio' => now()->addDays(40)->setTime(22, 0, 0),
            'fecha_fin' => now()->addDays(43)->setTime(4, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 275,
            'user_id' => 1,
            'nombre' => 'Fiestas del Carmen en Somo',
            'descripcion' => 'Procesión marinera en lanchas por la bahía de Santander y gran verbena popular nocturna.',
            'fecha_inicio' => now()->addDays(48)->setTime(18, 0, 0),
            'fecha_fin' => now()->addDays(49)->setTime(3, 30, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Loredo (276)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 276,
            'user_id' => 1,
            'nombre' => 'Derby de Loredo y Verbena',
            'descripcion' => 'La mítica e histórica carrera de caballos sobre la arena húmeda de la playa de Loredo, seguida de una gran romería y verbena nocturna.',
            'fecha_inicio' => now()->addDays(60)->setTime(11, 0, 0),
            'fecha_fin' => now()->addDays(61)->setTime(4, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Ajo (277)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 277,
            'user_id' => 1,
            'nombre' => 'Fiestas de San Pedruco Ajo',
            'descripcion' => 'Feria de ganado, paellada gigante municipal y animada verbena nocturna con orquesta.',
            'fecha_inicio' => now()->addDays(32)->setTime(12, 0, 0),
            'fecha_fin' => now()->addDays(34)->setTime(3, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Isla (278)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 278,
            'user_id' => 1,
            'nombre' => 'Feria del Pimiento e Isla Fest',
            'descripcion' => 'Mercado gastronómico dedicado al famoso pimiento de Isla con degustaciones populares y verbena de cierre.',
            'fecha_inicio' => now()->addDays(100)->setTime(10, 0, 0),
            'fecha_fin' => now()->addDays(101)->setTime(2, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Santillana del Mar (ID 246)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 246,
            'user_id' => 1,
            'nombre' => 'Fiestas de Santa Juliana',
            'descripcion' => 'Fiestas patronales de la villa románica por excelencia. Romerías tradicionales, trajes típicos y verbena popular nocturna.',
            'fecha_inicio' => now()->addDays(18)->setTime(11, 0, 0),
            'fecha_fin' => now()->addDays(20)->setTime(3, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 246,
            'user_id' => 1,
            'nombre' => 'Eventos Turísticos de Verano',
            'descripcion' => 'Representaciones teatrales al aire libre y actuaciones folclóricas cántabras en el casco histórico.',
            'fecha_inicio' => now()->addDays(50)->setTime(19, 0, 0),
            'fecha_fin' => now()->addDays(52)->setTime(23, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Puente Viesgo (ID 226)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 226,
            'user_id' => 1,
            'nombre' => 'Fiestas de San Miguel Puente Viesgo',
            'descripcion' => 'Patrón del municipio con un gran concurso de paellas, juegos rurales cántabros y verbena rural.',
            'fecha_inicio' => now()->addDays(120)->setTime(12, 0, 0),
            'fecha_fin' => now()->addDays(123)->setTime(4, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Limpias (ID 205)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 205,
            'user_id' => 1,
            'nombre' => 'Fiestas del Santo Cristo de Limpias',
            'descripcion' => 'Famosa festividad religiosa que atrae a muchos devotos. Por la noche se celebra una gran romería popular y verbenas con orquestas locales.',
            'fecha_inicio' => now()->addDays(110)->setTime(10, 0, 0),
            'fecha_fin' => now()->addDays(113)->setTime(3, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 205,
            'user_id' => 1,
            'nombre' => 'San Pedro en Limpias',
            'descripcion' => 'Pequeña romería tradicional con asado popular de sardinas y música en directo.',
            'fecha_inicio' => now()->addDays(30)->setTime(19, 0, 0),
            'fecha_fin' => now()->addDays(31)->setTime(2, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Rasines (ID 228)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 228,
            'user_id' => 1,
            'nombre' => 'Fiestas de San Andrés Rasines',
            'descripcion' => 'Verbenas tradicionales en la plaza de Rasines con orquestas del Asón y chocolate popular para los asistentes.',
            'fecha_inicio' => now()->addDays(185)->setTime(20, 0, 0),
            'fecha_fin' => now()->addDays(186)->setTime(3, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Entrambasaguas (ID 195)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 195,
            'user_id' => 1,
            'nombre' => 'Fiestas de San Esteban Entrambasaguas',
            'descripcion' => 'Patrón local con juegos de mesa tradicionales, procesión de pandereteras y verbena popular nocturna con orquesta cántabra.',
            'fecha_inicio' => now()->addDays(68)->setTime(11, 0, 0),
            'fecha_fin' => now()->addDays(70)->setTime(3, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Argoños (ID 173)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 173,
            'user_id' => 1,
            'nombre' => 'Fiestas del Carmen Argoños',
            'descripcion' => 'Romería costera con mucho ambiente turístico veraniego, conciertos acústicos al aire libre y verbena popular.',
            'fecha_inicio' => now()->addDays(48)->setTime(18, 0, 0),
            'fecha_fin' => now()->addDays(50)->setTime(3, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Selaya (ID 251)
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 251,
            'user_id' => 1,
            'nombre' => 'Fiestas de la Virgen de Valvanuz',
            'descripcion' => 'Una de las romerías más tradicionales de los valles pasiegos. Misa, danzas típicas, deportes rurales y gran verbena pasiega hasta el amanecer.',
            'fecha_inicio' => now()->addDays(80)->setTime(10, 0, 0),
            'fecha_fin' => now()->addDays(82)->setTime(5, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $eventos[] = [
            'id' => $id++,
            'lugar_id' => 251,
            'user_id' => 1,
            'nombre' => 'Fiestas del Carmen y San Antonio Selaya',
            'descripcion' => 'Famosas romerías pasiegas con concurso de tortillas, saltos pasiegos y verbenas populares llenas de juventud.',
            'fecha_inicio' => now()->addDays(48)->setTime(17, 0, 0),
            'fecha_fin' => now()->addDays(51)->setTime(4, 0, 0),
            'precio' => 0.00,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Insertar los eventos en bloques
        foreach (array_chunk($eventos, 30) as $chunk) {
            DB::table('eventos')->insert($chunk);
        }
    }
}
