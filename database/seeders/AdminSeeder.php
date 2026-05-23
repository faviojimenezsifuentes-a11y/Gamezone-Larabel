<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::updateOrCreate(
            ['correo' => 'admin@gamezone.com'],
            [
                'nombre' => 'Admin',
                'apellido' => 'GameZone',
                'telefono' => null,
                'password' => Hash::make('123456'),
                'rol' => 'admin',
            ]
        );
    }
}
