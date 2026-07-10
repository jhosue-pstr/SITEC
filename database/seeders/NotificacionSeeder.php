<?php

namespace Database\Seeders;

use App\Models\Notificacion;
use Illuminate\Database\Seeder;

class NotificacionSeeder extends Seeder
{
    public function run(): void
    {
        Notificacion::create([
            'usuario_id' => 1,
            'tarea_id' => 4,
            'titulo' => 'Nueva tarea asignada',
            'mensaje' => 'La tarea ST-00004 - Sin acceso a internet ha sido asignada al practicante José Luis Quispe Callata.',
            'leida' => true,
        ]);

        Notificacion::create([
            'usuario_id' => 3,
            'tarea_id' => 3,
            'titulo' => 'Tarea actualizada',
            'mensaje' => 'La tarea ST-00003 - Outlook no envía correos ha cambiado a estado: en_proceso.',
            'leida' => true,
        ]);

        Notificacion::create([
            'usuario_id' => 4,
            'tarea_id' => 4,
            'titulo' => 'Nueva tarea asignada',
            'mensaje' => 'Se te ha asignado la tarea ST-00004 - Sin acceso a internet.',
            'leida' => false,
        ]);

        Notificacion::create([
            'usuario_id' => 1,
            'tarea_id' => 9,
            'titulo' => 'Tarea observada',
            'mensaje' => 'La tarea ST-00009 - Configuración de correo en celular ha sido marcada como observada.',
            'leida' => false,
        ]);

        Notificacion::create([
            'usuario_id' => 3,
            'tarea_id' => 1,
            'titulo' => 'Tarea finalizada',
            'mensaje' => 'La tarea ST-00001 - Computadora no enciende ha sido finalizada satisfactoriamente.',
            'leida' => true,
        ]);
    }
}
