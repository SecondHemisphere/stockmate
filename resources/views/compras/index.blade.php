<x-layouts.app>

    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Inicio</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Compras</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <x-busqueda-con-boton :ruta="route('compras.index')" :ruta_crear="route('compras.create')" :valor="request('search', '')" placeholder="Buscar por producto..."
        texto_boton="Buscar" texto_crear="Nueva Compra" />

    @php
        $columnas = [
            ['campo' => 'id', 'titulo' => 'ID'],
            ['campo' => 'fecha_transaccion', 'titulo' => 'Fecha de Compra'],
            ['campo' => 'producto_nombre', 'titulo' => 'Producto'],
            ['campo' => 'cantidad', 'titulo' => 'Cantidad'],
            ['campo' => 'monto_total', 'titulo' => 'Monto Total', 'tipo' => 'moneda'],
            ['campo' => 'usuario_nombre', 'titulo' => 'Registrada Por'],
        ];
    @endphp

    <x-tabla-generica :columnas="$columnas" :filas="$compras" ruta-base="compras" :mostrarEditar="false" />

    @push('js')
        <script src="{{ mix('js/deleteConfirmation.js') }}"></script>
    @endpush

</x-layouts.app>
