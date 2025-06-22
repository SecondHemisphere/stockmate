<x-layouts.app>

    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item :href="route('dashboard')" class="text-teal-700 hover:text-teal-900">
            Inicio
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('ventas.index')" class="text-teal-700 hover:text-teal-900">
            Ventas
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item class="text-teal-500">
            Ver
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="p-6 min-h-screen flex justify-center">

        <div class="bg-white shadow rounded-lg p-8 w-full max-w-3xl print:p-0 print:shadow-none print:bg-white">

            {{-- Encabezado: Logo + Empresa + Factura --}}
            <div class="grid grid-cols-3 gap-6 mb-8 items-center">

                {{-- Logo --}}
                <div class="flex justify-center">
                    <img src="{{ asset('images/logo_empresa.png') }}" alt="Logo Empresa" class="h-20 object-contain" />
                </div>

                {{-- Datos Empresa --}}
                <div class="text-center text-teal-900">
                    <h2 class="font-bold text-xl uppercase">{{ config('empresa.nombre') }}</h2>
                    <p class="text-sm">{{ config('empresa.eslogan') }}</p>
                    <p class="text-sm">{{ config('empresa.direccion') }}, {{ config('empresa.ciudad') }}</p>
                    <p class="text-sm">Tel: {{ config('empresa.telefono') }}</p>
                    <p class="text-sm">RUC: {{ config('empresa.ruc') }}</p>
                </div>

                {{-- Datos Factura --}}
                <div class="text-right text-teal-900">
                    <h1 class="font-extrabold text-3xl uppercase mb-2">Factura</h1>
                    <p class="font-semibold text-lg">No: 001-001-{{ sprintf('%09d', $venta->numero_factura) }}</p>
                    <p class="text-sm mt-1">Fecha: {{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</p>
                </div>
            </div>

            {{-- Información Cliente --}}
            <div class="mb-6 p-4 bg-teal-100 rounded text-teal-900 text-sm">
                <p><strong>Cliente:</strong> {{ $venta->cliente->nombre }}</p>
                <p><strong>ID:</strong> {{ $venta->cliente->identificacion ?? 'N/A' }}</p>
                <p><strong>Dirección:</strong> {{ $venta->cliente->direccion ?? 'N/A' }}</p>
                <p><strong>Teléfono:</strong> {{ $venta->cliente->telefono ?? 'N/A' }}</p>
            </div>

            {{-- Detalle de productos --}}
            <table class="w-full mb-6 text-teal-900 text-sm border-collapse">
                <thead class="bg-teal-300 uppercase font-semibold text-teal-900">
                    <tr>
                        <th class="text-left p-2 border-b border-teal-300">Código</th>
                        <th class="text-left p-2 border-b border-teal-300">Descripción</th>
                        <th class="text-right p-2 border-b border-teal-300">Cantidad</th>
                        <th class="text-right p-2 border-b border-teal-300">Precio Unitario</th>
                        <th class="text-right p-2 border-b border-teal-300">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($venta->detalles as $detalle)
                        <tr class="{{ $loop->even ? 'bg-teal-50' : '' }}">
                            <td class="p-2">{{ $detalle->producto->id ?? '-' }}</td>
                            <td class="p-2">{{ $detalle->producto->nombre }}</td>
                            <td class="p-2 text-right">{{ $detalle->cantidad }}</td>
                            <td class="p-2 text-right">${{ number_format($detalle->precio_unitario, 2, ',', '.') }}
                            </td>
                            <td class="p-2 text-right">${{ number_format($detalle->precio_total, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Totales --}}
            <div class="text-right text-teal-900 font-semibold text-sm space-y-1">
                @php
                    $subtotalNeto = $venta->monto_total - $venta->monto_descuento;
                    $ivaCalculated = $venta->total_con_iva - $subtotalNeto;
                @endphp
                <div><span>Subtotal 12%:</span> ${{ number_format($subtotalNeto, 2, ',', '.') }}</div>
                <div><span>Descuento:</span> -${{ number_format($venta->monto_descuento, 2, ',', '.') }}</div>
                <div><span>IVA 12%:</span> ${{ number_format($ivaCalculated, 2, ',', '.') }}</div>
                <div class="text-xl border-t border-teal-400 mt-2 pt-2 font-bold uppercase">Total:
                    ${{ number_format($venta->total_con_iva, 2, ',', '.') }}</div>
            </div>

            {{-- Gracias --}}
            <div class="text-center mt-12 text-teal-900 font-semibold">
                ¡Gracias por su compra!
            </div>

        </div>

    </div>

</x-layouts.app>
