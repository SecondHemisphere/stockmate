<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'correo',
        'contrasena',
        'estado',
        'rol_id',
    ];

    protected $hidden = [
        'contrasena',
    ];

    // Relación: usuario pertenece a un rol
    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }

    // Nombre del rol
    public function getRolNombreAttribute()
    {
        return $this->rol ? $this->rol->nombre : 'Sin rol';
    }

    /**
     * Devuelve la contraseña para autenticación.
     */
    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    /**
     * Sobrescribe la verificación de la contraseña para soportar SHA256 y bcrypt.
     *
     * @param string $passwordPlain Texto plano ingresado por el usuario
     * @return bool
     */
    public function checkPassword($passwordPlain)
    {
        $storedHash = $this->contrasena;

        if (strlen($storedHash) === 64 && ctype_xdigit($storedHash)) {
            return hash('sha256', $passwordPlain) === $storedHash;
        }

        return Hash::check($passwordPlain, $storedHash);
    }

    /**
     * Obtener permisos del rol del usuario.
     *
     * @return \Illuminate\Support\Collection
     */
    public function permisos()
    {
        if ($this->rol) {
            return $this->rol->permisos; // Asumiendo relación en Rol con permisos()
        }
        return collect(); // Sin permisos si no tiene rol
    }

    /**
     * Verifica si el usuario tiene un permiso específico.
     *
     * @param string $permisoNombre
     * @return bool
     */
    public function hasPermission(string $permisoNombre): bool
    {
        return $this->permisos()->contains('nombre', $permisoNombre);
    }
}
