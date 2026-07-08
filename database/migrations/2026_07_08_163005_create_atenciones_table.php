<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('atenciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tarea_id')->unique()->constrained('tareas');
            $table->foreignId('practicante_id')->constrained('usuarios');

            $table->text('diagnostico')->nullable();
            $table->text('actividades_realizadas')->nullable();
            $table->text('solucion_aplicada')->nullable();
            $table->text('observaciones')->nullable();
            $table->integer('tiempo_atencion_minutos')->nullable();

            $table->timestamp('fecha_atencion')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atenciones');
    }
};
