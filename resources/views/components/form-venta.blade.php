@props([
    'venta' => null,
    'clientes' => [], // colección o array de clientes para el select (no usado directamente en TomSelect, pero útil para blade components)
    'productos' => [], // productos para seleccionar (no usado directamente en TomSelect, pero útil para blade components)
    'action',
    'method' => 'POST',
    'titulo' => 'Formulario de Venta',
    'number' => null, // For invoice number, assuming it's passed or generated
    'methods' => [], // Payment methods, assuming they are passed as a collection/array of objects with value and name
])

    <div class="invoice-container">
        <h2 class="invoice-header">{{ $titulo }}</h2>

        <form action="{{ $action }}" method="POST" class="space-y-6">
            @csrf
            @if (in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE']))
                @method($method)
            @endif

            <div class="invoice-section grid grid-cols-1 sm:grid-cols-3 gap-4">
                {{-- Cliente --}}
                <div class="flex items-center gap-2">
                    <label class="invoice-label min-w-[70px]" for="customer_id">Cliente:</label>
                    <select class="flex-1 border-gray-300 rounded-md" id="customer-select" name="customer_id"
                        placeholder="Selecciona un cliente..." required>
                        @if (old('customer_id', $venta->cliente_id ?? ''))
                            <option value="{{ old('customer_id', $venta->cliente_id ?? '') }}" selected>
                                {{ \App\Models\Customer::find(old('customer_id', $venta->cliente_id ?? ''))->name ?? 'Cliente seleccionado' }}
                            </option>
                        @endif
                    </select>
                    @error('customer_id')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Número de Factura --}}
                <div class="flex items-center gap-2">
                    <label class="invoice-label min-w-[70px]" for="number">N° Factura:</label>
                    <input type="text" name="number" id="number" required
                        value="{{ old('number', $venta->numero_factura ?? $number) }}"
                        class="w-full border-gray-300 rounded-md" placeholder="Ejemplo: F0001234"
                        {{ $number ? 'readonly' : '' }} />
                    @error('number')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Fecha --}}
                <div class="flex items-center gap-2">
                    <label class="invoice-label min-w-[70px]" for="sell_date">Fecha:</label>
                    <input type="datetime-local" name="sell_date" id="sell_date" required
                        value="{{ old('sell_date', isset($venta->fecha) ? date('Y-m-d\TH:i', strtotime($venta->fecha)) : date('Y-m-d\TH:i')) }}"
                        class="w-full border-gray-300 rounded-md" />
                    @error('sell_date')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Productos y Cantidades --}}
            <fieldset class="border border-gray-300 rounded-md p-4">
                <legend class="font-semibold text-gray-800 mb-2">Productos</legend>

                <table class="invoice-table">
                    <thead>
                        <tr>
                            <th colspan="5">Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>SubTotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="product-list">
                        @php
                            $detalleVenta = old('products', $venta ? $venta->detalles_venta->toArray() : [[]]); // Ensure at least one empty row
                        @endphp

                        @foreach ($detalleVenta as $index => $item)
                            <tr class="product-item" data-index="{{ $index }}">
                                <td colspan="5">
                                    <select class="product-select w-full border-gray-300 rounded-md"
                                        name="products[{{ $index }}][product_id]" required>
                                        @if (isset($item['product_id']))
                                            <option value="{{ $item['product_id'] }}" selected>
                                                {{ \App\Models\Product::find($item['product_id'])->nombre ?? 'Producto seleccionado' }}
                                            </option>
                                        @endif
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="products[{{ $index }}][sold_quantity]"
                                        value="{{ $item['cantidad'] ?? 1 }}" min="1"
                                        class="w-full border-gray-300 rounded-md sold-quantity" />
                                </td>
                                <td>
                                    <input type="text" name="products[{{ $index }}][sold_price]"
                                        value="{{ number_format($item['precio_unitario'] ?? 0, 2) }}"
                                        class="w-full price-input border-gray-300 rounded-md" readonly />
                                </td>
                                <td>
                                    <input type="text" name="products[{{ $index }}][total_sold_price]"
                                        value="{{ number_format(($item['precio_unitario'] ?? 0) * ($item['cantidad'] ?? 0), 2) }}"
                                        class="w-full total-sold-price border-gray-300 rounded-md" readonly />
                                </td>
                                <td class="text-center">
                                    <button type="button"
                                        class="remove-product text-red-600 text-lg font-bold px-2">X</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button type="button" id="add-product"
                    class="mt-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded transition">
                    + Agregar producto
                </button>
            </fieldset>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    {{-- Método de pago --}}
                    <div>
                        <label for="payment_method" class="block mb-2 font-semibold text-gray-800">Método de
                            Pago</label>
                        <select name="payment_method" id="payment_method" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 transition">
                            <option value="">Seleccionar método de pago</option>
                            @foreach ($methods as $methodOption)
                                <option value="{{ $methodOption->value }}"
                                    {{ old('payment_method', $venta->metodo_pago ?? '') === $methodOption->value ? 'selected' : '' }}>
                                    {{ $methodOption->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('payment_method')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Observaciones / Detalles del Pago --}}
                    <div class="mt-4">
                        <label for="details" class="block mb-2 font-semibold text-gray-800">Detalles del Pago /
                            Observaciones</label>
                        <textarea name="details" id="details" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 transition"
                            placeholder="Información adicional del pago o comentarios...">{{ old('details', $venta->observaciones ?? '') }}</textarea>
                        @error('details')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Totales --}}
                <div class="flex flex-col items-end justify-end">
                    <table class="invoice-table-totals w-full max-w-sm">
                        <tbody>
                            <tr>
                                <td class="text-left font-bold">Monto Total:</td>
                                <td>
                                    <input type="number" id="total_amount" name="total_amount"
                                        value="{{ old('total_amount', $venta->monto_total ?? 0.0) }}" min="0.00"
                                        step="0.01" class="w-full border-gray-300 rounded-md text-right px-2 py-1"
                                        readonly>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left font-bold">Descuento:</td>
                                <td>
                                    <input type="number" id="discount" name="discount_amount"
                                        value="{{ old('discount_amount', $venta->monto_descuento ?? 0) }}"
                                        min="0" step="0.01"
                                        class="w-full border-gray-300 rounded-md text-right px-2 py-1">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left font-bold">IVA (15%):</td>
                                <td>
                                    <input type="text" id="iva_amount" name="iva_amount"
                                        value="{{ number_format(($venta->monto_total ?? 0) * 0.15, 2) }}"
                                        class="w-full border-gray-300 rounded-md text-right px-2 py-1" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left font-bold">Total con IVA:</td>
                                <td>
                                    <input type="text" id="total_with_iva" name="total_with_iva"
                                        value="{{ old('total_with_iva', $venta->total_con_iva ?? 0.0) }}"
                                        min="0.00" step="0.01"
                                        class="w-full border-gray-300 rounded-md text-right px-2 py-1" readonly>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Botón Guardar --}}
            <div class="flex justify-center mt-6">
                <button type="submit" class="px-6 py-2 bg-[#fca311] text-black rounded-md shadow font-bold text-sm">
                    Guardar Factura y Pago
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>

