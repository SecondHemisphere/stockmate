<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    public function stock()
    {
        $productos = Producto::with('categoria')->get();

        $pdf = Pdf::loadView('reports.stock_pdf', compact('productos'));

        return $pdf->download('stock-report.pdf');
    }

    public function index()
    {
        return view('reportes.index');
    }
}

