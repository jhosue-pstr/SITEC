<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Banderas de cierre doble en la tarea
        Schema::table('tareas', function (Blueprint $table) {
            $table->boolean('finalizado_tecnico')->default(false)->after('fecha_finalizacion');
            $table->boolean('finalizado_solicitante')->default(false)->after('finalizado_tecnico');
        });

        // Registro representativo de derivación / escalamiento (el tercero no entra al sistema)
        Schema::create('derivaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tarea_id')->constrained('tareas')->cascadeOnDelete();
            $table->string('tipo', 20); // 'tecnico' | 'proveedor'
            $table->foreignId('tecnico_destino_id')->nullable()->constrained('usuarios')->nullOnDelete();
            $table->string('proveedor_nombre')->nullable();
            $table->text('motivo')->nullable();
            $table->foreignId('derivado_por_id')->constrained('usuarios');
            $table->timestamp('fecha_derivacion')->nullable();
            $table->timestamps();
        });

        // Encuesta de satisfacción del solicitante (vía WhatsApp)
        Schema::create('encuestas_satisfaccion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tarea_id')->constrained('tareas')->cascadeOnDelete();
            $table->string('numero_whatsapp', 20);
            $table->unsignedTinyInteger('calificacion');
            $table->text('comentario')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('encuestas_satisfaccion');
        Schema::dropIfExists('derivaciones');

        Schema::table('tareas', function (Blueprint $table) {
            $table->dropColumn(['finalizado_tecnico', 'finalizado_solicitante']);
        });
    }
};
