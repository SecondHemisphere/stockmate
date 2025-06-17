@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-layouts.app>
    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Productos
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="mb-4">
        <form action="{{ route('productos.index') }}" method="GET">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <input type="text" name="search" placeholder="Buscar por nombre..."
                        value="{{ request()->get('search') }}"
                        class="border rounded px-3 py-1 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                    <button type="submit" class="btn btn-neutral text-s px-4 py-2 rounded-lg">
                        Buscar
                    </button>
                </div>

                <a href="{{ route('productos.create') }}" class="btn btn-primary text-s px-6 py-2 rounded-lg">
                    Nuevo Producto
                </a>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-start">
        @foreach ($productos as $producto)
            <div x-data="{ showDetails: false }"
                class="rounded-lg overflow-hidden shadow-md bg-white hover:shadow-xl transition-shadow border border-[#faefbddc]">
                <!-- Imagen -->
                <div @click="$dispatch('open-image-modal', {
                        imageUrl: '{{ is_array($producto['ruta_imagen'])
                            ? Storage::url($producto['ruta_imagen'][0])
                            : Storage::url($producto['ruta_imagen']) }}'
                    })"
                    class="cursor-pointer w-full h-40 bg-white flex items-center justify-center overflow-hidden rounded-t-lg">
                    @if ($producto['ruta_imagen'] ?? false)
                        <img src="{{ is_array($producto['ruta_imagen'])
                            ? Storage::url($producto['ruta_imagen'][0])
                            : Storage::url($producto['ruta_imagen']) }}"
                            class="h-full w-full object-contain">
                    @else
                        <img src="{{ asset('images/no_image.png') }}" class="h-full w-full object-contain">
                    @endif
                </div>

                <!-- Info del producto -->
                <div class="p-4 text-black">
                    <h3 class="text-lg font-semibold mb-1 break-words">{{ $producto->nombre }}</h3>
                    <span
                        class="inline-block text-xs font-semibold px-2 py-1 rounded-full
                        {{ $producto->estado === 'ACTIVO' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $producto->estado }}
                    </span>

                    <p class="text-sm text-cyan-600 font-medium">
                        Categoría: {{ $producto->categoria->nombre ?? 'Sin categoría' }}
                    </p>
                    <p class="text-sm text-blue-800 font-medium">
                        Proveedor: {{ $producto->proveedor->nombre ?? 'Sin proveedor' }}
                    </p>
                    <p class="text-sm text-green-600 font-medium">Stock actual: {{ $producto->stock_actual }}</p>
                    <p class="text-sm text-red-600 mb-1 font-medium">Stock mínimo: {{ $producto->stock_minimo }}</p>
                    <p class="text-sm font-bold text-gray-700">Precio de Compra: ${{ $producto->precio_compra }}</p>
                    <p class="text-sm font-bold text-black">Precio de Venta: ${{ $producto->precio_venta }}</p>
                </div>

                <!-- Acciones -->
                <div class="mb-2 border-t border-gray-200 pt-2 px-4 flex items-center justify-between gap-2">
                    <button @click="showDetails = !showDetails"
                        class="text-xs text-blue-600 font-medium hover:underline transition duration-200">
                        <span x-show="!showDetails">➕ Ver detalles</span>
                        <span x-show="showDetails">➖ Ocultar detalles</span>
                    </button>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('productos.edit', $producto) }}"
                            class="btn text-xs px-4 py-2 rounded-lg bg-cyan-500 text-white hover:bg-cyan-700">
                            Editar
                        </a>

                        <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn text-xs px-4 py-2 rounded-lg bg-[#d9534f] text-white hover:bg-[#c9302c]">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Descripción -->
                <div x-show="showDetails" x-collapse x-transition
                    class="text-sm text-gray-800 bg-gray-50 p-2 rounded-md border border-gray-100 mx-4 mb-4">
                    {{ $producto->descripcion ?? 'Sin descripción disponible.' }}
                </div>
            </div>
        @endforeach
    </div>

    <div @click="
        imageUrl = '{{ is_array($producto['ruta_imagen']) && count($producto['ruta_imagen']) > 0
            ? Storage::url($producto['ruta_imagen'][0])
            : ($producto['ruta_imagen']
                ? Storage::url($producto['ruta_imagen'])
                : asset('images/no_image.png')) }}';
        open = true
    "
        class="cursor-pointer w-full h-40 bg-white flex items-center justify-center overflow-hidden rounded-t-lg">

        <!-- Modal global para mostrar imagen -->
        <div x-data="{ open: false, imageUrl: '' }" x-on:open-image-modal.window="imageUrl = $event.detail.imageUrl; open = true"
            x-show="open" x-transition.opacity.duration.100ms style="display: none"
            class="fixed inset-0 z-50 flex items-center justify-center" aria-modal="true" role="dialog">

            <div @click="open = false" class="absolute inset-0 cursor-pointer backdrop-blur-sm" aria-hidden="true">
            </div>

            <div class="relative max-w-3xl max-h-full p-4 z-10" @keydown.window.escape="open = false" tabindex="0">
                <button @click="open = false"
                    class="absolute top-4 right-4 bg-black bg-opacity-50 text-white text-sm font-semibold hover:bg-opacity-75 focus:outline-none focus:ring-2 focus:ring-white rounded px-3 py-1 shadow-lg z-20"
                    aria-label="Cerrar modal" type="button">
                    Cerrar
                </button>

                <img :src="imageUrl" alt="Imagen del producto"
                    class="max-w-full max-h-screen object-contain rounded" />
            </div>
        </div>

        @if (!request()->has('search'))
            <div class="mt-4">
                {{ $productos->links() }}
            </div>
        @endif

        @push('js')
            <script src="{{ mix('js/deleteConfirmation.js') }}"></script>
        @endpush
</x-layouts.app>
