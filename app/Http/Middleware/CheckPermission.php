<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request)  $next
     * @param  string  $permisos  Permisos separados por "|"
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $permisos): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->back()->with('swal', [
                'icon' => 'error',
                'title' => 'Acceso denegado',
                'text' => 'Debe iniciar sesión para acceder a esta página.',
                'confirmButtonColor' => '#3085d6',
            ]);
        }

        $permisosRequeridos = explode('|', $permisos);
        $permStr = implode(', ', $permisosRequeridos);

        foreach ($permisosRequeridos as $permiso) {
            if ($user->hasPermission(trim($permiso))) {
                return $next($request);
            }
        }

        $text = "El usuario <strong>\"{$user->nombre}\"</strong> no tiene los permisos necesarios para acceder a esta sección.<br><br><strong>Permisos requeridos:</strong><br>- " . implode("<br>- ", $permisosRequeridos);

        return redirect()->back()->with('swal', [
            'icon' => 'error',
            'title' => 'Acceso denegado',
            'html' => $text,
            'confirmButtonColor' => '#3085d6',
        ]);
    }
}
