<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'categoria_id',
        'proveedor_id',
        'nombre',
        'descripcion',
        'precio_compra',
        'precio_venta',
        'stock_minimo',
        'ruta_imagen',
        'estado',
    ];

    protected $casts = [
        'precio_compra' => 'decimal:2',
        'precio_venta' => 'decimal:2',
        'stock_minimo' => 'integer',
        'estado' => 'string',
    ];

    // Relaciones
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
}
