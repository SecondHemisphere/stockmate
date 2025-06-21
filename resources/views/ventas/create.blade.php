<x-layouts.app>

    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item :href="route('dashboard')">
            Inicio
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('ventas.index')">
            Ventas
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            Crear
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>
    
    <x-form-venta :action="route('ventas.store')" :clientes="$clientes" :productos="$productos" :metodosPago="$metodosPago" :numeroFactura="$numeroFactura"
        method="POST" titulo="Crear Venta" />
</x-layouts.app>
