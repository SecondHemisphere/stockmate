@props([
    'compra' => null,
    'productos' => [], // colección o array de productos para el select
    'action',
    'method' => 'POST',
    'titulo' => 'Formulario Compra',
])

<div class="max-w-xl mx-auto bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-semibold mb-6 text-gray-900">{{ $titulo }}</h2>

    <form action="{{ $action }}" method="POST" class="space-y-5">
        @csrf
        @if (in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE']))
            @method($method)
        @endif

        <!-- Producto -->
        @php
            $productoId = old('producto_id', optional($compra)->producto_id);
        @endphp
        <div class="flex-1 min-w-[220px]">
            <label for="producto_id" class="block mb-2 text-sm font-medium text-gray-700">Producto</label>
            <select id="producto-select" name="producto_id"
                class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                @if ($productoId)
                    <option value="{{ $productoId }}" selected>
                        {{ \App\Models\Producto::find($productoId)->nombre ?? 'Seleccionado' }}
                    </option>
                @endif
            </select>
            @error('producto_id')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Cantidad -->
        <div>
            <label for="cantidad" class="block mb-2 font-semibold text-gray-800">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" min="1" required
                value="{{ old('cantidad', $compra->cantidad ?? 1) }}" placeholder="Cantidad comprada"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            @error('cantidad')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Monto Total -->
        <div>
            <label for="monto_total" class="block mb-2 font-semibold text-gray-800">Monto Total</label>
            <input type="number" name="monto_total" id="monto_total" required
                value="{{ old('monto_total', $compra->monto_total ?? 1.00) }}" placeholder="Monto total en USD"
                min="0" step="0.01"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            @error('monto_total')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Fecha de Transacción -->
        <div>
            <label for="fecha_transaccion" class="block mb-2 font-semibold text-gray-800">Fecha de Compra</label>
            <input type="datetime-local" name="fecha_transaccion" id="fecha_transaccion" required
                value="{{ old('fecha_transaccion', isset($compra->fecha_transaccion) ? date('Y-m-d\TH:i', strtotime($compra->fecha_transaccion)) : now()->format('Y-m-d\TH:i')) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            @error('fecha_transaccion')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Botón -->
        <div>
            <button type="submit" class="btn-primary px-6 py-2 rounded-lg font-bold text-sm">
                Guardar
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        new TomSelect('#producto-select', {
            valueField: 'id',
            labelField: 'text',
            searchField: 'text',
            load: function(query, callback) {
                if (!query.length) return callback();

                fetch("{{ route('productos.search') }}?q=" + encodeURIComponent(query))
                    .then(response => response.json())
                    .then(data => {
                        if (data.items) {
                            callback(data.items);
                        } else {
                            callback();
                        }
                    })
                    .catch(error => {
                        console.error('Error loading products:', error);
                        callback();
                    });
            },
            placeholder: 'Buscar producto...',
            allowEmptyOption: true,
            maxOptions: 10
        });
    });
</script>
