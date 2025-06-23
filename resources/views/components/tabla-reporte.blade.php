<div class="max-w-full max-h-96 overflow-x-auto overflow-y-auto rounded-lg border border-gray-300 bg-white">
    <table class="min-w-full text-sm text-gray-700">
        <thead class="sticky top-0 z-10">
            <tr>
                @foreach ($columnas as $col)
                    @php
                        $titulo = (string) ($col['titulo'] ?? '');
                        $tituloLimite = \Illuminate\Support\Str::limit($titulo, 30);
                    @endphp
                    <th class="px-4 py-2 border-b border-gray-300 text-left whitespace-nowrap truncate max-w-xs"
                        title="{{ $titulo }}">
                        {{ $tituloLimite }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($filas as $index => $fila)
                <tr class="border-t hover:bg-gray-50">
                    @foreach ($columnas as $col)
                        @php
                            $campo = $col['campo'];
                            $tipo = $col['tipo'] ?? 'texto';
                            $valor = is_object($fila) ? $fila->{$campo} ?? '' : $fila[$campo] ?? '';
                        @endphp

                        <td class="px-4 py-2 border-b border-gray-200 whitespace-nowrap truncate max-w-xs"
                            title="{{ $valor }}">
                            @if ($campo === 'index')
                                {{ $index + 1 }}º
                            @else
                                @switch($tipo)
                                    @case('fecha')
                                        {{ $valor ? \Carbon\Carbon::parse($valor)->format('d/m/Y') : '-' }}
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
    </div>
