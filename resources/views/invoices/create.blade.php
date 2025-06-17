<x-layouts.app>
    <flux:breadcrumbs class="mb-4 text-gray-600">
        <flux:breadcrumbs.item :href="route('dashboard')" class="hover:text-blue-500">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('invoices.index')" class="hover:text-blue-500">Facturas</flux:breadcrumbs.item>
        <flux:breadcrumbs.item class="text-blue-600">Nueva</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="invoice-container">
        <div class="invoice-header">Factura de Venta</div>

        <form action="{{ route('invoices.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="invoice-section">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="flex items-center gap-2">
                        <label class="invoice-label min-w-[70px]" for="customer_id">Cliente:</label>
                        <select class="flex-1 border-gray-300 rounded-md" id="customer-select" name="customer_id" placeholder="Selecciona un cliente...">
                            @if(old('customer_id'))
                                <option value="{{ old('customer_id') }}" selected>
                                    {{ \App\Models\Customer::find(old('customer_id'))->name ?? 'Cliente seleccionado' }}
                                </option>
                            @endif
                        </select>
                        @error('customer_id')
                            <p class="text-red-600 text-xs mt-1">No has seleccionado ningún cliente</p>
                        @enderror
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="invoice-label">N°:</label>
                        <input type="text" name="number" value="{{ $number }}" class="w-full border-gray-300 rounded-md" readonly/>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="flex gap-2">
                            <label class="invoice-label">Fecha:</label>
                            <input type="date" name="sell_date" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-md" readonly />
                        </div>
                    </div>
                </div>
            </div>

            <div class="invoice-section mt-3">
                <div class="invoice-section mt-3">
                    <label class="invoice-label">Productos:</label>
                </div>   
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
                        <tr class="product-item" data-index="0">
                            <td colspan="5">
                                <select class="product-select w-full border-gray-300 rounded-md" name="products[0][product_id]"></select>
                            </td>
                            <td>
                                <input type="number" name="products[0][sold_quantity]" value="1" min="1" class="w-full border-gray-300 rounded-md sold-quantity">
                            </td>
                            <td>
                                <input type="text" name="products[0][sold_price]" class="w-full price-input border-gray-300 rounded-md" readonly>
                            </td>
                            <td>
                                <input type="text" name="products[0][total_sold_price]" value="0" class="w-full total-sold-price border-gray-300 rounded-md" readonly>
                            </td>
                            <td class="text-center">
                                <button type="button" class="remove-product text-red-600 text-lg font-bold px-2">X</button>
                            </td>
                        </tr>
                    </tbody>
                </table>                  
            </div>

            <div class="invoice-section">
                    <div class="flex items-center gap-2">
                        <div class="invoice-section grid grid-rows-1 gap-4">
                        <button type="button" id="add-product" class="mt-2 p-1 bg-blue-500 text-white rounded-md">
                            Agregar Productos
                        </button>
                        <div class="invoice-section grid grid-rows-1 gap-4">
                            <div>
                                <label class="invoice-label" for="payment_method">Método de Pago:</label>
                                <select name="payment_method" id="payment_method" class="w-full border-gray-300 rounded-md">
                                    <option value="">Seleccionar método de pago</option>
                                    @foreach($methods as $method)
                                        <option value="{{ $method->value }}">{{ $method->name }}</option>
                                    @endforeach
                                </select>
                                @error('payment_method')
                                    <p class="text-red-600 text-xs mt-1">Debes seleccionar un método de pago</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="invoice-label" for="details">Detalles del Pago:</label>
                                <textarea name="details" id="details"
                                class="w-full border border-gray-300 bg-gray-50 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-300"
                                rows="2" placeholder="Información adicional del pago..."></textarea>                
                                @error('details')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">  
                        <table class="invoice-table-totals">
                        <tbody>
                            <tr>
                                <td class="text-left font-bold">Monto Total:</td>
                                <td>
                                    <input type="number" id="total_amount" name="total_amount" value="0.00" min="0.00" step="0.01" class="w-full border-gray-300 rounded-md" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left font-bold">Descuento:</td>
                                <td>
                                    <input type="number" id="discount" name="discount_amount" value="0" min="0" class="w-full border-gray-300 rounded-md">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left font-bold">IVA (15%):</td>
                                <td>
                                    <input type="text" id="iva_amount" name="iva_amount" class="w-full border-gray-300 rounded-md" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left font-bold">Total con IVA:</td>
                                <td>
                                    <input type="text" id="total_with_iva" name="total_with_iva" value="0.00" min="0.00" step="0.01" class="w-full border-gray-300 rounded-md" readonly>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>

            <div class="invoice-section mt-3 justify-center">
                <button type="submit" class="justify-center px-6 py-2 bg-[#fca311] text-black rounded-md shadow">Guardar Factura y Pago</button>
            </div>
        </form>
    </div>
