<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ReporteController;

use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;

Route::get('/', function () {
    return redirect('/login');
})->name('home');

// Redirección si se visita /dashboard sin autenticación
Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {

    // Ajustes de cuenta del usuario
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    // Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    // Recursos principales
    Route::resource('categorias', CategoriaController::class)->names('categorias');
    Route::resource('productos', ProductoController::class)->names('productos');
    Route::resource('proveedores', ProveedorController::class)->parameters([
        'proveedores' => 'proveedor'
    ]);
    Route::resource('clientes', ClienteController::class)->names('clientes');
    Route::resource('usuarios', UsuarioController::class)->names('usuarios');

    Route::resource('ventas', VentaController::class)->names('ventas');
    Route::resource('compras', CompraController::class)->names('compras');

    // Búsquedas para select2 o ajax
    Route::get('/api/categorias/search', [CategoriaController::class, 'search'])->name('categorias.search');
    Route::get('/api/proveedores/search', [ProveedorController::class, 'search'])->name('proveedores.search');
    Route::get('/api/productos/search', [ProductoController::class, 'search'])->name('productos.search');
    Route::get('/api/clientes/search', [ClienteController::class, 'search'])->name('clientes.search');

    Route::prefix('reportes')->name('reportes.')->group(function () {

        // Página principal de reportes
        Route::get('/', [ReporteController::class, 'index'])->name('index');

        Route::get('stock-critico', [ReporteController::class, 'productosStockCritico'])->name('stock-critico');
        Route::get('stock-critico/pdf', [ReporteController::class, 'productosStockCriticoPdf'])->name('stock-critico.pdf');
        Route::get('stock-critico/excel', [ReporteController::class, 'productosStockCriticoExcel'])->name('stock-critico.excel');

        Route::get('top-productos', [ReporteController::class, 'topProductosExcel'])->name('top-productos');
        Route::get('top-productos/pdf', [ReporteController::class, 'topProductosExcelPdf'])->name('top-productos.pdf');
        Route::get('top-productos/excel', [ReporteController::class, 'topProductosExcel'])->name('top-productos.excel');
    });
});

require __DIR__ . '/auth.php';
