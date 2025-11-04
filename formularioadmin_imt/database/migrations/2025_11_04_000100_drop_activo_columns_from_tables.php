<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('coordinaciones') && Schema::hasColumn('coordinaciones', 'activo')) {
            Schema::table('coordinaciones', function (Blueprint $table) {
                $table->dropColumn('activo');
            });
        }
        if (Schema::hasTable('servicios') && Schema::hasColumn('servicios', 'activo')) {
            Schema::table('servicios', function (Blueprint $table) {
                $table->dropColumn('activo');
            });
        }
        if (Schema::hasTable('entidades_procedencia') && Schema::hasColumn('entidades_procedencia', 'activo')) {
            Schema::table('entidades_procedencia', function (Blueprint $table) {
                $table->dropColumn('activo');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('coordinaciones') && !Schema::hasColumn('coordinaciones', 'activo')) {
            Schema::table('coordinaciones', function (Blueprint $table) {
                $table->boolean('activo')->default(true);
            });
        }
        if (Schema::hasTable('servicios') && !Schema::hasColumn('servicios', 'activo')) {
            Schema::table('servicios', function (Blueprint $table) {
                $table->boolean('activo')->default(true);
            });
        }
        if (Schema::hasTable('entidades_procedencia') && !Schema::hasColumn('entidades_procedencia', 'activo')) {
            Schema::table('entidades_procedencia', function (Blueprint $table) {
                $table->boolean('activo')->default(true);
            });
        }
    }
};
