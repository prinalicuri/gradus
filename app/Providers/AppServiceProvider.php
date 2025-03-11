<?php

namespace App\Providers;

use App\Models\Carrera;
use App\Models\Facultade;
use App\Models\Universidade;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Scope para universidades activas
        Universidade::macro('scopeActivas', function (Builder $query) {
            return $query->where('estado', 'activo');
        });
        
        // Scope para facultades activas
        Facultade::macro('scopeActivas', function (Builder $query) {
            return $query->where('estado', 'activo');
        });
        
        // Scope para carreras activas
        Carrera::macro('scopeActivas', function (Builder $query) {
            return $query->where('estado', 'activo');
        });
    }
}

