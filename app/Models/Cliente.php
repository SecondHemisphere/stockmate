<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'correo',
        'telefono',
        'direccion',
        'estado',
    ];

    protected $casts = [
        'estado' => 'string',
    ];
}
