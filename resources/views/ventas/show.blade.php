<x-layouts.app>
    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Inicio</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('ventas.index')">Ventas</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Ver</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div
        class="invoice-container p-6 md:p-10 bg-white shadow-xl rounded-lg mx-auto my-8 max-w-4xl border border-gray-300 font-sans text-gray-800">

        {{-- Invoice Header --}}
        <div class="header-section text-center mb-8 pb-4 border-b border-gray-300">
            <h1 class="text-4xl font-extrabold text-blue-800 mb-2 tracking-wide uppercase">PAPELERÍA ACEVEDO</h1>
            <p class="text-sm text-gray-600">RUC: 0999999999001 | Teléfono: (04) 222-3333 | Dirección: Av. Siempre Viva
                123, Guayaquil, Ecuador</p>
        </div>

        {{-- Invoice Title & Number --}}
        <div class="flex justify-between items-end mb-6">
            <h2 class="text-3xl font-bold uppercase text-gray-900">Factura</h2>
            <div class="text-right">
                <p class="text-lg font-semibold">No. Factura: <span
                        class="font-bold text-blue-700">{{ $venta->numero_factura }}</span></p>
                <p class="text-sm text-gray-600">Fecha de Emisión: <span
                        class="font-medium">{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</span></p>
            </div>
        </div>

        {{-- Client and Sale Details --}}
        <div
            class="client-details-section grid grid-cols-1 md:grid-cols-2 gap-y-2 gap-x-6 mb-8 p-4 border border-gray-300 rounded-md bg-gray-50">
            <div>
                <p class="font-bold text-gray-700 uppercase mb-1">Detalles del Cliente:</p>
                <p><strong class="font-semibold">Cliente:</strong> {{ $venta->cliente->nombre }}</p>
                <p><strong class="font-semibold">Identificación:</strong> {{ $venta->cliente->identificacion ?? 'N/A' }}
                </p> {{-- Assuming 'identificacion' field for client --}}
            </div>
            <div>
                <p class="font-bold text-gray-700 uppercase mb-1">Detalles de la Venta:</p>
                <p><strong class="font-semibold">Método de Pago:</strong> {{ $venta->metodo_pago }}</p>
                <p><strong class="font-semibold">Registrada por:</strong> {{ $venta->usuario->name }}</p>
            </div>
        </div>

        <h3 class="text-xl font-bold text-gray-900 mb-4 border-b-2 pb-2 border-gray-300">Productos Vendidos</h3>

        {{-- Products Table --}}
        <div class="overflow-x-auto mb-8">
            <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
                <thead class="bg-blue-100">
                    <tr>
                        <th
                            class="px-4 py-3 border border-gray-300 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                            CÓDIGO</th>
                        <th
                            class="px-4 py-3 border border-gray-300 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                            DESCRIPCIÓN</th>
                        <th
                            class="px-4 py-3 border border-gray-300 text-right text-sm font-semibold text-gray-700 uppercase tracking-wider">
                            CANT.</th>
                        <th
                            class="px-4 py-3 border border-gray-300 text-right text-sm font-semibold text-gray-700 uppercase tracking-wider">
                            PRECIO UNIT.</th>
                        <th
                            class="px-4 py-3 border border-gray-300 text-right text-sm font-semibold text-gray-700 uppercase tracking-wider">
                            PRECIO TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($venta->detalles as $detalle)
                        <tr class="even:bg-gray-50 hover:bg-gray-100">
                            <td class="px-4 py-2 border border-gray-200 text-sm">
                                {{ $detalle->producto->id ?? 'N/A' }}</td>
                            <td class="px-4 py-2 border border-gray-200 text-sm">{{ $detalle->producto->nombre }}</td>
                            <td class="px-4 py-2 border border-gray-200 text-right text-sm">{{ $detalle->cantidad }}
                            </td>
                            <td class="px-4 py-2 border border-gray-200 text-right text-sm">
                                ${{ number_format($detalle->precio_unitario, 2, ',', '.') }}</td>
                            <td class="px-4 py-2 border border-gray-200 text-right text-sm">
                                ${{ number_format($detalle->precio_total, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Totals Section --}}
        <div class="flex justify-end mb-8">
            <div class="w-full md:w-1/2 lg:w-1/3 p-4 border border-gray-300 rounded-md bg-gray-50">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-700 font-medium">Subtotal:</span>
                    <span class="font-semibold text-lg">${{ number_format($venta->monto_total, 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-700 font-medium">Descuento:</span>
                    <span
                        class="font-semibold text-lg text-red-600">-${{ number_format($venta->monto_descuento, 2, ',', '.') }}</span>
                </div>
                @php
                    $subtotalConDescuento = $venta->monto_total - $venta->monto_descuento;
                    $ivaAmount = $venta->total_con_iva - $subtotalConDescuento;
                @endphp
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-700 font-medium">IVA:</span>
                    <span class="font-semibold text-lg">${{ number_format($ivaAmount, 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center border-t-2 border-gray-400 pt-3 mt-3">
                    <span class="text-gray-800 font-bold text-xl">TOTAL:</span>
                    <span
                        class="font-extrabold text-blue-700 text-2xl">${{ number_format($venta->total_con_iva, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>

        {{-- Observations/Notes --}}
        <div class="notes-section mb-8 p-4 border border-gray-300 rounded-md bg-gray-50">
            <p class="font-bold text-gray-700 uppercase mb-1">Observaciones:</p>
            <p class="text-sm text-gray-600">{{ $venta->observaciones ?: 'No hay observaciones para esta venta.' }}</p>
        </div>

        {{-- Footer Message --}}
        <div class="text-center text-lg font-semibold text-gray-700 mt-6 pt-4 border-t border-gray-300">
            <p>¡Gracias por su compra!</p>
        </div>
    </div>

</x-layouts.app>
