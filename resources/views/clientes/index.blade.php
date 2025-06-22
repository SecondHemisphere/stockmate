{{-- resources/views/clientes/index.blade.php --}}
<x-layouts.app>

    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Inicio</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Clientes</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <x-busqueda-con-boton :ruta="route('clientes.index')" :ruta_crear="route('clientes.create')" :valor="request('search', '')" placeholder="Buscar por nombre..."
        texto_boton="Buscar" texto_crear="Nuevo Cliente" />

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

    <x-tabla-generica :columnas="$columnas" :filas="$clientes" ruta-base="clientes" />
    
    @push('js')
        <script src="{{ mix('js/deleteConfirmation.js') }}"></script>
    @endpush

</x-layouts.app>
