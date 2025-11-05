<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('coordinaciones')) {
            Schema::create('coordinaciones', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nombre', 200);
                $table->string('coordinador', 150)->nullable();
                $table->string('correo_coordinador', 150)->nullable();
                $table->string('asistente', 150)->nullable();
                $table->string('correo_asistente', 150)->nullable();
                $table->string('representante', 150)->nullable();
                $table->string('correo_representante', 150)->nullable();
                $table->timestamp('fecha_creacion')->nullable();
                $table->index('nombre', 'idx_coordinaciones_nombre');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('coordinaciones')) {
            Schema::drop('coordinaciones');
        }
    }
};