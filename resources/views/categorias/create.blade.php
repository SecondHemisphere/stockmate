<x-layouts.app>

    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item :href="route('dashboard')">
            Inicio
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('categorias.index')">
            Categorias
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            Crear
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <x-form-categoria :action="route('categorias.store')" method="POST" titulo="Crear Categoría" />
</x-layouts.app>
