<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::create([
            'nombres' => 'Admin',
            'apellidos' => '—',
            'correo' => 'admin@admin.com',
            'telefono' => '',
            'rol' => 'jefe',
            'activo' => true,
            'password' => Hash::make('admin'),
        ]);
    }
}
