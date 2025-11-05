<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('entidades_procedencia')) {
            Schema::create('entidades_procedencia', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nombre', 200);
                $table->timestamp('fecha_creacion')->nullable();
                $table->unique('nombre');
                $table->index('nombre', 'idx_nombre');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('entidades_procedencia')) {
            Schema::drop('entidades_procedencia');
        }
    }
};