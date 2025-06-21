@props([
    'compra' => null,
    'action',
    'method' => 'POST',
    'titulo' => 'Formulario Compra',
])

@php
    $productoId = old('producto_id', optional($compra)->producto_id);
    $productoNombre = $productoId ? \App\Models\Producto::find($productoId)?->nombre : '';
@endphp

<div class="max-w-xl mx-auto bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-semibold mb-6 text-gray-900">{{ $titulo }}</h2>

    <form action="{{ $action }}" method="POST" class="space-y-5">
        @csrf
        @if (in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE']))
            @method($method)
        @endif

        <!-- Producto -->
        <div class="flex-1 min-w-[220px]">
            <label for="producto-search" class="block mb-2 font-semibold text-gray-800">Producto</label>
            <input type="text" id="producto-search" placeholder="Buscar producto..." autocomplete="off"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition mb-1"
                value="{{ $productoNombre }}">

            <select id="producto-select" name="producto_id" size="5"
                class="w-full border border-gray-300 rounded-md" style="height:auto;">
                @if ($productoId)
                    <option value="{{ $productoId }}" selected>{{ $productoNombre }}</option>
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
                value="{{ old('monto_total', $compra->monto_total ?? 1.0) }}" placeholder="Monto total en USD"
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
<!-- ... (resto del formulario igual) -->

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('producto-search');
        const select = document.getElementById('producto-select');

        function mostrarSelect(mostrar) {
            select.style.display = mostrar ? 'block' : 'none';
        }

        function cargarProductos(query) {
            if (!query.length) {
                select.innerHTML = '';
                mostrarSelect(false);
                return;
            }

            fetch("{{ route('productos.search') }}?q=" + encodeURIComponent(query))
                .then(res => res.json())
                .then(data => {
                    select.innerHTML = '';

                    if (data.items && data.items.length > 0) {
                        data.items.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.id;
                            option.textContent = item.text;
                            select.appendChild(option);
                        });
                        select.selectedIndex = 0;
                        mostrarSelect(true);
                    } else {
                        const option = document.createElement('option');
                        option.disabled = true;
                        option.textContent = 'No se encontraron productos';
                        select.appendChild(option);
                        mostrarSelect(true);
                    }
                })
                .catch(() => {
                    select.innerHTML = '';
                    const option = document.createElement('option');
                    option.disabled = true;
                    option.textContent = 'Error al cargar productos';
                    select.appendChild(option);
                    mostrarSelect(true);
                });
        }

        // Cuando el usuario escribe en el input, cargar productos y mostrar el select
        input.addEventListener('input', () => {
            const query = input.value.trim();
            cargarProductos(query);
        });

        // Cuando el usuario selecciona opción en select, oculta el select y actualiza input
        function opcionSeleccionada() {
            const selectedOption = select.options[select.selectedIndex];
            if (selectedOption && !selectedOption.disabled) {
                input.value = selectedOption.textContent;
                mostrarSelect(false);
            }
        }

        select.addEventListener('change', opcionSeleccionada);
        select.addEventListener('click', opcionSeleccionada);

        // Al cargar la página: si ya hay producto seleccionado, ocultar el select
        if (input.value.trim()) {
            mostrarSelect(false);
        } else {
            mostrarSelect(false); // También ocultamos si no hay valor (puedes cambiarlo a true si quieres)
        }
    });
</script>
