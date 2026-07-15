<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('formatos_atencion', function (Blueprint $table) {
            $table->string('tipo_equipo', 100)->nullable()->after('equipo_id');
            $table->string('codigo_patrimonial', 100)->nullable()->after('tipo_equipo');
            $table->string('numero_serie', 100)->nullable()->after('codigo_patrimonial');
            $table->string('marca', 100)->nullable()->after('numero_serie');
            $table->string('modelo', 100)->nullable()->after('marca');
        });
    }

    public function down(): void
    {
        Schema::table('formatos_atencion', function (Blueprint $table) {
            $table->dropColumn([
                'tipo_equipo',
                'codigo_patrimonial',
                'numero_serie',
                'marca',
                'modelo',
            ]);
        });
    }
};
