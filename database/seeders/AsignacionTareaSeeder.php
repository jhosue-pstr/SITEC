<?php

namespace Database\Seeders;

use App\Models\AsignacionTarea;
use Illuminate\Database\Seeder;

class AsignacionTareaSeeder extends Seeder
{
    public function run(): void
    {
        AsignacionTarea::create([
            'tarea_id' => 1, 'practicante_id' => 3, 'tipo_asignacion' => 'manual',
            'asignado_por_id' => 1, 'fecha_asignacion' => now()->subDays(10), 'activa' => false,
        ]);

        AsignacionTarea::create([
            'tarea_id' => 2, 'practicante_id' => 4, 'tipo_asignacion' => 'manual',
            'asignado_por_id' => 1, 'fecha_asignacion' => now()->subDays(8), 'activa' => false,
        ]);

        AsignacionTarea::create([
            'tarea_id' => 3, 'practicante_id' => 3, 'tipo_asignacion' => 'manual',
            'asignado_por_id' => 1, 'fecha_asignacion' => now()->subDays(5), 'activa' => true,
        ]);

        AsignacionTarea::create([
            'tarea_id' => 4, 'practicante_id' => 4, 'tipo_asignacion' => 'manual',
            'asignado_por_id' => 1, 'fecha_asignacion' => now()->subDays(1), 'activa' => true,
        ]);

        AsignacionTarea::create([
            'tarea_id' => 8, 'practicante_id' => 3, 'tipo_asignacion' => 'manual',
            'asignado_por_id' => 1, 'fecha_asignacion' => now()->subDays(15), 'activa' => false,
        ]);

        AsignacionTarea::create([
            'tarea_id' => 9, 'practicante_id' => 4, 'tipo_asignacion' => 'auto',
            'asignado_por_id' => null, 'fecha_asignacion' => now()->subDays(6), 'activa' => true,
        ]);

        AsignacionTarea::create([
            'tarea_id' => 10, 'practicante_id' => 3, 'tipo_asignacion' => 'manual',
            'asignado_por_id' => 1, 'fecha_asignacion' => now()->subDays(12), 'activa' => false,
        ]);

        AsignacionTarea::create([
            'tarea_id' => 11, 'practicante_id' => 4, 'tipo_asignacion' => 'manual',
            'asignado_por_id' => 1, 'fecha_asignacion' => now()->subDays(3), 'activa' => true,
        ]);
    }
}
