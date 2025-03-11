<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Orchid\Platform\Models\User as OrchidUser;

class User extends OrchidUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'apellido',
        'ci',
        'telefono',
        'tipo', // estudiante, docente, administrativo
        'permissions',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'permissions' => 'array',
    ];
    
    /**
     * Relación con universidades administradas
     */
    public function universidadesAdministradas()
    {
        return $this->belongsToMany(Universidade::class, 'universidad_user')
            ->withPivot('role');
    }
    
    /**
     * Relación con facultades administradas
     */
    public function facultadesAdministradas()
    {
        return $this->belongsToMany(Facultade::class, 'facultad_user')
            ->withPivot('role');
    }
    
    /**
     * Relación con carreras administradas
     */
    public function carrerasAdministradas()
    {
        return $this->belongsToMany(Carrera::class, 'carrera_user')
            ->withPivot('role');
    }
    
    /**
     * Relación con documentos como autor
     */
    public function documentosComoAutor()
    {
        return $this->belongsToMany(Documento::class, 'documento_autor')
            ->withPivot('es_principal');
    }
    
    /**
     * Relación con documentos como tutor
     */
    public function documentosComoTutor()
    {
        return $this->belongsToMany(Documento::class, 'documento_tutor')
            ->withPivot('tipo');
    }
    
    /**
     * Relación con documentos como tribunal
     */
    public function documentosComoTribunal()
    {
        return $this->belongsToMany(Documento::class, 'documento_tribunal')
            ->withPivot('cargo');
    }
    
    /**
     * Relación con evaluaciones realizadas
     */
    public function evaluacionesRealizadas()
    {
        return $this->hasMany(Evaluacione::class);
    }
}
