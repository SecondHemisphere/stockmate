{{-- resources/views/categorias/index.blade.php --}}
<x-layouts.app>

    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Inicio</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Categorías</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <x-busqueda-con-boton :ruta="route('categorias.index')" :ruta_crear="route('categorias.create')" :valor="request('search', '')" placeholder="Buscar por nombre..."
        texto_boton="Buscar" texto_crear="Nueva Categoría" />

    @php
        $columnas = [
            ['campo' => 'id', 'titulo' => 'ID'],
            ['campo' => 'nombre', 'titulo' => 'Nombre'],
            ['campo' => 'estado', 'titulo' => 'Estado', 'tipo' => 'estado'],
        ];
    @endphp

    <x-tabla-generica :columnas="$columnas" :filas="$categorias" ruta-base="categorias" />

    @push('js')
        <script src="{{ mix('js/deleteConfirmation.js') }}"></script>
    @endpush

</x-layouts.app>
