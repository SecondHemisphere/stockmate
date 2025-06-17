@props([
    'venta' => null,
    'clientes' => [], // colección o array de clientes para el select
    'productos' => [], // productos para seleccionar
    'action',
    'method' => 'POST',
    'titulo' => 'Formulario Venta',
])

<div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-8 font-sans">
    <h2 class="text-2xl font-semibold mb-6 text-gray-900 border-b pb-3">{{ $titulo }}</h2>

    <form action="{{ $action }}" method="POST" class="space-y-6">
        @csrf
        @if (in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE']))
            @method($method)
        @endif

        <!-- Cliente -->
        <div>
            <label for="cliente_id" class="block mb-2 font-semibold text-gray-800">Cliente</label>
            <select name="cliente_id" id="cliente_id" required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 transition">
                <option value="" disabled {{ old('cliente_id', $venta->cliente_id ?? '') ? '' : 'selected' }}>
                    -- Seleccione un cliente --
                </option>
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}"
                        {{ old('cliente_id', $venta->cliente_id ?? '') == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->nombre }}
                    </option>
                @endforeach
            </select>
            @error('cliente_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Número de factura -->
        <div>
            <label for="numero_factura" class="block mb-2 font-semibold text-gray-800">Número de Factura</label>
            <input type="text" name="numero_factura" id="numero_factura" required
                value="{{ old('numero_factura', $venta->numero_factura ?? '') }}" placeholder="Ejemplo: F0001234"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 transition">
            @error('numero_factura')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Fecha -->
        <div>
            <label for="fecha" class="block mb-2 font-semibold text-gray-800">Fecha</label>
            <input type="datetime-local" name="fecha" id="fecha" required
                value="{{ old('fecha', isset($venta->fecha) ? date('Y-m-d\TH:i', strtotime($venta->fecha)) : '') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 transition">
            @error('fecha')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Productos y Cantidades -->
        <fieldset class="border border-gray-300 rounded-md p-4">
            <legend class="font-semibold text-gray-800 mb-2">Productos</legend>

            <div class="space-y-4 max-h-72 overflow-y-auto">
                @php
                    $detalleVenta = old('productos', $venta ? $venta->detalles_venta->toArray() : []);
                @endphp

                <template id="producto-row-template">
                    <div class="flex items-center space-x-3">
                        <select name="productos[][producto_id]" required
                            class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 transition">
                            <option value="" disabled selected>Seleccione producto</option>
                            @foreach ($productos as $producto)
                                <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                            @endforeach
                        </select>

                        <input type="number" name="productos[][cantidad]" min="1" required
                            placeholder="Cantidad"
                            class="w-24 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 transition" />

                        <button type="button"
                            class="btn-eliminar-producto bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded"
                            title="Eliminar producto">&times;</button>
                    </div>
                </template>

                <div id="productos-container">
                    @if ($detalleVenta)
                        @foreach ($detalleVenta as $item)
                            <div class="flex items-center space-x-3">
                                <select name="productos[][producto_id]" required
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 transition">
                                    <option value="" disabled>Seleccione producto</option>
                                    @foreach ($productos as $producto)
                                        <option value="{{ $producto->id }}"
                                            {{ (int) ($item['producto_id'] ?? 0) === $producto->id ? 'selected' : '' }}>
                                            {{ $producto->nombre }}
                                        </option>
                                    @endforeach
                                </select>

                                <input type="number" name="productos[][cantidad]" min="1" required
                                    placeholder="Cantidad" value="{{ $item['cantidad'] ?? '' }}"
                                    class="w-24 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 transition" />

                                <button type="button"
                                    class="btn-eliminar-producto bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded"
                                    title="Eliminar producto">&times;</button>
                            </div>
                        @endforeach
                    @else
                        <!-- Al menos un producto vacío al cargar el formulario -->
                        <div class="flex items-center space-x-3">
                            <select name="productos[][producto_id]" required
                                class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 transition">
                                <option value="" disabled selected>Seleccione producto</option>
                                @foreach ($productos as $producto)
                                    <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                                @endforeach
                            </select>

                            <input type="number" name="productos[][cantidad]" min="1" required
                                placeholder="Cantidad"
                                class="w-24 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 transition" />

                            <button type="button"
                                class="btn-eliminar-producto bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded"
                                title="Eliminar producto">&times;</button>
                        </div>
                    @endif
                </div>
            </div>

            <button type="button" id="agregar-producto"
                class="mt-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded transition">
                + Agregar producto
            </button>
        </fieldset>

        <!-- Descuento -->
        <div>
            <label for="monto_descuento" class="block mb-2 font-semibold text-gray-800">Descuento</label>
            <input type="number" step="0.01" min="0" name="monto_descuento" id="monto_descuento"
                value="{{ old('monto_descuento', $venta->monto_descuento ?? 0) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 transition"
                placeholder="0.00" />
            @error('monto_descuento')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Monto Total -->
        <div>
            <label for="monto_total" class="block mb-2 font-semibold text-gray-800">Monto Total</label>
            <input type="number" step="0.01" min="0" name="monto_total" id="monto_total" required
                value="{{ old('monto_total', $venta->monto_total ?? '') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 transition"
                placeholder="Monto total sin IVA" />
            @error('monto_total')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Total con IVA -->
        <div>
            <label for="total_con_iva" class="block mb-2 font-semibold text-gray-800">Total con IVA</label>
            <input type="number" step="0.01" min="0" name="total_con_iva" id="total_con_iva" required
                value="{{ old('total_con_iva', $venta->total_con_iva ?? '') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 transition"
                placeholder="Monto total con IVA" />
            @error('total_con_iva')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Estado de pago -->
        <div>
            <label for="estado_pago" class="block mb-2 font-semibold text-gray-800">Estado de Pago</label>
            <select name="estado_pago" id="estado_pago" required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 transition">
                @php
                    $estados = ['PENDIENTE', 'PAGADO', 'CANCELADO', 'REEMBOLSADO'];
                @endphp
                @foreach ($estados as $estado)
                    <option value="{{ $estado }}"
                        {{ old('estado_pago', $venta->estado_pago ?? '') === $estado ? 'selected' : '' }}>
                        {{ ucfirst(strtolower($estado)) }}
                    </option>
                @endforeach
            </select>
            @error('estado_pago')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Botón Guardar -->
        <div>
            <button type="submit" class="btn-primary px-6 py-2 rounded-lg font-bold text-sm w-full md:w-auto">
                Guardar Venta
            </button>
        </div>
    </form>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('productos-container');
            const template = document.getElementById('producto-row-template').content;
            const btnAgregar = document.getElementById('agregar-producto');

            btnAgregar.addEventListener('click', () => {
                const clone = document.importNode(template, true);
                container.appendChild(clone);
                attachEliminarEventos();
            });

            function attachEliminarEventos() {
                container.querySelectorAll('.btn-eliminar-producto').forEach(btn => {
                    btn.onclick = (e) => {
                        e.target.closest('div').remove();
                    };
                });
            }

            attachEliminarEventos();
        });
    </script>
@endpush
