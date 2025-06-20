<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\Permiso;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function index(Request $request)
    {
        $roles = Rol::with('permisos')
            ->when($request->input('search'), function ($query, $search) {
                $query->where('nombre', 'like', "%{$search}%");
            })
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permisos = Permiso::orderBy('nombre')->get();
        return view('roles.create', compact('permisos'));
    }

    public function store(Request $request)
    {
        $datosValidados = $request->validate([
            'nombre' => 'required|string|min:3|max:50|unique:roles,nombre',
            'permisos' => 'required|array|min:1',
            'permisos.*' => 'exists:permisos,id',
        ]);

        $rol = Rol::create(['nombre' => $datosValidados['nombre']]);
        $rol->permisos()->sync($datosValidados['permisos']);

        return redirect()->route('roles.index')->with('swal', [
            'icon' => 'success',
            'title' => '¡Rol creado!',
            'text' => 'El rol se registró correctamente junto con sus permisos.',
        ]);
    }

    public function edit(Rol $rol)
    {
        if ($rol->nombre === 'Administrador') {
            return redirect()->route('roles.index')->with('swal', [
                'icon' => 'warning',
                'title' => 'Acción no permitida',
                'text' => 'No se puede editar el rol Administrador.',
            ]);
        }

        $permisos = Permiso::orderBy('nombre')->get();
        $rol->load('permisos');

        return view('roles.edit', compact('rol', 'permisos'));
    }

    public function update(Request $request, Rol $rol)
    {
        if ($rol->nombre === 'Administrador') {
            return redirect()->route('roles.index')->with('swal', [
                'icon' => 'warning',
                'title' => 'Acción no permitida',
                'text' => 'No se puede editar el rol Administrador.',
            ]);
        }

        $datosValidados = $request->validate([
            'nombre' => 'required|string|min:3|max:50|unique:roles,nombre,' . $rol->id,
            'permisos' => 'required|array|min:1',
            'permisos.*' => 'exists:permisos,id',
        ]);

        $rol->update(['nombre' => $datosValidados['nombre']]);
        $rol->permisos()->sync($datosValidados['permisos']);

        return redirect()->route('roles.index')->with('swal', [
            'icon' => 'success',
            'title' => '¡Rol actualizado!',
            'text' => 'El rol se actualizó correctamente junto con sus permisos.',
        ]);
    }

    public function destroy(Rol $rol)
    {
        if ($rol->nombre === 'Administrador') {
            return redirect()->route('roles.index')->with('swal', [
                'icon' => 'warning',
                'title' => 'Acción no permitida',
                'text' => 'No se puede eliminar el rol Administrador.',
            ]);
        }

        try {
            $rol->delete();

            return redirect()->route('roles.index')->with('swal', [
                'icon' => 'success',
                'title' => '¡Rol eliminado!',
                'text' => 'El rol se eliminó correctamente.',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('roles.index')->with('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'No se pudo eliminar el rol. Puede estar en uso por otros registros.',
            ]);
        }
    }
}
