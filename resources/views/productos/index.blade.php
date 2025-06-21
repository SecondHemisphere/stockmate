<x-layouts.app>

    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Inicio</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Productos</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <x-busqueda-con-boton :ruta="route('productos.index')" :ruta_crear="route('productos.create')" :valor="request('search', '')" placeholder="Buscar por nombre..."
        texto_boton="Buscar" texto_crear="Nuevo Producto" />

    @php
        $columnas = [
            ['campo' => 'id', 'titulo' => 'ID'],
            ['campo' => 'ruta_imagen', 'titulo' => 'Imagen', 'tipo' => 'imagen'],
            ['campo' => 'nombre', 'titulo' => 'Nombre'],
            ['campo' => 'categoria_nombre', 'titulo' => 'Categoría'],
            ['campo' => 'proveedor_nombre', 'titulo' => 'Proveedor'],
            ['campo' => 'stock_actual', 'titulo' => 'Stock Actual'],
            ['campo' => 'stock_minimo', 'titulo' => 'Stock Mínimo'],
            ['campo' => 'precio_compra', 'titulo' => 'Precio Compra', 'tipo' => 'moneda'],
            ['campo' => 'precio_venta', 'titulo' => 'Precio Venta', 'tipo' => 'moneda'],
            ['campo' => 'estado', 'titulo' => 'Estado', 'tipo' => 'estado'],
        ];
    @endphp

    <x-tabla-con-imagenes :columnas="$columnas" :filas="$productos" ruta-base="productos" />

    <x-paginacion :datos="$productos" />

    <!-- Modal para imagen en grande -->
    <div id="image-modal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden"
        onclick="document.getElementById('image-modal').classList.add('hidden')">
        <img id="image-modal-src" src="" alt="Imagen ampliada"
            class="max-w-[600px] w-full h-auto rounded shadow-lg" />
    </div>

    @push('js')
        <script src="{{ mix('js/deleteConfirmation.js') }}"></script>

        <script>
            function openImageModal(src) {
                const modal = document.getElementById('image-modal');
                const modalImg = document.getElementById('image-modal-src');
                modalImg.src = src;
                modal.classList.remove('hidden');
            }

            document.addEventListener('keydown', function(event) {
                if (event.key === "Escape") {
                    document.getElementById('image-modal').classList.add('hidden');
                }
            });
        </script>
    @endpush

</x-layouts.app>
