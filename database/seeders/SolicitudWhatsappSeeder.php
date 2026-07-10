<?php

namespace Database\Seeders;

use App\Models\SolicitudWhatsapp;
use Illuminate\Database\Seeder;

class SolicitudWhatsappSeeder extends Seeder
{
    public function run(): void
    {
        SolicitudWhatsapp::create([
            'tarea_id' => 5,
            'numero_whatsapp' => '+51951123461',
            'mensaje_original' => 'Hola, necesito ayuda con la instalación de Office en la PC del gerente.',
            'estado_conversacion' => 'completado',
            'external_message_id' => 'wamid.ABC123DEF456',
        ]);

        SolicitudWhatsapp::create([
            'tarea_id' => 12,
            'numero_whatsapp' => '+51951123462',
            'mensaje_original' => 'Buenos días, requiero apoyo para escanear documentos de expedientes técnicos.',
            'estado_conversacion' => 'recibido',
            'external_message_id' => 'wamid.GHI789JKL012',
        ]);

        SolicitudWhatsapp::create([
            'tarea_id' => null,
            'numero_whatsapp' => '+51951123463',
            'mensaje_original' => 'La impresora de mi oficina no funciona, necesito que alguien venga a revisarla.',
            'estado_conversacion' => 'pendiente',
            'external_message_id' => null,
        ]);
    }
}
