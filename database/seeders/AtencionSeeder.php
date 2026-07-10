<?php

namespace Database\Seeders;

use App\Models\Atencion;
use Illuminate\Database\Seeder;

class AtencionSeeder extends Seeder
{
    public function run(): void
    {
        Atencion::create([
            'tarea_id' => 1,
            'practicante_id' => 3,
            'diagnostico' => 'Fuente de poder dañada, no suministra energía a la placa madre.',
            'actividades_realizadas' => 'Revisión de la fuente de poder, verificación de voltajes, limpieza de conectores internos.',
            'solucion_aplicada' => 'Reemplazo de fuente de poder por una compatible.',
            'observaciones' => 'La PC quedó operativa. Se recomienda mantenerla conectada a un estabilizador.',
            'tiempo_atencion_minutos' => 60,
            'fecha_atencion' => now()->subDays(8),
        ]);

        Atencion::create([
            'tarea_id' => 2,
            'practicante_id' => 4,
            'diagnostico' => 'Sensor de papel atascado activado falsamente por residuos de papel.',
            'actividades_realizadas' => 'Apertura de la impresora, limpieza interna de rodillos y sensores.',
            'solucion_aplicada' => 'Extracción de residuos de papel y limpieza de sensores ópticos.',
            'observaciones' => 'Se realizó mantenimiento preventivo básico.',
            'tiempo_atencion_minutos' => 30,
            'fecha_atencion' => now()->subDays(7),
        ]);

        Atencion::create([
            'tarea_id' => 10,
            'practicante_id' => 3,
            'diagnostico' => 'Disco duro con sectores dañados causando errores críticos del sistema.',
            'actividades_realizadas' => 'Ejecución de chkdsk, verificación de SMART, respaldo de datos personales.',
            'solucion_aplicada' => 'Reemplazo de disco duro por SSD y reinstalación del sistema operativo.',
            'observaciones' => 'Se recuperaron todos los datos. Rendimiento mejoró significativamente con SSD.',
            'tiempo_atencion_minutos' => 180,
            'fecha_atencion' => now()->subDays(10),
        ]);

        Atencion::create([
            'tarea_id' => 8,
            'practicante_id' => 3,
            'diagnostico' => 'Tóner agotado, tambor en buen estado.',
            'actividades_realizadas' => 'Reemplazo de cartucho de tóner, prueba de impresión.',
            'solucion_aplicada' => 'Cambio de tóner por uno nuevo compatible.',
            'observaciones' => 'Se dejó un tóner de repuesto en oficina.',
            'tiempo_atencion_minutos' => 15,
            'fecha_atencion' => now()->subDays(14),
        ]);
    }
}
