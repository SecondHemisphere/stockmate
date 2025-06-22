@props(['columnas', 'filas', 'rutaBase', 'mostrarEditar' => true, 'mostrarVerDetalles' => false])

<div class="max-w-full overflow-x-auto">
    <div class="max-h-96 overflow-y-auto">
        <table class="table-auto w-full text-sm border-collapse">
            <thead class="sticky top-0 bg-white shadow-md">
                <tr>
                    @foreach ($columnas as $col)
                        @php
                            $titulo = (string) ($col['titulo'] ?? '');
                            $tituloLimite = \Illuminate\Support\Str::limit($titulo, 25);
                        @endphp
                        <th class="border px-4 py-2 text-left whitespace-nowrap truncate max-w-xs"
                            title="{{ $titulo }}">
                            {{ $tituloLimite }}
                        </th>
                    @endforeach
                    <th class="border px-4 py-2 text-center whitespace-nowrap">Acciones</th>
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

                            <td class="border px-4 py-2 whitespace-nowrap truncate max-w-xs" title="{{ $texto }}">
                                @switch($tipo)
                                    @case('estado')
                                        <span
                                            class="{{ $texto === 'ACTIVO' ? 'text-teal-600 font-semibold' : 'text-red-600 font-semibold' }}">
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

                        <td class="text-center whitespace-nowrap">
                            <div class="flex justify-center gap-2">
                                @if ($mostrarVerDetalles)
                                    <a href="{{ url($rutaBase . '/' . $fila->id) }}"
                                        class="bg-gray-500 text-white p-2 rounded hover:bg-gray-600"
                                        title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endif

                                @if ($mostrarEditar)
                                    <a href="{{ url($rutaBase . '/' . $fila->id . '/edit') }}"
                                        class="bg-teal-500 text-white p-2 rounded hover:bg-teal-600" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif

                                <form action="{{ url($rutaBase . '/' . $fila->id) }}" method="POST"
                                    class="inline-block delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white p-2 rounded hover:bg-red-600"
                                        title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
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
        </div>

        <x-paginacion :datos="$filas" />

    </div>
