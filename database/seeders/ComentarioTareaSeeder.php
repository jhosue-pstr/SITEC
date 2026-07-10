<?php

namespace Database\Seeders;

use App\Models\ComentarioTarea;
use Illuminate\Database\Seeder;

class ComentarioTareaSeeder extends Seeder
{
    public function run(): void
    {
        ComentarioTarea::create([
            'tarea_id' => 3,
            'usuario_id' => 1,
            'comentario' => 'Revisar también la configuración del firewall, podría estar bloqueando el puerto SMTP.',
        ]);

        ComentarioTarea::create([
            'tarea_id' => 3,
            'usuario_id' => 3,
            'comentario' => 'Ya revisé el firewall, los puertos están abiertos. El problema parece ser la contraseña del servidor SMTP.',
        ]);

        ComentarioTarea::create([
            'tarea_id' => 4,
            'usuario_id' => 1,
            'comentario' => 'Prioridad crítica. Coordinar con el administrador de red para revisar el switch del anexo.',
        ]);

        ComentarioTarea::create([
            'tarea_id' => 9,
            'usuario_id' => 1,
            'comentario' => 'La configuración está incompleta. Se necesita generar una contraseña de aplicación para el correo en Android. Pendiente de coordinar con el usuario.',
        ]);

        ComentarioTarea::create([
            'tarea_id' => 11,
            'usuario_id' => 4,
            'comentario' => 'El cable de red está roto en un tramo visible. Necesito un cable UTP categoría 6 de aproximadamente 15 metros para reemplazarlo.',
        ]);
    }
}
