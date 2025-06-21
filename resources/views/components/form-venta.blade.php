@props([
    'venta' => null,
    'clientes' => [],
    'productos' => [],
    'action',
    'method' => 'POST',
    'titulo' => 'Formulario de Venta',
    'number' => null,
    'methods' => [],
])

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
                <label for="cliente-search" class="block mb-2 font-semibold text-gray-800">Cliente</label>
                <input type="text" id="cliente-search" placeholder="Buscar cliente..." autocomplete="off"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md transition mb-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    value="{{ old('customer_name', $venta->cliente->nombre ?? '') }}">
                <select id="cliente-select" name="customer_id" size="5"
                    class="select-buscable w-full border border-gray-300 rounded-md absolute z-10 bg-white"
                    style="height:auto; display:none;">
                    @if (old('customer_id', $venta->cliente_id ?? null))
                        <option value="{{ old('customer_id', $venta->cliente_id) }}" selected>
                            {{ $venta->cliente->nombre ?? 'Cliente seleccionado' }}
                        </option>
                    @endif
                </select>
                @error('customer_id')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Número de Factura -->
            <div class="flex-1 min-w-[220px]">
                <label for="number" class="block mb-2 font-semibold text-gray-800">N° Factura</label>
                <input type="text" name="number" id="number" required
                    value="{{ old('number', $venta->numero_factura ?? $number) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Ejemplo: F0001234" {{ $number ? 'readonly' : '' }} />
                @error('number')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Fecha -->
            <div class="flex-1 min-w-[220px]">
                <label for="sell_date" class="block mb-2 font-semibold text-gray-800">Fecha</label>
                <input type="datetime-local" name="sell_date" id="sell_date" required
                    value="{{ old('sell_date', isset($venta->fecha) ? date('Y-m-d\TH:i', strtotime($venta->fecha)) : date('Y-m-d\TH:i')) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                @error('sell_date')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Productos -->
        <fieldset class="border border-gray-300 rounded-md p-4">
            <legend class="font-semibold text-gray-800 px-2">Productos</legend>

            <table class="w-full mt-2">
                <thead>
                    <tr class="border-b border-gray-300">
                        <th class="text-left pb-2">Producto</th>
                        <th class="text-center pb-2">Cantidad</th>
                        <th class="text-right pb-2">Precio</th>
                        <th class="text-right pb-2">SubTotal</th>
                        <th class="pb-2"></th>
                    </tr>
                </thead>
                <tbody id="product-list">
                    @php
                        $detalleVenta = old('products', $venta ? $venta->detalles_venta->toArray() : [[]]);
                    @endphp

                    @foreach ($detalleVenta as $index => $item)
                        <tr class="product-item border-b border-gray-200" data-index="{{ $index }}">
                            <td class="py-3">
                                <div class="relative">
                                    <input type="text"
                                        class="product-search w-full px-4 py-2 border border-gray-300 rounded-md transition mb-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Buscar producto..." autocomplete="off"
                                        value="{{ isset($item['product_id']) ? \App\Models\Product::find($item['product_id'])->nombre : '' }}">
                                    <select
                                        class="product-select w-full border border-gray-300 rounded-md absolute z-10 bg-white"
                                        name="products[{{ $index }}][product_id]" size="5"
                                        style="height:auto; display:none;">
                                        @if (isset($item['product_id']))
                                            <option value="{{ $item['product_id'] }}" selected>
                                                {{ \App\Models\Product::find($item['product_id'])->nombre }}
                                            </option>
                                        @endif
                                    </select>
                                </div>
                            </td>
                            <td class="px-2">
                                <input type="number" name="products[{{ $index }}][sold_quantity]"
                                    value="{{ $item['cantidad'] ?? 1 }}" min="1"
                                    class="sold-quantity w-full px-2 py-1 border border-gray-300 rounded-md text-center" />
                            </td>
                            <td class="px-2">
                                <input type="text" name="products[{{ $index }}][sold_price]"
                                    value="{{ number_format($item['precio_unitario'] ?? 0, 2) }}"
                                    class="price-input w-full px-2 py-1 border border-gray-300 rounded-md text-right"
                                    readonly />
                            </td>
                            <td class="px-2">
                                <input type="text" name="products[{{ $index }}][total_sold_price]"
                                    value="{{ number_format(($item['precio_unitario'] ?? 0) * ($item['cantidad'] ?? 0), 2) }}"
                                    class="total-sold-price w-full px-2 py-1 border border-gray-300 rounded-md text-right"
                                    readonly />
                            </td>
                            <td class="text-center">
                                <button type="button"
                                    class="remove-product text-red-600 font-bold px-2 hover:text-red-800">X</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="button" id="add-product"
                class="mt-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded transition">
                + Agregar producto
            </button>
        </fieldset>

        <div class="flex flex-wrap gap-6">
            <!-- Método de pago -->
            <div class="flex-1 min-w-[220px]">
                <label for="payment_method" class="block mb-2 font-semibold text-gray-800">Método de Pago</label>
                <select name="payment_method" id="payment_method" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Seleccionar método de pago</option>
                    @foreach ($methods as $methodOption)
                        <option value="{{ $methodOption->value }}"
                            {{ old('payment_method', $venta->metodo_pago ?? '') === $methodOption->value ? 'selected' : '' }}>
                            {{ $methodOption->name }}
                        </option>
                    @endforeach
                </select>
                @error('payment_method')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Observaciones -->
            <div class="flex-1 min-w-[220px]">
                <label for="details" class="block mb-2 font-semibold text-gray-800">Observaciones</label>
                <textarea name="details" id="details" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Detalles adicionales...">{{ old('details', $venta->observaciones ?? '') }}</textarea>
                @error('details')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Totales -->
        <div class="bg-gray-50 p-4 rounded-md">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="text-right">
                    <p class="font-semibold">Subtotal:</p>
                    <input type="text" id="subtotal_amount" value="0.00"
                        class="w-full px-2 py-1 border border-gray-300 rounded-md text-right bg-white" readonly>
                </div>
                <div class="text-right">
                    <p class="font-semibold">Descuento:</p>
                    <input type="number" id="discount" name="discount_amount"
                        value="{{ old('discount_amount', $venta->monto_descuento ?? 0) }}" min="0"
                        step="0.01" class="w-full px-2 py-1 border border-gray-300 rounded-md text-right">
                </div>
                <div class="text-right">
                    <p class="font-semibold">IVA (15%):</p>
                    <input type="text" id="iva_amount" value="0.00"
                        class="w-full px-2 py-1 border border-gray-300 rounded-md text-right bg-white" readonly>
                </div>
                <div class="text-right">
                    <p class="font-semibold">Total:</p>
                    <input type="text" id="total_with_iva" name="total_with_iva"
                        value="{{ old('total_with_iva', $venta->total_con_iva ?? 0.0) }}"
                        class="w-full px-2 py-1 border border-gray-300 rounded-md text-right bg-white font-bold"
                        readonly>
                </div>
            </div>
        </div>

        <!-- Botón Guardar -->
        <div class="flex justify-end mt-6">
            <button type="submit"
                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md transition">
                Guardar Factura
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
                // Variables globales
                let productIndex = {{ count($detalleVenta) }};

                // Inicializar select de cliente
                initSearchSelect('cliente', '{{ route('clientes.search') }}');

                // Inicializar selects de productos existentes
                document.querySelectorAll('.product-item').forEach(row => {
                    const index = row.dataset.index;
                    initSearchSelect(`products[${index}][product_id]`, "{{ route('productos.search') }}",
                    true);
                });

                // Agregar evento al botón de añadir producto
                document.getElementById('add-product').addEventListener('click', addProductRow);

                // Eventos para calcular totales
                document.getElementById('discount').addEventListener('input', updateTotals);

                // Función para inicializar selects de búsqueda
                function initSearchSelect(name, url, isProduct = false) {
                    const searchInput = document.getElementById(`${name}-search`);
                    const selectElement = document.getElementById(`${name}-select`);

                    if (!searchInput || !selectElement) return;

                    function showSelect(show) {
                        selectElement.style.display = show ? 'block' : 'none';
                    }

                    function loadItems(query) {
                        if (!query) {
                            selectElement.innerHTML = '';
                            showSelect(false);
                            return;
                        }

                        fetch(`${url}?q=${encodeURIComponent(query)}`)
                            .then(res => res.json())
                            .then(data => {
                                selectElement.innerHTML = '';

                                if (data.items && data.items.length) {
                                    data.items.forEach(item => {
                                        const option = document.createElement('option');
                                        option.value = item.id;
                                        option.textContent = item.text;
                                        if (isProduct) option.dataset.price = item.sold_price || 0;
                                        selectElement.appendChild(option);
                                    });
                                    selectElement.selectedIndex = 0;
                                    showSelect(true);
                                } else {
                                    const option = document.createElement('option');
                                    option.disabled = true;
                                    option.textContent = 'No se encontraron resultados';
                                    selectElement.appendChild(option);
                                    showSelect(true);
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                selectElement.innerHTML = '';
                                const option = document.createElement('option');
                                option.disabled = true;
                                option.textContent = 'Error al cargar datos';
                                selectElement.appendChild(option);
                                showSelect(true);
                            });
                    }

                    function itemSelected() {
                        const selectedOption = selectElement.options[selectElement.selectedIndex];
                        if (selectedOption && !selectedOption.disabled) {
                            searchInput.value = selectedOption.textContent;
                            showSelect(false);

                            if (isProduct) {
                                const row = selectElement.closest('.product-item');
                                const priceInput = row.querySelector('.price-input');
                                const price = parseFloat(selectedOption.dataset.price || 0);
                                priceInput.value = price.toFixed(2);
                                updateRowTotal(row);
                            }
                        }
                    }

                    searchInput.addEventListener('input', () => loadItems(searchInput.value.trim()));
                    selectElement.addEventListener('change', itemSelected);
                    selectElement.addEventListener('click', function(e) {
                        if (e.target.tagName === 'OPTION') {
                            itemSelected();
                        }
                    });

                    // Ocultar al hacer clic fuera
                    document.addEventListener('click', function(e) {
                            if (!selectElement.contains(e.target) {
                                    showSelect(false);
                                }
                            });

                        // Cargar inicialmente si hay valor
                        if (searchInput.value) {
                            loadItems(searchInput.value);
                        }
                    }

                    // Función para añadir nueva fila de producto
                    function addProductRow() {
                        const productList = document.getElementById('product-list');
                        const newRow = document.createElement('tr');
                        newRow.classList.add('product-item', 'border-b', 'border-gray-200');
                        newRow.dataset.index = productIndex;
                        newRow.innerHTML = `
                <td class="py-3">
                    <div class="relative">
                        <input type="text" class="product-search w-full px-4 py-2 border border-gray-300 rounded-md transition mb-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            placeholder="Buscar producto..." autocomplete="off">
                        <select class="product-select w-full border border-gray-300 rounded-md absolute z-10 bg-white" 
                            name="products[${productIndex}][product_id]" size="5"
                            style="height:auto; display:none;"></select>
                    </div>
                </td>
                <td class="px-2">
                    <input type="number" name="products[${productIndex}][sold_quantity]" value="1" min="1"
                        class="sold-quantity w-full px-2 py-1 border border-gray-300 rounded-md text-center" />
                </td>
                <td class="px-2">
                    <input type="text" name="products[${productIndex}][sold_price]" value="0.00"
                        class="price-input w-full px-2 py-1 border border-gray-300 rounded-md text-right" readonly />
                </td>
                <td class="px-2">
                    <input type="text" name="products[${productIndex}][total_sold_price]" value="0.00"
                        class="total-sold-price w-full px-2 py-1 border border-gray-300 rounded-md text-right" readonly />
                </td>
                <td class="text-center">
                    <button type="button"
                        class="remove-product text-red-600 font-bold px-2 hover:text-red-800">X</button>
                </td>
            `;

                        productList.appendChild(newRow);

                        // Inicializar el select de búsqueda para la nueva fila
                        initSearchSelect(`products[${productIndex}][product_id]`, '{{ route('productos.search') }}',
                            true);

                        // Agregar eventos a la nueva fila
                        const quantityInput = newRow.querySelector('.sold-quantity');
                        quantityInput.addEventListener('input', () => updateRowTotal(newRow));

                        const removeBtn = newRow.querySelector('.remove-product');
                        removeBtn.addEventListener('click', () => {
                            newRow.remove();
                            updateTotals();
                        });

                        productIndex++;
                    }

                    // Función para actualizar el total de una fila
                    function updateRowTotal(row) {
                        const quantityInput = row.querySelector('.sold-quantity');
                        const priceInput = row.querySelector('.price-input');
                        const totalInput = row.querySelector('.total-sold-price');

                        const quantity = parseFloat(quantityInput.value) || 0;
                        const price = parseFloat(priceInput.value) || 0;
                        const total = quantity * price;

                        totalInput.value = total.toFixed(2);
                        updateTotals();
                    }

                    // Función para actualizar todos los totales
                    function updateTotals() {
                        let subtotal = 0;
                        document.querySelectorAll('.total-sold-price').forEach(input => {
                            subtotal += parseFloat(input.value) || 0;
                        });

                        const discount = parseFloat(document.getElementById('discount').value) || 0;
                        const iva = (subtotal - discount) * 0.15;
                        const total = subtotal - discount + iva;

                        document.getElementById('subtotal_amount').value = subtotal.toFixed(2);
                        document.getElementById('iva_amount').value = iva.toFixed(2);
                        document.getElementById('total_with_iva').value = total.toFixed(2);
                    }

                    // Delegación de eventos para los inputs de cantidad
                    document.getElementById('product-list').addEventListener('input', function(e) {
                        if (e.target.classList.contains('sold-quantity')) {
                            updateRowTotal(e.target.closest('.product-item'));
                        }
                    });

                    // Delegación de eventos para los botones de eliminar
                    document.getElementById('product-list').addEventListener('click', function(e) {
                        if (e.target.classList.contains('remove-product')) {
                            e.target.closest('.product-item').remove();
                            updateTotals();
                        }
                    });

                    // Calcular totales iniciales
                    updateTotals();
                });
</script>
