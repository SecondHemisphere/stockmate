<x-layouts.app>

    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item :href="route('dashboard')">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('proveedores.index')">
            Proveedores
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            Crear
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <x-form-proveedor :action="route('proveedores.store')" method="POST" titulo="Crear Proveedores" />
</x-layouts.app>
