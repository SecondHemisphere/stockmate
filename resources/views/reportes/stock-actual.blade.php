<x-layouts.app>
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Reporte de Stock Actual de Productos</h2>
        <p class="text-sm text-gray-600">Visualización completa del inventario de productos activos.</p>
    </div>

    <div class="flex justify-between items-center mb-4">
        <!-- Botón PDF -->
        <a href="{{ route('reportes.stock-actual.pdf') }}"
            class="btn bg-red-600 hover:bg-red-500 text-white px-5 py-2 rounded-lg flex items-center gap-2">
            <i class="fas fa-file-pdf"></i> Descargar PDF
        </a>

        <!-- Botón Excel -->
        <a href="{{ route('reportes.stock-actual.excel') }}"
            class="btn bg-green-600 hover:bg-green-500 text-white px-5 py-2 rounded-lg flex items-center gap-2">
            <i class="fas fa-file-excel"></i> Descargar Excel
        </a>
    </div>

    <x-tabla-reporte :columnas="[
        ['campo' => 'id', 'titulo' => 'ID'],
        ['campo' => 'nombre', 'titulo' => 'Producto'],
        ['campo' => 'descripcion', 'titulo' => 'Descripción'],
        ['campo' => 'stock_actual', 'titulo' => 'Stock Actual'],
        ['campo' => 'stock_minimo', 'titulo' => 'Stock Mínimo'],
        ['campo' => 'precio_compra', 'titulo' => 'Precio Compra'],
        ['campo' => 'precio_venta', 'titulo' => 'Precio Venta'],
        ['campo' => 'categoria', 'titulo' => 'Categoría'],
        ['campo' => 'proveedor', 'titulo' => 'Proveedor'],
    ]" :filas="$productos" />
</x-layouts.app>
