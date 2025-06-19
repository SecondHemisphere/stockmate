<?php

namespace App\Http\Controllers;

use App\Exports\ExcelExporter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

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
}
