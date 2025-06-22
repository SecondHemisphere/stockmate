<x-layouts.app>

    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Inicio</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Usuarios</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <x-busqueda-con-boton :ruta="route('usuarios.index')" :ruta_crear="route('usuarios.create')" :valor="request('search', '')"
        placeholder="Buscar por nombre o correo..." texto_boton="Buscar" texto_crear="Nuevo Usuario" />

    <div class="overflow-x-auto max-w-full">
        <div class="max-h-96 overflow-y-auto border border-gray-300 rounded">
            <table class="table-auto w-full border-collapse">
                <thead class="sticky top-0 bg-white shadow">
                    <tr>
                        <th class="border px-4 py-2 text-left">ID</th>
                        <th class="border px-4 py-2 text-left">Nombre</th>
                        <th class="border px-4 py-2 text-left">Correo</th>
                        <th class="border px-4 py-2 text-left">Rol</th>
                        <th class="border px-4 py-2 text-left">Estado</th>
                        <th class="border px-4 py-2 text-center whitespace-nowrap">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($usuarios as $usuario)
                        <tr>
                            <td class="border px-4 py-2">{{ $usuario->id }}</td>
                            <td class="border px-4 py-2">{{ $usuario->nombre }}</td>
                            <td class="border px-4 py-2">{{ $usuario->correo }}</td>
                            <td class="border px-4 py-2">{{ $usuario->rol->nombre ?? '-' }}</td>
                            <td class="border px-4 py-2">
                                <span
                                    class="{{ $usuario->estado === 'ACTIVO' ? 'text-teal-600 font-semibold' : 'text-red-600 font-semibold' }}">
                                    {{ ucfirst(strtolower($usuario->estado)) }}
                                </span>
                            </td>
                            <td class="border px-4 py-2 text-center whitespace-nowrap space-x-2">
                                @if ($usuario->id !== 1)
                                    <a href="{{ route('usuarios.edit', $usuario->id) }}"
                                        class="inline-block bg-teal-500 text-white px-3 py-1 rounded hover:bg-teal-600 transition"
                                        title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST"
                                        style="display:inline-block;" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="btn-eliminar inline-block bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700 transition"
                                            title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 italic">No permitido</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">No hay usuarios para mostrar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('js')
        <script src="{{ mix('js/deleteConfirmation.js') }}"></script>
    @endpush

</x-layouts.app>
