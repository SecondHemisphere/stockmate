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
        'monto_descuento',
        'total_con_iva',
        'fecha',
        'metodo_pago',
        'observaciones',
    ];

    protected $casts = [
        'monto_total' => 'decimal:2',
        'monto_descuento' => 'decimal:2',
        'total_con_iva' => 'decimal:2',
        'fecha' => 'datetime',
        'metodo_pago' => 'string',
        'observaciones' => 'string',
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

    // Accesor para obtener el nombre del cliente fácilmente
    public function getClienteNombreAttribute()
    {
        return $this->cliente ? $this->cliente->nombre : 'Sin cliente';
    }

    // Accesor para obtener el nombre del método de pago en formato legible (opcional)
    public function getMetodoPagoNombreAttribute()
    {
        $metodos = [
            'EFECTIVO' => 'Efectivo',
            'TARJETA_CREDITO' => 'Tarjeta de Crédito',
            'TARJETA_DEBITO' => 'Tarjeta de Débito',
            'TRANSFERENCIA' => 'Transferencia',
            'OTRO' => 'Otro',
        ];

        return $metodos[$this->metodo_pago] ?? 'Desconocido';
    }

    public function getUsuarioNombreAttribute()
    {
        return $this->usuario ? $this->usuario->nombre : 'Sistema';
    }
}
