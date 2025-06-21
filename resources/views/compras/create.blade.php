<x-layouts.app>
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item :href="route('dashboard')">
            Inicio
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('compras.index')">
            Compras
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            Crear
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <x-form-compra :action="route('compras.store')" :productos="$productos" method="POST" titulo="Crear Compra" />
</x-layouts.app>
