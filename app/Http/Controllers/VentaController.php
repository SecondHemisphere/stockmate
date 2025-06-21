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
     * Mostrar listado de ventas con paginación y búsqueda por cliente o número factura.
     */
    public function index(Request $request)
    {
        $query = Venta::with(['cliente', 'usuario']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('cliente', function ($qc) use ($search) {
                    $qc->where('nombre', 'like', "%{$search}%");
                })
                    ->orWhere('numero_factura', 'like', "%{$search}%");
            });
        }

        $ventas = $query->orderBy('fecha', 'desc')
            ->paginate(10)
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
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'required|date',
            'monto_total' => 'required|numeric|min:0',
            'monto_descuento' => 'nullable|numeric|min:0',
            'total_con_iva' => 'required|numeric|min:0',
            'metodo_pago' => 'required|in:EFECTIVO,TARJETA_CREDITO,TARJETA_DEBITO,TRANSFERENCIA,OTRO',
            'observaciones' => 'nullable|string',

            // Validar detalles
            'detalles' => 'required|array|min:1',
            'detalles.*.producto_id' => 'required|exists:productos,id',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.precio_unitario' => 'required|numeric|min:0',
            'detalles.*.precio_total' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $venta = Venta::create([
                'cliente_id' => $request->cliente_id,
                'usuario_id' => request()->user()->id,
                'numero_factura' => Venta::generarNumeroFactura(),
                'fecha' => $request->fecha,
                'monto_total' => $request->monto_total,
                'monto_descuento' => $request->monto_descuento ?? 0,
                'total_con_iva' => $request->total_con_iva,
                'metodo_pago' => $request->metodo_pago,
                'observaciones' => $request->observaciones,
            ]);

            // Guardar detalles de la venta
            foreach ($request->detalles as $detalle) {
                $venta->detalles()->create([
                    'producto_id' => $detalle['producto_id'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_unitario'],
                    'precio_total' => $detalle['precio_total'],
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
            return back()->withInput()->withErrors(['error' => 'Error al guardar la venta: ' . $e->getMessage()]);
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
        try {
            $venta->delete();

            return redirect()
                ->route('ventas.index')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => '¡Venta eliminada!',
                    'text' => 'La venta y sus detalles se eliminaron correctamente.',
                ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('ventas.index')
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'No se pudo eliminar la venta. Puede estar relacionada con otros registros.',
                ]);
        }
    }
}
