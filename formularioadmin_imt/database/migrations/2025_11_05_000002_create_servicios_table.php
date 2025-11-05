<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('servicios')) {
            Schema::create('servicios', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nombre', 200);
                $table->unsignedInteger('coordinacion_predeterminada_id')->nullable();
                $table->text('descripcion')->nullable();
                $table->timestamp('fecha_creacion')->nullable();
                $table->index('nombre', 'idx_servicios_nombre');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('servicios')) {
            Schema::drop('servicios');
        }
    }
};