</x-layouts.app>

<script>
    let productIndex = 1;

    document.addEventListener('DOMContentLoaded', function () {
        initCustomerSelect('#customer-select', '{{ route('customers.search') }}');
        initProductSelect(0);
        attachEvents();
    });

    function initCustomerSelect(selector, url) {
        new TomSelect(selector, {
            valueField: 'id',
            labelField: 'text',
            searchField: 'text',
            load: function (query, callback) {
                if (!query.length) return callback();
                fetch(url + '?q=' + encodeURIComponent(query))
                    .then(response => response.json())
                    .then(data => callback(data.items || []))
                    .catch(() => callback());
            },
            placeholder: 'Buscar cliente...',
            allowEmptyOption: true
        });
    }
    function initProductSelect(index) {
        const selector = `select[name="products[${index}][product_id]"]`;

        new TomSelect(selector, {
            valueField: 'id',
            labelField: 'text',
            searchField: 'text',
            load: function (query, callback) {
                if (!query.length) return callback();
                fetch('{{ route('products.search2') }}?q=' + encodeURIComponent(query))
                    .then(response => response.json())
                    .then(data => callback(data.items || []))
                    .catch(() => callback());
            },
            placeholder: 'Buscar producto...',
            allowEmptyOption: true,
            render: {
                option: function (item, escape) {
                    return `<div>${escape(item.text)}</div>`;
                },
                item: function (item, escape) {
                    return `<div>${escape(item.text)}</div>`;
                }
            }
        });

        const selectElement = document.querySelector(selector);
        selectElement.addEventListener('change', () => {
            updatePrice(index);
        });
    }

    function attachEvents() {
        document.getElementById('add-product').addEventListener('click', () => {
            const row = `
                <tr class="product-item" data-index="${productIndex}">
                    <td colspan="5">
                        <select class="product-select w-full border-gray-300 rounded-md" name="products[${productIndex}][product_id]"></select>
                    </td>
                    <td>
                        <input type="number" name="products[${productIndex}][sold_quantity]" value="1" min="1" class="w-full border-gray-300 rounded-md sold-quantity">
                    </td>
                    <td>
                        <input type="text" name="products[${productIndex}][sold_price]" class="w-full price-input border-gray-300 rounded-md" readonly>
                    </td>
                    <td>
                        <input type="text" name="products[${productIndex}][total_sold_price]" value="0" class="w-full total-sold-price border-gray-300 rounded-md" readonly>
                    </td>
                    <td class="text-center">
                        <button type="button" class="remove-product text-red-600 text-lg font-bold px-2">X</button>
                    </td>
                </tr>
            `;
            document.getElementById('product-list').insertAdjacentHTML('beforeend', row);
            initProductSelect(productIndex);
            attachRowEvents(productIndex);
            productIndex++;
        });

        document.getElementById('discount').addEventListener('input', updateTotalAmount);
        document.getElementById('total_amount').addEventListener('input', updateTotalAmount);

        document.querySelectorAll('.remove-product').forEach(btn => {
            btn.addEventListener('click', function () {
                this.closest('tr').remove();
                updateTotalAmount();
            });
        });

        document.querySelectorAll('.sold-quantity').forEach(input => {
            input.addEventListener('input', function () {
                const index = parseInt(this.closest('.product-item').dataset.index);
                updatePrice(index);
            });
        });
    }

    function attachRowEvents(index) {
        const row = document.querySelector(`.product-item[data-index="${index}"]`);
        row.querySelector('.remove-product').addEventListener('click', function () {
            row.remove();
            updateTotalAmount();
        });

        row.querySelector('.sold-quantity').addEventListener('input', function () {
            updatePrice(index);
        });
    }

    function updatePrice(index) {
        const row = document.querySelector(`.product-item[data-index="${index}"]`);
        const select = row.querySelector('.product-select');
        const quantity = parseInt(row.querySelector('.sold-quantity').value) || 1;
        const priceInput = row.querySelector('.price-input');
        const totalInput = row.querySelector('.total-sold-price');

        const selectedOption = select.tomselect.options[select.value];

        if (selectedOption && selectedOption.sold_price !== undefined) {
            const price = selectedOption.sold_price;
            priceInput.value = parseFloat(price).toFixed(2);
            totalInput.value = (price * quantity).toFixed(2);
        } else {
            priceInput.value = '0.00';
            totalInput.value = '0.00';
        }
        updateTotalAmount();
    }

    function updateTotalAmount() {
        let totalAmount = 0;
        document.querySelectorAll('.total-sold-price').forEach(input => {
            totalAmount += parseFloat(input.value) || 0;
        });

        const discount = parseFloat(document.getElementById('discount').value) || 0;
        const netTotal = totalAmount - discount;
        const iva = netTotal * 0.15;
        const totalWithIva = netTotal + iva;

        document.getElementById('total_amount').value = netTotal.toFixed(2);
        document.getElementById('iva_amount').value = iva.toFixed(2);
        document.getElementById('total_with_iva').value = totalWithIva.toFixed(2);
    }
