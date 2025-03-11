<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Verificar si las columnas existen antes de añadirlas
            if (!Schema::hasColumn('users', 'apellido')) {
                $table->string('apellido')->nullable()->after('name');
            }
            
            if (!Schema::hasColumn('users', 'ci')) {
                $table->string('ci')->nullable()->after('apellido');
            }
            
            if (!Schema::hasColumn('users', 'telefono')) {
                $table->string('telefono')->nullable()->after('ci');
            }
            
            if (!Schema::hasColumn('users', 'tipo')) {
                $table->enum('tipo', ['estudiante', 'docente', 'administrativo'])->default('estudiante')->after('telefono');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Solo eliminar las columnas si existen
            if (Schema::hasColumn('users', 'apellido')) {
                $table->dropColumn('apellido');
            }
            
            if (Schema::hasColumn('users', 'ci')) {
                $table->dropColumn('ci');
            }
            
            if (Schema::hasColumn('users', 'telefono')) {
                $table->dropColumn('telefono');
            }
            
            if (Schema::hasColumn('users', 'tipo')) {
                $table->dropColumn('tipo');
            }
        });
    }
};

