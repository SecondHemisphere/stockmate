<x-layouts.app>

    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Proveedores</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <x-busqueda-con-boton :ruta="route('proveedores.index')" :ruta_crear="route('proveedores.create')" :valor="request('search', '')" placeholder="Buscar por nombre..."
        texto_boton="Buscar" texto_crear="Nuevo Proveedor" />

    @php
        $columnas = [
            ['campo' => 'id', 'titulo' => 'ID'],
            ['campo' => 'nombre', 'titulo' => 'Nombre'],
            ['campo' => 'correo', 'titulo' => 'Correo'],
            ['campo' => 'telefono', 'titulo' => 'Teléfono'],
            ['campo' => 'direccion', 'titulo' => 'Dirección'],
            ['campo' => 'estado', 'titulo' => 'Estado', 'tipo' => 'estado'],
        ];
    @endphp

    <x-tabla-generica :columnas="$columnas" :filas="$proveedores" ruta-base="proveedores" />

    <x-paginacion :datos="$proveedores" />

    @push('js')
        <script src="{{ mix('js/deleteConfirmation.js') }}"></script>
    @endpush

</x-layouts.app>
