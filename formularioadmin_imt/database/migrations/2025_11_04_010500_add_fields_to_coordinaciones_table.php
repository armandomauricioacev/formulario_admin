<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('coordinaciones')) {
            Schema::table('coordinaciones', function (Blueprint $table) {
                if (!Schema::hasColumn('coordinaciones', 'coordinador')) {
                    $table->string('coordinador', 150)->nullable()->after('nombre');
                }
                if (!Schema::hasColumn('coordinaciones', 'correo_coordinador')) {
                    $table->string('correo_coordinador', 150)->nullable()->after('coordinador');
                }
                if (!Schema::hasColumn('coordinaciones', 'asistente')) {
                    $table->string('asistente', 150)->nullable()->after('correo_coordinador');
                }
                if (!Schema::hasColumn('coordinaciones', 'correo_asistente')) {
                    $table->string('correo_asistente', 150)->nullable()->after('asistente');
                }
                if (!Schema::hasColumn('coordinaciones', 'representante')) {
                    $table->string('representante', 150)->nullable()->after('correo_asistente');
                }
                if (!Schema::hasColumn('coordinaciones', 'correo_representante')) {
                    $table->string('correo_representante', 150)->nullable()->after('representante');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('coordinaciones')) {
            Schema::table('coordinaciones', function (Blueprint $table) {
                if (Schema::hasColumn('coordinaciones', 'correo_representante')) {
                    $table->dropColumn('correo_representante');
                }
                if (Schema::hasColumn('coordinaciones', 'representante')) {
                    $table->dropColumn('representante');
                }
                if (Schema::hasColumn('coordinaciones', 'correo_asistente')) {
                    $table->dropColumn('correo_asistente');
                }
                if (Schema::hasColumn('coordinaciones', 'asistente')) {
                    $table->dropColumn('asistente');
                }
                if (Schema::hasColumn('coordinaciones', 'correo_coordinador')) {
                    $table->dropColumn('correo_coordinador');
                }
                if (Schema::hasColumn('coordinaciones', 'coordinador')) {
                    $table->dropColumn('coordinador');
                }
            });
        }
    }
};