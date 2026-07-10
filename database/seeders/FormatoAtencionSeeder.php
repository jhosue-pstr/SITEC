<?php

namespace Database\Seeders;

use App\Models\FormatoAtencion;
use Illuminate\Database\Seeder;

class FormatoAtencionSeeder extends Seeder
{
    public function run(): void
    {
        FormatoAtencion::create([
            'tarea_id' => 1,
            'equipo_id' => 1,
            'nombres_solicitante' => 'Ana María',
            'apellidos_solicitante' => 'Flores Mamani',
            'dni_solicitante' => '12345678',
            'telefono_movil' => '951123461',
            'regimen_laboral' => 'CAS',
            'cargo' => 'Asistente Administrativo',
            'unidad_organizacion' => 'Oficina de Recursos Humanos',
            'tipo_soporte_informatico' => 'hardware',
            'reporte_usuario' => 'La computadora no enciende desde esta mañana. No se escucha ningún ruido del ventilador ni luces en el gabinete.',
            'diagnostico_tecnico' => 'Fuente de poder dañada. No suministra voltaje a la placa madre ni a los componentes internos.',
            'observaciones' => 'Se reemplazó la fuente de poder. La PC quedó operativa. Se recomienda usar estabilizador.',
            'fecha_atencion' => now()->subDays(8)->toDateString(),
            'hora_atencion' => '10:30',
            'fecha_entrega' => now()->subDays(8)->toDateString(),
            'hora_entrega' => '11:45',
            'responsable_atencion_id' => 3,
            'nombre_responsable' => 'Ronald Jhosue Pastor Quispe',
            'estado_formato' => 'completado',
        ]);

        FormatoAtencion::create([
            'tarea_id' => 10,
            'equipo_id' => 13,
            'nombres_solicitante' => 'Miguel Ángel',
            'apellidos_solicitante' => 'Apaza Cruz',
            'dni_solicitante' => '87654321',
            'telefono_movil' => '951123470',
            'regimen_laboral' => 'DL 276',
            'cargo' => 'Comunicador Social',
            'unidad_organizacion' => 'Oficina de Imagen Institucional',
            'tipo_soporte_informatico' => 'hardware',
            'reporte_usuario' => 'La PC muestra una pantalla azul con código de error al iniciar Windows.',
            'diagnostico_tecnico' => 'Disco duro mecánico con sectores defectuosos. Se respaldaron los datos y se reemplazó por SSD.',
            'observaciones' => 'El cambio a SSD mejoró significativamente el rendimiento del equipo.',
            'fecha_atencion' => now()->subDays(10)->toDateString(),
            'hora_atencion' => '09:00',
            'fecha_entrega' => now()->subDays(10)->toDateString(),
            'hora_entrega' => '13:00',
            'responsable_atencion_id' => 3,
            'nombre_responsable' => 'Ronald Jhosue Pastor Quispe',
            'estado_formato' => 'completado',
        ]);
    }
}
