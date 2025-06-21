<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ReporteController;

use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;

Route::get('/', function () {
    return redirect('/login');
})->name('home');

// Dashboard protegido
Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rutas protegidas por autenticación y permisos
Route::middleware(['auth'])->group(function () {

    // Ajustes de cuenta del usuario sin permisos específicos (solo auth)
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    // Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    // Categorías: permisos para ver, crear, editar, eliminar
    Route::resource('categorias', CategoriaController::class)
        ->names('categorias')
        ->middleware('permission:categorias.ver|categorias.crear|categorias.editar|categorias.eliminar');

    // Productos
    Route::resource('productos', ProductoController::class)
        ->names('productos')
        ->middleware('permission:productos.ver|productos.crear|productos.editar|productos.eliminar');

    // Proveedores
    Route::resource('proveedores', ProveedorController::class)
        ->parameters(['proveedores' => 'proveedor'])
        ->middleware('permission:proveedores.ver|proveedores.crear|proveedores.editar|proveedores.eliminar');

    // Roles
    Route::resource('roles', RolController::class)
        ->parameters(['roles' => 'rol'])
        ->middleware('permission:roles.ver|roles.crear|roles.editar|roles.eliminar');

    // Clientes
    Route::resource('clientes', ClienteController::class)
        ->names('clientes')
        ->middleware('permission:clientes.ver|clientes.crear|clientes.editar|clientes.eliminar');

    // Usuarios
    Route::resource('usuarios', UsuarioController::class)
        ->names('usuarios')
        ->middleware('permission:usuarios.ver|usuarios.crear|usuarios.editar|usuarios.eliminar');

    // Ventas
    Route::resource('ventas', VentaController::class)
        ->names('ventas')
        ->middleware('permission:ventas.ver|ventas.crear|ventas.editar|ventas.eliminar');

    // Compras
    Route::resource('compras', CompraController::class)
        ->names('compras')
        ->middleware('permission:compras.ver|compras.crear|compras.editar|compras.eliminar');

    // Búsquedas para select2 o ajax
    Route::get('/api/categorias/search', [CategoriaController::class, 'search'])
        ->name('categorias.search')
        ->middleware('permission:categorias.ver');

    Route::get('/api/proveedores/search', [ProveedorController::class, 'search'])
        ->name('proveedores.search')
        ->middleware('permission:proveedores.ver');

    Route::get('/api/productos/search', [ProductoController::class, 'search'])
        ->name('productos.search')
        ->middleware('permission:productos.ver');

    Route::get('/api/clientes/search', [ClienteController::class, 'search'])
        ->name('clientes.search')
        ->middleware('permission:clientes.ver');

    // Reportes protegidos (puedes usar permisos generales o específicos)
    Route::prefix('reportes')->name('reportes.')->middleware('permission:reportes.ver')->group(function () {

        Route::get('/', [ReporteController::class, 'index'])->name('index');

        Route::get('stock-critico', [ReporteController::class, 'productosStockCritico'])->name('stock-critico');
        Route::get('stock-critico/pdf', [ReporteController::class, 'productosStockCriticoPdf'])->name('stock-critico.pdf');
        Route::get('stock-critico/excel', [ReporteController::class, 'productosStockCriticoExcel'])->name('stock-critico.excel');

        Route::get('top-productos', [ReporteController::class, 'topProductos'])->name('top-productos');
        Route::get('top-productos/pdf', [ReporteController::class, 'topProductosPdf'])->name('top-productos.pdf');
        Route::get('top-productos/excel', [ReporteController::class, 'topProductosExcel'])->name('top-productos.excel');

        Route::get('clientes-frecuentes', [ReporteController::class, 'clientesFrecuentes'])->name('clientes-frecuentes');
        Route::get('clientes-frecuentes/pdf', [ReporteController::class, 'clientesFrecuentesPdf'])->name('clientes-frecuentes.pdf');
        Route::get('clientes-frecuentes/excel', [ReporteController::class, 'clientesFrecuentesExcel'])->name('clientes-frecuentes.excel');

        Route::get('stock-actual', [ReporteController::class, 'stockActual'])->name('stock-actual');
        Route::get('stock-actual/pdf', [ReporteController::class, 'stockActualPdf'])->name('stock-actual.pdf');
        Route::get('stock-actual/excel', [ReporteController::class, 'stockActualExcel'])->name('stock-actual.excel');

        Route::get('proveedores-activos', [ReporteController::class, 'proveedoresActivos'])->name('proveedores-activos');
        Route::get('proveedores-activos/pdf', [ReporteController::class, 'proveedoresActivosPdf'])->name('proveedores-activos.pdf');
        Route::get('proveedores-activos/excel', [ReporteController::class, 'proveedoresActivosExcel'])->name('proveedores-activos.excel');

        Route::get('compras-filtradas', [ReporteController::class, 'comprasFiltradas'])->name('compras-filtradas');
        Route::get('compras-filtradas/pdf', [ReporteController::class, 'comprasFiltradasPdf'])->name('compras-filtradas.pdf');
        Route::get('compras-filtradas/excel', [ReporteController::class, 'comprasFiltradasExcel'])->name('compras-filtradas.excel');

        Route::get('ventas-filtradas', [ReporteController::class, 'ventasFiltradas'])->name('ventas-filtradas');
        Route::get('ventas-filtradas/pdf', [ReporteController::class, 'ventasFiltradasPdf'])->name('ventas-filtradas.pdf');
        Route::get('ventas-filtradas/excel', [ReporteController::class, 'ventasFiltradasExcel'])->name('ventas-filtradas.excel');

        Route::get('historial-producto', [ReporteController::class, 'historialProducto'])->name('historial-producto');
        Route::get('historial-producto/pdf', [ReporteController::class, 'historialProductoPdf'])->name('historial-producto.pdf');
        Route::get('historial-producto/excel', [ReporteController::class, 'historialProductoExcel'])->name('historial-producto.excel');
    });
});

require __DIR__ . '/auth.php';
