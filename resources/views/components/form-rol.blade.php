@props([
    'rol' => null,
    'permisos' => [],
    'action',
    'method' => 'POST',
    'titulo' => 'Formulario Rol',
])

<div class="max-w-xl mx-auto bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-semibold mb-6 text-gray-900">{{ $titulo }}</h2>

    <form action="{{ $action }}" method="POST" class="space-y-5">
        @csrf
        @if (in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE']))
            @method($method)
        @endif

        <!-- Nombre del Rol -->
        <div>
            <label for="nombre" class="block mb-2 font-semibold text-gray-800">Nombre del Rol</label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $rol->nombre ?? '') }}" required
                placeholder="Ej: Administrador, Vendedor..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            @error('nombre')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Permisos -->
        <div>
            <label class="block mb-2 font-semibold text-gray-800">Permisos <span class="text-red-600">*</span></label>
            <div class="grid grid-cols-2 gap-2 max-h-64 overflow-auto border rounded-md p-3 bg-gray-50">
                @foreach ($permisos as $permiso)
                    @php
                        $checked = old('permisos')
                            ? in_array($permiso->id, old('permisos', []))
                            : isset($rol) && $rol->permisos->contains('id', $permiso->id);
                    @endphp
                    <label class="inline-flex items-center space-x-2">
                        <input type="checkbox" name="permisos[]" value="{{ $permiso->id }}"
                            {{ $checked ? 'checked' : '' }} class="form-checkbox h-5 w-5 text-blue-600">
                        <span class="text-gray-700">{{ ucfirst(str_replace('.', ' ', $permiso->nombre)) }}</span>
                    </label>
                @endforeach
            </div>
            @error('permisos')
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