@push('scripts')
    {{-- TomSelect CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    {{-- TomSelect JS --}}
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <script>
        let productIndex =
            {{ count(old('products', $venta ? $venta->detalles_venta->toArray() : [])) > 0 ? count(old('products', $venta ? $venta->detalles_venta->toArray() : [])) : 1 }};

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Customer Select
            initCustomerSelect('#customer-select', '{{ route('customers.search') }}');

            // Initialize Product Selects for existing rows (if any)
            document.querySelectorAll('.product-item').forEach((row, index) => {
                initProductSelect(index);
            });
            // If there are no existing product rows (new invoice), ensure at least one select is initialized
            if (document.querySelectorAll('.product-item').length === 0) {
                addProductRow(); // Add an initial empty row
            }

            attachEvents(); // Attach all dynamic event listeners

            updateTotalAmount(); // Calculate initial totals
        });

        function initCustomerSelect(selector, url) {
            new TomSelect(selector, {
                valueField: 'id',
                labelField: 'text', // Assuming your search API returns 'text' for display
                searchField: 'text',
                load: function(query, callback) {
                    if (!query.length) return callback();
                    fetch(url + '?q=' + encodeURIComponent(query))
                        .then(response => response.json())
                        .then(data => callback(data.items || []))
                        .catch(() => callback());
                },
                placeholder: 'Buscar cliente...',
                allowEmptyOption: true,
                create: false, // Prevents creating new options
                render: {
                    option: function(item, escape) {
                        return `<div>${escape(item.text)}</div>`;
                    },
                    item: function(item, escape) {
                        return `<div>${escape(item.text)}</div>`;
                    }
                }
            });
        }

        function initProductSelect(index) {
            const selector = `select[name="products[${index}][product_id]"]`;
            const selectElement = document.querySelector(selector);

            if (!selectElement) return; // Ensure the element exists

            new TomSelect(selectElement, {
                valueField: 'id',
                labelField: 'text', // Assuming your search API returns 'text' for display
                searchField: 'text',
                load: function(query, callback) {
                    if (!query.length) return callback();
                    fetch('{{ route('products.search2') }}?q=' + encodeURIComponent(query))
                        .then(response => response.json())
                        .then(data => callback(data.items || []))
                        .catch(() => callback());
                },
                placeholder: 'Buscar producto...',
                allowEmptyOption: true,
                create: false, // Prevents creating new options
                render: {
                    option: function(item, escape) {
                        // Ensure 'sold_price' is included if available
                        const priceInfo = item.sold_price ? ` ($${item.sold_price.toFixed(2)})` : '';
                        return `<div>${escape(item.text)}${priceInfo}</div>`;
                    },
                    item: function(item, escape) {
                        return `<div>${escape(item.text)}</div>`;
                    }
                },
                onChange: function(value) {
                    // This is crucial: when a product is selected, update its price and recalculate totals
                    const row = this.wrapper.closest('.product-item');
                    const currentRowIndex = parseInt(row.dataset.index);
                    updatePrice(currentRowIndex);
                }
            });

            // If an old value exists, set it and trigger change to load price
            const oldProductId = selectElement.value;
            if (oldProductId) {
                // Fetch the product details to get its price
                fetch('{{ route('products.search2') }}?id=' + oldProductId)
                    .then(response => response.json())
                    .then(data => {
                        if (data.item) {
                            const product = data.item;
                            // Add the selected option to TomSelect's cache if not already there
                            selectElement.tomselect.addOption({
                                id: product.id,
                                text: product.name, // Assuming product object has a 'name'
                                sold_price: product.price // Assuming product object has a 'price'
                            });
                            selectElement.tomselect.setValue(product.id);
                            updatePrice(index);
                        }
                    })
                    .catch(error => console.error('Error fetching product details:', error));
            }
        }

        function attachEvents() {
            document.getElementById('add-product').addEventListener('click', addProductRow);

            document.getElementById('discount').addEventListener('input', updateTotalAmount);

            // Initial attachment for existing remove buttons and quantity inputs
            document.getElementById('product-list').addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-product')) {
                    e.target.closest('tr').remove();
                    updateTotalAmount();
                }
            });

            document.getElementById('product-list').addEventListener('input', function(e) {
                if (e.target.classList.contains('sold-quantity')) {
                    const index = parseInt(e.target.closest('.product-item').dataset.index);
                    updatePrice(index);
                }
            });
        }

        function addProductRow() {
            const productList = document.getElementById('product-list');
            const newRow = document.createElement('tr');
            newRow.classList.add('product-item');
            newRow.dataset.index = productIndex;
            newRow.innerHTML = `
                <td colspan="5">
                    <select class="product-select w-full border-gray-300 rounded-md"
                        name="products[${productIndex}][product_id]" required></select>
                </td>
                <td>
                    <input type="number" name="products[${productIndex}][sold_quantity]" value="1" min="1"
                        class="w-full border-gray-300 rounded-md sold-quantity" />
                </td>
                <td>
                    <input type="text" name="products[${productIndex}][sold_price]" value="0.00"
                        class="w-full price-input border-gray-300 rounded-md" readonly />
                </td>
                <td>
                    <input type="text" name="products[${productIndex}][total_sold_price]" value="0.00"
                        class="w-full total-sold-price border-gray-300 rounded-md" readonly />
                </td>
                <td class="text-center">
                    <button type="button" class="remove-product text-red-600 text-lg font-bold px-2">X</button>
                </td>
            `;
            productList.appendChild(newRow);
            initProductSelect(productIndex); // Initialize TomSelect for the new row
            productIndex++;
            updateTotalAmount();
        }

        function updatePrice(index) {
            const row = document.querySelector(`.product-item[data-index="${index}"]`);
            if (!row) return; // Exit if row no longer exists (e.g., deleted)

            const selectElement = row.querySelector('.product-select');
            const quantityInput = row.querySelector('.sold-quantity');
            const priceInput = row.querySelector('.price-input');
            const totalInput = row.querySelector('.total-sold-price');

            const quantity = parseInt(quantityInput.value) || 1;
            const tomSelectInstance = selectElement.tomselect;

            let price = 0;
            if (tomSelectInstance && tomSelectInstance.items.length > 0) {
                const selectedOption = tomSelectInstance.options[tomSelectInstance.items[
                0]]; // Get the selected option object
                if (selectedOption && selectedOption.sold_price !== undefined) {
                    price = parseFloat(selectedOption.sold_price);
                }
            }

            priceInput.value = price.toFixed(2);
            totalInput.value = (price * quantity).toFixed(2);

            updateTotalAmount();
        }

        function updateTotalAmount() {
            let totalAmount = 0;
            document.querySelectorAll('.total-sold-price').forEach(input => {
                totalAmount += parseFloat(input.value) || 0;
            });

            const discountInput = document.getElementById('discount');
            const discount = parseFloat(discountInput.value) || 0;

            const netTotal = totalAmount - discount;
            const ivaRate = 0.15; // Assuming 15% IVA
            const iva = netTotal * ivaRate;
            const totalWithIva = netTotal + iva;

            document.getElementById('total_amount').value = Math.max(0, netTotal).toFixed(
            2); // Ensure total doesn't go below 0
            document.getElementById('iva_amount').value = Math.max(0, iva).toFixed(2);
            document.getElementById('total_with_iva').value = Math.max(0, totalWithIva).toFixed(2);
        }
    </script>
