<x-layouts.app>
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Reporte de Compras Filtradas</h2>
        <p class="text-sm text-gray-600">Control de compras según proveedor y rango de fechas.</p>
    </div>

    <!-- Formulario filtros -->
    <form method="GET" action="{{ route('reportes.compras-filtradas') }}" class="mb-6 flex flex-wrap gap-4 items-end">
        <div>
            <label for="fecha_inicio" class="block text-gray-700 font-semibold mb-1">Fecha Inicio</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ request('fecha_inicio') }}"
                class="border border-gray-300 rounded px-3 py-2" />
        </div>
        <div>
            <label for="fecha_fin" class="block text-gray-700 font-semibold mb-1">Fecha Fin</label>
            <input type="date" name="fecha_fin" id="fecha_fin" value="{{ request('fecha_fin') }}"
                class="border border-gray-300 rounded px-3 py-2" disabled />
        </div>
        <div>
            <label for="proveedor_id" class="block text-gray-700 font-semibold mb-1">Proveedor</label>
            <select name="proveedor_id" id="proveedor_id" class="border border-gray-300 rounded px-3 py-2">
                <option value="">-- Todos --</option>
                @foreach ($proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}" @if (request('proveedor_id') == $proveedor->id) selected @endif>
                        {{ $proveedor->nombre }}
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

    <!-- Botones descarga -->
    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('reportes.compras-filtradas.pdf', request()->query()) }}"
            class="btn bg-red-600 hover:bg-red-500 text-white px-5 py-2 rounded-lg flex items-center gap-2">
            <i class="fas fa-file-pdf"></i> Descargar PDF
        </a>

        <a href="{{ route('reportes.compras-filtradas.excel', request()->query()) }}"
            class="btn bg-green-600 hover:bg-green-500 text-white px-5 py-2 rounded-lg flex items-center gap-2">
            <i class="fas fa-file-excel"></i> Descargar Excel
        </a>
    </div>

    <x-tabla-reporte :columnas="[
        ['campo' => 'fecha_transaccion', 'titulo' => 'Fecha'],
        ['campo' => 'proveedor_nombre', 'titulo' => 'Proveedor'],
        ['campo' => 'producto', 'titulo' => 'Producto'],
        ['campo' => 'cantidad', 'titulo' => 'Cantidad'],
        ['campo' => 'monto_total', 'titulo' => 'Monto Total'],
    ]" :filas="$compras" :formatear="[
        'monto_total' => fn($valor) => '$' . number_format($valor, 2),
        'fecha_transaccion' => fn($valor) => \Carbon\Carbon::parse($valor)->format('d/m/Y H:i'),
    ]" />

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
                }
            }

            toggleFechaFin();

            fechaInicio.addEventListener('input', toggleFechaFin);
        });
    </script>
</x-layouts.app>
