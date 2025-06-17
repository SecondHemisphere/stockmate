<x-layouts.app>
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item :href="route('dashboard')">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('categorias.index')">
            Categorias
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            Editar
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <x-form-categoria :categoria="$categoria" :action="route('categorias.update', ['categoria' => $categoria->id])" method="PUT" titulo="Editar Categoría" />
</x-layouts.app>
