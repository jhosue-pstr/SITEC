<?php

namespace Database\Seeders;

use App\Models\Equipo;
use Illuminate\Database\Seeder;

class EquipoSeeder extends Seeder
{
    public function run(): void
    {
        $equipos = [
            ['tipo_equipo' => 'computadora', 'codigo_patrimonial' => 'MPSR-001', 'numero_serie' => 'SN-ABC-001', 'marca' => 'Lenovo', 'modelo' => 'ThinkCentre M720', 'oficina_id' => 1, 'usuario_responsable_id' => 1],
            ['tipo_equipo' => 'computadora', 'codigo_patrimonial' => 'MPSR-002', 'numero_serie' => 'SN-ABC-002', 'marca' => 'Lenovo', 'modelo' => 'ThinkCentre M720', 'oficina_id' => 2, 'usuario_responsable_id' => 2],
            ['tipo_equipo' => 'laptop', 'codigo_patrimonial' => 'MPSR-003', 'numero_serie' => 'SN-ABC-003', 'marca' => 'Dell', 'modelo' => 'Latitude 3420', 'oficina_id' => 3, 'usuario_responsable_id' => 3],
            ['tipo_equipo' => 'computadora', 'codigo_patrimonial' => 'MPSR-004', 'numero_serie' => 'SN-ABC-004', 'marca' => 'HP', 'modelo' => 'ProDesk 400', 'oficina_id' => 4, 'usuario_responsable_id' => 4],
            ['tipo_equipo' => 'impresora', 'codigo_patrimonial' => 'MPSR-005', 'numero_serie' => 'SN-ABC-005', 'marca' => 'Epson', 'modelo' => 'L3550', 'oficina_id' => 5, 'usuario_responsable_id' => 5],
            ['tipo_equipo' => 'computadora', 'codigo_patrimonial' => 'MPSR-006', 'numero_serie' => 'SN-ABC-006', 'marca' => 'Lenovo', 'modelo' => 'ThinkCentre M910', 'oficina_id' => 6, 'usuario_responsable_id' => 6],
            ['tipo_equipo' => 'impresora', 'codigo_patrimonial' => 'MPSR-007', 'numero_serie' => 'SN-ABC-007', 'marca' => 'HP', 'modelo' => 'LaserJet M404', 'oficina_id' => 7, 'usuario_responsable_id' => 7],
            ['tipo_equipo' => 'laptop', 'codigo_patrimonial' => 'MPSR-008', 'numero_serie' => 'SN-ABC-008', 'marca' => 'HP', 'modelo' => 'ProBook 450', 'oficina_id' => 8, 'usuario_responsable_id' => 8],
            ['tipo_equipo' => 'monitor', 'codigo_patrimonial' => 'MPSR-009', 'numero_serie' => 'SN-ABC-009', 'marca' => 'Samsung', 'modelo' => 'S22F350', 'oficina_id' => 9, 'usuario_responsable_id' => 9],
            ['tipo_equipo' => 'computadora', 'codigo_patrimonial' => 'MPSR-010', 'numero_serie' => 'SN-ABC-010', 'marca' => 'Dell', 'modelo' => 'OptiPlex 3080', 'oficina_id' => 10, 'usuario_responsable_id' => 10],
            ['tipo_equipo' => 'router', 'codigo_patrimonial' => 'MPSR-011', 'numero_serie' => 'SN-ABC-011', 'marca' => 'MikroTik', 'modelo' => 'RB951Ui-2HnD', 'oficina_id' => 3, 'usuario_responsable_id' => null],
            ['tipo_equipo' => 'switch', 'codigo_patrimonial' => 'MPSR-012', 'numero_serie' => 'SN-ABC-012', 'marca' => 'Cisco', 'modelo' => 'SG250-26', 'oficina_id' => 3, 'usuario_responsable_id' => null],
            ['tipo_equipo' => 'computadora', 'codigo_patrimonial' => 'MPSR-013', 'numero_serie' => 'SN-ABC-013', 'marca' => 'Lenovo', 'modelo' => 'ThinkCentre M720', 'oficina_id' => 11, 'usuario_responsable_id' => 11],
            ['tipo_equipo' => 'impresora', 'codigo_patrimonial' => 'MPSR-014', 'numero_serie' => 'SN-ABC-014', 'marca' => 'Epson', 'modelo' => 'L5190', 'oficina_id' => 12, 'usuario_responsable_id' => null],
            ['tipo_equipo' => 'computadora', 'codigo_patrimonial' => 'MPSR-015', 'numero_serie' => 'SN-ABC-015', 'marca' => 'HP', 'modelo' => 'ProDesk 400', 'oficina_id' => 13, 'usuario_responsable_id' => 12],
        ];

        foreach ($equipos as $e) {
            Equipo::create($e);
        }
    }
}
