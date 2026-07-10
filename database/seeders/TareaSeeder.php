<?php

namespace Database\Seeders;

use App\Models\Tarea;
use Illuminate\Database\Seeder;

class TareaSeeder extends Seeder
{
    public function run(): void
    {
        $tareas = [
            [
                'codigo' => 'ST-00001', 'titulo' => 'Computadora no enciende', 'descripcion' => 'La PC de recursos humanos no enciende, no se escucha ningún ruido del ventilador.',
                'tipo_soporte' => 'hardware', 'prioridad' => 'alta', 'estado' => 'finalizado',
                'solicitante_id' => 6, 'oficina_id' => 4, 'practicante_asignado_id' => 3,
                'fecha_registro' => now()->subDays(10), 'fecha_asignacion' => now()->subDays(10),
                'fecha_inicio' => now()->subDays(9), 'fecha_finalizacion' => now()->subDays(8),
            ],
            [
                'codigo' => 'ST-00002', 'titulo' => 'Impresora no imprime', 'descripcion' => 'La impresora Epson L3550 de Administración no imprime, muestra error de papel atascado pero no hay papel atascado.',
                'tipo_soporte' => 'impresion', 'prioridad' => 'media', 'estado' => 'finalizado',
                'solicitante_id' => 7, 'oficina_id' => 5, 'practicante_asignado_id' => 4,
                'fecha_registro' => now()->subDays(8), 'fecha_asignacion' => now()->subDays(8),
                'fecha_inicio' => now()->subDays(7), 'fecha_finalizacion' => now()->subDays(7),
            ],
            [
                'codigo' => 'ST-00003', 'titulo' => 'Outlook no envía correos', 'descripcion' => 'En la oficina de Tesorería no se pueden enviar correos desde Outlook, solo reciben.',
                'tipo_soporte' => 'software', 'prioridad' => 'alta', 'estado' => 'en_proceso',
                'solicitante_id' => 8, 'oficina_id' => 6, 'practicante_asignado_id' => 3,
                'fecha_registro' => now()->subDays(5), 'fecha_asignacion' => now()->subDays(5),
                'fecha_inicio' => now()->subDays(4), 'fecha_finalizacion' => null,
            ],
            [
                'codigo' => 'ST-00004', 'titulo' => 'Sin acceso a internet', 'descripcion' => 'En el módulo de Desarrollo Urbano no hay conexión a internet desde ayer.',
                'tipo_soporte' => 'red', 'prioridad' => 'critica', 'estado' => 'asignado',
                'solicitante_id' => 9, 'oficina_id' => 13, 'practicante_asignado_id' => 4,
                'fecha_registro' => now()->subDays(2), 'fecha_asignacion' => now()->subDays(1),
                'fecha_inicio' => null, 'fecha_finalizacion' => null,
            ],
            [
                'codigo' => 'ST-00005', 'titulo' => 'Instalación de Office 365', 'descripcion' => 'Se necesita instalar Microsoft Office 365 en la PC nueva del Gerente Municipal.',
                'tipo_soporte' => 'software', 'prioridad' => 'media', 'estado' => 'pendiente',
                'solicitante_id' => 10, 'oficina_id' => 2, 'practicante_asignado_id' => null,
                'fecha_registro' => now()->subDays(1), 'fecha_asignacion' => null,
                'fecha_inicio' => null, 'fecha_finalizacion' => null,
            ],
            [
                'codigo' => 'ST-00006', 'titulo' => 'Mouse y teclado no funcionan', 'descripcion' => 'Los periféricos de la PC de Alcaldía dejaron de funcionar repentinamente.',
                'tipo_soporte' => 'hardware', 'prioridad' => 'baja', 'estado' => 'pendiente',
                'solicitante_id' => 11, 'oficina_id' => 1, 'practicante_asignado_id' => null,
                'fecha_registro' => now(), 'fecha_asignacion' => null,
                'fecha_inicio' => null, 'fecha_finalizacion' => null,
            ],
            [
                'codigo' => 'ST-00007', 'titulo' => 'Sistema SIAF no abre', 'descripcion' => 'El SIAF se queda en pantalla de carga y no permite ingresar al módulo de contabilidad.',
                'tipo_soporte' => 'software', 'prioridad' => 'critica', 'estado' => 'pendiente',
                'solicitante_id' => 12, 'oficina_id' => 7, 'practicante_asignado_id' => null,
                'fecha_registro' => now(), 'fecha_asignacion' => null,
                'fecha_inicio' => null, 'fecha_finalizacion' => null,
            ],
            [
                'codigo' => 'ST-00008', 'titulo' => 'Cambio de tóner impresora', 'descripcion' => 'La impresora LaserJet de Contabilidad reporta tóner vacío.',
                'tipo_soporte' => 'impresion', 'prioridad' => 'media', 'estado' => 'cancelado',
                'solicitante_id' => 13, 'oficina_id' => 7, 'practicante_asignado_id' => 3,
                'fecha_registro' => now()->subDays(15), 'fecha_asignacion' => now()->subDays(15),
                'fecha_inicio' => now()->subDays(14), 'fecha_finalizacion' => now()->subDays(14),
            ],
            [
                'codigo' => 'ST-00009', 'titulo' => 'Configuración de correo en celular', 'descripcion' => 'El jefe de Abastecimiento quiere configurar su correo institucional en su celular Android.',
                'tipo_soporte' => 'software', 'prioridad' => 'baja', 'estado' => 'observado',
                'solicitante_id' => 14, 'oficina_id' => 8, 'practicante_asignado_id' => 4,
                'fecha_registro' => now()->subDays(6), 'fecha_asignacion' => now()->subDays(6),
                'fecha_inicio' => now()->subDays(5), 'fecha_finalizacion' => null,
            ],
            [
                'codigo' => 'ST-00010', 'titulo' => 'Pantalla azul en PC de Imagen', 'descripcion' => 'La computadora de Imagen Institucional muestra pantalla azul al iniciar.',
                'tipo_soporte' => 'hardware', 'prioridad' => 'alta', 'estado' => 'finalizado',
                'solicitante_id' => 15, 'oficina_id' => 11, 'practicante_asignado_id' => 3,
                'fecha_registro' => now()->subDays(12), 'fecha_asignacion' => now()->subDays(12),
                'fecha_inicio' => now()->subDays(11), 'fecha_finalizacion' => now()->subDays(10),
            ],
            [
                'codigo' => 'ST-00011', 'titulo' => 'Cable de red dañado', 'descripcion' => 'En Desarrollo Social el cable de red está dañado, no hay conexión en 2 PCs.',
                'tipo_soporte' => 'red', 'prioridad' => 'alta', 'estado' => 'en_proceso',
                'solicitante_id' => 6, 'oficina_id' => 14, 'practicante_asignado_id' => 4,
                'fecha_registro' => now()->subDays(4), 'fecha_asignacion' => now()->subDays(3),
                'fecha_inicio' => now()->subDays(2), 'fecha_finalizacion' => null,
            ],
            [
                'codigo' => 'ST-00012', 'titulo' => 'Escaneo de documentos', 'descripcion' => 'Se requiere escanear documentos de Expedientes Técnicos a digital.',
                'tipo_soporte' => 'otro', 'prioridad' => 'baja', 'estado' => 'pendiente',
                'solicitante_id' => 7, 'oficina_id' => 13, 'practicante_asignado_id' => null,
                'fecha_registro' => now(), 'fecha_asignacion' => null,
                'fecha_inicio' => null, 'fecha_finalizacion' => null,
            ],
        ];

        foreach ($tareas as $t) {
            Tarea::create($t);
        }
    }
}
