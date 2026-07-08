<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asignaciones_tarea', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tarea_id')->constrained('tareas');
            $table->foreignId('practicante_id')->constrained('usuarios');
            $table->string('tipo_asignacion', 30);
            $table->foreignId('asignado_por_id')->nullable()->constrained('usuarios');
            $table->timestamp('fecha_asignacion')->useCurrent();
            $table->timestamp('fecha_fin_asignacion')->nullable();
            $table->boolean('activa')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asignaciones_tarea');
    }
};
