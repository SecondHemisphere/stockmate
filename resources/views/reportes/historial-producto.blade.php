<x-layouts.app>
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Historial de Producto</h2>
        <p class="text-sm text-gray-600">Movimientos de compras y ventas por producto.</p>
    </div>

    <!-- Formulario de filtros -->
    <form method="GET" action="{{ route('reportes.historial-producto') }}" class="mb-6 flex flex-wrap gap-4 items-end">
        <div>
            <label for="producto_id" class="block text-gray-700 font-semibold mb-1">Producto</label>
            <select name="producto_id" id="producto_id" class="border border-gray-300 rounded px-3 py-2">
                <option value="" disabled selected>Seleccione un producto</option>
                @foreach ($productos as $producto)
                    <option value="{{ $producto->id }}" @selected(request('producto_id') == $producto->id)>
                        {{ $producto->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <button type="submit" class="btn bg-teal-500 hover:bg-teal-800 text-white px-6 py-2 rounded">
                Filtrar
            </button>
        </div>
    </form>

    @if (request('producto_id'))
        <!-- Botones de descarga -->
        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('reportes.historial-producto.pdf', request()->query()) }}"
                class="btn bg-red-600 hover:bg-red-500 text-white px-5 py-2 rounded-lg flex items-center gap-2">
                <i class="fas fa-file-pdf"></i> Descargar PDF
            </a>

            <a href="{{ route('reportes.historial-producto.excel', request()->query()) }}"
                class="btn bg-green-600 hover:bg-green-500 text-white px-5 py-2 rounded-lg flex items-center gap-2">
                <i class="fas fa-file-excel"></i> Descargar Excel
            </a>
        </div>

        <!-- Tabla de resultados -->
        <x-tabla-reporte :columnas="[
            ['campo' => 'fecha', 'titulo' => 'Fecha'],
            ['campo' => 'producto_nombre', 'titulo' => 'Producto'],
            ['campo' => 'tipo_movimiento', 'titulo' => 'Tipo'],
            ['campo' => 'cantidad', 'titulo' => 'Cantidad'],
            ['campo' => 'precio_unitario', 'titulo' => 'P. Unitario'],
            ['campo' => 'precio_total', 'titulo' => 'Total'],
            ['campo' => 'relacionado', 'titulo' => 'Proveedor/Cliente'],
            ['campo' => 'usuario_nombre', 'titulo' => 'Usuario'],
        ]" :filas="$movimientos" :formatear="[
            'fecha' => fn($v) => \Carbon\Carbon::parse($v)->format('d/m/Y H:i'),
            'precio_unitario' => fn($v) => '$' . number_format($v, 2, '.', ','),
            'precio_total' => fn($v) => '$' . number_format($v, 2, '.', ','),
        ]" />
    @endif
</x-layouts.app>
