<x-layouts.app>
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Movimientos de Inventario</h2>
        <p class="text-sm text-gray-600">Entradas y salidas filtradas por usuario y fecha.</p>
    </div>

    <!-- Formulario de filtros -->
    <form method="GET" action="{{ route('reportes.movimientos-inventario') }}"
        class="mb-6 flex flex-wrap gap-4 items-end">
        <div>
            <label for="fecha_inicio" class="block text-gray-700 font-semibold mb-1">Fecha Inicio</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ request('fecha_inicio') }}"
                class="border border-gray-300 rounded px-3 py-2" />
        </div>
        <div>
            <label for="fecha_fin" class="block text-gray-700 font-semibold mb-1">Fecha Fin</label>
            <input type="date" name="fecha_fin" id="fecha_fin" value="{{ request('fecha_fin') }}"
                class="border border-gray-300 rounded px-3 py-2" {{ request('fecha_inicio') ? '' : 'disabled' }} />
        </div>
        <div>
            <label for="usuario_id" class="block text-gray-700 font-semibold mb-1">Usuario</label>
            <select name="usuario_id" id="usuario_id" class="border border-gray-300 rounded px-3 py-2">
                <option value="">-- Todos --</option>
                @foreach ($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" @selected(request('usuario_id') == $usuario->id)>
                        {{ $usuario->nombre }}
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

    @if (request('fecha_inicio'))
        <!-- Botones de descarga -->
        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('reportes.movimientos-inventario.pdf', request()->query()) }}"
                class="btn bg-red-600 hover:bg-red-500 text-white px-5 py-2 rounded-lg flex items-center gap-2">
                <i class="fas fa-file-pdf"></i> Descargar PDF
            </a>

            <a href="{{ route('reportes.movimientos-inventario.excel', request()->query()) }}"
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
    @else
        <div class="text-center text-gray-500 mt-10">
            <p>Seleccione al menos una <strong>fecha de inicio</strong> para visualizar el reporte.</p>
        </div>
    @endif

    <!-- Script para habilitar Fecha Fin -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fechaInicio = document.getElementById('fecha_inicio');
            const fechaFin = document.getElementById('fecha_fin');

            function toggleFechaFin() {
                if (fechaInicio.value) {
                    fechaFin.disabled = false;
                    fechaFin.min = fechaInicio.value;
                } else {
                    fechaFin.disabled = true;
                    fechaFin.value = '';
                    fechaFin.min = '';
                }
            }

            toggleFechaFin();
            fechaInicio.addEventListener('input', toggleFechaFin);
        });
    </script>
</x-layouts.app>
