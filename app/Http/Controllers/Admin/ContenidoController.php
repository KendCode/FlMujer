<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contenido;

class ContenidoController extends Controller
{
    public function index()
    {
        $contenidos = Contenido::all();
        return view('admin.contenidos.index', compact('contenidos'));
    }

    public function create()
    {
        return view('admin.contenidos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'seccion' => 'required|string|max:255',
            'titulo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('contenidos','public');
        }

        Contenido::create($data);

        return redirect()->route('admin.contenidos.index')->with('success','Contenido creado correctamente.');
    }

    public function edit(Contenido $contenido)
    {
        return view('admin.contenidos.edit', compact('contenido'));
    }

    public function update(Request $request, Contenido $contenido)
    {
        $data = $request->validate([
            'seccion' => 'required|string|max:255',
            'titulo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('contenidos','public');
        }

        $contenido->update($data);

        return redirect()->route('admin.contenidos.index')->with('success','Contenido actualizado correctamente.');
    }

    public function destroy(Contenido $contenido)
    {
        $contenido->delete();
        return redirect()->route('admin.contenidos.index')->with('success','Contenido eliminado correctamente.');
    }
}
