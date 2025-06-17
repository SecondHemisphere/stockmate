<x-layouts.app>
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item :href="route('dashboard')">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('clientes.index')">
            Clientes
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            Editar
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <x-form-cliente :cliente="$cliente" :action="route('clientes.update', ['cliente' => $cliente->id])" method="PUT" titulo="Editar Cliente" />
</x-layouts.app>
