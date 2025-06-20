<x-layouts.app>
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item :href="route('dashboard')">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('roles.index')">
            Roles
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            Editar
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <x-form-rol :rol="$rol" :action="route('roles.update', ['rol' => $rol->id])" method="PUT" titulo="Editar Rol" />
</x-layouts.app>
