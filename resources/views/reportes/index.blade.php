<x-layouts.app>
    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Reportes
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="mb-4">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Generar Reportes</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Reporte de Stock Actual -->
            <div class="border p-6 rounded-xl shadow-lg bg-white hover:shadow-xl transition duration-300 ease-in-out">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Stock Actual</h3>
                <p class="text-sm text-gray-600 mb-4">Todos los productos con su stock y detalles.</p>
                <div class="flex flex-col gap-4">
                    <a href="#" class="btn px-6 py-3 rounded-lg bg-red-600 text-white hover:bg-red-500 flex items-center gap-2 transition duration-300">
                        <i class="fas fa-file-pdf text-lg"></i> Descargar PDF
                    </a>
                    <a href="#" class="btn px-6 py-3 rounded-lg bg-green-600 text-white hover:bg-green-500 flex items-center gap-2 transition duration-300">
                        <i class="fas fa-file-excel text-lg"></i> Descargar Excel
                    </a>
                </div>
            </div>

            <!-- Reporte de Productos con Stock Bajo -->
            <div class="border p-6 rounded-xl shadow-lg bg-white hover:shadow-xl transition duration-300 ease-in-out">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Productos con Stock Bajo</h3>
                <p class="text-sm text-gray-600 mb-4">Productos cuyo stock está por debajo del mínimo.</p>
                <div class="flex flex-col gap-4">
                    <a href="#" class="btn px-6 py-3 rounded-lg bg-red-600 text-white hover:bg-red-500 flex items-center gap-2 transition duration-300">
                        <i class="fas fa-file-pdf text-lg"></i> Descargar PDF
                    </a>
                    <a href="#" class="btn px-6 py-3 rounded-lg bg-green-600 text-white hover:bg-green-500 flex items-center gap-2 transition duration-300">
                        <i class="fas fa-file-excel text-lg"></i> Descargar Excel
                    </a>
                </div>
            </div>

            <!-- Reporte de Movimientos de Inventario -->
            <div class="border p-6 rounded-xl shadow-lg bg-white hover:shadow-xl transition duration-300 ease-in-out">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Movimientos de Inventario</h3>
                <p class="text-sm text-gray-600 mb-4">Entradas y salidas por fecha, usuario, tipo de movimiento.</p>
                <div class="flex flex-col gap-4">
                    <a href="#" class="btn px-6 py-3 rounded-lg bg-red-600 text-white hover:bg-red-500 flex items-center gap-2 transition duration-300">
                        <i class="fas fa-file-pdf text-lg"></i> Descargar PDF
                    </a>
                    <a href="#" class="btn px-6 py-3 rounded-lg bg-green-600 text-white hover:bg-green-500 flex items-center gap-2 transition duration-300">
                        <i class="fas fa-file-excel text-lg"></i> Descargar Excel
                    </a>
                </div>
            </div>

            <!-- Reporte de Ventas por Fecha -->
            <div class="border p-6 rounded-xl shadow-lg bg-white hover:shadow-xl transition duration-300 ease-in-out">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Ventas por Fecha</h3>
                <p class="text-sm text-gray-600 mb-4">Qué se vendió, cuándo, cuánto se recaudó.</p>
                <div class="flex flex-col gap-4">
                    <a href="#" class="btn px-6 py-3 rounded-lg bg-red-600 text-white hover:bg-red-500 flex items-center gap-2 transition duration-300">
                        <i class="fas fa-file-pdf text-lg"></i> Descargar PDF
                    </a>
                    <a href="#" class="btn px-6 py-3 rounded-lg bg-green-600 text-white hover:bg-green-500 flex items-center gap-2 transition duration-300">
                        <i class="fas fa-file-excel text-lg"></i> Descargar Excel
                    </a>
                </div>
            </div>

            <!-- Reporte de Productos Más Vendidos -->
            <div class="border p-6 rounded-xl shadow-lg bg-white hover:shadow-xl transition duration-300 ease-in-out">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Productos Más Vendidos</h3>
                <p class="text-sm text-gray-600 mb-4">Ranking de productos más vendidos en un período.</p>
                <div class="flex flex-col gap-4">
                    <a href="#" class="btn px-6 py-3 rounded-lg bg-red-600 text-white hover:bg-red-500 flex items-center gap-2 transition duration-300">
                        <i class="fas fa-file-pdf text-lg"></i> Descargar PDF
                    </a>
                    <a href="#" class="btn px-6 py-3 rounded-lg bg-green-600 text-white hover:bg-green-500 flex items-center gap-2 transition duration-300">
                        <i class="fas fa-file-excel text-lg"></i> Descargar Excel
                    </a>
                </div>
            </div>

            <!-- Reporte de Historial de un Producto -->
            <div class="border p-6 rounded-xl shadow-lg bg-white hover:shadow-xl transition duration-300 ease-in-out">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Historial de un Producto</h3>
                <p class="text-sm text-gray-600 mb-4">Todos los movimientos que ha tenido un producto.</p>
                <div class="flex flex-col gap-4">
                    <a href="#" class="btn px-6 py-3 rounded-lg bg-red-600 text-white hover:bg-red-500 flex items-center gap-2 transition duration-300">
                        <i class="fas fa-file-pdf text-lg"></i> Descargar PDF
                    </a>
                    <a href="#" class="btn px-6 py-3 rounded-lg bg-green-600 text-white hover:bg-green-500 flex items-center gap-2 transition duration-300">
                        <i class="fas fa-file-excel text-lg"></i> Descargar Excel
                    </a>
                </div>
            </div>

            <!-- Reporte de Compras -->
            <div class="border p-6 rounded-xl shadow-lg bg-white hover:shadow-xl transition duration-300 ease-in-out">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Reportes de Compras</h3>
                <p class="text-sm text-gray-600 mb-4">Qué se compró, a quién, cuánto costó, cuándo.</p>
                <div class="flex flex-col gap-4">
                    <a href="#" class="btn px-6 py-3 rounded-lg bg-red-600 text-white hover:bg-red-500 flex items-center gap-2 transition duration-300">
                        <i class="fas fa-file-pdf text-lg"></i> Descargar PDF
                    </a>
                    <a href="#" class="btn px-6 py-3 rounded-lg bg-green-600 text-white hover:bg-green-500 flex items-center gap-2 transition duration-300">
                        <i class="fas fa-file-excel text-lg"></i> Descargar Excel
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
