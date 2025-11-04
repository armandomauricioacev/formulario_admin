<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Restore 'activo' on coordinaciones if missing
        if (Schema::hasTable('coordinaciones') && !Schema::hasColumn('coordinaciones', 'activo')) {
            Schema::table('coordinaciones', function (Blueprint $table) {
                $table->boolean('activo')->default(true);
                $table->index('activo', 'idx_activo');
            });
        }

        // Restore 'activo' on servicios if missing
        if (Schema::hasTable('servicios') && !Schema::hasColumn('servicios', 'activo')) {
            Schema::table('servicios', function (Blueprint $table) {
                $table->boolean('activo')->default(true);
                $table->index('activo', 'idx_activo');
            });
        }

        // Restore 'activo' on entidades_procedencia if missing
        if (Schema::hasTable('entidades_procedencia') && !Schema::hasColumn('entidades_procedencia', 'activo')) {
            Schema::table('entidades_procedencia', function (Blueprint $table) {
                $table->boolean('activo')->default(true);
                $table->index('activo', 'idx_activo');
            });
        }
    }

    public function down(): void
    {
        // Drop 'activo' if present (rollback)
        if (Schema::hasTable('coordinaciones') && Schema::hasColumn('coordinaciones', 'activo')) {
            Schema::table('coordinaciones', function (Blueprint $table) {
                $table->dropIndex('idx_activo');
                $table->dropColumn('activo');
            });
        }
        if (Schema::hasTable('servicios') && Schema::hasColumn('servicios', 'activo')) {
            Schema::table('servicios', function (Blueprint $table) {
                $table->dropIndex('idx_activo');
                $table->dropColumn('activo');
            });
        }
        if (Schema::hasTable('entidades_procedencia') && Schema::hasColumn('entidades_procedencia', 'activo')) {
            Schema::table('entidades_procedencia', function (Blueprint $table) {
                $table->dropIndex('idx_activo');
                $table->dropColumn('activo');
            });
        }
    }
};