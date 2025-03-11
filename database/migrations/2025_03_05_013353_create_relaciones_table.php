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
        // Tabla pivote para administradores de universidades
        Schema::create('universidade_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('universidade_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('role')->default('admin');
            $table->timestamps();
            
            $table->unique(['universidade_id', 'user_id']);
        });
        
        // Tabla pivote para administradores de facultades
        Schema::create('facultade_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('facultade_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('role')->default('admin');
            $table->timestamps();
            
            $table->unique(['facultade_id', 'user_id']);
        });
        
        // Tabla pivote para administradores de carreras
        Schema::create('carrera_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrera_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('role')->default('admin');
            $table->timestamps();
            
            $table->unique(['carrera_id', 'user_id']);
        });
        
        // Tabla pivote para autores de documentos
        Schema::create('documento_autor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('documento_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('es_principal')->default(false);
            $table->string('role')->default('estudiante');
            $table->timestamps();
            
            $table->unique(['documento_id', 'user_id']);
        });
        
        // Tabla pivote para tutores de documentos
        Schema::create('documento_tutor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('documento_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('tipo', ['principal', 'co-tutor'])->default('principal');
            $table->string('role')->default('docente');
            $table->timestamps();
            
            $table->unique(['documento_id', 'user_id']);
        });
        
        // Tabla pivote para tribunales de documentos
        Schema::create('documento_tribunal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('documento_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('cargo', ['presidente', 'secretario', 'vocal'])->default('vocal');
            $table->string('role')->default('docente');
            $table->timestamps();
            
            $table->unique(['documento_id', 'user_id']);
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documento_tribunal');
        Schema::dropIfExists('documento_tutor');
        Schema::dropIfExists('documento_autor');
        Schema::dropIfExists('carrera_user');
        Schema::dropIfExists('facultade_user');
        Schema::dropIfExists('universidade_user');
        Schema::dropIfExists('role_user');
    }
};