<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Mostrar listado de clientes con búsqueda y paginación.
     */
    public function index(Request $request)
    {
        $query = Cliente::query();

        if ($search = $request->input('search')) {
            $query->where('nombre', 'like', "%{$search}%");
        }

        $clientes = $query->orderBy('nombre')->paginate(10)->withQueryString();

        return view('clientes.index', compact('clientes'));
    }

    /**
     * Mostrar formulario para crear un cliente nuevo.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Almacenar un cliente nuevo.
     */
    public function store(Request $request)
    {
        $datosValidados = $request->validate([
            'nombre' => 'required|string|min:3|max:50|unique:clientes,nombre',
            'correo' => 'nullable|email|max:255|unique:clientes,correo',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
        ]);

        Cliente::create($datosValidados);

        return redirect()
            ->route('clientes.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => '¡Cliente creado!',
                'text' => 'El cliente se ha registrado correctamente.',
            ]);
    }

    /**
     * Mostrar formulario para editar un cliente existente.
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Actualizar un cliente.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $datosValidados = $request->validate([
            'nombre' => 'required|string|min:3|max:50|unique:clientes,nombre,' . $cliente->id,
            'correo' => 'nullable|email|max:255|unique:clientes,correo,' . $cliente->id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
            'estado' => 'required|in:ACTIVO,INACTIVO',
        ]);

        $cliente->update($datosValidados);

        return redirect()
            ->route('clientes.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => '¡Cliente actualizado!',
                'text' => 'Los datos se han guardado correctamente.',
            ]);
    }

    /**
     * Eliminar un cliente.
     */
    public function destroy(Cliente $cliente)
    {
        try {
            $cliente->delete();

            return redirect()
                ->route('clientes.index')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => '¡Cliente eliminado!',
                    'text' => 'El cliente ha sido eliminado correctamente.',
                ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('clientes.index')
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'No se pudo eliminar el cliente. Puede estar relacionado con otros registros.',
                ]);
        }
    }

    /**
     * Búsqueda para autocompletado (ejemplo select2).
     */
    public function search(Request $request)
    {
        $buscar = $request->input('q', '');

        $resultados = Cliente::where('nombre', 'like', "%{$buscar}%")
            ->orderBy('nombre')
            ->select('id', 'nombre as text')
            ->limit(10)
            ->get();

        return response()->json(['items' => $resultados]);
    }
}
