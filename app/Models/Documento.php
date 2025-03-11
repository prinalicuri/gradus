<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Documento extends Model
{
    use HasFactory, AsSource, Filterable, Attachable;
    
    protected $fillable = [
        'titulo',
        'resumen',
        'tipo', // tesis, trabajo de grado, proyecto, adscripción
        'fecha_publicacion',
        'archivo_url',
        'visibilidad', // publico, resumen, privado
        'carrera_id',
        'estado'
    ];
    
    /**
     * Relación con carrera
     */
    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }
    
    /**
     * Relación con autores (estudiantes)
     */
    public function autores()
    {
        return $this->belongsToMany(User::class, 'documento_autor')
            ->withPivot('es_principal')
            ->wherePivot('role', 'estudiante');
    }
    
    /**
     * Relación con tutores
     */
    public function tutores()
    {
        return $this->belongsToMany(User::class, 'documento_tutor')
            ->withPivot('tipo') // principal, co-tutor
            ->wherePivot('role', 'docente');
    }
    
    /**
     * Relación con tribunales
     */
    public function tribunales()
    {
        return $this->belongsToMany(User::class, 'documento_tribunal')
            ->withPivot('cargo') // presidente, secretario, vocal
            ->wherePivot('role', 'docente');
    }
    
    /**
     * Relación con evaluaciones
     */
    public function evaluaciones()
    {
        return $this->hasMany(Evaluacione::class);
    }
}