</script>
<style>
    body {
        background-color: #f7f5f2; 
        color: #3d3d3d;
    }

    .invoice-container {
        background-color: #fff;
        padding: 40px;
        border: 1px solid #bbb;
        max-width: 1000px;
        margin: auto;
        box-shadow: 0 0 12px rgba(0, 0, 0, 0.08);
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
    }

    .invoice-label {
        font-weight: bold;
        color: #444;
    }

    .invoice-section input[type="text"],
    .invoice-section input[type="number"] {
        width: 100%;
        max-width: 220px;
        padding: 6px 10px;
        border: 1px solid #ccc;
        background-color: #fafafa;
        color: #333;
        font-family: inherit;
    }

    .invoice-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1px;
        background-color: #fff;
    }

    .invoice-table th {
        border: 1px solid #bbb;
        padding: 5px;
        text-align: left;
        background-color: #e6e6e6;
        color: #2d2d2d;
        font-weight: 600;
    }

    .invoice-table td {
        border: 1px solid #ccc;
        padding: 2px;
        background-color: #fdfdfd;
        color: #333;
    }

    .invoice-table-totals {
        width: 100%;
        border-collapse: collapse;
        margin-top: 3px;
        margin-bottom: 3px;
        margin-left: 135px;
        background-color: #e6e6e6;
    }

    .invoice-table-totals th {
        border: 1px solid #bbb;
        padding: 2px;
        text-align: left;
        background-color: #e6e6e6;
        color: #2d2d2d;
        font-weight: 600;
    }

    .invoice-table-totals td {
        border: 1px solid #ccc;
        padding: 2px;
        text-align: left;
        background-color: #fdfdfd;
        color: #333;
    }

    .total-section {
        text-align: right;
        margin-top: 20px;
        font-size: 18px;
        font-weight: bold;
        color: #2f2f2f;
    } 
    
    .invoice-section select {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        background-color: #fafafa;
        font-family: inherit;
        color: #333;
        font-size: 14px;
        transition: border-color 0.3s ease;
    }

    .invoice-section textarea {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ccc;
        border-radius: 6px;
        background-color: #fafafa;
        font-family: inherit;
        color: #333;
        font-size: 14px;
        transition: border-color 0.3s ease;
        min-height: 80px; 
    }

    .invoice-section textarea:focus {
        border-color: #a3a3a3;
        outline: none;
        background-color: #fff;
    }

    .invoice-section select:focus {
        border-color: #a3a3a3;
        outline: none;
        background-color: #fff;
    }

    .invoice-footer {
        margin-top: 40px;
        font-size: 12px;
        color: #666;
        text-align: center;
        border-top: 1px solid #ccc;
        padding-top: 10px;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }

    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    } 
</style>
