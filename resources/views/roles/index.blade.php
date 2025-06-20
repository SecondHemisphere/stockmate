<x-layouts.app>

    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Roles</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <x-busqueda-con-boton :ruta="route('roles.index')" :ruta_crear="route('roles.create')" :valor="request('search', '')"
        placeholder="Buscar por nombre del rol..." texto_boton="Buscar" texto_crear="Nuevo Rol" />

    @php
        $columnas = [['campo' => 'id', 'titulo' => 'ID'], ['campo' => 'nombre', 'titulo' => 'Nombre del Rol']];
    @endphp

    <x-tabla-generica :columnas="$columnas" :filas="$roles" ruta-base="roles" />

    <x-paginacion :datos="$roles" />

    @push('js')
        <script src="{{ mix('js/deleteConfirmation.js') }}"></script>
    @endpush

</x-layouts.app>
