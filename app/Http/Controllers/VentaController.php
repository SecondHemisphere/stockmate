<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    /**
     * Mostrar listado de ventas con paginación y búsqueda por cliente o número de factura.
     */
    public function index(Request $request)
    {
        $query = Venta::with(['cliente', 'usuario']);

        if ($busqueda = $request->input('search')) {
            $query->where(function ($q) use ($busqueda) {
                $q->whereHas('cliente', function ($qc) use ($busqueda) {
                    $qc->where('nombre', 'like', "%{$busqueda}%");
                })
                    ->orWhere('numero_factura', 'like', "%{$busqueda}%");
            });
        }

        $ventas = $query->orderBy('fecha', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('ventas.index', compact('ventas'));
    }

    /**
     * Mostrar formulario para crear una nueva venta.
     */
    public function create()
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $productos = Producto::orderBy('nombre')->get();
        $metodosPago = Venta::METODOS_PAGO;
        $numeroFactura = Venta::generarNumeroFactura();

        return view('ventas.create', compact('clientes', 'productos', 'metodosPago', 'numeroFactura'));
    }

    /**
     * Almacenar una nueva venta y sus detalles.
     */
    public function store(Request $request)
    {
        $userId = $request->user()->id;

        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'required|date',
            'porcentaje_descuento' => 'required|numeric|min:0',
            'metodo_pago' => 'required|in:EFECTIVO,TARJETA_CREDITO,TARJETA_DEBITO,TRANSFERENCIA,OTRO',
            'observaciones' => 'nullable|string',
            'numero_factura' => 'required|unique:ventas,numero_factura',

            // Validar detalles
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $venta = Venta::create([
                'cliente_id' => $request->cliente_id,
                'usuario_id' => $userId,
                'numero_factura' => $request->numero_factura,
                'fecha' => $request->fecha,
                'porcentaje_descuento' => $request->porcentaje_descuento,
                'metodo_pago' => $request->metodo_pago,
                'observaciones' => $request->observaciones,
            ]);

            // Guardar detalles de la venta
            foreach ($request->productos as $producto) {
                $venta->detalles()->create([
                    'producto_id' => $producto['producto_id'],
                    'cantidad' => $producto['cantidad'],
                ]);
            }

            DB::commit();

            return redirect()
                ->route('ventas.index')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => '¡Venta registrada!',
                    'text' => 'La venta se ha guardado correctamente.',
                ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'Ocurrió un error al registrar la venta: ' . $e->getMessage(),
                ]);
        }
    }

    /**
     * Mostrar detalles de una venta.
     */
    public function show(Venta $venta)
    {
        $venta->load(['cliente', 'usuario', 'detalles.producto']);
        return view('ventas.show', compact('venta'));
    }

    /**
     * Eliminar una venta y sus detalles.
     */
    public function destroy(Venta $venta)
    {
        DB::beginTransaction();

        try {
            foreach ($venta->detalles as $detalle) {
                $producto = Producto::find($detalle->producto_id);
                if ($producto) {
                    $producto->stock_actual += $detalle->cantidad;
                    $producto->save();
                }
            }

            $venta->delete();

            DB::commit();

            return redirect()
                ->route('ventas.index')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => '¡Venta eliminada!',
                    'text' => 'La venta y sus detalles se eliminaron correctamente.',
                ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('ventas.index')
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'No se pudo eliminar la venta: ' . $e->getMessage(),
                ]);
        }
    }
}
