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
        Schema::create('facultades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('sigla')->nullable();
            $table->text('descripcion')->nullable();
            $table->foreignId('universidade_id')->constrained('universidades')->onDelete('cascade');
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facultades');
    }
};
