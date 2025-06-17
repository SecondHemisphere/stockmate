<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        // === Totales generales ===
        $totalCategorias        = DB::select('CALL sp_total_categorias()');
        $totalProductos         = DB::select('CALL sp_total_productos()');
        $totalProveedores       = DB::select('CALL sp_total_proveedores()');
        $totalClientes          = DB::select('CALL sp_total_clientes()');
        $totalUsuarios          = DB::select('CALL sp_total_usuarios()');

        // === Stock ===
        $stockTotal             = DB::select('CALL sp_stock_total()');
        $totalStockCritico      = DB::select('CALL sp_total_stock_critico()');
        $productosCriticos      = DB::select('CALL sp_productos_stock_critico()');

        // === Ventas y facturación ===
        $totalUnidadesVendidas  = DB::select('CALL sp_total_unidades_vendidas()');
        $totalFacturas          = DB::select('CALL sp_total_facturas()');
        $totalVentasHoy         = DB::select('CALL sp_total_ventas_hoy()');
        $montoVentasHoy         = DB::select('CALL sp_monto_total_ventas_hoy()');
        $topProductosVendidos   = DB::select('CALL sp_top_productos_vendidos()');

        // === Ganancias ===
        $gananciaTotal          = DB::select('CALL sp_total_ganancias()');
        $gananciaMesActual      = DB::select('CALL sp_ganancia_mes_actual()');

        return view('dashboard', [
            // Totales generales
            'categorias'          => $totalCategorias[0]->total_categorias ?? 0,
            'productos'           => $totalProductos[0]->total_productos ?? 0,
            'proveedores'         => $totalProveedores[0]->total_proveedores ?? 0,
            'clientes'            => $totalClientes[0]->total_clientes ?? 0,
            'usuarios'            => $totalUsuarios[0]->total_usuarios ?? 0,

            // Stock
            'stockTotal'          => $stockTotal[0]->total_stock ?? 0,
            'stockCritico'        => $totalStockCritico[0]->total_criticos ?? 0,
            'productosCriticos'   => $productosCriticos,

            // Ventas
            'unidadesVendidas'    => $totalUnidadesVendidas[0]->total_unidades ?? 0,
            'totalFacturas'       => $totalFacturas[0]->total_facturas ?? 0,
            'ventasHoy'           => $totalVentasHoy[0]->total_ventas_hoy ?? 0,
            'montoVentasHoy'      => $montoVentasHoy[0]->monto_ventas_hoy ?? 0,
            'topVendidos'         => $topProductosVendidos,

            // Ganancias
            'gananciaTotal'       => $gananciaTotal[0]->ganancia_total ?? 0,
            'gananciaMes'         => $gananciaMesActual[0]->ganancia_mes ?? 0,
        ]);
    }

    public function getCriticalStockProducts(Request $request)
    {
        $criticalStockProducts = DB::select('CALL get_critical_stock_products()');

        if ($request->ajax()) {
            return response()->json([
                'products' => view('partials.critical_stock_products', compact('criticalStockProducts'))->render(),
                'next_page_url' => null,
            ]);
        }

        return view('dashboard', compact('criticalStockProducts'));
    }
}
