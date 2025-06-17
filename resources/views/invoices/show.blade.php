<x-layouts.app>
    <flux:breadcrumbs class="mb-4 text-gray-600">
        <flux:breadcrumbs.item :href="route('dashboard')" class="hover:text-blue-500">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('invoices.index')" class="hover:text-blue-500">
            Facturas
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item class="text-blue-600">
            Ver
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="invoice-container">
        <div class="invoice-header">Factura de Venta</div>

        <div class="invoice-section">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="invoice-label">Cliente:</label>
                    <p>{{ $invoice->customer->name }}</p>
                </div>
                <div>
                    <label class="invoice-label">N° :</label>
                    <p>{{ $invoice->number }}</p>
                </div>
                <div>
                    <label class="invoice-label">Fecha:</label>
                    <p>{{ $invoice->sell_date }}</p>
                </div>
            </div>
        </div>

        <div class="invoice-section">
            <label class="invoice-label">Productos:</label>
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>SubTotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->sell_details as $item)
                        <tr>
                            <td>{{ $item->product->product_name }}</td>
                            <td>{{ $item->quantity_sold }}</td>
                            <td>{{ number_format($item->sold_price, 2) }}</td>
                            <td>{{ number_format($item->total_sold_price, 2) }}</td>
                        </tr>
                    @endforeach
                    @php
                        $ivaRate = 0.15;
                        $ivaAmount = $invoice->total_amount * $ivaRate;
                        $totalWithIva = $invoice->total_amount + $ivaAmount;
                    @endphp
                    <tr class="font-bold">
                        <td colspan="3" class="text-right">Monto Total:</td>
                        <td rowspan="4" class="text-right align-top">{{ number_format($invoice->total_amount, 2) }}<br>
                            {{ number_format($invoice->discount_amount, 2) }}<br>
                            {{ number_format($ivaAmount, 2) }}<br>
                            {{ number_format($totalWithIva, 2) }}
                        </td>
                    </tr>
                    <tr class="font-bold">
                        <td colspan="3" class="text-right">Descuento:</td>
                    </tr>
                    <tr class="font-bold">
                        <td colspan="3" class="text-right">IVA (15%):</td>
                    </tr>
                    <tr class="font-bold">
                        <td colspan="3" class="text-right">Total con IVA:</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="invoice-section">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="invoice-label">Método de Pago:</label>
                    <p>{{ $invoice->payment->payment_method }}</p>
                </div>
                <div>
                    <label class="invoice-label">Detalles del Pago:</label>
                    <p>{{ $invoice->payment->details }}</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

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
        margin-bottom: 20px;
    }

    .invoice-label {
        font-weight: bold;
        color: #444;
        display: block;
        margin-bottom: 5px;
    }

    .invoice-section p {
        color: #333;
        margin-bottom: 10px;
    }

    .invoice-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        background-color: #fff;
    }

    .invoice-table th {
        border: 1px solid #bbb;
        padding: 8px;
        text-align: left;
        background-color: #e6e6e6;
        color: #2d2d2d;
        font-weight: 600;
    }

    .invoice-table td {
        border: 1px solid #ccc;
        padding: 8px;
        background-color: #fdfdfd;
        color: #333;
    }

    .invoice-table tr.font-bold td {
        font-weight: bold;
    }

    .invoice-table tr.text-lg td {
        font-size: 1.2em;
    }

    .invoice-table td.text-right {
        text-align: right;
    }
</style>