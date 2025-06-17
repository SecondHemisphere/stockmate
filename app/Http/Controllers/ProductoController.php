<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::with(['categoria', 'proveedor']);

        if ($search = $request->input('search')) {
            $query->where('nombre', 'like', "%{$search}%");
        }

        $productos = $query->orderBy('nombre')->paginate(10)->withQueryString();

        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nombre')->get();
        $proveedores = Proveedor::orderBy('nombre')->get();

        return view('productos.create', compact('categorias', 'proveedores'));
    }

    public function store(Request $request)
    {
        $datosValidados = $request->validate([
            'categoria_id' => 'nullable|exists:categorias,id',
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'nombre' => 'required|string|max:100|unique:productos,nombre',
            'descripcion' => 'required|string',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'stock_actual' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'ruta_imagen' => 'nullable|string|max:255',
            'estado' => 'required|in:ACTIVO,INACTIVO',
        ]);

        Producto::create($datosValidados);

        return redirect()
            ->route('productos.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => '¡Producto creado!',
                'text' => 'El producto se ha registrado correctamente.',
            ]);
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::orderBy('nombre')->get();
        $proveedores = Proveedor::orderBy('nombre')->get();

        return view('productos.edit', compact('producto', 'categorias', 'proveedores'));
    }

    public function update(Request $request, Producto $producto)
    {
        $datosValidados = $request->validate([
            'categoria_id' => 'nullable|exists:categorias,id',
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'nombre' => 'required|string|max:100|unique:productos,nombre,' . $producto->id,
            'descripcion' => 'required|string',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'stock_actual' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'ruta_imagen' => 'nullable|string|max:255',
            'estado' => 'required|in:ACTIVO,INACTIVO',
        ]);

        $producto->update($datosValidados);

        return redirect()
            ->route('productos.edit', $producto)
            ->with('swal', [
                'icon' => 'success',
                'title' => '¡Producto actualizado!',
                'text' => 'Los datos se han guardado correctamente.',
            ]);
    }

    public function destroy(Producto $producto)
    {
        try {
            $producto->delete();

            return redirect()
                ->route('productos.index')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => '¡Producto eliminado!',
                    'text' => 'El producto ha sido eliminado correctamente.',
                ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('productos.index')
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'No se pudo eliminar el producto. Puede estar relacionado con otros registros.',
                ]);
        }
    }

    public function search(Request $request)
    {
        $buscar = $request->input('q', '');

        $resultados = Producto::where('nombre', 'like', "%{$buscar}%")
            ->orderBy('nombre')
            ->select('id', 'nombre as text')
            ->limit(10)
            ->get();

        return response()->json(['items' => $resultados]);
    }
}
