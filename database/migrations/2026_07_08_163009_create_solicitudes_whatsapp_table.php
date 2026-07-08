<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitudes_whatsapp', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tarea_id')->nullable()->constrained('tareas');

            $table->string('numero_whatsapp', 30);
            $table->text('mensaje_original')->nullable();
            $table->string('estado_conversacion', 30)->default('recibido');
            $table->string('external_message_id', 150)->unique()->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitudes_whatsapp');
    }
};
