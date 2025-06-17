<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Producto;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    /**
     * Mostrar listado de compras con búsqueda y paginación.
     */
    public function index(Request $request)
    {
        $query = Compra::with('producto');

        if ($search = $request->input('search')) {
            $query->whereHas('producto', function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%");
            });
        }

        $compras = $query->orderBy('fecha_transaccion', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('compras.index', compact('compras'));
    }

    /**
     * Mostrar formulario para crear una compra nueva.
     */
    public function create()
    {
        $productos = Producto::orderBy('nombre')->get();
        return view('compras.create', compact('productos'));
    }

    /**
     * Almacenar una compra nueva.
     */
    public function store(Request $request)
    {
        $datosValidados = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'monto_total' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:1',
            'fecha_transaccion' => 'required|date',
        ]);

        Compra::create($datosValidados);

        return redirect()
            ->route('compras.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => '¡Compra creada!',
                'text' => 'La compra se ha registrado correctamente.',
            ]);
    }

    /**
     * Eliminar una compra.
     */
    public function destroy(Compra $compra)
    {
        try {
            $compra->delete();

            return redirect()
                ->route('compras.index')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => '¡Compra eliminada!',
                    'text' => 'La compra ha sido eliminada correctamente.',
                ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('compras.index')
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'No se pudo eliminar la compra. Puede estar relacionada con otros registros.',
                ]);
        }
    }
}
