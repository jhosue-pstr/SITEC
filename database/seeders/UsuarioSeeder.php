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
            'nombres' => 'Luther Pedro',
            'apellidos' => 'Vilca Mansilla',
            'correo' => 'lvilca@munisanroman.gob.pe',
            'telefono' => '951123456',
            'rol' => 'jefe',
            'activo' => true,
            'password' => Hash::make('password'),
        ]);

        $practicantes = [
            ['nombres' => 'Ronald Jhosue', 'apellidos' => 'Pastor Quispe', 'correo' => 'rpastor@munisanroman.gob.pe', 'telefono' => '951123457'],
            ['nombres' => 'Carlos Alberto', 'apellidos' => 'Mamani Condori', 'correo' => 'cmamani@munisanroman.gob.pe', 'telefono' => '951123458'],
            ['nombres' => 'María Elena', 'apellidos' => 'Huanca Ramos', 'correo' => 'mhuanca@munisanroman.gob.pe', 'telefono' => '951123459'],
            ['nombres' => 'José Luis', 'apellidos' => 'Quispe Callata', 'correo' => 'jquispe@munisanroman.gob.pe', 'telefono' => '951123460'],
        ];

        foreach ($practicantes as $p) {
            $p['rol'] = 'practicante';
            $p['activo'] = true;
            $p['password'] = Hash::make('password');
            Usuario::create($p);
        }

        $solicitantes = [
            ['nombres' => 'Ana María', 'apellidos' => 'Flores Mamani', 'correo' => 'aflores@munisanroman.gob.pe', 'telefono' => '951123461'],
            ['nombres' => 'Pedro', 'apellidos' => 'Ccori Apaza', 'correo' => 'pccori@munisanroman.gob.pe', 'telefono' => '951123462'],
            ['nombres' => 'Rosa', 'apellidos' => 'Mendoza de la Cruz', 'correo' => 'rmendoza@munisanroman.gob.pe', 'telefono' => '951123463'],
            ['nombres' => 'Juan', 'apellidos' => 'Calsina Quispe', 'correo' => 'jcalsina@munisanroman.gob.pe', 'telefono' => '951123464'],
            ['nombres' => 'Carmen', 'apellidos' => 'Paredes Huanca', 'correo' => 'cparedes@munisanroman.gob.pe', 'telefono' => '951123465'],
            ['nombres' => 'David', 'apellidos' => 'Mamani Huanca', 'correo' => 'dmamani@munisanroman.gob.pe', 'telefono' => '951123466'],
            ['nombres' => 'Lucía', 'apellidos' => 'Condori Yana', 'correo' => 'lcondori@munisanroman.gob.pe', 'telefono' => '951123467'],
            ['nombres' => 'Roberto', 'apellidos' => 'Quispe Hancco', 'correo' => 'rquispe@munisanroman.gob.pe', 'telefono' => '951123468'],
            ['nombres' => 'Sandra', 'apellidos' => 'Huayta Quispe', 'correo' => 'shuayta@munisanroman.gob.pe', 'telefono' => '951123469'],
            ['nombres' => 'Miguel Ángel', 'apellidos' => 'Apaza Cruz', 'correo' => 'mapaza@munisanroman.gob.pe', 'telefono' => '951123470'],
        ];

        foreach ($solicitantes as $s) {
            $s['rol'] = 'solicitante';
            $s['activo'] = true;
            $s['password'] = Hash::make('password');
            Usuario::create($s);
        }
    }
}
