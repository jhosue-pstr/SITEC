<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evidencias', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tarea_id')->constrained('tareas');
            $table->foreignId('atencion_id')->nullable()->constrained('atenciones');

            $table->string('nombre_archivo', 255);
            $table->string('url_archivo', 500);
            $table->string('tipo_evidencia', 50);
            $table->string('descripcion', 255)->nullable();

            $table->foreignId('subido_por_id')->constrained('usuarios');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evidencias');
    }
};
