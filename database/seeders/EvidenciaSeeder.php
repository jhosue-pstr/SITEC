<?php

namespace Database\Seeders;

use App\Models\Evidencia;
use Illuminate\Database\Seeder;

class EvidenciaSeeder extends Seeder
{
    public function run(): void
    {
        Evidencia::create([
            'tarea_id' => 1,
            'atencion_id' => 1,
            'nombre_archivo' => 'fuente_poder_danada.jpg',
            'url_archivo' => '/storage/evidencias/fuente_poder_danada.jpg',
            'tipo_evidencia' => 'imagen',
            'descripcion' => 'Fuente de poder con componentes quemados.',
            'subido_por_id' => 3,
        ]);

        Evidencia::create([
            'tarea_id' => 1,
            'atencion_id' => 1,
            'nombre_archivo' => 'pc_operativa.jpeg',
            'url_archivo' => '/storage/evidencias/pc_operativa.jpeg',
            'tipo_evidencia' => 'imagen',
            'descripcion' => 'PC funcionando correctamente después del reemplazo.',
            'subido_por_id' => 3,
        ]);

        Evidencia::create([
            'tarea_id' => 2,
            'atencion_id' => 2,
            'nombre_archivo' => 'impresora_limpieza.jpg',
            'url_archivo' => '/storage/evidencias/impresora_limpieza.jpg',
            'tipo_evidencia' => 'imagen',
            'descripcion' => 'Limpieza de rodillos internos.',
            'subido_por_id' => 4,
        ]);

        Evidencia::create([
            'tarea_id' => 10,
            'atencion_id' => 3,
            'nombre_archivo' => 'disco_danado.jpg',
            'url_archivo' => '/storage/evidencias/disco_danado.jpg',
            'tipo_evidencia' => 'imagen',
            'descripcion' => 'Disco duro con sectores dañados.',
            'subido_por_id' => 3,
        ]);

        Evidencia::create([
            'tarea_id' => 10,
            'atencion_id' => 3,
            'nombre_archivo' => 'informe_reparacion.pdf',
            'url_archivo' => '/storage/evidencias/informe_reparacion.pdf',
            'tipo_evidencia' => 'documento',
            'descripcion' => 'Informe detallado de la reparación realizada.',
            'subido_por_id' => 3,
        ]);
    }
}
