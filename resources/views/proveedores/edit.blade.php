<x-layouts.app>
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item :href="route('dashboard')">
            Inicio
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('proveedores.index')">
            Proveedores
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            Editar
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <x-form-proveedor :proveedor="$proveedor" :action="route('proveedores.update', ['proveedor' => $proveedor->id])" method="PUT" titulo="Editar Proveedor" />
</x-layouts.app>
