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
        return view('dashboard');
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
