<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            OficinaSeeder::class,
            UsuarioSeeder::class,
            EquipoSeeder::class,
            TareaSeeder::class,
            AtencionSeeder::class,
            EvidenciaSeeder::class,
            ComentarioTareaSeeder::class,
            AsignacionTareaSeeder::class,
            NotificacionSeeder::class,
            FormatoAtencionSeeder::class,
            SolicitudWhatsappSeeder::class,
        ]);
    }
}
