<x-layouts.app>

    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Inicio</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Roles</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <x-busqueda-con-boton :ruta="route('roles.index')" :ruta_crear="route('roles.create')" :valor="request('search', '')" placeholder="Buscar por nombre ..."
        texto_boton="Buscar" texto_crear="Nuevo Rol" />

    <div class="overflow-x-auto max-w-full mt-6">
        <div class="max-h-96 overflow-y-auto border border-gray-300 rounded">
            <table class="table-auto w-full border-collapse">
                <thead class="sticky top-0 bg-white shadow">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left whitespace-nowrap">ID</th>
                        <th class="border border-gray-300 px-4 py-2 text-left whitespace-nowrap">Rol</th>
                        <th class="border border-gray-300 px-4 py-2 text-left whitespace-normal">Permisos</th>
                        <th class="border border-gray-300 px-4 py-2 text-center whitespace-nowrap">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $rol)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2 whitespace-nowrap">{{ $rol->id }}</td>

                            <td class="border border-gray-300 px-4 py-2 whitespace-nowrap">{{ $rol->nombre }}</td>

                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700 leading-relaxed">
                                @php
                                    $agrupados = collect($rol->permisos)->groupBy(function ($permiso) {
                                        return ucfirst(explode('.', $permiso->nombre)[0]);
                                    });
                                @endphp

                                @foreach ($agrupados as $grupo => $permisos)
                                    <div class="mb-1">
                                        <strong>{{ $grupo }}:</strong>
                                        {{ $permisos->pluck('nombre')->map(fn($p) => ucfirst(explode('.', $p)[1] ?? ''))->implode(', ') }}
                                    </div>
                                @endforeach
                            </td>

                            <td class="border border-gray-300 px-4 py-2 text-center whitespace-nowrap space-x-2">
                                @if ($rol->id !== 1)
                                    <a href="{{ route('roles.edit', $rol->id) }}"
                                        class="inline-block bg-teal-500 text-white p-2 rounded hover:bg-teal-600 transition"
                                        title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('roles.destroy', $rol->id) }}" method="POST"
                                        style="display:inline-block;" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="btn-eliminar inline-block bg-red-500 text-white p-2 rounded hover:bg-red-700 transition"
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
                            <td colspan="4" class="text-center py-4 text-gray-500">
                                No hay roles para mostrar.
                            </td>
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
