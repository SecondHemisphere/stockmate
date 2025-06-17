<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'producto_id',
        'monto_total',
        'cantidad',
        'fecha_transaccion',
    ];

    protected $casts = [
        'monto_total' => 'decimal:2',
        'cantidad' => 'integer',
        'fecha_transaccion' => 'datetime',
    ];

    // Relación con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function getProductoNombreAttribute()
    {
        return $this->producto ? $this->producto->nombre : 'Sin producto';
    }
}
