<x-layouts.app>

    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Compras</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <x-busqueda-con-boton :ruta="route('compras.index')" :ruta_crear="route('compras.create')" :valor="request('search', '')" placeholder="Buscar por producto..."
        texto_boton="Buscar" texto_crear="Nueva Compra" />

    @php
        $columnas = [
            ['campo' => 'id', 'titulo' => 'ID'],
            ['campo' => 'producto_nombre', 'titulo' => 'Producto'],
            ['campo' => 'cantidad', 'titulo' => 'Cantidad'],
            ['campo' => 'monto_total', 'titulo' => 'Monto Total'],
            ['campo' => 'fecha_transaccion', 'titulo' => 'Fecha de Compra'],
        ];
    @endphp

    <x-tabla-generica :columnas="$columnas" :filas="$compras" ruta-base="compras" :mostrarEditar="false" />

    <x-paginacion :datos="$compras" />

    @push('js')
        <script src="{{ mix('js/deleteConfirmation.js') }}"></script>
    @endpush

</x-layouts.app>
