<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    /**
     * Mostrar lista de roles con búsqueda.
     */
    public function index(Request $request)
    {
        $query = Rol::query();

        if ($search = $request->input('search')) {
            $query->where('nombre', 'like', "%{$search}%");
        }

        $roles = $query->orderBy('nombre')->paginate(10)->withQueryString();

        return view('roles.index', compact('roles'));
    }

    /**
     * Mostrar formulario para crear un nuevo rol.
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Guardar un nuevo rol.
     */
    public function store(Request $request)
    {
        $datosValidados = $request->validate([
            'nombre' => 'required|string|min:3|max:50|unique:roles,nombre',
        ]);

        Rol::create($datosValidados);

        return redirect()
            ->route('roles.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => '¡Rol creado!',
                'text' => 'El rol se registró correctamente.',
            ]);
    }

    /**
     * Mostrar formulario para editar un rol.
     */
    public function edit(Rol $rol)
    {
        return view('roles.edit', compact('rol'));
    }

    /**
     * Actualizar un rol existente.
     */
    public function update(Request $request, Rol $rol)
    {
        $datosValidados = $request->validate([
            'nombre' => 'required|string|min:3|max:50|unique:roles,nombre,' . $rol->id,
        ]);

        $rol->update($datosValidados);

        return redirect()
            ->route('roles.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => '¡Rol actualizado!',
                'text' => 'El rol se actualizó correctamente.',
            ]);
    }

    /**
     * Eliminar un rol.
     */
    public function destroy(Rol $rol)
    {
        try {
            $rol->delete();

            return redirect()
                ->route('roles.index')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => '¡Rol eliminado!',
                    'text' => 'El rol se eliminó correctamente.',
                ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('roles.index')
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'No se pudo eliminar el rol. Puede estar en uso por otros registros.',
                ]);
        }
    }
}
