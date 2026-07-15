<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tareas', function (Blueprint $table) {
            // El solicitante pidió otro técnico desde el chat ("mas" -> opción 2)
            $table->boolean('solicita_cambio_tecnico')->default(false)->after('finalizado_solicitante');
            // El solicitante pidió cerrar el ticket desde el chat ("mas" -> opción 3)
            $table->boolean('solicita_cierre')->default(false)->after('solicita_cambio_tecnico');
            // Evita enviar el recordatorio de 48h más de una vez
            $table->boolean('recordatorio_48h_enviado')->default(false)->after('solicita_cierre');
        });
    }

    public function down(): void
    {
        Schema::table('tareas', function (Blueprint $table) {
            $table->dropColumn(['solicita_cambio_tecnico', 'solicita_cierre', 'recordatorio_48h_enviado']);
        });
    }
};
