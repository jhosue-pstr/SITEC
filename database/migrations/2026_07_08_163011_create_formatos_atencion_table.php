<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formatos_atencion', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tarea_id')->unique()->constrained('tareas');
            $table->foreignId('equipo_id')->nullable()->constrained('equipos');

            $table->string('nombres_solicitante', 100);
            $table->string('apellidos_solicitante', 100);
            $table->string('dni_solicitante', 15)->nullable();
            $table->string('telefono_movil', 20)->nullable();
            $table->string('regimen_laboral', 50)->nullable();
            $table->string('regimen_laboral_especificar', 150)->nullable();
            $table->string('cargo', 150)->nullable();
            $table->string('unidad_organizacion', 200)->nullable();

            $table->string('tipo_soporte_informatico', 50);
            $table->text('reporte_usuario');
            $table->text('diagnostico_tecnico')->nullable();
            $table->text('observaciones')->nullable();

            $table->date('fecha_atencion')->nullable();
            $table->time('hora_atencion')->nullable();
            $table->date('fecha_entrega')->nullable();
            $table->time('hora_entrega')->nullable();

            $table->foreignId('responsable_atencion_id')->constrained('usuarios');
            $table->string('nombre_responsable', 200)->nullable();
            $table->string('firma_responsable_url', 500)->nullable();
            $table->string('firma_solicitante_url', 500)->nullable();

            $table->string('estado_formato', 30)->default('pendiente_firma');
            $table->string('pdf_url', 500)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formatos_atencion');
    }
};
