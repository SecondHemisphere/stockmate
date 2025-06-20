<?php

namespace App\Http\Controllers;

use App\Exports\ExcelExporter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index()
    {
        return view('reportes.index');
    }

    public function productosStockCritico()
    {
        $productos = DB::table('vw_productos_stock_minimo')->get();

        return view('reportes.stock-critico', compact('productos'));
    }

    public function productosStockCriticoPdf()
    {
        $productos = DB::table('vw_productos_stock_minimo')->get();
        $pdf = Pdf::loadView('reportes.stock-critico-pdf', compact('productos'));
        return $pdf->download('stock-critico.pdf');
    }

    public function productosStockCriticoExcel()
    {
        $productos = DB::table('vw_productos_stock_minimo')->get();

        $headers = [
            'index' => 'ID',
            'nombre' => 'Producto',
            'descripcion' => 'Descripción',
            'stock_actual' => 'Stock Actual',
            'stock_minimo' => 'Stock Mínimo',
            'categoria' => 'Categoría',
            'proveedor' => 'Proveedor',
        ];

        $data = $productos->map(function ($item, $key) {
            return [
                'index' => $key + 1,
                'nombre' => $item->nombre,
                'descripcion' => $item->descripcion,
                'stock_actual' => $item->stock_actual,
                'stock_minimo' => $item->stock_minimo,
                'categoria' => $item->categoria,
                'proveedor' => $item->proveedor,
            ];
        })->toArray();

        return (new ExcelExporter($data, $headers, 'stock_critico.xlsx'))->export();
    }

    public function topProductos()
    {
        $productos = DB::table('vw_productos_mas_vendidos')->get();

        return view('reportes.top-productos', compact('productos'));
    }

    public function topProductosPdf()
    {
        $productos = DB::table('vw_productos_mas_vendidos')->get();

        $pdf = Pdf::loadView('reportes.top-productos-pdf', compact('productos'));

        return $pdf->download('top-productos.pdf');
    }

    public function topProductosExcel()
    {
        $productos = DB::table('vw_productos_mas_vendidos')->get();

        $headers = [
            'index' => 'Posición',
            'nombre' => 'Producto',
            'total_vendido' => 'Unidades Vendidas',
        ];

        $data = $productos->map(function ($item, $key) {
            return [
                'index' => ($key + 1) . 'º',
                'nombre' => $item->nombre,
                'total_vendido' => $item->total_vendido,
            ];
        })->toArray();

        return (new ExcelExporter($data, $headers, 'top-productos.xlsx'))->export();
    }

    public function clientesFrecuentes()
    {
        $clientes = DB::table('vw_clientes_frecuentes')->get();
        return view('reportes.clientes-frecuentes', compact('clientes'));
    }

    public function clientesFrecuentesPdf()
    {
        $clientes = DB::table('vw_clientes_frecuentes')->get();
        $pdf = Pdf::loadView('reportes.clientes-frecuentes-pdf', compact('clientes'));
        return $pdf->download('clientes-frecuentes.pdf');
    }

    public function clientesFrecuentesExcel()
    {
        $clientes = DB::table('vw_clientes_frecuentes')->get();

        $headers = [
            'index' => 'Posición',
            'nombre' => 'Cliente',
            'numero_compras' => 'Número de Compras',
            'total_compras' => 'Total Comprado',
        ];

        $data = $clientes->map(function ($item, $key) {
            return [
                'index' => ($key + 1) . 'º',
                'nombre' => $item->nombre,
                'numero_compras' => $item->numero_compras,
                'total_compras' => number_format($item->total_compras, 2),
            ];
        })->toArray();

        return (new ExcelExporter($data, $headers, 'clientes-frecuentes.xlsx'))->export();
    }

    public function stockActual()
    {
        $productos = DB::table('vw_stock_actual_productos')->get();
        return view('reportes.stock-actual', compact('productos'));
    }

    public function stockActualPdf()
    {
        $productos = DB::table('vw_stock_actual_productos')->get();
        $pdf = Pdf::loadView('reportes.stock-actual-pdf', compact('productos'));
        return $pdf->download('stock-actual.pdf');
    }

    public function stockActualExcel()
    {
        $productos = DB::table('vw_stock_actual_productos')->get();

        $headers = [
            'index' => 'ID',
            'nombre' => 'Producto',
            'descripcion' => 'Descripción',
            'stock_actual' => 'Stock Actual',
            'stock_minimo' => 'Stock Mínimo',
            'precio_compra' => 'Precio Compra',
            'precio_venta' => 'Precio Venta',
            'categoria' => 'Categoría',
            'proveedor' => 'Proveedor',
        ];

        $data = $productos->map(function ($item, $key) {
            return [
                'index' => $key + 1,
                'nombre' => $item->nombre,
                'descripcion' => $item->descripcion,
                'stock_actual' => $item->stock_actual,
                'stock_minimo' => $item->stock_minimo,
                'precio_compra' => number_format($item->precio_compra, 2),
                'precio_venta' => number_format($item->precio_venta, 2),
                'categoria' => $item->categoria,
                'proveedor' => $item->proveedor,
            ];
        })->toArray();

        return (new ExcelExporter($data, $headers, 'stock-actual.xlsx'))->export();
    }

    public function proveedoresActivos()
    {
        $proveedores = DB::table('vw_proveedores_activos')->get();
        return view('reportes.proveedores-activos', compact('proveedores'));
    }

    public function proveedoresActivosPdf()
    {
        $proveedores = DB::table('vw_proveedores_activos')->get();
        $pdf = Pdf::loadView('reportes.proveedores-activos-pdf', compact('proveedores'));
        return $pdf->download('proveedores-activos.pdf');
    }

    public function proveedoresActivosExcel()
    {
        $proveedores = DB::table('vw_proveedores_activos')->get();

        $headers = [
            'index' => 'ID',
            'nombre' => 'Nombre',
            'correo' => 'Correo',
            'telefono' => 'Teléfono',
            'direccion' => 'Dirección',
            'estado' => 'Estado',
        ];

        $data = $proveedores->map(function ($item, $key) {
            return [
                'index' => $key + 1,
                'nombre' => $item->nombre,
                'correo' => $item->correo,
                'telefono' => $item->telefono,
                'direccion' => $item->direccion,
                'estado' => ucfirst(strtolower($item->estado)),
            ];
        })->toArray();

        return (new ExcelExporter($data, $headers, 'proveedores-activos.xlsx'))->export();
    }

    public function comprasFiltradas(Request $request)
    {
        $query = DB::table('vw_compras_por_fecha');

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha_transaccion', [$request->fecha_inicio, $request->fecha_fin]);
        }

        if ($request->filled('proveedor_id')) {
            $query->where('proveedor_id', $request->proveedor_id);
        }

        $compras = $query->get();

        $proveedores = DB::table('proveedores')->where('estado', 'ACTIVO')->get();

        return view('reportes.compras-filtradas', compact('compras', 'proveedores'));
    }

    public function comprasFiltradasPdf(Request $request)
    {
        $query = DB::table('vw_compras_por_fecha');

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha_transaccion', [$request->fecha_inicio, $request->fecha_fin]);
        }

        if ($request->filled('proveedor_id')) {
            $query->where('proveedor_id', $request->proveedor_id);
        }

        $compras = $query->get();

        $pdf = Pdf::loadView('reportes.compras-filtradas-pdf', compact('compras'));

        return $pdf->download('compras.pdf');
    }

    public function comprasFiltradasExcel(Request $request)
    {
        $query = DB::table('vw_compras_por_fecha');

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha_transaccion', [$request->fecha_inicio, $request->fecha_fin]);
        }

        if ($request->filled('proveedor_id')) {
            $query->where('proveedor_id', $request->proveedor_id);
        }

        $compras = $query->get();

        $headers = [
            'fecha_transaccion' => 'Fecha',
            'proveedor_nombre' => 'Proveedor',
            'producto' => 'Producto',
            'cantidad' => 'Cantidad',
            'monto_total' => 'Monto Total',
        ];

        $data = $compras->map(function ($item, $key) {
            return [
                'fecha_transaccion' => \Carbon\Carbon::parse($item->fecha_transaccion)->format('d/m/Y H:i'),
                'proveedor_nombre' => $item->proveedor_nombre,
                'producto' => $item->producto,
                'cantidad' => $item->cantidad,
                'monto_total' => number_format($item->monto_total, 2),
            ];
        })->toArray();

        return (new ExcelExporter($data, $headers, 'compras.xlsx'))->export();
    }

    public function ventasFiltradas(Request $request)
    {
        $query = DB::table('vw_ventas_por_fecha');

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
        } elseif ($request->filled('fecha_inicio')) {
            $query->where('fecha', '>=', $request->fecha_inicio);
        } elseif ($request->filled('fecha_fin')) {
            $query->where('fecha', '<=', $request->fecha_fin);
        }

        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }

        if ($request->filled('usuario_id')) {
            $query->where('usuario_id', $request->usuario_id);
        }

        $ventas = $query->orderBy('fecha', 'desc')->get();

        $clientes = DB::table('clientes')->where('estado', 'ACTIVO')->get();
        $usuarios = DB::table('usuarios')->where('estado', 'ACTIVO')->get();

        return view('reportes.ventas-filtradas', compact('ventas', 'clientes', 'usuarios'));
    }

    public function ventasFiltradasPdf(Request $request)
    {
        $query = DB::table('vw_ventas_por_fecha');

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
        } elseif ($request->filled('fecha_inicio')) {
            $query->where('fecha', '>=', $request->fecha_inicio);
        } elseif ($request->filled('fecha_fin')) {
            $query->where('fecha', '<=', $request->fecha_fin);
        }

        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }

        if ($request->filled('usuario_id')) {
            $query->where('usuario_id', $request->usuario_id);
        }

        $ventas = $query->orderBy('fecha', 'desc')->get();

        $pdf = Pdf::loadView('reportes.ventas-filtradas-pdf', compact('ventas'));

        return $pdf->download('ventas.pdf');
    }

    public function ventasFiltradasExcel(Request $request)
    {
        $query = DB::table('vw_ventas_por_fecha');

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
        } elseif ($request->filled('fecha_inicio')) {
            $query->where('fecha', '>=', $request->fecha_inicio);
        } elseif ($request->filled('fecha_fin')) {
            $query->where('fecha', '<=', $request->fecha_fin);
        }

        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }

        if ($request->filled('usuario_id')) {
            $query->where('usuario_id', $request->usuario_id);
        }

        $ventas = $query->orderBy('fecha', 'desc')->get();

        $headers = [
            'fecha' => 'Fecha',
            'numero_factura' => 'Número Factura',
            'cliente_nombre' => 'Cliente',
            'usuario_nombre' => 'Usuario',
            'monto_total' => 'Monto Total',
            'monto_descuento' => 'Descuento',
            'total_con_iva' => 'Total con IVA',
            'metodo_pago' => 'Método de Pago',
            'observaciones' => 'Observaciones',
        ];

        $data = $ventas->map(function ($item, $key) {
            return [
                'fecha' => \Carbon\Carbon::parse($item->fecha)->format('d/m/Y H:i'),
                'numero_factura' => $item->numero_factura,
                'cliente_nombre' => $item->cliente_nombre,
                'usuario_nombre' => $item->usuario_nombre,
                'monto_total' => number_format($item->monto_total, 2),
                'monto_descuento' => number_format($item->monto_descuento, 2),
                'total_con_iva' => number_format($item->total_con_iva, 2),
                'metodo_pago' => $item->metodo_pago,
                'observaciones' => $item->observaciones,
            ];
        })->toArray();

        return (new ExcelExporter($data, $headers, 'ventas.xlsx'))->export();
    }

    public function historialProducto(Request $request)
    {
        $productos = DB::table('productos')->select('id', 'nombre')->get();

        $query = DB::table('vw_historial_producto')
            ->orderBy('producto_id')
            ->orderBy('fecha');

        if ($request->filled('producto_id')) {
            $query->where('producto_id', $request->producto_id);
        }

        $movimientos = $query->get()->map(function ($item) {
            $item->fecha_formateada = \Carbon\Carbon::parse($item->fecha)->format('d/m/Y H:i');
            $item->precio_unitario_formateado = '$' . number_format($item->precio_unitario, 2, '.', ',');
            $item->precio_total_formateado = '$' . number_format($item->precio_total, 2, '.', ',');
            return $item;
        });

        return view('reportes.historial-producto', compact('movimientos', 'productos'));
    }

    public function historialProductoPdf(Request $request)
    {
        $query = DB::table('vw_historial_producto')
            ->orderBy('producto_id')
            ->orderBy('fecha');

        if ($request->filled('producto_id')) {
            $query->where('producto_id', $request->producto_id);
        }

        $movimientos = $query->get();

        $pdf = Pdf::loadView('reportes.historial-producto-pdf', compact('movimientos'));

        return $pdf->download('historial-producto.pdf');
    }

    public function historialProductoExcel(Request $request)
    {
        $query = DB::table('vw_historial_producto')
            ->orderBy('producto_id')
            ->orderBy('fecha');

        if ($request->filled('producto_id')) {
            $query->where('producto_id', $request->producto_id);
        }

        $movimientos = $query->get();

        $headers = [
            'fecha' => 'Fecha',
            'producto_nombre' => 'Producto',
            'tipo_movimiento' => 'Tipo',
            'cantidad' => 'Cantidad',
            'precio_unitario' => 'Precio Unitario',
            'precio_total' => 'Precio Total',
            'relacionado' => 'Proveedor/Cliente',
            'usuario_nombre' => 'Usuario',
        ];

        $data = $movimientos->map(function ($item, $key) {
            return [
                'index' => $key + 1,
                'producto_nombre' => $item->producto_nombre,
                'tipo_movimiento' => $item->tipo_movimiento,
                'fecha' => \Carbon\Carbon::parse($item->fecha)->format('d/m/Y H:i'),
                'cantidad' => $item->cantidad,
                'precio_unitario' => number_format($item->precio_unitario, 2),
                'precio_total' => number_format($item->precio_total, 2),
                'relacionado' => $item->relacionado,
                'usuario_nombre' => $item->usuario_nombre,
            ];
        })->toArray();

        return (new ExcelExporter($data, $headers, 'historial-producto.xlsx'))->export();
    }
}
