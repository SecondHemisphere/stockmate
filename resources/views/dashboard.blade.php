@php
    $cardBase =
        'flex items-center justify-start gap-4 p-3 rounded-xl shadow-md cursor-pointer h-[130px] overflow-hidden transition-all hover:brightness-95';
@endphp

<x-layouts.app :title="__('Dashboard')">
    <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">

        <!-- Inventario Actual -->
        <div class="col-span-full text-xl font-bold text-gray-700">Inventario Actual</div>

        <!-- Stock Crítico -->
        <div id="openCriticalStockModal" class="{{ $cardBase }} bg-red-300 text-red-800">
            <i class="fas fa-exclamation-triangle text-4xl"></i>
            <div>
                <div class="text-lg font-semibold">Stock Crítico</div>
                <div class="text-3xl font-bold">{{ $stockCritico }}</div>
            </div>
        </div>

        <!-- Existencia Actual -->
        <div class="{{ $cardBase }} bg-teal-300 text-teal-900">
            <i class="fas fa-cube text-4xl"></i>
            <div>
                <div class="text-lg font-semibold">Existencia Actual</div>
                <div class="text-3xl font-bold">{{ $stockTotal }}</div>
            </div>
        </div>

        <!-- Existencia Vendida -->
        <div class="{{ $cardBase }} bg-blue-300 text-blue-900">
            <i class="fas fa-box-open text-4xl"></i>
            <div>
                <div class="text-lg font-semibold">Existencia Vendida</div>
                <div class="text-3xl font-bold">{{ $unidadesVendidas }}</div>
            </div>
        </div>

        <!-- Productos -->
        <div class="{{ $cardBase }} bg-sky-300 text-sky-900">
            <i class="fas fa-boxes text-4xl"></i>
            <div>
                <div class="text-lg font-semibold">Productos</div>
                <div class="text-3xl font-bold">{{ $productos }}</div>
            </div>
        </div>

        <!-- Categorías -->
        <div class="{{ $cardBase }} bg-teal-400 text-teal-900">
            <i class="fas fa-tags text-4xl"></i>
            <div>
                <div class="text-lg font-semibold">Categorías</div>
                <div class="text-3xl font-bold">{{ $categorias }}</div>
            </div>
        </div>

        <!-- Movimiento Comercial -->
        <div class="col-span-full text-xl font-bold text-gray-700">Movimiento Comercial</div>

        <!-- Ventas del Mes -->
        <div class="{{ $cardBase }} bg-blue-400 text-blue-900">
            <i class="fas fa-chart-line text-4xl"></i>
            <div>
                <div class="text-lg font-semibold">Ventas del Mes</div>
                <div class="text-3xl font-bold">{{ $gananciaMes }}</div>
            </div>
        </div>

        <!-- Ventas Hoy -->
        <div class="{{ $cardBase }}  bg-teal-400 text-teal-900">
            <i class="fas fa-shopping-bag text-4xl"></i>
            <div>
                <div class="text-lg font-semibold"> Ventas Hoy</div>
                <div class="text-3xl font-bold">{{ $ventasHoy }}</div>
            </div>
        </div>

        <!-- Importe Vendido Hoy -->
        <div class="{{ $cardBase }} bg-sky-400 text-sky-900">
            <i class="fas fa-cash-register text-4xl"></i>
            <div>
                <div class="text-lg font-semibold">Importe Vendido Hoy</div>
                <div class="text-3xl font-bold">{{ $montoVentasHoy }}</div>
            </div>
        </div>

        <!-- Beneficio Bruto -->
        <div class="{{ $cardBase }} bg-teal-500 text-teal-900">
            <i class="fas fa-dollar-sign text-4xl"></i>
            <div>
                <div class="text-lg font-semibold">Beneficio Bruto</div>
                <div class="text-3xl font-bold">{{ $gananciaTotal }}</div>
            </div>
        </div>

        <!-- Facturas -->
        <div class="{{ $cardBase }} bg-sky-500 text-sky-900">
            <i class="fas fa-file-invoice-dollar text-4xl"></i>
            <div>
                <div class="text-lg font-semibold">Facturas</div>
                <div class="text-3xl font-bold">{{ $totalFacturas }}</div>
            </div>
        </div>

        <!-- Personas -->
        <div class="col-span-full text-xl font-bold text-gray-700">Personas</div>

        <!-- Clientes -->
        <div class="{{ $cardBase }} bg-blue-400 text-blue-900">
            <i class="fas fa-users text-4xl"></i>
            <div>
                <div class="text-lg font-semibold">Clientes</div>
                <div class="text-3xl font-bold">{{ $clientes }}</div>
            </div>
        </div>

        <!-- Proveedores -->
        <div class="{{ $cardBase }} bg-teal-500 text-teal-900">
            <i class="fas fa-truck text-4xl"></i>
            <div>
                <div class="text-lg font-semibold">Proveedores</div>
                <div class="text-3xl font-bold">{{ $proveedores }}</div>
            </div>
        </div>

        <!-- Usuarios -->
        <div class="{{ $cardBase }} bg-blue-500 text-blue-900">
            <i class="fas fa-user text-4xl"></i>
            <div>
                <div class="text-lg font-semibold">Usuarios</div>
                <div class="text-3xl font-bold">{{ $usuarios }}</div>
            </div>
        </div>
    </div>

    <!-- Top Productos Vendidos -->
    <div class="col-span-full text-xl font-bold text-gray-700 mt-8 mb-3">Top Productos Vendidos</div>

    @forelse ($topVendidos as $prod)
        <div
            class="flex justify-between items-center p-4 bg-white rounded-lg shadow border border-gray-200 mt-2 mb-2 mr-1">
            <div class="font-semibold text-gray-700">{{ $prod->nombre }}</div>
            <div class="text-teal-700 font-bold text-lg">{{ number_format($prod->total_vendido) }} $</div>
        </div>
    @empty
        <div class="col-span-full text-center text-gray-500">No hay datos de productos vendidos aún.</div>
    @endforelse

    <!-- Modal Stock Crítico -->
    <div id="criticalStockModal"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div
            class="bg-white p-6 rounded-xl max-w-xl w-full max-h-[85vh] overflow-hidden shadow-2xl border-t-4 border-red-400 animate-fade-in">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold text-red-600 flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle text-red-600 text-3xl"></i>
                    Productos con Stock Crítico
                </h3>
                <button id="closeCriticalStockModal" class="text-gray-500 hover:text-red-700 text-xl">×</button>
            </div>

            <div class="overflow-y-auto max-h-64 space-y-2 pr-2" id="critical-stock-products">
                @forelse ($productosCriticos as $producto)
                    <div class="fade-in hidden p-2 border border-red-300 rounded bg-red-100 text-sm">
                        <strong>{{ $producto->nombre }}</strong> — Stock: <span
                            class="font-bold">{{ $producto->stock_actual }}</span>
                    </div>
                @empty
                    <div class="text-center text-gray-500">No hay productos críticos.</div>
                @endforelse
                <div id="loading" class="text-center py-2 text-gray-500">
                    <button class="px-4 py-2 bg-red-300 text-red-700 rounded" disabled>Cargando...</button>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

<script>
    document.getElementById('openCriticalStockModal').addEventListener('click', function() {
        const modal = document.getElementById('criticalStockModal');
        const loading = document.getElementById('loading');
        const items = document.querySelectorAll('#critical-stock-products .fade-in');

        modal.classList.remove('hidden');
        loading.style.display = 'block';

        setTimeout(() => {
            loading.style.display = 'none';
            items.forEach(item => item.classList.remove('hidden'));
        }, 1000);
    });

    document.getElementById('closeCriticalStockModal').addEventListener('click', function() {
        document.getElementById('criticalStockModal').classList.add('hidden');
    });

    document.getElementById('criticalStockModal').addEventListener('click', function(event) {
        if (event.target === this) {
            this.classList.add('hidden');
        }
    });
</script>
