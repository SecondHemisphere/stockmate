@props(['columnas', 'filas'])

<table class="min-w-full bg-white text-sm text-gray-700 border border-gray-300 rounded-lg overflow-hidden">
    <thead class="bg-red-100 text-red-700">
        <tr>
            @foreach ($columnas as $col)
                <th class="px-4 py-2 border-b border-gray-300 text-left">
                    {{ $col['titulo'] }}
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @forelse ($filas as $index => $fila)
            <tr class="border-t">
                @foreach ($columnas as $col)
                    <td class="px-4 py-2 border-b border-gray-200">
                        @php
                            $campo = $col['campo'];
                            $tipo = $col['tipo'] ?? 'texto';
                        @endphp

                        @if ($campo === 'index')
                            {{ $index + 1 }}º
                        @else
                            @php
                                $valor = $fila->{$campo} ?? '';
                            @endphp

                            @switch($tipo)
                                @case('fecha')
                                    {{ $valor ? \Carbon\Carbon::parse($valor)->format('d/m/Y') : '-' }}
                                @break

                                @case('imagen')
                                    @if ($valor)
                                        <img src="{{ asset('uploads/' . $valor) }}" alt="Imagen" class="h-10 w-auto rounded">
                                    @else
                                        <span class="text-gray-400 italic">Sin imagen</span>
                                    @endif
                                @break

                                @default
                                    {{ $valor }}
                            @endswitch
                        @endif
                    </td>
                @endforeach
            </tr>
            @empty
                <tr>
                    <td colspan="{{ count($columnas) }}" class="text-center py-4 text-gray-500">
                        No hay registros para mostrar.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
