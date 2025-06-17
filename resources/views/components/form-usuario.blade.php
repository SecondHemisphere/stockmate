@props([
    'usuario' => null,
    'action',
    'method' => 'POST',
    'titulo' => 'Formulario Usuario',
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
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $usuario->nombre ?? '') }}"
                required placeholder="Nombre del usuario"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            @error('nombre')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Correo -->
        <div>
            <label for="correo" class="block mb-2 font-semibold text-gray-800">Correo electrónico</label>
            <input type="email" name="correo" id="correo" value="{{ old('correo', $usuario->correo ?? '') }}"
                placeholder="ejemplo@correo.com"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            @error('correo')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Contraseña (solo para crear) -->
        @if (!isset($usuario))
            <!-- Contraseña -->
            <div>
                <label for="contrasena" class="block mb-2 font-semibold text-gray-800">Contraseña</label>
                <input type="password" name="contrasena" id="contrasena" placeholder="Ingrese una contraseña"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                @error('contrasena')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirmar Contraseña -->
            <div>
                <label for="contrasena_confirmation" class="block mb-2 font-semibold text-gray-800">Confirmar
                    Contraseña</label>
                <input type="password" name="contrasena_confirmation" id="contrasena_confirmation"
                    placeholder="Repita la contraseña"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            </div>
        @endif

        <!-- Estado -->
        <div>
            <label for="estado" class="block mb-2 font-semibold text-gray-800">Estado</label>
            @php
                $estadoSeleccionado = old('estado', $usuario->estado ?? 'ACTIVO');
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
