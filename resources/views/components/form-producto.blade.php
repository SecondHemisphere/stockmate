@props([
    'producto' => null,
    'action',
    'method' => 'POST',
    'titulo' => 'Formulario Producto',
])

<div class="max-w-xl mx-auto bg-white rounded-lg shadow-lg p-8">
    <h2 class="text-2xl font-semibold mb-8 text-gray-800">{{ $titulo }}</h2>

    <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @if (in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE']))
            @method($method)
        @endif

        <div class="flex flex-wrap gap-6">
            <!-- Nombre -->
            <div class="flex-1 min-w-[220px]">
                <label for="nombre" class="block mb-2 text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $producto->nombre ?? '') }}"
                    placeholder="Nombre del producto"
                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                @error('nombre')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Categoría -->
            @php
                $categoriaId = old('categoria_id', optional($producto)->categoria_id);
            @endphp
            <div class="flex-1 min-w-[220px]">
                <label for="categoria_id" class="block mb-2 text-sm font-medium text-gray-700">Categoría</label>
                <select id="categoria-select" name="categoria_id"
                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    @if ($categoriaId)
                        <option value="{{ $categoriaId }}" selected>
                            {{ \App\Models\Categoria::find($categoriaId)->nombre ?? 'Seleccionada' }}
                        </option>
                    @endif
                </select>
                @error('categoria_id')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Proveedor -->
            @php
                $proveedorId = old('proveedor_id', optional($producto)->proveedor_id);
            @endphp
            <div class="flex-1 min-w-[220px]">
                <label for="proveedor_id" class="block mb-2 text-sm font-medium text-gray-700">Proveedor</label>
                <select id="proveedor-select" name="proveedor_id"
                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    @if ($proveedorId)
                        <option value="{{ $proveedorId }}" selected>
                            {{ \App\Models\Proveedor::find($proveedorId)->nombre ?? 'Seleccionado' }}
                        </option>
                    @endif
                </select>
                @error('proveedor_id')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap gap-6">
            <!-- Precio de compra -->
            <div class="flex-1 min-w-[180px]">
                <label for="precio_compra" class="block mb-2 text-sm font-medium text-gray-700">Precio de Compra</label>
                <input type="number" id="precio_compra" name="precio_compra"
                    value="{{ old('precio_compra', $producto->precio_compra ?? '0.01') }}" step="0.01"
                    min="0.01" max="999999.99"
                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                @error('precio_compra')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Margen de ganancia -->
            <div class="flex-1 min-w-[140px]">
                <label for="margen" class="block mb-2 text-sm font-medium text-gray-700">Margen de Ganancia
                    (%)</label>
                <input type="number" id="margen" name="margen"
                    value="{{ old('margen', $producto->margen ?? '40') }}" step="1" min="1" max="500"
                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                @error('margen')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Precio de venta -->
            <div class="flex-1 min-w-[180px]">
                <label for="precio_venta" class="block mb-2 text-sm font-medium text-gray-700">Precio de Venta</label>
                <input type="number" id="precio_venta" name="precio_venta"
                    value="{{ old('precio_venta', $producto->precio_venta ?? '') }}" step="0.01" min="0.01"
                    max="999999.99"
                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                @error('precio_venta')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Stock mínimo -->
            <div class="flex-1 min-w-[150px]">
                <label for="stock_minimo" class="block mb-2 text-sm font-medium text-gray-700">Stock Mínimo</label>
                <input type="number" id="stock_minimo" name="stock_minimo"
                    value="{{ old('stock_minimo', $producto->stock_minimo ?? '10') }}" step="1" min="10"
                    max="999999"
                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                @error('stock_minimo')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap gap-6 items-start">
            <!-- Descripción -->
            <div class="flex-grow min-w-[300px] md:w-3/4">
                <label for="descripcion" class="block mb-2 text-sm font-medium text-gray-700">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="4" placeholder="Detalles del producto"
                    class="w-full rounded-md border border-gray-300 px-3 py-2 resize-y focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
                @error('descripcion')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Imagen -->
            <div class="relative mt-4 w-full md:w-1/4 max-w-[200px]">
                <div class="w-full h-40 overflow-hidden rounded-md border border-gray-300 bg-gray-50">
                    <img id="imgPreview" class="w-full h-full object-contain object-center"
                        src="{{ old('ruta_imagen') ? asset('storage/' . old('ruta_imagen')) : ($producto && $producto->ruta_imagen ? asset('storage/' . $producto->ruta_imagen) : asset('images/no_image.png')) }}"
                        alt="Imagen del producto">
                </div>
                <label for="imagen"
                    class="cursor-pointer block mt-3 text-center text-sm font-semibold text-white bg-blue-600 rounded-md px-4 py-2 hover:bg-blue-700 transition">
                    Cambiar Imagen
                </label>
                <input type="file" name="imagen" id="imagen" accept="image/*" class="hidden"
                    onchange="previewImage(event, '#imgPreview')">
                @error('imagen')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Botón -->
        <div>
            <button type="submit"
                class="inline-block px-8 py-3 bg-blue-600 text-white font-semibold rounded-md shadow hover:bg-blue-700 transition">
                Guardar Producto
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        new TomSelect('#categoria-select', {
            valueField: 'id',
            labelField: 'text',
            searchField: 'text',
            load: function(query, callback) {
                if (!query.length) return callback();

                fetch("{{ route('categorias.search') }}?q=" + encodeURIComponent(query))
                    .then(response => response.json())
                    .then(data => {
                        if (data.items) {
                            callback(data.items);
                        } else {
                            callback();
                        }
                    })
                    .catch(error => {
                        console.error('Error loading categories:', error);
                        callback();
                    });
            },
            placeholder: 'Buscar categoría...',
            allowEmptyOption: true,
            maxOptions: 10
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        new TomSelect('#proveedor-select', {
            valueField: 'id',
            labelField: 'text',
            searchField: 'text',
            load: function(query, callback) {
                if (!query.length) return callback();

                fetch("{{ route('proveedores.search') }}?q=" + encodeURIComponent(query))
                    .then(response => response.json())
                    .then(data => {
                        if (data.items) {
                            callback(data.items);
                        } else {
                            callback();
                        }
                    })
                    .catch(error => {
                        console.error('Error loading vendors:', error);
                        callback();
                    });
            },
            placeholder: 'Buscar proveedor...',
            allowEmptyOption: true,
            maxOptions: 10
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const compraInput = document.getElementById('precio_compra');
        const ventaInput = document.getElementById('precio_venta');
        const margenInput = document.getElementById('margen');

        function calcularPrecioVenta() {
            const compra = parseFloat(compraInput.value);
            const margen = parseFloat(margenInput.value);
            if (!isNaN(compra) && !isNaN(margen)) {
                const venta = compra * (1 + margen / 100);
                ventaInput.value = venta.toFixed(2);
                ventaInput.min = compra.toFixed(2);
            }
        }

        compraInput.addEventListener('input', calcularPrecioVenta);
        margenInput.addEventListener('input', calcularPrecioVenta);

        ventaInput.addEventListener('input', function() {
            const compra = parseFloat(compraInput.value);
            const venta = parseFloat(ventaInput.value);
            if (!isNaN(compra) && !isNaN(venta) && venta < compra) {
                alert("El precio de venta no puede ser menor al precio de compra.");
                ventaInput.value = compra.toFixed(2);
            }
        });

        calcularPrecioVenta();

        function previewImage(event, targetId) {
            const input = event.target;
            const preview = document.querySelector(targetId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => preview.src = e.target.result;
                reader.readAsDataURL(input.files[0]);
            }
        }
    });
</script>
