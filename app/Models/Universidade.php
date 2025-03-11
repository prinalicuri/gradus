<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Universidade extends Model
{
    use HasFactory, AsSource, Filterable, Attachable;
    
    protected $table = 'universidades';
    
    protected $fillable = [
        'nombre',
        'sigla',
        'direccion',
        'telefono',
        'email',
        'sitio_web',
        'logo',
        'estado'
    ];
    
    /**
     * Relación con facultades
     */
    public function facultades()
    {
        return $this->hasMany(Facultade::class);
    }
    
    /**
     * Relación con usuarios administradores de la universidad
     */
    public function administradores()
    {
        return $this->belongsToMany(User::class, 'universidade_user')
            ->withPivot('role')
            ->wherePivot('role', 'admin');
    }
}

