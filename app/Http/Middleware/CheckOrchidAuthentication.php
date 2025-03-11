<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckOrchidAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('platform.login');
        }

        // Verificar si el usuario tiene permisos para acceder a Orchid
        $user = Auth::user();
        
        // Verificar permisos específicos para universidades
        if ($request->is('*/universidades*') && !$this->checkPermission($user, 'platform.universidades')) {
            abort(403, 'No tienes permisos para gestionar universidades.');
        }

        // Verificar permisos específicos para facultades
        if ($request->is('*/facultades*') && !$this->checkPermission($user, 'platform.facultades')) {
            abort(403, 'No tienes permisos para gestionar facultades.');
        }

        // Verificar permisos específicos para carreras
        if ($request->is('*/carreras*') && !$this->checkPermission($user, 'platform.carreras')) {
            abort(403, 'No tienes permisos para gestionar carreras.');
        }

        // Verificar permisos específicos para documentos
        if ($request->is('*/documentos*') && !$this->checkPermission($user, 'platform.documentos')) {
            abort(403, 'No tienes permisos para gestionar documentos.');
        }

        // Verificar permisos específicos para evaluaciones
        if ($request->is('*/evaluaciones*') && !$this->checkPermission($user, 'platform.evaluaciones')) {
            abort(403, 'No tienes permisos para gestionar evaluaciones.');
        }

        return $next($request);
    }
    
    /**
     * Verifica si el usuario tiene un permiso específico
     * 
     * @param \App\Models\User $user
     * @param string $permission
     * @return bool
     */
    private function checkPermission($user, $permission): bool
    {
        // Verificar si el usuario es administrador (tiene todos los permisos)
        if ($user->hasRole('admin')) {
            return true;
        }
        
        // Verificar el permiso específico en los roles del usuario
        foreach ($user->roles as $role) {
            if (isset($role->permissions[$permission]) && $role->permissions[$permission]) {
                return true;
            }
        }
        
        // Verificar el permiso específico en los permisos directos del usuario
        if (isset($user->permissions[$permission]) && $user->permissions[$permission]) {
            return true;
        }
        
        return false;
    }
}
