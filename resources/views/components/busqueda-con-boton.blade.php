{{-- resources/views/components/busqueda-con-boton.blade.php --}}

@props([
    'ruta',
    'ruta_crear',
    'valor' => '',
    'placeholder' => 'Buscar...',
    'texto_boton' => 'Buscar',
    'texto_crear' => 'Crear nuevo',
])

<div class="mb-4 flex justify-between items-center">
    <form action="{{ $ruta }}" method="GET" class="flex items-center space-x-3">
        <input
            type="text"
            name="search"
            placeholder="{{ $placeholder }}"
            value="{{ $valor }}"
            class="border rounded px-3 py-2"
        >
        <button type="submit" class="btn btn-neutral text-s px-4 py-2 rounded-lg">
            {{ $texto_boton }}
        </button>
    </form>

    <a href="{{ $ruta_crear }}" class="btn-primary text-s px-6 py-2 rounded-lg font-bold">
        {{ $texto_crear }}
    </a>
</div>
