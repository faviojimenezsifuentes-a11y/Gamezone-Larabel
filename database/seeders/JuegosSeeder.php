<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JuegosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('juegos')->insertOrIgnore([
            [
                'titulo' => 'Marvel’s Spider-Man 2',
                'descripcion' => 'Aventura de mundo abierto con Spider-Man y Miles Morales.',
                'precio' => 249.90,
                'categoria' => 'Aventura',
                'imagen' => 'assets/img/juegos/SPIDERMAN2.png',
                'stock' => 10,
            ],
            [
                'titulo' => 'Crash Team Racing Nitro-Fueled',
                'descripcion' => 'Remake del clásico Crash Team Racing.',
                'precio' => 159.90,
                'categoria' => 'Carreras',
                'imagen' => 'assets/img/juegos/CRASHNITRO.png',
                'stock' => 10,
            ],
            [
                'titulo' => 'Dragon Ball: Sparking! Zero',
                'descripcion' => 'Juego de lucha basado en Dragon Ball.',
                'precio' => 229.90,
                'categoria' => 'Lucha',
                'imagen' => 'assets/img/juegos/DRAGONBALL.png',
                'stock' => 10,
            ],
            [
                'titulo' => 'EA Sports FC 25',
                'descripcion' => 'Simulador de fútbol edición 2025.',
                'precio' => 199.90,
                'categoria' => 'Deportes',
                'imagen' => 'assets/img/juegos/FIFA25.png',
                'stock' => 10,
            ],
            [
                'titulo' => 'God of War Ragnarök',
                'descripcion' => 'Acción y aventura con Kratos y Atreus.',
                'precio' => 239.90,
                'categoria' => 'Aventura',
                'imagen' => 'assets/img/juegos/GODOFWAR.png',
                'stock' => 10,
            ],
            [
                'titulo' => 'Grand Theft Auto V',
                'descripcion' => 'Juego de mundo abierto con múltiples personajes.',
                'precio' => 119.90,
                'categoria' => 'Acción',
                'imagen' => 'assets/img/juegos/GTAV.png',
                'stock' => 10,
            ],
            [
                'titulo' => 'Call of Duty: Modern Warfare III',
                'descripcion' => 'Shooter en primera persona de la saga Call of Duty.',
                'precio' => 279.90,
                'categoria' => 'Shooter',
                'imagen' => 'assets/img/juegos/CODMW3.png',
                'stock' => 10,
            ],
            [
                'titulo' => 'Resident Evil 4 Remake',
                'descripcion' => 'Remake del clásico survival horror Resident Evil 4.',
                'precio' => 189.90,
                'categoria' => 'Horror',
                'imagen' => 'assets/img/juegos/RESIDENTEVIL4.png',
                'stock' => 10,
            ],
            [
                'titulo' => 'Crash Bandicoot 4',
                'descripcion' => 'Aventura de plataformas con Crash Bandicoot.',
                'precio' => 129.90,
                'categoria' => 'Aventura',
                'imagen' => 'assets/img/juegos/CRASH4.png',
                'stock' => 10,
            ],
            [
                'titulo' => 'Gang Beasts',
                'descripcion' => 'Juego de peleas multijugador divertido y caótico.',
                'precio' => 239.90,
                'categoria' => 'Party',
                'imagen' => 'assets/img/juegos/GANGBEASTS.png',
                'stock' => 10,
            ],
        ]);
    }
}
