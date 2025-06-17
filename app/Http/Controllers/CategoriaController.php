<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Mostrar el listado de categorías con paginación y búsqueda opcional.
     */
    public function index(Request $request)
    {
        $query = Categoria::query();

        if ($search = $request->input('search')) {
            $query->where('nombre', 'like', "%{$search}%");
        }

        $categorias = $query->orderBy('nombre')->paginate(10)->withQueryString();

        return view('categorias.index', compact('categorias'));
    }

    /**
     * Mostrar el formulario para crear una nueva categoría.
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Almacenar una nueva categoría en la base de datos.
     */
    public function store(Request $request)
    {
        $datosValidados = $request->validate([
            'nombre' => 'required|string|min:3|max:50|unique:categorias,nombre',
            'estado' => 'required|in:ACTIVO,INACTIVO',
        ]);

        Categoria::create($datosValidados);

        return redirect()
            ->route('categorias.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => '¡Bien hecho!',
                'text' => 'La categoría se ha creado correctamente.',
            ]);
    }

    /**
     * Mostrar el formulario para editar una categoría existente.
     */
    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Actualizar los datos de una categoría.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $datosValidados = $request->validate([
            'nombre' => 'required|string|min:3|max:50|unique:categorias,nombre,' . $categoria->id,
            'estado' => 'required|in:ACTIVO,INACTIVO',
        ]);

        $categoria->update($datosValidados);

        return redirect()
            ->route('categorias.edit', $categoria)
            ->with('swal', [
                'icon' => 'success',
                'title' => '¡Bien hecho!',
                'text' => 'La categoría se ha actualizado correctamente.',
            ]);
    }

    /**
     * Eliminar una categoría de la base de datos.
     */
    public function destroy(Categoria $categoria)
    {
        try {
            $categoria->delete();

            return redirect()
                ->route('categorias.index')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => '¡Bien hecho!',
                    'text' => 'La categoría se ha eliminado correctamente.',
                ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('categorias.index')
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'No se pudo eliminar la categoría, posiblemente está relacionada con otros registros.',
                ]);
        }
    }

    /**
     * Buscar categorías para autocompletado (por ejemplo: select2).
     */
    public function search(Request $request)
    {
        $buscar = $request->input('q', '');

        $resultados = Categoria::where('nombre', 'like', "%{$buscar}%")
            ->orderBy('nombre')
            ->select('id', 'nombre as text')
            ->limit(10)
            ->get();

        return response()->json(['items' => $resultados]);
    }
}
