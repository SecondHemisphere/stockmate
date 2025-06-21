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
            ['campo' => 'descripcion', 'titulo' => 'Descripcion'],
        ];
    @endphp

    <x-tabla-con-imagenes :columnas="$columnas" :filas="$productos" ruta-base="productos" />

    <x-paginacion :datos="$productos" />

    <!-- Modal para imagen-->
    <div id="image-modal"
        class="fixed inset-0 z-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-200 backdrop-blur-sm backdrop-brightness-75 bg-black/30"
        onclick="closeImageModal()">
        <img id="image-modal-src" src="" alt="Imagen ampliada"
            class="w-auto h-auto max-w-[400px] max-h-[60vh] object-contain rounded shadow-lg"
            onclick="event.stopPropagation()" />
    </div>

    @push('js')
        <script src="{{ mix('js/deleteConfirmation.js') }}"></script>

        <script>
            function openImageModal(src) {
                const modal = document.getElementById('image-modal');
                const modalImg = document.getElementById('image-modal-src');

                modalImg.src = src;
                modal.classList.remove('opacity-0', 'pointer-events-none');
            }

            function closeImageModal() {
                const modal = document.getElementById('image-modal');
                modal.classList.add('opacity-0', 'pointer-events-none');
            }

            document.addEventListener('keydown', function(event) {
                if (event.key === "Escape") {
                    closeImageModal();
                }
            });
        </script>
    @endpush

</x-layouts.app>
