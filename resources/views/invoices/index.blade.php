<x-layouts.app>

<div class="mb-4 flex justify-between items-center">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item :href="route('dashboard')">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            Facturas
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <a href="{{route('invoices.create')}}" class="btn btn-primary text-s px-6 py-2 rounded-lg">
        Nueva Factura
    </a>
</div>

<div>
    <table class="table-bordered">
        <thead>
            <tr>
                <th scope="col">
                    Número
                </th>
                <th scope="col">
                    Cliente
                </th>
                <th scope="col">
                    Monto Total
                </th>
                <th scope="col">
                    Descuento
                </th>
                <th scope="col">
                    Monto Con IVA
                </th>
                <th scope="col">
                    Fecha
                </th>
                <th scope="col">
                    Estado
                </th>
                <th scope="col">
                    Método (Pago)
                </th>
                <th scope="col" width="10px" class="text-center">
                    Acciones
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $invoice)
                <tr class="bg-white border-b border-[#e5d3b3]">
                    <td scope="row">
                        {{$invoice->number}}
                    </td>
                    <td>
                        {{$invoice->customer->name}}
                    </td>
                    <td>
                        {{$invoice->total_amount}} USD
                    </td>
                    <td>
                        {{$invoice->discount_amount}} USD
                    </td>
                    <td>
                        {{$invoice->total_with_iva}} USD
                    </td>
                    <td>
                        {{$invoice->sell_date}}
                    </td>
                    <td>
                        {{$invoice->payment_status}}
                    </td> 
                    <td>
                        {{$invoice->payment->payment_method}}
                    </td>
                    <td text-center whitespace-nowrap>
                        <div class="flex space-x-2">
                            <a href="{{route('invoices.show', $invoice)}}" class="btn-view px-4 py-2 bg-">
                                Ver
                            </a>              
                            <a href="{{route('invoices.edit', $invoice)}}" class="btn-edit px-4 py-2">
                                Editar
                            </a>
                    
                            <form class="delete-form" action="{{route('invoices.destroy', $invoice)}}" method="POST">
                                @csrf
                                @method('DELETE')
                    
                                <button class="btn-delete px-4 py-2">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

    <div class="mt-4">
        {{ $invoices->links() }}
    </div>

    @push('js')
        <script src="{{ mix('js/deleteConfirmation.js') }}"></script>
    @endpush

</x-layouts.app>