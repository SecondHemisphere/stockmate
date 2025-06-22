<x-layouts.app>

    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Inicio</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('ventas.index')">Ventas</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Detalles de Venta</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Detalle de Venta #{{ $venta->numero_factura }}</h2>

        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <p><strong>Cliente:</strong> {{ $venta->cliente->nombre }}</p>
                <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</p>
                <p><strong>Método de Pago:</strong> {{ $venta->metodo_pago }}</p>
                <p><strong>Registrada por:</strong> {{ $venta->usuario->name }}</p>
            </div>
            <div>
                <p><strong>Subtotal:</strong> ${{ number_format($venta->monto_total, 2, ',', '.') }}</p>
                <p><strong>Descuento:</strong> ${{ number_format($venta->monto_descuento, 2, ',', '.') }}</p>
                <p><strong>Total con IVA:</strong> ${{ number_format($venta->total_con_iva, 2, ',', '.') }}</p>
                <p><strong>Observaciones:</strong> {{ $venta->observaciones ?: '-' }}</p>
            </div>
        </div>

        <hr class="my-6">

        <h3 class="text-xl font-semibold text-gray-700 mb-2">Productos Vendidos</h3>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">Producto</th>
                        <th class="px-4 py-2 border text-right">Cantidad</th>
                        <th class="px-4 py-2 border text-right">Precio Unitario</th>
                        <th class="px-4 py-2 border text-right">Precio Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($venta->detalles as $detalle)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $detalle->producto->nombre }}</td>
                            <td class="px-4 py-2 border text-right">{{ $detalle->cantidad }}</td>
                            <td class="px-4 py-2 border text-right">
                                ${{ number_format($detalle->precio_unitario, 2, ',', '.') }}</td>
                            <td class="px-4 py-2 border text-right">
                                ${{ number_format($detalle->precio_total, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <a href="{{ route('ventas.index') }}"
                class="inline-block bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition">
                Volver al listado
            </a>
        </div>
    </div>

</x-layouts.app>
