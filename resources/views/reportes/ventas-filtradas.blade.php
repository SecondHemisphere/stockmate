<x-layouts.app>
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Reporte de Ventas Filtradas</h2>
        <p class="text-sm text-gray-600">Control de ventas según cliente, usuario y rango de fechas.</p>
    </div>

    <!-- Formulario filtros -->
    <form method="GET" action="{{ route('reportes.ventas-filtradas') }}" class="mb-6 flex flex-wrap gap-4 items-end">
        <div>
            <label for="fecha_inicio" class="block text-gray-700 font-semibold mb-1">Fecha Inicio</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ request('fecha_inicio') }}"
                class="border border-gray-300 rounded px-3 py-2" />
        </div>
        <div>
            <label for="fecha_fin" class="block text-gray-700 font-semibold mb-1">Fecha Fin</label>
            <input type="date" name="fecha_fin" id="fecha_fin" value="{{ request('fecha_fin') }}"
                class="border border-gray-300 rounded px-3 py-2" />
        </div>
        <div>
            <label for="cliente_id" class="block text-gray-700 font-semibold mb-1">Cliente</label>
            <select name="cliente_id" id="cliente_id"
                class="border border-gray-300 rounded px-3 py-2 w-full max-w-[200px]">
                <option value="">-- Todos --</option>
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}" @if (request('cliente_id') == $cliente->id) selected @endif>
                        {{ $cliente->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="usuario_id" class="block text-gray-700 font-semibold mb-1">Usuario</label>
            <select name="usuario_id" id="usuario_id" class="border border-gray-300 rounded px-3 py-2">
                <option value="">-- Todos --</option>
                @foreach ($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" @if (request('usuario_id') == $usuario->id) selected @endif>
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

    <!-- Botones descarga -->
    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('reportes.ventas-filtradas.pdf', request()->query()) }}"
            class="btn bg-red-600 hover:bg-red-500 text-white px-5 py-2 rounded-lg flex items-center gap-2">
            <i class="fas fa-file-pdf"></i> Descargar PDF
        </a>

        <a href="{{ route('reportes.ventas-filtradas.excel', request()->query()) }}"
            class="btn bg-green-600 hover:bg-green-500 text-white px-5 py-2 rounded-lg flex items-center gap-2">
            <i class="fas fa-file-excel"></i> Descargar Excel
        </a>
    </div>

    <x-tabla-reporte :columnas="[
        ['campo' => 'fecha', 'titulo' => 'Fecha'],
        ['campo' => 'numero_factura', 'titulo' => 'Factura'],
        ['campo' => 'cliente_nombre', 'titulo' => 'Cliente'],
        ['campo' => 'usuario_nombre', 'titulo' => 'Usuario'],
        ['campo' => 'monto_total', 'titulo' => 'Monto Total'],
        ['campo' => 'metodo_pago', 'titulo' => 'Método de Pago'],
    ]" :filas="$ventas" :formatear="[
        'monto_total' => fn($valor) => '$' . number_format($valor, 2),
        'fecha' => fn($valor) => \Carbon\Carbon::parse($valor)->format('d/m/Y H:i'),
    ]" />

    <!-- Script para habilitar/deshabilitar Fecha Fin según Fecha Inicio -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fechaInicio = document.getElementById('fecha_inicio');
            const fechaFin = document.getElementById('fecha_fin');

            function toggleFechaFin() {
                if (fechaInicio.value) {
                    fechaFin.disabled = false;
                    fechaFin.min = fechaInicio.value;
                    if (fechaFin.value && fechaFin.value < fechaInicio.value) {
                        fechaFin.value = fechaInicio.value;
                    }
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
