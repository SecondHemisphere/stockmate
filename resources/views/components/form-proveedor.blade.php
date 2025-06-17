@props([
    'proveedor' => null,
    'action',
    'method' => 'POST',
    'titulo' => 'Formulario Proveedor',
])

<div class="max-w-xl mx-auto bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-semibold mb-6 text-gray-900">{{ $titulo }}</h2>

    <form action="{{ $action }}" method="POST" class="space-y-5">
        @csrf
        @if (in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE']))
            @method($method)
        @endif

        <!-- Nombre -->
        <div>
            <label for="nombre" class="block mb-2 font-semibold text-gray-800">Nombre</label>
            <input type="text" name="nombre" id="nombre"
                value="{{ old('nombre', $proveedor->nombre ?? '') }}" required
                placeholder="Nombre del proveedor"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            @error('nombre')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Correo -->
        <div>
            <label for="correo" class="block mb-2 font-semibold text-gray-800">Correo electrónico</label>
            <input type="email" name="correo" id="correo"
                value="{{ old('correo', $proveedor->correo ?? '') }}"
                placeholder="ejemplo@correo.com"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            @error('correo')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Teléfono -->
        <div>
            <label for="telefono" class="block mb-2 font-semibold text-gray-800">Teléfono</label>
            <input type="text" name="telefono" id="telefono"
                value="{{ old('telefono', $proveedor->telefono ?? '') }}"
                placeholder="Ej. 0987654321"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            @error('telefono')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Dirección -->
        <div>
            <label for="direccion" class="block mb-2 font-semibold text-gray-800">Dirección</label>
            <textarea name="direccion" id="direccion" rows="3"
                placeholder="Dirección del proveedor"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">{{ old('direccion', $proveedor->direccion ?? '') }}</textarea>
            @error('direccion')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Estado -->
        <div>
            <label for="estado" class="block mb-2 font-semibold text-gray-800">Estado</label>
            @php
                $estadoSeleccionado = old('estado', $proveedor->estado ?? 'ACTIVO');
            @endphp
            <select name="estado" id="estado" required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                <option value="ACTIVO" {{ $estadoSeleccionado === 'ACTIVO' ? 'selected' : '' }}>Activo</option>
                <option value="INACTIVO" {{ $estadoSeleccionado === 'INACTIVO' ? 'selected' : '' }}>Inactivo</option>
            </select>
            @error('estado')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Botón -->
        <div>
            <button type="submit" class="btn-primary px-6 py-2 rounded-lg font-bold text-sm">
                Guardar
            </button>
        </div>
    </form>
</div>
