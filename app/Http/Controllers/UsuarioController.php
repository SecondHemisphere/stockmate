<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Mostrar lista de usuarios con búsqueda.
     */
    public function index(Request $request)
    {
        $query = Usuario::with('rol');

        if ($search = $request->input('search')) {
            $query->where('nombre', 'like', "%{$search}%")
                ->orWhere('correo', 'like', "%{$search}%");
        }

        $usuarios = $query->orderBy('nombre')->get();

        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Mostrar formulario para crear un nuevo usuario.
     */
    public function create()
    {
        $roles = Rol::orderBy('nombre')->get();
        return view('usuarios.create', compact('roles'));
    }

    /**
     * Guardar un nuevo usuario.
     */
    public function store(Request $request)
    {
        $datosValidados = $request->validate([
            'nombre' => 'required|string|min:3|max:255',
            'correo' => 'required|email|max:255|unique:usuarios,correo',
            'contrasena' => 'required|string|min:6|confirmed',
            'rol_id' => 'required|exists:roles,id',
        ]);

        $datosValidados['contrasena'] = Hash::make($datosValidados['contrasena']);

        Usuario::create($datosValidados);

        return redirect()
            ->route('usuarios.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => '¡Usuario creado!',
                'text' => 'El usuario ha sido registrado correctamente.',
            ]);
    }

    /**
     * Mostrar formulario para editar un usuario.
     */
    public function edit(Usuario $usuario)
    {
        $roles = Rol::orderBy('nombre')->get();
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    /**
     * Actualizar un usuario existente.
     */
    public function update(Request $request, Usuario $usuario)
    {
        $datosValidados = $request->validate([
            'nombre' => 'required|string|min:3|max:255',
            'correo' => 'required|email|max:255|unique:usuarios,correo,' . $usuario->id,
            'contrasena' => 'nullable|string|min:6|confirmed',
            'estado' => 'required|in:ACTIVO,INACTIVO',
            'rol_id' => 'required|exists:roles,id',
        ]);

        if (!empty($datosValidados['contrasena'])) {
            $datosValidados['contrasena'] = Hash::make($datosValidados['contrasena']);
        } else {
            unset($datosValidados['contrasena']);
        }

        $usuario->update($datosValidados);

        return redirect()
            ->route('usuarios.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => '¡Usuario actualizado!',
                'text' => 'Los datos se han actualizado correctamente.',
            ]);
    }

    /**
     * Eliminar un usuario.
     */
    public function destroy(Usuario $usuario)
    {
        if ($usuario->id === 1) {
            return redirect()
                ->route('usuarios.index')
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Acción no permitida',
                    'text' => 'No puedes eliminar al usuario Administrador.',
                ]);
        }

        try {
            $usuario->delete();

            return redirect()
                ->route('usuarios.index')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => '¡Usuario eliminado!',
                    'text' => 'El usuario ha sido eliminado correctamente.',
                ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('usuarios.index')
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'No se pudo eliminar el usuario. Puede estar relacionado con otros registros.',
                ]);
        }
    }

    /**
     * Búsqueda para select2 u otros componentes.
     */
    public function search(Request $request)
    {
        $buscar = $request->input('q', '');

        $resultados = Usuario::where('nombre', 'like', "%{$buscar}%")
            ->orderBy('nombre')
            ->select('id', 'nombre as text')
            ->limit(10)
            ->get();

        return response()->json(['items' => $resultados]);
    }
}
