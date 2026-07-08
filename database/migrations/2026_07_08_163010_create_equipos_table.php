<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();

            $table->string('tipo_equipo', 50);
            $table->string('codigo_patrimonial', 100)->unique()->nullable();
            $table->string('numero_serie', 150)->unique()->nullable();

            $table->string('marca', 100)->nullable();
            $table->string('modelo', 150)->nullable();

            $table->foreignId('oficina_id')->nullable()->constrained('oficinas');
            $table->foreignId('usuario_responsable_id')->nullable()->constrained('usuarios');

            $table->boolean('activo')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
