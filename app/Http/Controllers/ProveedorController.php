<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Mostrar listado de proveedores con búsqueda y paginación.
     */
    public function index(Request $request)
    {
        $query = Proveedor::query();

        if ($search = $request->input('search')) {
            $query->where('nombre', 'like', "%{$search}%");
        }

        $proveedores = $query->orderBy('nombre')->paginate(10)->withQueryString();

        return view('proveedores.index', compact('proveedores'));
    }

    /**
     * Mostrar formulario de creación de proveedor.
     */
    public function create()
    {
        return view('proveedores.create');
    }

    /**
     * Almacenar un nuevo proveedor.
     */
    public function store(Request $request)
    {
        $datosValidados = $request->validate([
            'nombre' => 'required|string|min:3|max:50|unique:proveedores,nombre',
            'correo' => 'nullable|email|max:255|unique:proveedores,correo',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
        ]);

        Proveedor::create($datosValidados);

        return redirect()
            ->route('proveedores.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => '¡Proveedor creado!',
                'text' => 'El proveedor se ha registrado correctamente.',
            ]);
    }

    /**
     * Mostrar formulario para editar un proveedor.
     */
    public function edit(Proveedor $proveedor)
    {
        return view('proveedores.edit', compact('proveedor'));
    }

    /**
     * Actualizar un proveedor existente.
     */
    public function update(Request $request, Proveedor $proveedor)
    {
        $datosValidados = $request->validate([
            'nombre' => 'required|string|min:3|max:50|unique:proveedores,nombre,' . $proveedor->id,
            'correo' => 'nullable|email|max:255|unique:proveedores,correo,' . $proveedor->id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
            'estado' => 'required|in:ACTIVO,INACTIVO',
        ]);

        $proveedor->update($datosValidados);

        return redirect()
            ->route('proveedores.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => '¡Proveedor actualizado!',
                'text' => 'Los datos se han guardado correctamente.',
            ]);
    }

    /**
     * Eliminar proveedor.
     */
    public function destroy(Proveedor $proveedor)
    {
        try {
            $proveedor->delete();

            return redirect()
                ->route('proveedores.index')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => '¡Proveedor eliminado!',
                    'text' => 'El proveedor ha sido eliminado correctamente.',
                ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('proveedores.index')
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'No se pudo eliminar el proveedor. Puede estar relacionado con otros registros.',
                ]);
        }
    }

    /**
     * Búsqueda para autocompletado (select2 u otros).
     */
    public function search(Request $request)
    {
        $buscar = $request->input('q', '');

        $resultados = Proveedor::where('nombre', 'like', "%{$buscar}%")
            ->orderBy('nombre')
            ->select('id', 'nombre as text')
            ->limit(10)
            ->get();

        return response()->json(['items' => $resultados]);
    }
}
