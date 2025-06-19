<x-layouts.app>
    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Reportes</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="mb-4">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Generar Reportes</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

            <!-- Reporte de Productos con Stock Crítico  -->
            <div class="border p-6 rounded-xl shadow-lg bg-white hover:shadow-xl transition duration-300 ease-in-out">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Productos con Stock Crítico</h3>
                <p class="text-sm text-gray-600 mb-4">Productos con niveles de stock críticos.</p>
                <a href="{{ route('reportes.stock-critico') }}"
                    class="btn px-6 py-3 rounded-lg bg-teal-600 text-white hover:bg-teal-800 flex items-center gap-2 transition duration-300">
                    <i class="fas fa-table text-lg"></i> Ver
                </a>
            </div>

            <!-- Reporte de Productos Más Vendidos -->
            <div class="border p-6 rounded-xl shadow-lg bg-white hover:shadow-xl transition duration-300 ease-in-out">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Productos Más Vendidos</h3>
                <p class="text-sm text-gray-600 mb-4">Ranking por cantidad vendida.</p>
                <a href="{{ route('reportes.top-productos') }}"
                    class="btn px-6 py-3 rounded-lg bg-teal-600 text-white hover:bg-teal-800 flex items-center gap-2 transition duration-300">
                    <i class="fas fa-table text-lg"></i> Ver
                </a>
            </div>

            <!-- Reporte de Ventas por Rango de Fechas -->
            <div class="border p-6 rounded-xl shadow-lg bg-white hover:shadow-xl transition duration-300 ease-in-out">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Ventas por Rango de Fechas</h3>
                <p class="text-sm text-gray-600 mb-4">Filtra ventas por día, mes o período.</p>
                <a href="{{ route('reportes.stock-critico') }}"
                    class="btn px-6 py-3 rounded-lg bg-teal-600 text-white hover:bg-teal-800 flex items-center gap-2 transition duration-300">
                    <i class="fas fa-table text-lg"></i> Ver
                </a>
            </div>

            <!-- Reporte de Compras por Rango de Fechas -->
            <div class="border p-6 rounded-xl shadow-lg bg-white hover:shadow-xl transition duration-300 ease-in-out">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Compras por Rango de Fechas</h3>
                <p class="text-sm text-gray-600 mb-4">Control de compras según proveedor y fecha.</p>
                <a href="{{ route('reportes.stock-critico') }}"
                    class="btn px-6 py-3 rounded-lg bg-teal-600 text-white hover:bg-teal-800 flex items-center gap-2 transition duration-300">
                    <i class="fas fa-table text-lg"></i> Ver
                </a>
            </div>

            <!-- Reporte de Auditoría del Sistema -->
            <div class="border p-6 rounded-xl shadow-lg bg-white hover:shadow-xl transition duration-300 ease-in-out">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Auditoría del Sistema</h3>
                <p class="text-sm text-gray-600 mb-4">Seguimiento de cambios realizados por usuarios.</p>
                <a href="{{ route('reportes.stock-critico') }}"
                    class="btn px-6 py-3 rounded-lg bg-teal-600 text-white hover:bg-teal-800 flex items-center gap-2 transition duration-300">
                    <i class="fas fa-table text-lg"></i> Ver
                </a>
            </div>

            <!-- Reporte de Productos con Stock Actual -->
            <div class="border p-6 rounded-xl shadow-lg bg-white hover:shadow-xl transition duration-300 ease-in-out">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Stock Actual</h3>
                <p class="text-sm text-gray-600 mb-4">Todos los productos con su stock y detalles.</p>
                <a href="{{ route('reportes.stock-actual') }}"
                    class="btn px-6 py-3 rounded-lg bg-teal-600 text-white hover:bg-teal-800 flex items-center gap-2 transition duration-300">
                    <i class="fas fa-table text-lg"></i> Ver
                </a>
            </div>

            <!-- Reporte de Historial de Producto -->
            <div class="border p-6 rounded-xl shadow-lg bg-white hover:shadow-xl transition duration-300 ease-in-out">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Historial de Producto</h3>
                <p class="text-sm text-gray-600 mb-4">Movimientos detallados de un producto.</p>
                <a href="{{ route('reportes.stock-critico') }}"
                    class="btn px-6 py-3 rounded-lg bg-teal-600 text-white hover:bg-teal-800 flex items-center gap-2 transition duration-300">
                    <i class="fas fa-table text-lg"></i> Ver
                </a>
            </div>

            <!-- Reporte de Movimientos de Inventario -->
            <div class="border p-6 rounded-xl shadow-lg bg-white hover:shadow-xl transition duration-300 ease-in-out">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Movimientos de Inventario</h3>
                <p class="text-sm text-gray-600 mb-4">Entradas y salidas filtradas por usuario y fecha.</p>
                <a href="{{ route('reportes.stock-critico') }}"
                    class="btn px-6 py-3 rounded-lg bg-teal-600 text-white hover:bg-teal-800 flex items-center gap-2 transition duration-300">
                    <i class="fas fa-table text-lg"></i> Ver
                </a>
            </div>

            <!-- Reporte de Clientes frecuentes -->
            <div class="border p-6 rounded-xl shadow-lg bg-white hover:shadow-xl transition duration-300 ease-in-out">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Clientes Frecuentes</h3>
                <p class="text-sm text-gray-600 mb-4">Clientes con más compras en un período.</p>
                <a href="{{ route('reportes.clientes-frecuentes') }}"
                    class="btn px-6 py-3 rounded-lg bg-teal-600 text-white hover:bg-teal-800 flex items-center gap-2 transition duration-300">
                    <i class="fas fa-table text-lg"></i> Ver
                </a>
            </div>

            <!-- Reporte de Proveedores activos -->
            <div class="border p-6 rounded-xl shadow-lg bg-white hover:shadow-xl transition duration-300 ease-in-out">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Proveedores Activos</h3>
                <p class="text-sm text-gray-600 mb-4">Lista actualizada de proveedores activos.</p>
                <a href="{{ route('reportes.stock-critico') }}"
                    class="btn px-6 py-3 rounded-lg bg-teal-600 text-white hover:bg-teal-800 flex items-center gap-2 transition duration-300">
                    <i class="fas fa-table text-lg"></i> Ver
                </a>
            </div>

        </div>
    </div>
</x-layouts.app>
