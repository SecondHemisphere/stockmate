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
            'index' => '#',
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
}
