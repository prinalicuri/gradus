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
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('resumen');
            $table->enum('tipo', ['tesis', 'trabajo_grado', 'proyecto_grado', 'adscripcion']);
            $table->date('fecha_publicacion');
            $table->string('archivo_url')->nullable();
            $table->enum('visibilidad', ['publico', 'resumen', 'privado'])->default('resumen');
            $table->foreignId('carrera_id')->constrained('carreras')->onDelete('cascade');
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
