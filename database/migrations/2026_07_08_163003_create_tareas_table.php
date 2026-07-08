<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();

            $table->string('codigo', 20)->unique();
            $table->string('titulo', 150);
            $table->text('descripcion');
            $table->string('tipo_soporte', 50);
            $table->string('prioridad', 20)->default('media');
            $table->string('estado', 30)->default('pendiente');
            $table->string('ubicacion_detalle', 200)->nullable();

            $table->foreignId('solicitante_id')->constrained('usuarios');
            $table->foreignId('oficina_id')->nullable()->constrained('oficinas');
            $table->foreignId('practicante_asignado_id')->nullable()->constrained('usuarios');

            $table->timestamp('fecha_registro')->useCurrent();
            $table->timestamp('fecha_asignacion')->nullable();
            $table->timestamp('fecha_inicio')->nullable();
            $table->timestamp('fecha_finalizacion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
