<x-layouts.app>

    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item :href="route('dashboard')">
            Inicio
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('clientes.index')">
            Clientes
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            Crear
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <x-form-cliente :action="route('clientes.store')" method="POST" titulo="Crear Cliente" />
</x-layouts.app>
