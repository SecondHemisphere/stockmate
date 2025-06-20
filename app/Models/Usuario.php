<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
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

    // Relaciones
    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }

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

        // Si la longitud del hash es 64, asumimos que es SHA256 (hex)
        if (strlen($storedHash) === 64 && ctype_xdigit($storedHash)) {
            // Comparar SHA256 del password con el hash guardado
            return hash('sha256', $passwordPlain) === $storedHash;
        }

        // Si no, asumimos que es bcrypt, usamos la función estándar
        return Hash::check($passwordPlain, $storedHash);
    }
}
