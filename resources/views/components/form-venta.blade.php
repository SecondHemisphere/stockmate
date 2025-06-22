@props(['action', 'clientes', 'productos', 'metodosPago', 'numeroFactura', 'method' => 'POST', 'titulo'])

<div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-semibold mb-6 text-gray-900">{{ $titulo }}</h2>

    <form action="{{ $action }}" method="POST" class="space-y-6">
        @csrf
        @if (in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE']))
            @method($method)
        @endif

        <div class="flex flex-wrap gap-6">
            <!-- Cliente -->
            <div class="flex-1 min-w-[220px] relative">
                <label for="buscar-cliente" class="block mb-2 font-semibold text-gray-800">Cliente *</label>
                <input type="text" id="buscar-cliente" name="nombre_cliente" placeholder="Buscar cliente..."
                    autocomplete="off" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md transition mb-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    value="{{ old('nombre_cliente', '') }}">
                <select id="select-cliente" name="cliente_id" size="5"
                    class="select-buscable w-full border border-gray-300 rounded-md absolute z-10 bg-white"
                    style="height:auto; display:none;">
                    @if (old('cliente_id'))
                        <option value="{{ old('cliente_id') }}" selected>
                            Cliente seleccionado
                        </option>
                    @endif
                </select>
                @error('cliente_id')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Número de Factura -->
            <div class="mb-4">
                <label for="numero_factura" class="block mb-2 font-semibold text-gray-800">Número de Factura</label>
                <input type="text" name="numero_factura" value="{{ $numeroFactura }}" readonly
                    class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed" />
            </div>

            <!-- Fecha -->
            <div class="flex-1 min-w-[220px]">
                <label for="fecha" class="block mb-2 font-semibold text-gray-800">Fecha *</label>
                <input type="datetime-local" name="fecha" id="fecha" required
                    value="{{ old('fecha', date('Y-m-d\TH:i')) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
            </div>
        </div>

        <!-- Productos -->
        <fieldset class="border border-gray-300 rounded-md p-4">
            <legend class="font-semibold text-gray-800 px-2">Productos *</legend>

            <table class="w-full mt-2">
                <thead>
                    <tr class="border-b border-gray-300">
                        <th class="text-left pb-2">Producto</th>
                        <th class="text-center pb-2">Cantidad</th>
                        <th class="text-center pb-2">Stock</th>
                        <th class="text-right pb-2">Precio Unitario</th>
                        <th class="text-right pb-2">SubTotal</th>
                        <th class="pb-2"></th>
                    </tr>
                </thead>
                <tbody id="lista-productos">
                    <tr class="fila-producto border-b border-gray-200" data-indice="0">
                        <td class="py-3">
                            <div class="relative">
                                <input type="text"
                                    class="buscar-producto w-full px-4 py-2 border border-gray-300 rounded-md transition mb-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Buscar producto..." autocomplete="off" required>
                                <select
                                    class="select-producto w-full border border-gray-300 rounded-md absolute z-10 bg-white"
                                    name="productos[0][producto_id]" size="5"
                                    style="height:auto; display:none;"></select>
                            </div>
                        </td>
                        <td class="px-2">
                            <input type="number" name="productos[0][cantidad]" value="1" min="1" required
                                class="cantidad w-full px-2 py-1 border border-gray-300 rounded-md text-center" />
                        </td>
                        <td class="px-2 text-center">
                            <span class="stock-disponible text-sm text-gray-600">0</span>
                        </td>
                        <td class="px-2">
                            <input type="text" name="productos[0][precio_unitario]" value="0.00" required
                                class="precio-unitario w-full px-2 py-1 border border-gray-300 rounded-md text-right"
                                readonly />
                        </td>
                        <td class="px-2">
                            <input type="text" name="productos[0][precio_total]" value="0.00" required
                                class="precio-total w-full px-2 py-1 border border-gray-300 rounded-md text-right"
                                readonly />
                        </td>
                        <td class="text-center">
                            <button type="button"
                                class="eliminar-producto text-red-600 font-bold px-2 hover:text-red-800">X</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <button type="button" id="agregar-producto"
                class="mt-4 bg-teal-600 hover:bg-teal-800 text-white font-semibold px-4 py-2 rounded transition">
                + Agregar producto
            </button>
        </fieldset>

        <div class="flex flex-wrap gap-6 mt-4">
            <!-- Método de pago -->
            <div class="flex-1 min-w-[220px]">
                <label for="metodo_pago" class="block mb-2 font-semibold text-gray-800">Método de Pago *</label>
                <select name="metodo_pago" id="metodo_pago" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Seleccionar método de pago</option>
                    @foreach ($metodosPago as $key => $label)
                        <option value="{{ $key }}" {{ old('metodo_pago') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('metodo_pago')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Observaciones -->
            <div class="flex-1 min-w-[220px]">
                <label for="observaciones" class="block mb-2 font-semibold text-gray-800">Observaciones</label>
                <textarea name="observaciones" id="observaciones" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Detalles adicionales...">{{ old('observaciones') }}</textarea>
                @error('observaciones')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Totales -->
        <div class="bg-gray-50 p-4 rounded-md mt-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="text-right">
                    <p class="font-semibold">Subtotal:</p>
                    <input type="text" id="subtotal" value="0.00"
                        class="w-full px-2 py-1 border border-gray-300 rounded-md text-right bg-white" readonly>
                </div>
                <div class="text-right">
                    <p class="font-semibold">Descuento:</p>
                    <input type="number" id="descuento" name="monto_descuento"
                        value="{{ old('monto_descuento', 0) }}" min="0" step="0.01"
                        class="w-full px-2 py-1 border border-gray-300 rounded-md text-right">
                </div>
                <div class="text-right">
                    <p class="font-semibold">IVA (15%):</p>
                    <input type="text" id="iva" value="0.00"
                        class="w-full px-2 py-1 border border-gray-300 rounded-md text-right bg-white" readonly>
                </div>
                <div class="text-right">
                    <p class="font-semibold">Total:</p>
                    <input type="text" id="total" name="total_con_iva"
                        value="{{ old('total_con_iva', 0.0) }}"
                        class="w-full px-2 py-1 border border-gray-300 rounded-md text-right bg-white font-bold"
                        readonly>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit"
                class="px-6 py-2 bg-teal-600 hover:bg-teal-800 text-white font-semibold rounded-md transition">
                Guardar Factura
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let indiceProducto = 1;

        // --------------------- CLIENTES ---------------------
        function inicializarBusquedaCliente() {
            const buscarInput = document.getElementById('buscar-cliente');
            const selectElement = document.getElementById('select-cliente');

            if (!buscarInput || !selectElement) return;

            function mostrarSelect(mostrar) {
                selectElement.style.display = mostrar ? 'block' : 'none';
            }

            function cargarClientes(consulta) {
                if (!consulta) {
                    selectElement.innerHTML = '';
                    mostrarSelect(false);
                    return;
                }

                fetch('{{ route('clientes.search') }}?q=' + encodeURIComponent(consulta))
                    .then(res => res.json())
                    .then(data => {
                        selectElement.innerHTML = '';
                        if (data.items && data.items.length) {
                            data.items.forEach(item => {
                                const option = document.createElement('option');
                                option.value = item.id;
                                option.textContent = item.text;
                                selectElement.appendChild(option);
                            });
                            selectElement.selectedIndex = 0;
                            mostrarSelect(true);
                        } else {
                            const option = document.createElement('option');
                            option.disabled = true;
                            option.textContent = 'No se encontraron resultados';
                            selectElement.appendChild(option);
                            mostrarSelect(true);
                        }
                    }).catch(() => {
                        selectElement.innerHTML = '';
                        const option = document.createElement('option');
                        option.disabled = true;
                        option.textContent = 'Error al cargar datos';
                        selectElement.appendChild(option);
                        mostrarSelect(true);
                    });
            }

            function clienteSeleccionado() {
                const opcion = selectElement.options[selectElement.selectedIndex];
                if (opcion && !opcion.disabled) {
                    buscarInput.value = opcion.textContent;
                    mostrarSelect(false);
                }
            }

            buscarInput.addEventListener('input', () => cargarClientes(buscarInput.value.trim()));
            selectElement.addEventListener('change', clienteSeleccionado);
            selectElement.addEventListener('click', e => {
                if (e.target.tagName === 'OPTION') clienteSeleccionado();
            });

            document.addEventListener('click', e => {
                if (!selectElement.contains(e.target) && e.target !== buscarInput) {
                    mostrarSelect(false);
                }
            });

            if (buscarInput.value) cargarClientes(buscarInput.value);
        }

        // --------------------- PRODUCTOS ---------------------
        function inicializarBusquedaProducto(fila) {
            const buscarInput = fila.querySelector('.buscar-producto');
            const selectElement = fila.querySelector('.select-producto');
            const stockSpan = fila.querySelector('.stock-disponible');
            const precioInput = fila.querySelector('.precio-unitario');
            const cantidadInput = fila.querySelector('.cantidad');
            const totalInput = fila.querySelector('.precio-total');

            function mostrarSelect(mostrar) {
                selectElement.style.display = mostrar ? 'block' : 'none';
            }

            function cargarProductos(consulta) {
                if (!consulta) {
                    selectElement.innerHTML = '';
                    mostrarSelect(false);
                    return;
                }

                fetch('{{ route('productos.searchVentas') }}?q=' + encodeURIComponent(consulta))
                    .then(res => res.json())
                    .then(data => {
                        selectElement.innerHTML = '';
                        if (data.items && data.items.length) {
                            data.items.forEach(item => {
                                const option = document.createElement('option');
                                option.value = item.id;
                                option.textContent = item.text;
                                option.dataset.precio = item.precio_venta || 0;
                                option.dataset.stock = item.stock || 0;
                                selectElement.appendChild(option);
                            });
                            selectElement.selectedIndex = 0;
                            mostrarSelect(true);
                        } else {
                            const option = document.createElement('option');
                            option.disabled = true;
                            option.textContent = 'No se encontraron resultados';
                            selectElement.appendChild(option);
                            mostrarSelect(true);
                        }
                    }).catch(() => {
                        selectElement.innerHTML = '';
                        const option = document.createElement('option');
                        option.disabled = true;
                        option.textContent = 'Error al cargar datos';
                        selectElement.appendChild(option);
                        mostrarSelect(true);
                    });
            }

            function productoSeleccionado() {
                const opcion = selectElement.options[selectElement.selectedIndex];
                if (opcion && !opcion.disabled) {
                    buscarInput.value = opcion.textContent;
                    mostrarSelect(false);

                    const precio = parseFloat(opcion.dataset.precio) || 0;
                    const stock = parseInt(opcion.dataset.stock) || 0;
                    let cantidad = parseInt(cantidadInput.value) || 1;

                    // Límite de stock
                    cantidadInput.max = stock;
                    if (cantidad > stock) {
                        cantidad = stock;
                        cantidadInput.value = cantidad;
                    } else if (cantidad < 1) {
                        cantidad = 1;
                        cantidadInput.value = cantidad;
                    }

                    // Actualizar campos
                    precioInput.value = precio.toFixed(2);
                    stockSpan.textContent = stock;
                    totalInput.value = (cantidad * precio).toFixed(2);

                    selectElement.name = `productos[${fila.dataset.indice}][producto_id]`;

                    actualizarTotales();
                }
            }

            buscarInput.addEventListener('input', () => cargarProductos(buscarInput.value.trim()));
            selectElement.addEventListener('change', productoSeleccionado);
            selectElement.addEventListener('click', e => {
                if (e.target.tagName === 'OPTION') productoSeleccionado();
            });

            document.addEventListener('click', e => {
                if (!selectElement.contains(e.target) && e.target !== buscarInput) {
                    mostrarSelect(false);
                }
            });

            cantidadInput.addEventListener('input', function() {
                let cantidad = parseInt(this.value) || 1;
                const precio = parseFloat(precioInput.value) || 0;
                const stock = parseInt(stockSpan.textContent) || 0;

                if (cantidad > stock) this.value = stock;
                if (cantidad < 1) this.value = 1;

                totalInput.value = (parseInt(this.value) * precio).toFixed(2);
                actualizarTotales();
            });

            if (buscarInput.value) cargarProductos(buscarInput.value);
        }

        // --------------------- TOTALES ---------------------
        function actualizarTotales() {
            let subtotal = 0;
            document.querySelectorAll('.precio-total').forEach(input => {
                subtotal += parseFloat(input.value) || 0;
            });

            const descuento = parseFloat(document.getElementById('descuento').value) || 0;
            const iva = (subtotal - descuento) * 0.15;
            const total = subtotal - descuento + iva;

            document.getElementById('subtotal').value = subtotal.toFixed(2);
            document.getElementById('iva').value = iva.toFixed(2);
            document.getElementById('total').value = total.toFixed(2);
            document.querySelector('input[name="total_con_iva"]').value = total.toFixed(2);
        }

        // --------------------- INICIALIZAR ---------------------
        inicializarBusquedaCliente();

        const primeraFila = document.querySelector('.fila-producto');
        if (primeraFila) {
            inicializarBusquedaProducto(primeraFila);
        }

        // --------------------- AGREGAR FILA ---------------------
        document.getElementById('agregar-producto').addEventListener('click', function() {
            const lista = document.getElementById('lista-productos');
            const fila = document.createElement('tr');
            fila.classList.add('fila-producto', 'border-b', 'border-gray-200');
            fila.dataset.indice = indiceProducto;

            fila.innerHTML = `
            <td class="py-3">
                <div class="relative">
                    <input type="text" class="buscar-producto w-full px-4 py-2 border border-gray-300 rounded-md transition mb-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Buscar producto..." autocomplete="off" required>
                    <select class="select-producto w-full border border-gray-300 rounded-md absolute z-10 bg-white" name="productos[${indiceProducto}][producto_id]" size="5" style="height:auto; display:none;"></select>
                </div>
            </td>
            <td class="px-2">
                <input type="number" name="productos[${indiceProducto}][cantidad]" value="1" min="1" required class="cantidad w-full px-2 py-1 border border-gray-300 rounded-md text-center" />
            </td>
            <td class="px-2 text-center">
                <span class="stock-disponible text-sm text-gray-600">0</span>
            </td>
            <td class="px-2">
                <input type="text" name="productos[${indiceProducto}][precio_unitario]" value="0.00" required class="precio-unitario w-full px-2 py-1 border border-gray-300 rounded-md text-right" readonly />
            </td>
            <td class="px-2">
                <input type="text" name="productos[${indiceProducto}][precio_total]" value="0.00" required class="precio-total w-full px-2 py-1 border border-gray-300 rounded-md text-right" readonly />
            </td>
            <td class="text-center">
                <button type="button" class="eliminar-producto text-red-600 font-bold px-2 hover:text-red-800">X</button>
            </td>
        `;

            lista.appendChild(fila);
            inicializarBusquedaProducto(fila);

            fila.querySelector('.eliminar-producto').addEventListener('click', () => {
                fila.remove();
                actualizarTotales();
            });

            indiceProducto++;
        });

        // --------------------- ELIMINAR FILA ---------------------
        document.getElementById('lista-productos').addEventListener('click', function(e) {
            if (e.target.classList.contains('eliminar-producto')) {
                e.target.closest('.fila-producto').remove();
                actualizarTotales();
            }
        });

        // --------------------- DESCUENTO ---------------------
        document.getElementById('descuento').addEventListener('input', actualizarTotales);

        // --------------------- INICIO ---------------------
        actualizarTotales();
    });
</script>
