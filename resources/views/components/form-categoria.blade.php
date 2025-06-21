@props([
    'categoria' => null,
    'action',
    'method' => 'POST',
    'titulo' => 'Formulario Categoría',
])

<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-semibold mb-6 text-gray-900">{{ $titulo }}</h2>

    <form action="{{ $action }}" method="POST" class="space-y-5">
        @csrf
        @if (in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE']))
            @method($method)
        @endif

        <!-- Nombre -->
        <div>
            <label for="nombre" class="block mb-2 font-semibold text-gray-800">
                Nombre
            </label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $categoria->nombre ?? '') }}"
                required placeholder="Ingrese el nombre"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            @error('nombre')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Estado -->
        @if (isset($categoria))
            <div>
                <label for="estado" class="block mb-2 font-semibold text-gray-800">
                    Estado
                </label>
                @php
                    $estadoSeleccionado = old('estado', $categoria->estado ?? 'ACTIVO');
                @endphp
                <select name="estado" id="estado" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="ACTIVO" {{ $estadoSeleccionado === 'ACTIVO' ? 'selected' : '' }}>Activo</option>
                    <option value="INACTIVO" {{ $estadoSeleccionado === 'INACTIVO' ? 'selected' : '' }}>Inactivo
                    </option>
                </select>
                @error('estado')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        @endif

        <!-- Botón -->
        <div>
            <button type="submit" class="btn-primary text-s px-6 py-2 rounded-lg font-bold">
                Guardar
            </button>
        </div>
    </form>
</div>
