<x-layouts.app>

    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item :href="route('dashboard')">
            Inicio
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('roles.index')">
            Roles
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            Crear
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <x-form-rol :permisos="$permisos" :action="route('roles.store')" method="POST" titulo="Crear Rol" />

</x-layouts.app>
