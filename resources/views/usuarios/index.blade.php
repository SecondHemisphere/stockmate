<x-layouts.app>

    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Usuarios</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <x-busqueda-con-boton :ruta="route('usuarios.index')" :ruta_crear="route('usuarios.create')" :valor="request('search', '')"
        placeholder="Buscar por nombre o correo..." texto_boton="Buscar" texto_crear="Nuevo Usuario" />

    @php
        $columnas = [
            ['campo' => 'id', 'titulo' => 'ID'],
            ['campo' => 'nombre', 'titulo' => 'Nombre'],
            ['campo' => 'correo', 'titulo' => 'Correo'],
            ['campo' => 'estado', 'titulo' => 'Estado', 'tipo' => 'estado'],
        ];
    @endphp

    <x-tabla-generica :columnas="$columnas" :filas="$usuarios" ruta-base="usuarios" />

    <x-paginacion :datos="$usuarios" />

    @push('js')
        <script src="{{ mix('js/deleteConfirmation.js') }}"></script>
    @endpush

</x-layouts.app>
