<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductosStockCriticoExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DB::table('vw_productos_stock_minimo')->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'Producto',
            'Descripción',
            'Stock Actual',
            'Stock Mínimo',
            'Categoría',
            'Proveedor',
        ];
    }
}
