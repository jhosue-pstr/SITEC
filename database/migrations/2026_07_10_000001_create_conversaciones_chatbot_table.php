<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversaciones_chatbot', function (Blueprint $table) {
            $table->id();
            $table->string('numero_whatsapp', 20)->unique();
            $table->string('estado', 50)->default('inicio');
            $table->json('datos_temp')->nullable();
            $table->foreignId('tarea_id')->nullable()->constrained('tareas');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversaciones_chatbot');
    }
};
