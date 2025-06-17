{{-- resources/views/components/tabla-generica.blade.php --}}
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
                    <td class="border border-gray-300 px-4 py-2">
                        @php
                            $campo = $col['campo'];
                            $tipo = $col['tipo'] ?? 'texto';
                            $valor = $fila->{$campo} ?? '';
                        @endphp

                        @switch($tipo)
                            @case('estado')
                                <span
                                    class="inline-block px-2 py-1 rounded text-white {{ $valor === 'ACTIVO' ? 'bg-teal-500' : 'bg-red-500' }}">
                                    {{ ucfirst(strtolower($valor)) }}
                                </span>
                            @break

                            @case('fecha')
                                {{ $valor ? \Carbon\Carbon::parse($valor)->format('d/m/Y') : '-' }}
                            @break

                            @case('imagen')
                                @if ($valor)
                                    <img src="{{ asset('uploads/' . $valor) }}" alt="{{ $fila->nombre ?? '' }}"
                                        class="h-12 w-auto rounded">
                                @else
                                    <span class="text-gray-400 italic">Sin imagen</span>
                                @endif
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

                <td class="border border-gray-300 px-4 py-2 text-center space-x-2">
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
