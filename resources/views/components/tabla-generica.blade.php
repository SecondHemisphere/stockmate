@props(['columnas', 'filas', 'rutaBase', 'mostrarEditar' => true, 'mostrarVerDetalles' => false])

<table class="overflow-x-auto">
    <thead>
        <tr>
            @foreach ($columnas as $col)
                @php
                    $titulo = (string) ($col['titulo'] ?? '');
                    $tituloLimite = \Illuminate\Support\Str::limit($titulo, 25);
                @endphp
                <th class="border border-gray-300 px-4 py-2 text-left max-w-xs truncate" title="{{ $titulo }}">
                    {{ $tituloLimite }}
                </th>
            @endforeach
            <th class="border border-gray-300 px-4 py-2 text-center">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($filas as $fila)
            <tr>
                @foreach ($columnas as $col)
                    @php
                        $campo = $col['campo'];
                        $tipo = $col['tipo'] ?? 'texto';
                        $valor = $fila->{$campo} ?? '';
                        $texto = (string) $valor;
                        $textoLimite = \Illuminate\Support\Str::limit($texto, 50);
                    @endphp

                    <td class="border border-gray-300 px-4 py-2 max-w-xs truncate" title="{{ $texto }}">
                        @switch($tipo)
                            @case('estado')
                                <span class="{{ $texto === 'ACTIVO' ? 'text-teal-600' : 'text-red-600' }}">
                                    {{ ucfirst(strtolower($texto)) }}
                                </span>
                            @break

                            @case('fecha')
                                {{ $texto ? \Carbon\Carbon::parse($texto)->format('d/m/Y') : '-' }}
                            @break

                            @case('moneda')
                                {{ $valor !== null ? '$' . number_format($valor, 2, ',', '.') : '-' }}
                            @break

                            @default
                                {{ $textoLimite }}
                        @endswitch
                    </td>
                @endforeach

                <td class="border border-gray-300 px-4 py-2 text-center">
                    <div class="flex justify-center items-center gap-2 flex-wrap">
                        @if ($mostrarVerDetalles)
                            <a href="{{ url($rutaBase . '/' . $fila->id) }}"
                                class="inline-block bg-stone-500 text-white px-3 py-1 rounded hover:bg-stone-600 transition">
                                Ver
                            </a>
                        @endif

                        @if ($mostrarEditar)
                            <a href="{{ url($rutaBase . '/' . $fila->id . '/edit') }}"
                                class="inline-block bg-teal-500 text-white px-3 py-1 rounded hover:bg-teal-600 transition">
                                Editar
                            </a>
                        @endif

                        <form id="delete-form" action="{{ url($rutaBase . '/' . $fila->id) }}" method="POST"
                            style="display:inline-block;" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                class="btn-eliminar inline-block bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700 transition">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan="{{ count($columnas) + 1 }}" class="text-center py-4 text-gray-500">
                        No hay registros para mostrar.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
