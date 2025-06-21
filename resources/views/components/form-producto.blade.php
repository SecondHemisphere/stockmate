@props([
    'producto' => null,
    'action',
    'method' => 'POST',
    'titulo' => 'Formulario Producto',
])

@php
    $categoriaId = old('categoria_id', $producto->categoria_id ?? null);
    $categoriaNombre = $categoriaId ? \App\Models\Categoria::find($categoriaId)?->nombre : '';
    $proveedorId = old('proveedor_id', $producto->proveedor_id ?? null);
    $proveedorNombre = $proveedorId ? \App\Models\Proveedor::find($proveedorId)?->nombre : '';
@endphp

<div class="max-w-xl mx-auto bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-semibold mb-6 text-gray-900">{{ $titulo }}</h2>

    <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if (in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE']))
            @method($method)
        @endif

        <div class="flex flex-wrap gap-6">
            <!-- Nombre -->
            <div class="flex-1 min-w-[220px]">
                <label for="nombre" class="block mb-2 font-semibold text-gray-800">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $producto->nombre ?? '') }}"
                    placeholder="Nombre del producto"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('nombre')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Categoría -->
            <div class="flex-1 min-w-[220px] relative">
                <label for="categoria-search" class="block mb-2 font-semibold text-gray-800">Categoría</label>
                <input type="text" id="categoria-search" placeholder="Buscar categoría..." autocomplete="off"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md transition mb-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    value="{{ $categoriaNombre }}">
                <select id="categoria-select" name="categoria_id" size="5"
                    class="select-buscable w-full border border-gray-300 rounded-md absolute z-10 bg-white"
                    style="height:auto; display:none;">
                    @if ($categoriaId)
                        <option value="{{ $categoriaId }}" selected>{{ $categoriaNombre }}</option>
                    @endif
                </select>
                @error('categoria_id')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Proveedor -->
            <div class="flex-1 min-w-[220px] relative">
                <label for="proveedor-search" class="block mb-2 font-semibold text-gray-800">Proveedor</label>
                <input type="text" id="proveedor-search" placeholder="Buscar proveedor..." autocomplete="off"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md transition mb-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    value="{{ $proveedorNombre }}">
                <select id="proveedor-select" name="proveedor_id" size="5"
                    class="select-buscable w-full border border-gray-300 rounded-md absolute z-10 bg-white"
                    style="height:auto; display:none;">
                    @if ($proveedorId)
                        <option value="{{ $proveedorId }}" selected>{{ $proveedorNombre }}</option>
                    @endif
                </select>
                @error('proveedor_id')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Estado -->
            @if ($producto && $producto->id)
                <div class="flex-1 min-w-[200px]">
                    <label for="estado" class="block mb-2 font-semibold text-gray-800">Estado</label>
                    @php
                        $estadoSeleccionado = old('estado', $producto->estado ?? 'ACTIVO');
                    @endphp
                    <select name="estado" id="estado" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="ACTIVO" {{ $estadoSeleccionado === 'ACTIVO' ? 'selected' : '' }}>Activo
                        </option>
                        <option value="INACTIVO" {{ $estadoSeleccionado === 'INACTIVO' ? 'selected' : '' }}>Inactivo
                        </option>
                    </select>
                    @error('estado')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            @endif
        </div>

        <div class="flex flex-wrap gap-6">
            <!-- Precio de compra -->
            <div class="flex-1 min-w-[180px]">
                <label for="precio_compra" class="block mb-2 font-semibold text-gray-800">Precio de Compra</label>
                <input type="number" id="precio_compra" name="precio_compra"
                    value="{{ old('precio_compra', $producto->precio_compra ?? '0.01') }}" step="0.01"
                    min="0.01" max="999999.99"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                @error('precio_compra')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Margen de ganancia -->
            <div class="flex-1 min-w-[140px]">
                <label for="margen" class="block mb-2 font-semibold text-gray-800">Margen de Ganancia (%)</label>
                <input type="number" id="margen" name="margen"
                    value="{{ old('margen', $producto->margen ?? '40') }}" step="1" min="1" max="500"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                @error('margen')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Precio de venta -->
            <div class="flex-1 min-w-[180px]">
                <label for="precio_venta" class="block mb-2 font-semibold text-gray-800">Precio de Venta</label>
                <input type="number" id="precio_venta" name="precio_venta"
                    value="{{ old('precio_venta', $producto->precio_venta ?? '') }}" step="0.01" min="0.01"
                    max="999999.99"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                @error('precio_venta')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Stock mínimo -->
            <div class="flex-1 min-w-[150px]">
                <label for="stock_minimo" class="block mb-2 font-semibold text-gray-800">Stock Mínimo</label>
                <input type="number" id="stock_minimo" name="stock_minimo"
                    value="{{ old('stock_minimo', $producto->stock_minimo ?? '10') }}" step="1" min="10"
                    max="999999"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                @error('stock_minimo')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap gap-6 items-start">
            <!-- Descripción -->
            <div class="flex-grow min-w-[300px] md:w-2/4">
                <label for="descripcion" class="block mb-2 font-semibold text-gray-800">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="7" placeholder="Detalles del producto"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md resize-y focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
                @error('descripcion')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Imagen -->
            <div class="relative mt-4 w-full md:w-2/4 max-w-[200px]">
                <div class="w-full h-40 overflow-hidden rounded-md border border-gray-300 bg-gray-50">
                    <img id="imgPreview" class="w-full h-full object-contain object-center"
                        src="{{ old('ruta_imagen') ? asset('storage/' . old('ruta_imagen')) : ($producto && $producto->ruta_imagen ? asset('storage/' . $producto->ruta_imagen) : asset('images/no_image.png')) }}"
                        alt="Imagen del producto">
                </div>
                <label for="imagen"
                    class="cursor-pointer block mt-3 text-center text-sm font-semibold text-white btn btn-neutral rounded-md px-4 py-2 transition">
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
            <button type="submit" class="btn-primary px-6 py-2 rounded-lg font-bold text-m">
                Guardar Producto
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Categoría
        const categoriaInput = document.getElementById('categoria-search');
        const categoriaSelect = document.getElementById('categoria-select');

        function mostrarCategoriaSelect(mostrar) {
            categoriaSelect.style.display = mostrar ? 'block' : 'none';
        }

        function cargarCategorias(query) {
            if (!query.length) {
                categoriaSelect.innerHTML = '';
                mostrarCategoriaSelect(false);
                return;
            }

            fetch("{{ route('categorias.search') }}?q=" + encodeURIComponent(query))
                .then(res => res.json())
                .then(data => {
                    categoriaSelect.innerHTML = '';

                    if (data.items && data.items.length > 0) {
                        data.items.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.id;
                            option.textContent = item.text;
                            categoriaSelect.appendChild(option);
                        });
                        categoriaSelect.selectedIndex = 0;
                        mostrarCategoriaSelect(true);
                    } else {
                        const option = document.createElement('option');
                        option.disabled = true;
                        option.textContent = 'No se encontraron categorías';
                        categoriaSelect.appendChild(option);
                        mostrarCategoriaSelect(true);
                    }
                })
                .catch(() => {
                    categoriaSelect.innerHTML = '';
                    const option = document.createElement('option');
                    option.disabled = true;
                    option.textContent = 'Error al cargar categorías';
                    categoriaSelect.appendChild(option);
                    mostrarCategoriaSelect(true);
                });
        }

        function categoriaSeleccionada() {
            const selectedOption = categoriaSelect.options[categoriaSelect.selectedIndex];
            if (selectedOption && !selectedOption.disabled) {
                categoriaInput.value = selectedOption.textContent;
                mostrarCategoriaSelect(false);
            }
        }

        categoriaInput.addEventListener('input', () => {
            cargarCategorias(categoriaInput.value.trim());
        });

        categoriaSelect.addEventListener('change', categoriaSeleccionada);
        categoriaSelect.addEventListener('click', categoriaSeleccionada);

        // Inicialmente oculto
        mostrarCategoriaSelect(false);

        // Proveedor
        const proveedorInput = document.getElementById('proveedor-search');
        const proveedorSelect = document.getElementById('proveedor-select');

        function mostrarProveedorSelect(mostrar) {
            proveedorSelect.style.display = mostrar ? 'block' : 'none';
        }

        function cargarProveedores(query) {
            if (!query.length) {
                proveedorSelect.innerHTML = '';
                mostrarProveedorSelect(false);
                return;
            }

            fetch("{{ route('proveedores.search') }}?q=" + encodeURIComponent(query))
                .then(res => res.json())
                .then(data => {
                    proveedorSelect.innerHTML = '';

                    if (data.items && data.items.length > 0) {
                        data.items.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.id;
                            option.textContent = item.text;
                            proveedorSelect.appendChild(option);
                        });
                        proveedorSelect.selectedIndex = 0;
                        mostrarProveedorSelect(true);
                    } else {
                        const option = document.createElement('option');
                        option.disabled = true;
                        option.textContent = 'No se encontraron proveedores';
                        proveedorSelect.appendChild(option);
                        mostrarProveedorSelect(true);
                    }
                })
                .catch(() => {
                    proveedorSelect.innerHTML = '';
                    const option = document.createElement('option');
                    option.disabled = true;
                    option.textContent = 'Error al cargar proveedores';
                    proveedorSelect.appendChild(option);
                    mostrarProveedorSelect(true);
                });
        }

        function proveedorSeleccionado() {
            const selectedOption = proveedorSelect.options[proveedorSelect.selectedIndex];
            if (selectedOption && !selectedOption.disabled) {
                proveedorInput.value = selectedOption.textContent;
                mostrarProveedorSelect(false);
            }
        }

        proveedorInput.addEventListener('input', () => {
            cargarProveedores(proveedorInput.value.trim());
        });

        proveedorSelect.addEventListener('change', proveedorSeleccionado);
        proveedorSelect.addEventListener('click', proveedorSeleccionado);

        // Inicialmente oculto
        mostrarProveedorSelect(false);

        // Preview imagen
        window.previewImage = function(event, targetId) {
            const input = event.target;
            const preview = document.querySelector(targetId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => preview.src = e.target.result;
                reader.readAsDataURL(input.files[0]);
            }
        };

        // Precio de venta automático
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

        ventaInput.addEventListener('input', () => {
            const compra = parseFloat(compraInput.value);
            const venta = parseFloat(ventaInput.value);
            if (!isNaN(compra) && !isNaN(venta) && venta < compra) {
                alert("El precio de venta no puede ser menor al precio de compra.");
                ventaInput.value = compra.toFixed(2);
            }
        });

        calcularPrecioVenta();
    });
</script>