@endpush

<style>
    body {
        background-color: #f7f5f2;
        color: #3d3d3d;
        font-family: 'Arial', sans-serif;
        /* Added a general font-family for better consistency */
    }

    .invoice-container {
        background-color: #fff;
        padding: 40px;
        border: 1px solid #bbb;
        max-width: 1000px;
        margin: auto;
        box-shadow: 0 0 12px rgba(0, 0, 0, 0.08);
        border-radius: 8px;
        /* Added border-radius for softer edges */
    }

    .invoice-header {
        text-align: center;
        font-size: 26px;
        font-weight: bold;
        margin-bottom: 30px;
        text-transform: uppercase;
        color: #2f2f2f;
        border-bottom: 2px solid #d6d6d6;
        padding-bottom: 10px;
        letter-spacing: 1px;
    }

    .invoice-section {
        margin-bottom: 5px;
        /* Reduced margin for tighter layout */
    }

    .invoice-label {
        font-weight: bold;
        color: #444;
        white-space: nowrap;
        /* Prevent label from wrapping */
    }

    /* General input styling */
    .invoice-section input[type="text"],
    .invoice-section input[type="number"],
    .invoice-section input[type="datetime-local"],
    .invoice-section select,
    .invoice-section textarea {
        width: 100%;
        padding: 8px 12px;
        /* Increased padding for better ergonomics */
        border: 1px solid #ccc;
        border-radius: 6px;
        background-color: #fafafa;
        color: #333;
        font-family: inherit;
        font-size: 14px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        /* Added box-shadow transition */
    }

    .invoice-section input:focus,
    .invoice-section select:focus,
    .invoice-section textarea:focus {
        border-color: #a3a3a3;
        outline: none;
        background-color: #fff;
        box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
        /* Indigo focus ring */
    }

    /* Specific overrides for smaller inputs */
    .invoice-section input[type="number"].w-24 {
        max-width: 96px;
        /* 24 Tailwind units */
    }

    .invoice-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        /* Adjusted margin */
        background-color: #fff;
        border-radius: 6px;
        /* Rounded corners for table */
        overflow: hidden;
        /* Ensures rounded corners are visible */
    }

    .invoice-table th {
        border: 1px solid #bbb;
        padding: 8px;
        /* Increased padding */
        text-align: left;
        background-color: #e6e6e6;
        color: #2d2d2d;
        font-weight: 600;
        font-size: 14px;
    }

    .invoice-table td {
        border: 1px solid #ccc;
        padding: 6px;
        /* Increased padding */
        background-color: #fdfdfd;
        color: #333;
        font-size: 13px;
    }

    /* Adjust specific input sizes within the table if needed */
    .invoice-table .sold-quantity,
    .invoice-table .price-input,
    .invoice-table .total-sold-price {
        padding: 6px 8px;
        /* Smaller padding for table inputs */
        font-size: 13px;
    }

    .invoice-table-totals {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        /* Adjusted margin */
        margin-bottom: 15px;
        background-color: #e6e6e6;
        /* Consistent background */
        border-radius: 6px;
        overflow: hidden;
    }

    .invoice-table-totals th,
    .invoice-table-totals td {
        border: 1px solid #bbb;
        padding: 8px 12px;
        text-align: right;
        /* Align totals to the right */
        background-color: #fdfdfd;
        color: #333;
        font-size: 14px;
    }

    .invoice-table-totals td:first-child {
        text-align: left;
        /* Keep labels left-aligned */
        font-weight: bold;
        background-color: #e6e6e6;
        /* Label column background */
    }

    .total-section {
        text-align: right;
        margin-top: 20px;
        font-size: 18px;
        font-weight: bold;
        color: #2f2f2f;
    }

    /* Style for buttons */
    .bg-indigo-600 {
        background-color: #4f46e5;
    }

    .hover\:bg-indigo-700:hover {
        background-color: #4338ca;
    }

    .bg-red-600 {
        background-color: #dc2626;
    }

    .hover\:bg-red-700:hover {
        background-color: #b91c1c;
    }

    .bg-[#fca311] {
        background-color: #fca311;
    }

    .bg-[#fca311]:hover {
        background-color: #e09100;
    }

    /* Remove spin buttons from number inputs */
    input[type="number"] {
        -moz-appearance: textfield;
    }

    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
