<?php

namespace App\Console\Commands;

use App\Models\Tarea;
use App\Models\Usuario;
use App\Services\ChatbotService;
use Illuminate\Console\Command;

class SeguimientoTareas extends Command
{
    protected $signature = 'tareas:seguimiento';

    protected $description = 'Envía recordatorios a 48h y auto-confirma el cierre de tickets tras 5 días hábiles sin confirmación del solicitante.';

    public function handle(): int
    {
        $chatbot = app(ChatbotService::class);
        $jefe = Usuario::where('rol', 'jefe')->first();
        $ahora = now();

        $tareas = Tarea::where('finalizado_solicitante', false)
            ->where('estado', '!=', 'cancelado')
            ->get();

        $procesadas = 0;

        foreach ($tareas as $tarea) {
            if (! $tarea->fecha_registro) {
                continue;
            }

            // --- Recordatorio a 48h (una sola vez) ---
            if (! $tarea->recordatorio_48h_enviado
                && $tarea->fecha_registro->copy()->addHours(48)->lessThanOrEqualTo($ahora)) {

                if (! $tarea->finalizado_tecnico) {
                    $chatbot->recordatorioSinFinalizar($tarea);
                } else {
                    $chatbot->recordatorioEsperandoConfirmacion($tarea);
                }

                $tarea->update(['recordatorio_48h_enviado' => true]);
                $procesadas++;
            }

            // --- Auto-cierre a 5 días hábiles (lun-vie) desde el registro ---
            if ($tarea->finalizado_tecnico
                && $ahora->greaterThanOrEqualTo($tarea->fechaLimiteConfirmacion())) {

                $tarea->update(['finalizado_solicitante' => true]);
                $tarea->recalcularCierre();

                Notificacion::create([
                    'usuario_id' => $jefe?->id,
                    'tarea_id' => $tarea->id,
                    'titulo' => 'Cierre automático de ticket',
                    'mensaje' => "La solicitud {$tarea->codigo} se confirmó automáticamente tras 5 días hábiles sin respuesta del solicitante.",
                ]);

                $chatbot->notificarAutoConfirmacion($tarea);
                $procesadas++;
            }
        }

        $this->info("Seguimiento de tareas procesado. {$procesadas} acción(es) ejecutada(s).");

        return self::SUCCESS;
    }
}
