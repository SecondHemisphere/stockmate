{{-- resources/views/components/tabla-con-imagenes.blade.php --}}
@props(['columnas', 'filas', 'rutaBase', 'mostrarEditar' => true])

<table class="table-auto w-full border-collapse border border-gray-300">
    <thead>
        <tr>
            @foreach ($columnas as $col)
                <th class="border border-gray-300 px-4 py-2 text-left">{{ $col['titulo'] }}</th>
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
                        $valor = is_array($fila) ? $fila[$campo] ?? '' : $fila->{$campo} ?? '';
                    @endphp

                    <td class="border border-gray-300 px-4 py-2 align-middle">
                        @switch($tipo)
                            @case('estado')
                                <span class="{{ $valor === 'ACTIVO' ? 'text-teal-600' : 'text-red-600' }}">
                                    {{ ucfirst(strtolower($valor)) }}
                                </span>
                            @break

                            @case('fecha')
                                {{ $valor ? \Carbon\Carbon::parse($valor)->format('d/m/Y') : '-' }}
                            @break

                            @case('imagen')
                                @if ($valor)
                                    <img src="{{ asset('storage/' . $valor) }}" alt="{{ $fila->nombre ?? '' }}"
                                        class="h-15 w-auto rounded mx-auto cursor-pointer"
                                        onclick="openImageModal('{{ asset('storage/' . $valor) }}')" />
                                @else
                                    <span class="text-gray-400 italic">Sin imagen</span>
                                @endif
                            @break

                            @case('moneda')
                                {{ $valor !== null ? '$' . number_format($valor, 2, ',', '.') : '-' }}
                            @break

                            @case('acciones')
                                {!! $valor !!}
                            @break

                            @default
                                @if ($campo === 'direccion')
                                    @php
                                        $textoCompleto = $valor;
                                        $textoCorto = \Illuminate\Support\Str::limit($textoCompleto, 30);
                                    @endphp
                                    <span title="{{ $textoCompleto }}">{{ $textoCorto }}</span>
                                @else
                                    {{ $valor }}
                                @endif
                        @endswitch
                    </td>
                @endforeach

                @if (!collect($columnas)->pluck('campo')->contains('acciones'))
                    <td class="border border-gray-300 px-4 py-2 text-center">
                        <div class="flex justify-center items-center gap-2 flex-wrap">
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
                @endif
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
