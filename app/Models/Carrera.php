<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Carrera extends Model
{
    use HasFactory, AsSource, Filterable, Attachable;
    
    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'facultade_id',
        'estado'
    ];
    
    /**
     * Relación con facultad
     */
    public function facultade()
    {
        return $this->belongsTo(Facultade::class);
    }
    
    /**
     * Relación con documentos
     */
    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }
    
    /**
     * Relación con administradores de la carrera
     */
    public function administradores()
    {
        return $this->belongsToMany(User::class, 'carrera_user')
            ->withPivot('role')
            ->wherePivot('role', 'admin');
    }
}