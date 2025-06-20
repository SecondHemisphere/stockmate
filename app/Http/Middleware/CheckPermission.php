<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $permisos  Permisos separados por "|"
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $permisos): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(403, 'No autorizado');
        }

        $permisosRequeridos = explode('|', $permisos);

        foreach ($permisosRequeridos as $permiso) {
            if ($user->hasPermission(trim($permiso))) {
                return $next($request);
            }
        }

        abort(403, 'No autorizado');
    }
}
