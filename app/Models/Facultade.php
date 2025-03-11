<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Facultade extends Model
{
    use HasFactory, AsSource, Filterable, Attachable;
    
    protected $table = 'facultades';
    
    protected $fillable = [
        'nombre',
        'sigla',
        'descripcion',
        'universidade_id',
        'estado'
    ];
    
    /**
     * Relación con universidad
     */
    public function universidade()
    {
        return $this->belongsTo(Universidade::class);
    }
    
    /**
     * Relación con carreras
     */
    public function carreras()
    {
        return $this->hasMany(Carrera::class);
    }
    
    /**
     * Relación con administradores de la facultad
     */
    public function administradores()
    {
        return $this->belongsToMany(User::class, 'facultade_user')
            ->withPivot('role')
            ->wherePivot('role', 'admin');
    }
}