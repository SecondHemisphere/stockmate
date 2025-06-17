@php
    $cardBase = "flex items-center justify-start gap-4 p-3 rounded-xl shadow-md cursor-pointer h-[130px] overflow-hidden transition-all hover:brightness-110";
@endphp

<x-layouts.app :title="__('Dashboard')">
    <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">

        <!-- Inventario Actual -->
        <div class="col-span-full text-xl font-bold text-gray-700">Inventario Actual</div>

        <!-- Stock Crítico -->
        <div id="openCriticalStockModal" class="{{ $cardBase }} bg-red-500 text-white">
            <i class="fas fa-exclamation-triangle text-4xl text-white"></i>
            <div>
                <div class="text-lg font-semibold">Stock Crítico</div>
                <div class="text-3xl font-bold"> 1 </div>
            </div>
        </div>

        <!-- Existencia Actual -->
        <div class="{{ $cardBase }} bg-cyan-700 text-white">
            <i class="fas fa-cube text-4xl text-white"></i>
            <div>
                <div class="text-lg font-semibold">Existencia Actual</div>
                <div class="text-3xl font-bold"> 1 </div>
            </div>
        </div>

        <!-- Existencia Vendida -->
        <div class="{{ $cardBase }} bg-emerald-600 text-white">
            <i class="fas fa-box-open text-4xl text-white"></i>
            <div>
                <div class="text-lg font-semibold">Existencia Vendida</div>
                <div class="text-3xl font-bold"> 1 </div>
            </div>
        </div>

        <!-- Productos -->
        <div class="{{ $cardBase }} bg-yellow-300 text-gray-800">
            <i class="fas fa-boxes text-4xl text-gray-800"></i>
            <div>
                <div class="text-lg font-semibold">Productos</div>
                <div class="text-3xl font-bold"> 1 </div>
            </div>
        </div>

        <!-- Categorías -->
        <div class="{{ $cardBase }} bg-orange-400 text-white">
            <i class="fas fa-tags text-4xl text-white"></i>
            <div>
                <div class="text-lg font-semibold">Categorías</div>
                <div class="text-3xl font-bold"> 1 </div>
            </div>
        </div>

        <!-- Movimiento Comercial -->
        <div class="col-span-full text-xl font-bold text-gray-700">Movimiento Comercial</div>

        <!-- Ventas del mes -->
        <div class="{{ $cardBase }} bg-indigo-600 text-white">
            <i class="fas fa-chart-line text-4xl text-white"></i>
            <div>
                <div class="text-lg font-semibold">Ventas del mes</div>
                <div class="text-3xl font-bold"> 1 </div>
            </div>
        </div>

        <!-- Importe Vendido -->
        <div class="{{ $cardBase }} bg-teal-600 text-white">
            <i class="fas fa-cash-register text-4xl text-white"></i>
            <div>
                <div class="text-lg font-semibold">Importe Vendido</div>
                <div class="text-3xl font-bold"> 1 </div>
            </div>
        </div>

        <!-- Beneficio Bruto -->
        <div class="{{ $cardBase }} bg-green-600 text-white">
            <i class="fas fa-dollar-sign text-4xl text-white"></i>
            <div>
                <div class="text-lg font-semibold">Beneficio Bruto</div>
                <div class="text-3xl font-bold"> 1 </div>
            </div>
        </div>

        <!-- Facturas -->
        <div class="{{ $cardBase }} bg-slate-600 text-white">
            <i class="fas fa-file-invoice-dollar text-4xl text-white"></i>
            <div>
                <div class="text-lg font-semibold">Facturas</div>
                <div class="text-3xl font-bold"> 1 </div>
            </div>
        </div>

        <!-- Personas -->
        <div class="col-span-full text-xl font-bold text-gray-700">Personas</div>

        <!-- Clientes -->
        <div class="{{ $cardBase }} bg-sky-500 text-white">
            <i class="fas fa-users text-4xl text-white"></i>
            <div>
                <div class="text-lg font-semibold">Clientes</div>
                <div class="text-3xl font-bold"> 1 </div>
            </div>
        </div>

        <!-- Proveedores -->
        <div class="{{ $cardBase }} bg-blue-500 text-white">
            <i class="fas fa-truck text-4xl text-white"></i>
            <div>
                <div class="text-lg font-semibold truncate">Proveedores</div>
                <div class="text-3xl font-bold"> 1 </div>
            </div>
        </div>

        <!-- Usuarios -->
        <div class="{{ $cardBase }} bg-gray-800 text-white">
            <i class="fas fa-user text-4xl text-white"></i>
            <div>
                <div class="text-lg font-semibold">Usuarios</div>
                <div class="text-3xl font-bold"> 1 </div>
            </div>
        </div>
    </div>

    <!-- Modal Stock Crítico -->
    <div id="criticalStockModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white p-6 rounded-xl max-w-xl w-full max-h-[85vh] overflow-hidden shadow-2xl border-t-4 border-yellow-500 animate-fade-in">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold text-yellow-600 flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle text-yellow-600 text-3xl"></i>
                    Productos con Stock Crítico
                </h3>
                <button id="closeCriticalStockModal" class="text-gray-500 hover:text-red-500 text-xl">×</button>
            </div>

            <div class="overflow-y-auto max-h-64 space-y-2 pr-2" id="critical-stock-products">
                <div id="loading" class="text-center py-2 text-gray-500">
                    <button class="px-4 py-2 bg-red-500 text-white rounded" disabled>Cargando...</button>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

<script>
    document.getElementById('openCriticalStockModal').addEventListener('click', function () {
        const modal = document.getElementById('criticalStockModal');
        const loading = document.getElementById('loading');
        const items = document.querySelectorAll('#critical-stock-products .fade-in');

        modal.classList.remove('hidden');
        loading.style.display = 'block';

        // Esperar antes de mostrar productos
        setTimeout(() => {
            loading.style.display = 'none';
            items.forEach(item => item.classList.remove('hidden'));
        }, 1000); // ajustable
    });

    document.getElementById('closeCriticalStockModal').addEventListener('click', function () {
        document.getElementById('criticalStockModal').classList.add('hidden');
    });

    document.getElementById('criticalStockModal').addEventListener('click', function (event) {
        if (event.target === this) {
            this.classList.add('hidden');
        }
    });
</script>
