{{-- resources/views/ventas/index.blade.php --}}

<x-layouts.app>

    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Ventas</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <x-busqueda-con-boton :ruta="route('ventas.index')" :ruta_crear="route('ventas.create')" :valor="request('search', '')"
        placeholder="Buscar por número de factura o cliente..." texto_boton="Buscar" texto_crear="Nueva Venta" />

    @php
        $columnas = [
            ['campo' => 'id', 'titulo' => 'ID'],
            ['campo' => 'numero_factura', 'titulo' => 'Número Factura'],
            ['campo' => 'cliente_nombre', 'titulo' => 'Cliente'],
            ['campo' => 'monto_total', 'titulo' => 'Monto Total'],
            ['campo' => 'fecha', 'titulo' => 'Fecha', 'tipo' => 'fecha'],
            ['campo' => 'metodo_pago', 'titulo' => 'Método Pago'],
        ];
    @endphp

    <x-tabla-generica :columnas="$columnas" :filas="$ventas" ruta-base="ventas" :mostrarEditar="false" />

    <x-paginacion :datos="$ventas" />

    @push('js')
        <script src="{{ mix('js/deleteConfirmation.js') }}"></script>
    @endpush

</x-layouts.app>
