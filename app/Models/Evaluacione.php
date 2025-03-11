<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Evaluacione extends Model
{
    use HasFactory, AsSource, Filterable, Attachable;
    
    protected $table = 'evaluaciones';
    
    protected $fillable = [
        'puntuacion',
        'comentario',
        'documento_id',
        'user_id',
        'fecha_evaluacion'
    ];
    
    /**
     * Relación con documento
     */
    public function documento()
    {
        return $this->belongsTo(Documento::class);
    }
    
    /**
     * Relación con evaluador (docente)
     */
    public function evaluador()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

