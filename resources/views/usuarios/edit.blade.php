<x-layouts.app>
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item :href="route('dashboard')">
            Inicio
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('usuarios.index')">
            Usuarios
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            Editar
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <x-form-usuario :usuario="$usuario" :action="route('usuarios.update', ['usuario' => $usuario->id])" :roles="$roles" method="PUT" titulo="Editar Usuario" />

</x-layouts.app>
