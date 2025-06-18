<?php

namespace App\Http\Controllers;

use App\Exports\ProductosStockCriticoExport;
use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

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
        return Excel::download(new ProductosStockCriticoExport, 'stock-critico.xlsx');
    }
}
