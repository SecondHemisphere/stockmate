<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'cliente_id',
        'usuario_id',
        'numero_factura',
        'monto_total',
        'fecha',
        'monto_descuento',
        'total_con_iva',
        'estado_pago',
    ];

    protected $casts = [
        'monto_total' => 'decimal:2',
        'monto_descuento' => 'decimal:2',
        'total_con_iva' => 'decimal:2',
        'fecha' => 'datetime',
    ];

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    // Relación con Usuario (vendedor o quien realizó la venta)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // Relación con detalles_venta
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'venta_id');
    }

    public function getClienteNombreAttribute()
    {
        return $this->cliente ? $this->cliente->nombre : 'Sin cliente';
    }
}
