<?php

namespace Database\Seeders;

use App\Models\Oficina;
use Illuminate\Database\Seeder;

class OficinaSeeder extends Seeder
{
    public function run(): void
    {
        $oficinas = [
            ['nombre' => 'Alcaldía', 'ubicacion' => 'Palacio Municipal - 2do Piso'],
            ['nombre' => 'Gerencia Municipal', 'ubicacion' => 'Palacio Municipal - 2do Piso'],
            ['nombre' => 'Oficina General de Tecnología de la Información', 'ubicacion' => 'Palacio Municipal - 1er Piso'],
            ['nombre' => 'Oficina de Recursos Humanos', 'ubicacion' => 'Palacio Municipal - 3er Piso'],
            ['nombre' => 'Oficina de Administración', 'ubicacion' => 'Palacio Municipal - 1er Piso'],
            ['nombre' => 'Oficina de Tesorería', 'ubicacion' => 'Palacio Municipal - 1er Piso'],
            ['nombre' => 'Oficina de Contabilidad', 'ubicacion' => 'Palacio Municipal - 2do Piso'],
            ['nombre' => 'Oficina de Abastecimiento', 'ubicacion' => 'Palacio Municipal - 3er Piso'],
            ['nombre' => 'Oficina de Planeamiento y Presupuesto', 'ubicacion' => 'Palacio Municipal - 2do Piso'],
            ['nombre' => 'Oficina de Asesoría Jurídica', 'ubicacion' => 'Palacio Municipal - 1er Piso'],
            ['nombre' => 'Oficina de Imagen Institucional', 'ubicacion' => 'Palacio Municipal - 3er Piso'],
            ['nombre' => 'Subgerencia de Servicios Públicos', 'ubicacion' => 'Local Anexo - Av. Circunvalación'],
            ['nombre' => 'Subgerencia de Desarrollo Urbano', 'ubicacion' => 'Local Anexo - Av. Circunvalación'],
            ['nombre' => 'Subgerencia de Desarrollo Social', 'ubicacion' => 'Local Anexo - Jr. San Martín'],
            ['nombre' => 'División de Fiscalización', 'ubicacion' => 'Local Anexo - Jr. San Martín'],
        ];

        foreach ($oficinas as $oficina) {
            Oficina::create($oficina);
        }
    }
}
