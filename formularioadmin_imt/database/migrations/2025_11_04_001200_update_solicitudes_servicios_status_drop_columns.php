<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1) Actualizar 'pendiente' a 'en_revision'
        DB::statement("UPDATE solicitudes_servicios SET estatus = 'en_revision', fecha_actualizacion = CURRENT_TIMESTAMP WHERE estatus = 'pendiente'");

        // 2) Eliminar columnas usuario_actualizacion y notas_internas si existen
        if (Schema::hasTable('solicitudes_servicios')) {
            Schema::table('solicitudes_servicios', function (Blueprint $table) {
                if (Schema::hasColumn('solicitudes_servicios', 'usuario_actualizacion')) {
                    $table->dropColumn('usuario_actualizacion');
                }
                if (Schema::hasColumn('solicitudes_servicios', 'notas_internas')) {
                    $table->dropColumn('notas_internas');
                }
            });
        }

        // 3) Modificar ENUM para permitir solo 'en_revision' y 'revisado'
        DB::statement("ALTER TABLE solicitudes_servicios MODIFY COLUMN estatus ENUM('en_revision','revisado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en_revision'");
    }

    public function down(): void
    {
        // Restaurar ENUM original con estados previos
        DB::statement("ALTER TABLE solicitudes_servicios MODIFY COLUMN estatus ENUM('pendiente','en_revision','aprobada','rechazada','completada') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente'");

        // Reagregar columnas eliminadas (solo si no existen)
        if (Schema::hasTable('solicitudes_servicios')) {
            Schema::table('solicitudes_servicios', function (Blueprint $table) {
                if (!Schema::hasColumn('solicitudes_servicios', 'usuario_actualizacion')) {
                    $table->string('usuario_actualizacion', 100)->nullable();
                }
                if (!Schema::hasColumn('solicitudes_servicios', 'notas_internas')) {
                    $table->text('notas_internas')->nullable();
                }
            });
        }
    }
};